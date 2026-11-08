<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Peran;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'filmCount' => Film::count(),
            'castCount' => Cast::count(),
            'genreCount' => Genre::count(),
            'peranCount' => Peran::count(),
            'userCount' => User::count(),
        ]);
    }
}
