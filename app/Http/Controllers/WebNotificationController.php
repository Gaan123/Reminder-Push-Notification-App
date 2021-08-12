<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class WebNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home',['user'=>auth()->user()]);
    }

    public function storeToken(Request $request)
    {
        auth()->user()->update(['device_key'=>$request->token]);
        return response()->json(['Token successfully stored.']);
    }

    public function updateSettings(Request $request)
    {
        $data=[
            'snooze_time' => $request->input('snooze_time')?$request->input('snooze_date').' '.$request->input('snooze_time'):null,
            'notification' => $request->input('notification') ? 1 : 0
        ];
       auth()->user()->update($data);
       return redirect()->back();
    }
}
