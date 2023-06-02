<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\NotificationActivity;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ActivityController extends Controller
{
    // set index page view
	public function index() {
		$category = ActivityCategory::where('is_active', '=', 1)->get();
        $authorizedRoles = ['gapoktan', 'poktan'];
        $user = User::whereHas('roles', static function ($query) use ($authorizedRoles) {
            return $query->whereIn('name', $authorizedRoles);
        })->get();
		return view('admin.kegiatan.index', compact('category', 'user'));
	}

    // handle fetch all eamployees ajax request
	public function fetchAll() {
		$emps = Activity::join('activity_categories', 'activities.category_activity_id', '=', 'activity_categories.id')
                    ->join('users', 'activities.user_id', '=', 'users.id')
                    ->select('activities.*', 'activity_categories.name as name')
                    ->where('activity_categories.is_active', '=', 1)
                    ->orderBy('activities.updated_at', 'desc')
                    ->get();
		$output = '';
		if ($emps->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Kategori Kegiatan</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>';
            $nomor=1;
			foreach ($emps as $emp) {
				$output .= '<tr>';
                $output .= '<td>' . $nomor++ . '</td>';
                $output .= '<td style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;" class="p-0">' . $emp->title . '</td>';
                if (empty($emp->name)) {
                    $output .= '<td><a class="text-danger">Tidak ada kategori</a></p>';
                } else {
                    $output .= '<td>' . $emp->name . '</td>';
                }
                $output .= '<td>' . date("d F Y", strtotime($emp->date)) . '</td>
                <td style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 2; overflow: hidden;" class="p-0">' . $emp->desc . '</td>
                <td>
                  <a href="#" id="' . $emp->id . '" class="text-success mx-1 editIcon" data-toggle="modal" data-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i></a>
                  <a href="#" id="' . $emp->id . '" class="text-danger mx-1 deleteIcon"><i class="bi-trash h4"></i></a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">Tidak ada data Kegiatan!</h1>';
		}
	}

    // handle insert a new employee ajax request
	public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'title' => 'required|max:255',
            'category_activity_id' => 'required',
            'desc' => 'required',
            'date' => 'required',
        ], [
            'user_id.required' => 'Pilih user diperlukan!',
            'title.required' => 'Judul kegiatan diperlukan!',
            'title.max' => 'Judul kegiatan maksimal 255 karakter!',
            'category_activity_id.required' => 'Kategori kegiatan diperlukan!',
            'desc.required' => 'Deskripsi kegiatan diperlukan!',
            'date.required' => 'Tanggal kegiatan diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $activity = new Activity();
            $activity->title = $request->title;
            $activity->slug = $request->slug;
            $activity->category_activity_id = $request->category_activity_id;
            $activity->desc = $request->desc;
            $activity->date = Carbon::createFromFormat('d-M-Y', $request->date)->format('Y-m-d h:i:s');
            $activity->user_id = $request->user_id;
            $activity->save();

            $notification = new NotificationActivity();
            $notification->activity_id = $activity->id;
            $notification->save();

            return response()->json([
                'status' => 200,
            ]);
        }
	}

    // handle edit an employee ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$emp = Activity::with('user')->find($id);
		return response()->json($emp);
	}

	// handle update an employee ajax request
	public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'category_activity_id' => 'required',
            'desc' => 'required',
            'date' => 'required',
        ], [
            'title.required' => 'Judul kegiatan diperlukan!',
            'title.max' => 'Judul kegiatan maksimal 255 karakter!',
            'category_activity_id.required' => 'Kategori kegiatan diperlukan!',
            'desc.required' => 'Deskripsi kegiatan diperlukan!',
            'date.required' => 'Tanggal kegiatan diperlukan!',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $emp = Activity::find($request->emp_id);

            if ($request->user_id) {
                $empData = ['title' => $request->title, 'slug' => $request->slug, 'category_activity_id' => $request->category_activity_id, 'desc' => $request->desc];
                $empData['date'] = Carbon::createFromFormat('d-M-Y', $request->date)->format('Y-m-d h:i:s');
                $empData['user_id'] = $request->user_id;
            } else {
                $empData = ['title' => $request->title, 'slug' => $request->slug, 'category_activity_id' => $request->category_activity_id, 'desc' => $request->desc];
                $empData['date'] = Carbon::createFromFormat('d-M-Y', $request->date)->format('Y-m-d h:i:s');
            }
            $emp->update($empData);
            return response()->json([
                'status' => 200,
            ]);
        }
	}

    // handle delete an employee ajax request
	public function delete(Request $request)
    {
		$id = $request->id;
		// $emp = Activity::find($id);
		$emp = Activity::with('activity_category')->where('id', $id);
        $emp->delete();
	}

    public function checkSlug(Request $request)
    {
        // Old version: without uniqueness
        $slug = $request->title;

        // New version: to generate unique slugs
        $slug = SlugService::createSlug(Activity::class, 'slug', $request->title);

        return response()->json(['slug' => $slug]);
    }
}
