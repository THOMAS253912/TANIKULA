<?php

namespace App\Http\Controllers\Petani;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NotificationActivity;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function markNotificationActivity(Request $request)
    {
        NotificationActivity::where('id', $request->id)->update([
            'read_at' => Carbon::now(),
        ]);

        return response()->json();
    }
}
