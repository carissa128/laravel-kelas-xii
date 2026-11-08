<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FilmController extends Controller
{
    public function index(): View
    {
        return view('admin.resources.index', [
            'title' => 'Film',
            'resourceRoute' => 'admin.films',
            'items' => Film::with('genre')->orderBy('title')->paginate(20),
            'columns' => ['title' => 'Judul', 'genre.name' => 'Genre', 'year' => 'Tahun'],
        ]);
    }

    public function create(): View
    {
        return $this->form(new Film(), 'Tambah film', 'admin.films.store', 'POST');
    }

    public function store(Request $request): RedirectResponse
    {
        Film::create($this->validated($request));

        return redirect()->route('admin.films.index')->with('status', 'Film berhasil ditambahkan.');
    }

    public function edit(Film $film): View
    {
        return $this->form($film, 'Ubah film', 'admin.films.update', 'PUT');
    }

    public function update(Request $request, Film $film): RedirectResponse
    {
        $film->update($this->validated($request));

        return redirect()->route('admin.films.index')->with('status', 'Film berhasil diperbarui.');
    }

    public function destroy(Film $film): RedirectResponse
    {
        if ($film->kritiks()->exists() || $film->perans()->exists()) {
            return back()->withErrors(['delete' => 'Film yang memiliki komentar atau data peran tidak dapat dihapus.']);
        }

        $film->delete();

        return redirect()->route('admin.films.index')->with('status', 'Film berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'sinopsis' => ['required', 'string', 'max:10000'],
            'year' => ['required', 'integer', 'min:1888', 'max:'.(now()->year + 5)],
            'poster' => ['required', 'string', 'max:2048'],
            'genre_id' => ['required', 'integer', 'exists:genres,id'],
        ]);
    }

    private function form(Film $film, string $title, string $action, string $method): View
    {
        return view('admin.resources.form', [
            'title' => $title,
            'action' => $action,
            'method' => $method,
            'resourceRoute' => 'admin.films',
            'item' => $film,
            'fields' => [
                ['name' => 'title', 'label' => 'Judul', 'type' => 'text'],
                ['name' => 'sinopsis', 'label' => 'Sinopsis', 'type' => 'textarea'],
                ['name' => 'year', 'label' => 'Tahun', 'type' => 'number'],
                ['name' => 'poster', 'label' => 'Path poster (contoh: template/images/film.jpg)', 'type' => 'text'],
                ['name' => 'genre_id', 'label' => 'Genre', 'type' => 'select', 'options' => Genre::orderBy('name')->pluck('name', 'id')],
            ],
        ]);
    }
}
