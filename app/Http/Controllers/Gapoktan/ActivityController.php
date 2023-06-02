<?php

namespace App\Http\Controllers\Gapoktan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Poktan;
use App\Models\Gapoktan;
use App\Models\ActivityCategory;
use App\Models\PushNotification;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ActivityController extends Controller
{
    // set index page view
    public function index()
    {
        $gapoktans = Gapoktan::where('user_id', auth()->user()->id)->first();
        $category = ActivityCategory::where('gapoktan_id', $gapoktans->id)->where('is_active', '=', 1)->get();
        return view('gapoktan.kegiatan.index', compact('category'));
    }

    // handle fetch all eamployees ajax request
    public function fetchAddActivity()
    {
        $emps = Activity::join('activity_categories', 'activities.category_activity_id', '=', 'activity_categories.id')
            ->join('users', 'activities.user_id', '=', 'users.id')
            ->select('activities.*', 'activity_categories.name as name')
            ->where('activity_categories.is_active', '=', 1)
            ->where('user_id', auth()->user()->id)
            ->orderBy('activities.updated_at', 'desc')
            ->get();
        $output = '';
        if ($emps->count() > 0) {
            $output .= '<table id="table_add_activity" class="table table-striped table-sm text-center align-middle">
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
            $nomor = 1;
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

    // handle fetch all eamployees ajax request
    public function fetchDraftActivity()
    {
        $poktan = Poktan::join('gapoktans', 'poktans.gapoktan_id', '=', 'gapoktans.id')
                ->join('users', 'poktans.user_id', '=', 'users.id')
                ->select('poktans.*', 'users.name as name')
                ->where('gapoktans.user_id', auth()->user()->id)
                ->orderBy('poktans.updated_at', 'desc')
                ->get();
        foreach($poktan as $poktan){
            $userIdPoktan = $poktan['user_id'];
            $checkPosted[] = $userIdPoktan;
        }
        $checkPosted[] = auth()->user()->id;
        // dd($checkPosted);
        $emps = Activity::join('activity_categories', 'activities.category_activity_id', '=', 'activity_categories.id')
            ->join('users', 'activities.user_id', '=', 'users.id')
            ->select('activities.*', 'activity_categories.name as name')
            ->where('activity_categories.is_active', '=', 1)
            ->where(static function ($query) use ($checkPosted) {
                return $query->whereIn('user_id', $checkPosted);
            })
            ->orderBy('activities.updated_at', 'desc')
            ->get();
        $output = '';
        if ($emps->count() > 0) {
            $output .= '<table id="table_draft_activity" class="table table-striped table-sm text-center align-middle">
            <thead>
              <tr>
                <th>No</th>
                <th>Dibuat Oleh</th>
                <th>Judul Kegiatan</th>
                <th>Tanggal Kegiatan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>';
            $nomor = 1;
            foreach ($emps as $emp) {
                $output .= '<tr>';
                $output .= '<td>' . $nomor++ . '</td>';
                $output .= '<td>' . $emp->user->name . '</td>';
                $output .= '<td>' . $emp->title . '</td>';
                $output .= '<td>' . date("d F Y", strtotime($emp->date)) . '</td>
                <td>
                  <a href="#" id="' . $emp->id . '" class="text-success mx-1 showDraftActivity" data-toggle="modal" data-target="#showDraftActivityModal"><i class="bi-eye h4"></i></a>
                </td>
              </tr>';
            }
            $output .= '</tbody></table>';
            echo $output;
        } else {
            echo '<h1 class="text-center text-secondary my-5">Tidak ada data Kegiatan!</h1>';
        }
    }

    // handle edit an employee ajax request
    public function show(Request $request)
    {
        $id = $request->id;
        $emp = Activity::with('user', 'activity_category')->find($id);
        return response()->json($emp);
    }

    // handle insert a new employee ajax request
    public function store(Request $request)
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

        if ($validator->fails()) {
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
            $activity->user_id = auth()->user()->id;
            $activity->save();

            // $notification = new NotificationActivity();
            // $notification->activity_id = $activity->id;
            // $notification->save();

            // Push Notification
            $user_id = auth()->user()->id;
            $url = "https://fcm.googleapis.com/fcm/send";
            $SERVER_API_KEY = 'AAAASSWA7hI:APA91bGkfIJFNGyqIJAiKtLXI79XdZpDuicn7pQrFv-yXdbLmLQETRkRkCY5VnGZBfwRevDkUJdA0ADnJ7Z5r1rnS4flS-ds8yxe_bp4sXouzH8Nfj-PHYCGl8-pVKkE49WqsSuPkKtd';
            $headers = [
                'Authorization' => 'key=' . $SERVER_API_KEY,
                'Content-Type' => 'application/json',
            ];

            PushNotification::create([
                'user_id' => auth()->user()->id,
                "title" => "Kegiatan Terbaru",
                "body" => $request->title,
                "img" => "fas fa-clipboard",
            ]);

            Http::withHeaders($headers)->post($url, [
                // "to" => "cWmdLu_QQqa6CR28k2aDtJ:APA91bHs2-K9fkZ7rOIUOvrq2bEtlxNpTUoZSn7-TpOcNpfmbwFRfhY1NPBCjYv53uCHJLfFPmsmG84pSWXmG2ezDVkv-opbrM-AaQ42j_UKso-qAqGWlMoJv0AhffI2NAaKTv9DIe0v",
                'to' => '/topics/topic_user_id_' . $user_id,
                "notification" => [
                    "title" => "Kegiatan Terbaru",
                    "body" => $request->title,
                    "mutable_content" => true,
                    "sound" => "Tri-tone"
                ]
            ]);

            return response()->json([
                'status' => 200,
            ]);
        }
    }

    // handle edit an employee ajax request
    public function edit(Request $request)
    {
        $id = $request->id;
        $emp = Activity::find($id);
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

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $activity = Activity::find($request->emp_id);
            $activity->title = $request->title;
            $activity->slug = $request->slug;
            $activity->category_activity_id = $request->category_activity_id;
            $activity->desc = $request->desc;
            $activity->date = Carbon::createFromFormat('d-M-Y', $request->date)->format('Y-m-d h:i:s');
            $activity->user_id = auth()->user()->id;
            $activity->save();

            $notification = new NotificationActivity();
            $notification->activity_id = $activity->id;
            $notification->save();
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
