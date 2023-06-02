<?php

namespace App\Http\Controllers\Gapoktan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Farmer;
use App\Models\Gapoktan;
use App\Models\Field;
use App\Models\FieldRecapPlanting;
use App\Models\FieldRecapHarvest;
use App\Models\Education;
use App\Models\Activity;
use App\Models\Poktan;
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
		    $gapoktans = Gapoktan::with('user')->where('user_id', auth()->user()->id)->first();
            $fields[] = Field::join('field_categories', 'fields.field_category_id', '=', 'field_categories.id')
                    ->join('gapoktans', 'fields.gapoktan_id', '=', 'gapoktans.id')
                    ->join('farmers', 'fields.farmer_id', '=', 'farmers.id')
                    ->select('fields.*', 'field_categories.name as name')
                    ->where(\DB::raw("DATE_FORMAT(fields.created_at, '%Y')"),$value)
                    ->where('fields.gapoktan_id', $gapoktans->id)
                    ->count();
            $plant[] = FieldRecapPlanting::join('fields', 'field_recap_plantings.field_id', '=', 'fields.id')
                    ->join('farmers', 'field_recap_plantings.farmer_id', '=', 'farmers.id')
                    ->select('field_recap_plantings.*', 'fields.farmer_id as name')
                    ->where('farmers.gapoktan_id', '=', $gapoktans->id)
                    ->where(\DB::raw("DATE_FORMAT(field_recap_plantings.created_at, '%Y')"),$value)
                    ->count();
            $harvest[] = FieldRecapHarvest::join('field_recap_plantings', 'field_recap_harvests.planting_id', '=', 'field_recap_plantings.id')
                    ->join('farmers', 'field_recap_harvests.farmer_id', '=', 'farmers.id')
                    ->select('field_recap_harvests.*', 'farmers.user_id as name')
                    ->where('farmers.gapoktan_id', '=', $gapoktans->id)
                    ->where('field_recap_harvests.status', '=', 'panen')
                    ->where(\DB::raw("DATE_FORMAT(field_recap_harvests.created_at, '%Y')"),$value)
                    ->count();
        }

    	return view('gapoktan.dashboard.index')
                ->with('year',json_encode($year,JSON_NUMERIC_CHECK))
                ->with('fields',json_encode($fields,JSON_NUMERIC_CHECK))
                ->with('plant',json_encode($plant,JSON_NUMERIC_CHECK))
                ->with('harvest',json_encode($harvest,JSON_NUMERIC_CHECK));
    }

    // handle fetch all eamployees ajax request
	public function fetchAll(Request $request) {
		$gapoktans = Gapoktan::with('user')->where('user_id', auth()->user()->id)->first();
        $countPlant = FieldRecapPlanting::join('fields', 'field_recap_plantings.field_id', '=', 'fields.id')
                    ->join('farmers', 'field_recap_plantings.farmer_id', '=', 'farmers.id')
                    ->select('field_recap_plantings.*', 'fields.farmer_id as name')
                    ->where('farmers.gapoktan_id', '=', $gapoktans->id)
                    ->orderBy('updated_at', 'desc')
                    ->count();
        $countHarvest = FieldRecapHarvest::join('field_recap_plantings', 'field_recap_harvests.planting_id', '=', 'field_recap_plantings.id')
                    ->join('farmers', 'field_recap_harvests.farmer_id', '=', 'farmers.id')
                    ->select('field_recap_harvests.*', 'farmers.user_id as name')
                    ->where('farmers.gapoktan_id', '=', $gapoktans->id)
                    ->orderBy('updated_at', 'desc')
                    ->count();
        $countFarmer = Farmer::join('poktans', 'farmers.poktan_id', '=', 'poktans.id')
                    ->join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                    ->join('users', 'farmers.user_id', '=', 'users.id')
                    ->where('gapoktans.user_id', '=', auth()->user()->id)
                    ->count();
        $countFarmerActive = Farmer::join('poktans', 'farmers.poktan_id', '=', 'poktans.id')
                    ->join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                    ->join('users', 'farmers.user_id', '=', 'users.id')
                    ->where('farmers.is_active', '=', 1)
                    ->where('gapoktans.user_id', '=', auth()->user()->id)
                    ->count();
        $countFarmerDeactive = Farmer::join('poktans', 'farmers.poktan_id', '=', 'poktans.id')
                    ->join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                    ->join('users', 'farmers.user_id', '=', 'users.id')
                    ->where('farmers.is_active', '=', 0)
                    ->where('gapoktans.user_id', '=', auth()->user()->id)
                    ->count();
        $countPoktan = Poktan::join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                    ->join('users', 'poktans.user_id', '=', 'users.id')
                    ->where('gapoktans.user_id', '=', auth()->user()->id)
                    ->count();
        $countPoktanActive = Poktan::join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                    ->join('users', 'poktans.user_id', '=', 'users.id')
                    ->where('poktans.is_active', '=', 1)
                    ->where('gapoktans.user_id', '=', auth()->user()->id)
                    ->count();
        $countPoktanDeactive = Poktan::join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                    ->join('users', 'poktans.user_id', '=', 'users.id')
                    ->where('poktans.is_active', '=', 0)
                    ->where('gapoktans.user_id', '=', auth()->user()->id)
                    ->count();
        $countEducation = Education::join('education_categories', 'education.category_education_id', '=', 'education_categories.id')
                    ->join('users', 'education.user_id', '=', 'users.id')
                    ->select('education.*', 'education_categories.name as name')
                    ->where('education_categories.is_active', '=', 1)
                    ->where('user_id', auth()->user()->id)
                    ->count();
        $countActivity = Activity::join('activity_categories', 'activities.category_activity_id', '=', 'activity_categories.id')
                    ->join('users', 'activities.user_id', '=', 'users.id')
                    ->select('activities.*', 'activity_categories.name as name')
                    ->where('activity_categories.is_active', '=', 1)
                    ->where('user_id', auth()->user()->id)
                    ->count();

		$output = '';
            $output .= '
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #16A085">
                            <i class="far fa-solid fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Akun Poktan</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div>
                                        '.$countPoktan.'
                                    </div>
                                    <div class="mt-2 pl-2">
                                        <div style="font-size: 9px"><i class="fas fa-circle text-success" style="font-size: 9px"></i> Aktif('.$countPoktanActive.')</div>
                                        <div style="font-size: 9px"><i class="fas fa-circle text-danger" style="font-size: 9px"></i> Belum aktif('.$countPoktanDeactive.')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #16A085">
                            <i class="far fa-solid fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Akun Petani</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-row">
                                    <div>
                                        '.$countFarmer.'
                                    </div>
                                    <div class="mt-2 pl-2">
                                        <div style="font-size: 9px"><i class="fas fa-circle text-success" style="font-size: 9px"></i> Aktif('.$countFarmerActive.')</div>
                                        <div style="font-size: 9px"><i class="fas fa-circle text-danger" style="font-size: 9px"></i> Belum aktif('.$countFarmerDeactive.')</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #16A085">
                            <i class="far fa-solid fa-calendar-days"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Tandur</h4>
                            </div>
                            <div class="card-body">
                                '.$countPlant.'
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #16A085">
                            <i class="far fa-solid fa-calendar-check"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Panen</h4>
                            </div>
                            <div class="card-body">
                                '.$countHarvest.'
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon" style="background: #16A085">
                            <i class="far fa-solid fa-clapperboard"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Post Edukasi</h4>
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
                                <h4>Post Kegiatan</h4>
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
