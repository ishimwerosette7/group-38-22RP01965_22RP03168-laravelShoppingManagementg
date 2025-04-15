<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;

class UserActivityController extends Controller
{
    public function index()
    {
        $activities = UserActivity::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.activities.index', compact('activities'));
    }

    public function show(UserActivity $activity)
    {
        if ($activity->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.activities.show', compact('activity'));
    }

    public static function logActivity($action, $details = null)
    {
        return UserActivity::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'ip_address' => request()->ip(),
            'login_time' => now(),
            'details' => $details,
        ]);
    }
} 