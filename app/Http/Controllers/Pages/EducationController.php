<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Education;
use App\Models\EducationCategory;
use App\Models\Farmer;
use App\Models\Poktan;
use App\Models\Gapoktan;
use App\Models\User;
use App\Models\HistoryEducation;
use Illuminate\Support\Carbon;

class EducationController extends Controller
{
    public function index()
    {
        $categories = EducationCategory::where('is_active', '=', 1)->get();
        // $farmer = Farmer::where('user_id', auth()->user()->id)->first();
        // $checkPosted = [$farmer->gapoktan->user_id, $farmer->poktan->user_id];

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
        $educations = Education::with('historyEducation')
                    ->join('education_categories', 'education.category_education_id', '=', 'education_categories.id')
                    ->join('users', 'education.user_id', '=', 'users.id')
                    ->select('education.*', 'education_categories.name as name')
                    ->where('education_categories.is_active', '=', 1)
                    ->where(static function ($query) use ($checkPosted) {
                        return $query->whereIn('user_id', $checkPosted);
                    })
                    ->orderBy('education.updated_at', 'desc')
                    ->filter(request(['kategori-edukasi', 'diposting-oleh', 'pencarian']))
                    ->paginate(6)
                    ->withQueryString();
        $educationsMore = Education::with('historyEducation')
                    ->join('education_categories', 'education.category_education_id', '=', 'education_categories.id')
                    ->join('users', 'education.user_id', '=', 'users.id')
                    ->select('education.*', 'education_categories.name as name')
                    ->where('education_categories.is_active', '=', 1)
                    ->where(static function ($query) use ($checkPosted) {
                        return $query->whereIn('user_id', $checkPosted);
                    })
                    ->orderByRaw('RAND()')
                    ->take(3)
                    ->get();
		return view('pages.edukasi.index', compact('educations', 'categories', 'educationsMore'));
	}

    public function show(Education $education)
    {
        $farmer = Farmer::where('user_id', '=', auth()->user()->id)->get();
        foreach ($farmer as $data) {
            $education = Education::findOrFail($education->id);
            if ($education) {
                $checkHistory = HistoryEducation::where('education_id', $education->id)->exists();
                if (!$checkHistory) {
                    $historyEducation = new HistoryEducation();
                    $historyEducation->education_id = $education->id;
                    $historyEducation->farmer_id = $data->id;
                    $historyEducation->save();
                }
            }
        }

        return view('pages.edukasi.detail', [
            'education' => $education,
            'educationsMore' => Education::with('historyEducation')
                    ->join('education_categories', 'education.category_education_id', '=', 'education_categories.id')
                    ->join('users', 'education.user_id', '=', 'users.id')
                    ->select('education.*', 'education_categories.name as name')
                    ->where('education_categories.is_active', '=', 1)
                    ->orderByRaw('RAND()')
                    ->take(3)
                    ->get(),
            'categories' => EducationCategory::where('is_active', '=', 1)->get()
        ]);
    }

    public function autocomplete(Request $request)
    {
        return Education::select('title')
        ->where('title', 'like', "%{$request->term}%")
        ->pluck('title');
    }
}
