<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Farmer;
use App\Models\Field;
use App\Models\FieldRecapPlanting;
use App\Models\FieldRecapHarvest;
use App\Models\Product;
use App\Models\Education;
use App\Models\Activity;
use App\Models\Poktan;
use App\Models\Gapoktan;
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
            $fields[] = Field::join('field_categories', 'fields.field_category_id', '=', 'field_categories.id')
                    ->join('gapoktans', 'fields.gapoktan_id', '=', 'gapoktans.id')
                    ->join('farmers', 'fields.farmer_id', '=', 'farmers.id')
                    ->select('fields.*', 'field_categories.name as name')
                    ->where(\DB::raw("DATE_FORMAT(fields.created_at, '%Y')"),$value)
                    ->count();
            $plant[] = FieldRecapPlanting::join('fields', 'field_recap_plantings.field_id', '=', 'fields.id')
                    ->join('farmers', 'field_recap_plantings.farmer_id', '=', 'farmers.id')
                    ->select('field_recap_plantings.*', 'fields.farmer_id as name')
                    ->where(\DB::raw("DATE_FORMAT(field_recap_plantings.created_at, '%Y')"),$value)
                    ->count();
            $harvest[] = FieldRecapHarvest::join('field_recap_plantings', 'field_recap_harvests.planting_id', '=', 'field_recap_plantings.id')
                    ->join('farmers', 'field_recap_harvests.farmer_id', '=', 'farmers.id')
                    ->select('field_recap_harvests.*', 'farmers.user_id as name')
                    ->where('field_recap_harvests.status', '=', 'panen')
                    ->where(\DB::raw("DATE_FORMAT(field_recap_harvests.created_at, '%Y')"),$value)
                    ->count();
        }

    	return view('admin.dashboard.index')
                ->with('year',json_encode($year,JSON_NUMERIC_CHECK))
                ->with('fields',json_encode($fields,JSON_NUMERIC_CHECK))
                ->with('plant',json_encode($plant,JSON_NUMERIC_CHECK))
                ->with('harvest',json_encode($harvest,JSON_NUMERIC_CHECK));
    }

    // handle fetch all eamployees ajax request
	public function fetchAll(Request $request) {
        $countPlant = FieldRecapPlanting::join('fields', 'field_recap_plantings.field_id', '=', 'fields.id')
                    ->join('farmers', 'field_recap_plantings.farmer_id', '=', 'farmers.id')
                    ->select('field_recap_plantings.*', 'fields.farmer_id as name')
                    ->orderBy('updated_at', 'desc')
                    ->count();
        $countHarvest = FieldRecapHarvest::join('field_recap_plantings', 'field_recap_harvests.planting_id', '=', 'field_recap_plantings.id')
                    ->join('farmers', 'field_recap_harvests.farmer_id', '=', 'farmers.id')
                    ->select('field_recap_harvests.*', 'farmers.user_id as name')
                    ->orderBy('updated_at', 'desc')
                    ->count();
        $countFarmer = Farmer::join('poktans', 'farmers.poktan_id', '=', 'poktans.id')
                    ->join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                    ->join('users', 'farmers.user_id', '=', 'users.id')
                    ->count();
        $countFarmerActive = Farmer::join('poktans', 'farmers.poktan_id', '=', 'poktans.id')
                    ->join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                    ->join('users', 'farmers.user_id', '=', 'users.id')
                    ->where('farmers.is_active', '=', 1)
                    ->count();
        $countFarmerDeactive = Farmer::join('poktans', 'farmers.poktan_id', '=', 'poktans.id')
                    ->join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                    ->join('users', 'farmers.user_id', '=', 'users.id')
                    ->where('farmers.is_active', '=', 0)
                    ->count();
        $countPoktan = Poktan::join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                    ->join('users', 'poktans.user_id', '=', 'users.id')
                    ->count();
        $countPoktanActive = Poktan::join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                    ->join('users', 'poktans.user_id', '=', 'users.id')
                    ->where('poktans.is_active', '=', 1)
                    ->count();
        $countPoktanDeactive = Poktan::join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                    ->join('users', 'poktans.user_id', '=', 'users.id')
                    ->where('poktans.is_active', '=', 0)
                    ->count();
        $countGapoktan = Gapoktan::join('users', 'gapoktans.user_id', '=', 'users.id')->count();
        $countEducation = Education::join('education_categories', 'education.category_education_id', '=', 'education_categories.id')
                    ->join('users', 'education.user_id', '=', 'users.id')
                    ->select('education.*', 'education_categories.name as name')
                    ->where('education_categories.is_active', '=', 1)
                    ->count();
        $countActivity = Activity::join('activity_categories', 'activities.category_activity_id', '=', 'activity_categories.id')
                    ->join('users', 'activities.user_id', '=', 'users.id')
                    ->select('activities.*', 'activity_categories.name as name')
                    ->where('activity_categories.is_active', '=', 1)
                    ->count();
        $countProduct = Product::join('product_categories', 'products.category_product_id', '=', 'product_categories.id')
                    ->join('users', 'products.user_id', '=', 'users.id')
                    ->select('products.*', 'product_categories.name as category_product')
                    ->where('product_categories.is_active', '=', 1)
                    ->count();

		$output = '';
            $output .= '
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                    <div class="inner">
                        <h5 class="font-weight-bold">Akun Gapoktan</h5>
                        <p>'. $countGapoktan .' Akun</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-solid fa-user text-warning"></i>
                    </div>
                    <a href="admin/daftar-gapoktan" class="mt-3 small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                    <div class="inner">
                        <h5 class="font-weight-bold">Akun Poktan</h5>

                        <h5>'. $countPoktan .' Akun</h5>
                        <div style="font-size: 9px"><i class="fas fa-circle text-success"></i> Aktif ('.$countPoktanActive.')</div>
                        <div style="font-size: 9px"><i class="fas fa-circle text-danger"></i> Belum aktif ('.$countPoktanDeactive.')</div>
                    </div>
                    <div class="icon">
                        <i class="far fa-solid fa-user text-primary"></i>
                    </div>
                    <a href="admin/daftar-poktan" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                    <div class="inner">
                        <h5 class="font-weight-bold">Akun Petani</h5>

                        <h5>'. $countFarmer .' Akun</h5>
                        <div style="font-size: 9px"><i class="fas fa-circle text-success"></i> Aktif ('.$countFarmerActive.')</div>
                        <div style="font-size: 9px"><i class="fas fa-circle text-danger"></i> Belum aktif ('.$countFarmerDeactive.')</div>
                    </div>
                    <div class="icon">
                        <i class="far fa-solid fa-user text-success"></i>
                    </div>
                    <a href="admin/daftar-petani" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                    <div class="inner">
                        <h5 class="font-weight-bold">Tandur</h5>
                        <p>'. $countPlant .' Kegiatan Tandur</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-solid fa-calendar-days"></i>
                    </div>
                    <a href="admin/tandur" class="mt-3 small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                    <div class="inner">
                        <h5 class="font-weight-bold">Panen</h5>
                        <p>'. $countHarvest .' Kegiatan Panen</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-solid fa-calendar-check"></i>
                    </div>
                    <a href="admin/panen" class="mt-3 small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                    <div class="inner">
                        <h5 class="font-weight-bold">Produk</h5>
                        <p>'. $countProduct .' Postingan Produk</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-solid fa-cart-plus"></i>
                    </div>
                    <a href="admin/produk" class="mt-3 small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                    <div class="inner">
                        <h5 class="font-weight-bold">Edukasi</h5>
                        <p>'. $countEducation .' Postingan Edukasi</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-solid fa-clapperboard"></i>
                    </div>
                    <a href="admin/edukasi" class="mt-3 small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-light">
                    <div class="inner">
                        <h5 class="font-weight-bold">Kegiatan</h5>
                        <p>'. $countActivity .' Postingan Kegiatan</p>
                    </div>
                    <div class="icon">
                        <i class="far fa-solid fa-clipboard"></i>
                    </div>
                    <a href="admin/kegiatan" class="mt-3 small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>';
			echo $output;
	}
}
