<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\Poktan;
use App\Models\Gapoktan;
use App\Models\Field;
use App\Models\FieldRecapPlanting;
use App\Models\FieldRecapHarvest;
use App\Models\Education;
use App\Models\Activity;
use Redirect, Response;
Use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $year = ['2022','2023'];

        $fields = [];
        $plant = [];
        $harvest = [];
        foreach ($year as $key => $value) {
            $farmers = Farmer::where('user_id', auth()->user()->id)->first();
            $fields[] = Field::join('field_categories', 'fields.field_category_id', '=', 'field_categories.id')
                    ->join('gapoktans', 'fields.gapoktan_id', '=', 'gapoktans.id')
                    ->join('farmers', 'fields.farmer_id', '=', 'farmers.id')
                    ->select('fields.*', 'field_categories.name as name')
                    ->where('fields.farmer_id', $farmers->id)
                    ->where(\DB::raw("DATE_FORMAT(fields.created_at, '%Y')"),$value)
                    ->count();
            $plant[] = FieldRecapPlanting::join('fields', 'field_recap_plantings.field_id', '=', 'fields.id')
                    ->join('farmers', 'field_recap_plantings.farmer_id', '=', 'farmers.id')
                    ->select('field_recap_plantings.*', 'fields.farmer_id as name')
                    ->where('farmers.user_id', '=', auth()->user()->id)
                    ->where(\DB::raw("DATE_FORMAT(field_recap_plantings.created_at, '%Y')"),$value)
                    ->count();
            $harvest[] = FieldRecapHarvest::join('field_recap_plantings', 'field_recap_harvests.planting_id', '=', 'field_recap_plantings.id')
                    ->join('farmers', 'field_recap_harvests.farmer_id', '=', 'farmers.id')
                    ->select('field_recap_harvests.*', 'farmers.user_id as name')
                    ->where('farmers.user_id', '=', auth()->user()->id)
                    ->where('field_recap_harvests.status', '=', 'panen')
                    ->where(\DB::raw("DATE_FORMAT(field_recap_harvests.created_at, '%Y')"),$value)
                    ->count();
        }

    	return view('petani.dashboard.index')
                ->with('year',json_encode($year,JSON_NUMERIC_CHECK))
                ->with('fields',json_encode($fields,JSON_NUMERIC_CHECK))
                ->with('plant',json_encode($plant,JSON_NUMERIC_CHECK))
                ->with('harvest',json_encode($harvest,JSON_NUMERIC_CHECK));
    }

    // handle fetch all eamployees ajax request
	public function fetchAll(Request $request)
    {
        $gapoktan = Gapoktan::join('farmers', 'gapoktans.id', '=', 'farmers.gapoktan_id')
                ->join('users', 'farmers.user_id', '=', 'users.id')
                ->select('gapoktans.*', 'users.name as name')
                ->where('farmers.user_id', auth()->user()->id)
                ->orderBy('gapoktans.updated_at', 'desc')
                ->first();
        $poktan = Poktan::join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                ->join('users', 'poktans.user_id', '=', 'users.id')
                ->select('poktans.*', 'users.name as name')
                ->where('gapoktans.id', $gapoktan->id)
                ->orderBy('poktans.updated_at', 'desc')
                ->get();
        foreach($poktan as $poktan){
            $userIdPoktan = $poktan['user_id'];
            $checkPosted[] = $userIdPoktan;
        }
        $checkPosted[] = $gapoktan->user_id;
        // dd($checkPosted);
        $countEducation = Education::join('education_categories', 'education.category_education_id', '=', 'education_categories.id')
                    ->join('users', 'education.user_id', '=', 'users.id')
                    ->select('education.*', 'education_categories.name as name')
                    ->where('education_categories.is_active', '=', 1)
                    ->where(static function ($query) use ($checkPosted) {
                        return $query->whereIn('user_id', $checkPosted);
                    })
                    ->count();
        $countActivity = Activity::join('activity_categories', 'activities.category_activity_id', '=', 'activity_categories.id')
                    ->join('users', 'activities.user_id', '=', 'users.id')
                    ->select('activities.*', 'activity_categories.name as name')
                    ->where('activity_categories.is_active', '=', 1)
                    ->where(static function ($query) use ($checkPosted) {
                        return $query->whereIn('user_id', $checkPosted);
                    })
                    ->count();

		$output = '';
            $output .= '
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #16A085">
                            <i class="far fa-solid fa-clapperboard"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total post Edukasi</h4>
                            </div>
                            <div class="card-body">
                                '.$countEducation.'
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #16A085">
                            <i class="far fa-solid fa-clipboard"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total post Kegiatan</h4>
                            </div>
                            <div class="card-body">
                                '.$countActivity.'
                            </div>
                        </div>
                    </div>
                </div>';
			echo $output;
	}
}
