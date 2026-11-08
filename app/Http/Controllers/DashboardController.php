<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $comments = $user->kritiks()->with('film')->latest()->limit(10)->get();

        return view('dashboard', [
            'user' => $user,
            'commentCount' => $user->kritiks()->count(),
            'comments' => $comments,
        ]);
    }
}
