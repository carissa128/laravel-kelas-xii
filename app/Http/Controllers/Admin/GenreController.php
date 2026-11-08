<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class GenreController extends Controller
{
    public function index(): View
    {
        return view('admin.resources.index', [
            'title' => 'Genre',
            'resourceRoute' => 'admin.genres',
            'items' => Genre::orderBy('name')->paginate(20),
            'columns' => ['name' => 'Nama genre'],
        ]);
    }

    public function create(): View
    {
        return $this->form(new Genre(), 'Tambah genre', 'admin.genres.store', 'POST');
    }

    public function store(Request $request): RedirectResponse
    {
        Genre::create($this->validated($request));

        return redirect()->route('admin.genres.index')->with('status', 'Genre berhasil ditambahkan.');
    }

    public function edit(Genre $genre): View
    {
        return $this->form($genre, 'Ubah genre', 'admin.genres.update', 'PUT');
    }

    public function update(Request $request, Genre $genre): RedirectResponse
    {
        $genre->update($this->validated($request, $genre));

        return redirect()->route('admin.genres.index')->with('status', 'Genre berhasil diperbarui.');
    }

    public function destroy(Genre $genre): RedirectResponse
    {
        if ($genre->films()->exists()) {
            return back()->withErrors(['delete' => 'Genre yang masih digunakan oleh film tidak dapat dihapus.']);
        }

        $genre->delete();

        return redirect()->route('admin.genres.index')->with('status', 'Genre berhasil dihapus.');
    }

    private function validated(Request $request, ?Genre $genre = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:45', Rule::unique('genres', 'name')->ignore($genre?->id)],
        ]);
    }

    private function form(Genre $genre, string $title, string $action, string $method): View
    {
        return view('admin.resources.form', [
            'title' => $title,
            'action' => $action,
            'method' => $method,
            'resourceRoute' => 'admin.genres',
            'item' => $genre,
            'fields' => [['name' => 'name', 'label' => 'Nama genre', 'type' => 'text']],
        ]);
    }
}
