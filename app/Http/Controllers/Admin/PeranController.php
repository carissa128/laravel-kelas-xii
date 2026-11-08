<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Film;
use App\Models\Peran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PeranController extends Controller
{
    public function index(): View
    {
        return view('admin.resources.index', [
            'title' => 'Peran',
            'resourceRoute' => 'admin.perans',
            'items' => Peran::with(['cast', 'film'])->orderBy('id')->paginate(20),
            'columns' => ['actor' => 'Nama peran', 'cast.name' => 'Cast', 'film.title' => 'Film'],
        ]);
    }

    public function create(): View
    {
        return $this->form(new Peran(), 'Tambah peran', 'admin.perans.store', 'POST');
    }

    public function store(Request $request): RedirectResponse
    {
        Peran::create($this->validated($request));

        return redirect()->route('admin.perans.index')->with('status', 'Peran berhasil ditambahkan.');
    }

    public function edit(Peran $peran): View
    {
        return $this->form($peran, 'Ubah peran', 'admin.perans.update', 'PUT');
    }

    public function update(Request $request, Peran $peran): RedirectResponse
    {
        $peran->update($this->validated($request));

        return redirect()->route('admin.perans.index')->with('status', 'Peran berhasil diperbarui.');
    }

    public function destroy(Peran $peran): RedirectResponse
    {
        $peran->delete();

        return redirect()->route('admin.perans.index')->with('status', 'Peran berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'actor' => ['required', 'string', 'max:255'],
            'cast_id' => ['required', 'integer', 'exists:casts,id'],
            'film_id' => ['required', 'integer', 'exists:films,id'],
        ]);
    }

    private function form(Peran $peran, string $title, string $action, string $method): View
    {
        return view('admin.resources.form', [
            'title' => $title,
            'action' => $action,
            'method' => $method,
            'resourceRoute' => 'admin.perans',
            'item' => $peran,
            'fields' => [
                ['name' => 'actor', 'label' => 'Nama peran', 'type' => 'text'],
                ['name' => 'cast_id', 'label' => 'Cast', 'type' => 'select', 'options' => Cast::orderBy('name')->pluck('name', 'id')],
                ['name' => 'film_id', 'label' => 'Film', 'type' => 'select', 'options' => Film::orderBy('title')->pluck('title', 'id')],
            ],
        ]);
    }
}
