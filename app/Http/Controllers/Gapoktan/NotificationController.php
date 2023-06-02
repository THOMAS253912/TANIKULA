<?php

namespace App\Http\Controllers\Gapoktan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotificationUser;
use App\Models\NotificationPlant;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function markNotificationUser(Request $request)
    {
        NotificationUser::where('id', $request->id)->update([
            'read_at' => Carbon::now(),
        ]);

        return response()->json();
    }

    public function markNotificationPlant(Request $request)
    {
        NotificationPlant::where('id', $request->id)->update([
            'read_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 200,
        ]);
    }

    public function markNotificationHarvest(Request $request)
    {
        NotificationPlant::where('id', $request->id)->update([
            'read_at' => Carbon::now(),
        ]);

        return response()->json([
            'status' => 200,
        ]);
    }
}
