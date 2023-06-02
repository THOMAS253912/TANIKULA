<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Str;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController as BaseController;


class ProductApiController extends BaseController
{
    public function index()
    {
        $datas = Product::latest()->get();

        $result = ProductResource::collection($datas);
        return $this->sendResponse($result, 'Data fetched');
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        } 
 
        $datas = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_product_id' => $request->category_product_id, 
            'code' => $request->code, 
            'stoke' => $request->stoke, 
            'price' => $request->price, 
            // 'image' => $fileName,
            'user_id' => $request->user_id, 
            'desc' => $request->desc, 
        ]);

        $result = ProductResource::make($datas);
        return $this->sendResponse($result, 'Data Strored');
        // return $result;
    }


    public function show($slug)
    {
        $product = Product::where('slug',$slug)->firstOrfail();
        return $this->sendResponse($product, 'Data fetched');
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        // $validator = Validator::make($request->all(),[
        //     'name' => 'required'
        // ]);

        // if($validator->fails()){
        //     return $this->sendError("Validation Error", $validator->errors());
        // }

        $datas = Product::findOrFail($id);

        $datas->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_product_id' => $request->category_product_id, 
            'stoke' => $request->stoke, 
            'price' => $request->price, 
            'desc' => $request->desc, 
        ]);

        $datas->update();

        return $this->sendResponse($datas, 'Data Updated');
    }

    public function destroy($id)
    {
        $data = Product::findOrFail($id);
        $data->delete();

        return $this->sendResponse($data, 'Data deleted');
    }

    public function search($name)
    {
        $datas = Product::where('name', 'LIKE', '%'. $name. '%')->get();
        if(count($datas)){
            // return Response()->json($datas);
            // return response()->json(['Data Found.', $datas]);
            $result = ProductResource::collection($datas);
            return $this->sendResponse($result, 'Data fetched');
        }
        else
        {
            return response()->json(['Result' => 'No Data not found'], 404);
      }
    }
}
