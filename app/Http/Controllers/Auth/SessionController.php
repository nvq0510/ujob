<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    public function index()
    {
        $userSessions = DB::table('sessions')
            ->where('user_id', Auth::id())
            ->get();

        return view('sessions.index', compact('userSessions'));
    }

    public function destroy($id)
    {
        DB::table('sessions')->where('id', $id)->delete();
        return redirect()->route('sessions.index')->with('success', 'Session logged out successfully.');
    }
}
