<?php

namespace App\Http\Controllers\Api\Petani;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController as BaseController;
use App\Http\Resources\fieldResources;
use App\Http\Resources\HarvestResource;
use App\Http\Resources\PlantResource;
use App\Models\Field;
use App\Models\FieldRecapHarvest;
use App\Models\FieldRecapPlanting;
use App\Models\Plant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class PlantApiController extends BaseController
{
    public function field($id)
    {
        // $id -> id farmer
        $datas = Field::join('field_categories', 'fields.field_category_id', '=', 'field_categories.id')
            ->join('gapoktans', 'fields.gapoktan_id', '=', 'gapoktans.id')
            ->join('farmers', 'fields.farmer_id', '=', 'farmers.id')
            ->select('fields.*', 'field_categories.name as name')
            ->where('fields.farmer_id', $id)
            ->where('fields.status', '!=', 'tandur')
            ->where('fields.status', '!=', 'panen')
            ->where('fields.status', '!=', 'belum selesai panen')
            ->orderBy('fields.updated_at', 'desc')
            ->paginate(7);
        $result = fieldResources::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function plant($id)
    {
        // $id -> id farmer
        $datas = FieldRecapPlanting::join('fields', 'field_recap_plantings.field_id', '=', 'fields.id')
            ->join('farmers', 'field_recap_plantings.farmer_id', '=', 'farmers.id')
            ->select('field_recap_plantings.*', 'fields.farmer_id as name')
            ->where('farmers.user_id', '=', $id)
            ->orderBy('field_recap_plantings.updated_at', 'desc')
            ->paginate(7);
        $results = PlantResource::collection($datas);
        return $this->sendResponse($results, 'Data fetched');
    }

    // tambah tandur
    public function storePlant(Request $request)
    {
        $plant = Field::find($request->field_id);
        $plant->status = 'tandur';
        $plant->save();

        $planting = FieldRecapPlanting::where('field_id', $request->field_id)->create([
            'field_id' => $request->field_id,
            'farmer_id' => $request->farmer_id,
            'date_planting' => Carbon::parse($request->date_planting)->format('Y-m-d'),
            'status' => 'melakukan tandur',
        ]);

        return $this->sendResponse($planting, 'Data fetched');
    }

    ////////////////////

    // Panen
    public function plantDataForHarvest($id)
    {
        $datas = FieldRecapPlanting::join('fields', 'field_recap_plantings.field_id', '=', 'fields.id')
            ->join('farmers', 'field_recap_plantings.farmer_id', '=', 'farmers.id')
            ->select('field_recap_plantings.*', 'fields.farmer_id as name')
            ->where('farmers.user_id', '=', $id)
            ->where('field_recap_plantings.status', '!=', 'sudah panen')
            ->where('field_recap_plantings.status', '!=', 'belum selesai panen')
            ->orderBy('field_recap_plantings.updated_at', 'desc')
            ->paginate(7);

        $results = PlantResource::collection($datas);
        return $this->sendResponse($results, 'Data fetched');
    }

    public function harvest($id)
    {
        $result = FieldRecapHarvest::join('field_recap_plantings', 'field_recap_harvests.planting_id', '=', 'field_recap_plantings.id')
            ->join('farmers', 'field_recap_harvests.farmer_id', '=', 'farmers.id')
            ->select('field_recap_harvests.*', 'farmers.user_id as name')
            ->where('farmers.user_id', '=', $id)
            ->orderBy('field_recap_harvests.updated_at', 'desc')
            ->paginate(7);

        $results = HarvestResource::collection($result);
        return $this->sendResponse($results, 'Data fetched');
    }


    public function doHarvest(Request $request)
    {
        // plant_id
        // farmer_id
        // date_farmer
        // status

        if ($request->status === 'panen') {
            $planting = FieldRecapHarvest::where('planting_id', $request->plant_id)->create([
                'planting_id' => $request->plant_id,
                'farmer_id' => $request->farmer_id,
                'date_harvest' => Carbon::parse($request->date_harvest)->format('Y-m-d h:i:s'),
                'status' => $request->status,
            ]);

            $plant = Field::find($request->field_id);
            $plant->status = $request->status;
            $plant->save();

            $planting = FieldRecapPlanting::find($request->field_id)->update([
                'status' => 'sudah panen',
            ]);
        } elseif ($request->status === 'belum selesai panen') {
            $planting = FieldRecapHarvest::where('planting_id', $request->plant_id)->create([
                'planting_id' => $request->plant_id,
                'farmer_id' => $request->farmer_id,
                'date_harvest' => Carbon::parse($request->date_harvest)->format('Y-m-d h:i:s'),
                'status' => $request->status,
            ]);

            $plant = Field::find($request->field_id);
            $plant->status = $request->status;
            $plant->save();

            $planting = FieldRecapPlanting::find($request->field_id)->update([
                'status' => $request->status,
            ]);
        }

        // return response()->json([
        //     'status' => 200,
        // ]);
        return $this->sendResponse($planting, 'Data fetched');
    }

    // update
    public function updatePanen(Request $request)
    {
        // id
        // field_id
        // plant_id
        // farmer_id
        // date_harvest
        // status
        $planting = FieldRecapHarvest::find($request->id)->update([
            'planting_id' => $request->plant_id,
            'farmer_id' => $request->farmer_id,
            'date_harvest' => Carbon::parse($request->date_harvest)->format('Y-m-d h:i:s'),
            'status' => $request->status,
        ]);

        $plant = Field::where('id', $request->field_id)->first();
        $plant->status = $request->status;
        $plant->save();

        return response()->json([
            'status' => 200,
        ]);
    }




    /////////////////////////////

    public function index()
    {
        $datas = Plant::latest()->get();
        $result = PlantResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function indexByIdUser($id)
    {
        $datas = Plant::where('farmer_id', $id)->latest()->get();
        $result = PlantResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'plant_tanaman' => 'required',
            'surface_area' => 'required',
            'address' => 'required',
            'plating_date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $datas = Plant::create([
            'id' => $request->id,
            'farmer_id' => $request->farmer_id,
            'poktan_id' => $request->poktan_id,
            "plant_tanaman" => $request->plant_tanaman,
            'surface_area' => $request->surface_area,
            'address' => $request->address,
            'plating_date' => $request->plating_date,
            'harvest_date' => $request->harvest_date,
            'status' => "tandur",
        ]);
        $result = PlantResource::make($datas);
        return $this->sendResponse($result, 'Data Strored');
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'plant_tanaman' => 'required',
            'surface_area' => 'required',
            'plating_date' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $datas = Plant::findOrFail($id);

        $datas->update([
            "plant_tanaman" => $request->plant_tanaman,
            'surface_area' => $request->surface_area,
            'address' => $request->address,
            'plating_date' => $request->plating_date,
            'harvest_date' => $request->harvest_date,
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }

    public function addHarvestDate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'harvest_date' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $datas = Plant::findOrFail($id);

        $datas->update([
            'harvest_date' => $request->harvest_date,
            'status' => "panen",
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }

    public function updateStatus($id)
    {
        $datas = Plant::findOrFail($id);

        $datas->update([
            'status' => "selesai",
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }

    public function destroy($id)
    {
        $data = Plant::findOrFail($id);
        $data->delete();

        return $this->sendResponse($data, 'Data deleted');
    }
}
