<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CastController extends Controller
{
    public function index(): View
    {
        return view('admin.resources.index', [
            'title' => 'Cast',
            'resourceRoute' => 'admin.casts',
            'items' => Cast::orderBy('name')->paginate(20),
            'columns' => ['name' => 'Nama', 'age' => 'Umur', 'bio' => 'Biografi'],
        ]);
    }

    public function create(): View
    {
        return $this->form(new Cast(), 'Tambah cast', 'admin.casts.store', 'POST');
    }

    public function store(Request $request): RedirectResponse
    {
        Cast::create($this->validated($request));

        return redirect()->route('admin.casts.index')->with('status', 'Cast berhasil ditambahkan.');
    }

    public function edit(Cast $cast): View
    {
        return $this->form($cast, 'Ubah cast', 'admin.casts.update', 'PUT');
    }

    public function update(Request $request, Cast $cast): RedirectResponse
    {
        $cast->update($this->validated($request));

        return redirect()->route('admin.casts.index')->with('status', 'Cast berhasil diperbarui.');
    }

    public function destroy(Cast $cast): RedirectResponse
    {
        if ($cast->perans()->exists()) {
            return back()->withErrors(['delete' => 'Cast yang masih digunakan oleh data peran tidak dapat dihapus.']);
        }

        $cast->delete();

        return redirect()->route('admin.casts.index')->with('status', 'Cast berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:45'],
            'age' => ['required', 'integer', 'min:0', 'max:120'],
            'bio' => ['required', 'string', 'max:10000'],
        ]);
    }

    private function form(Cast $cast, string $title, string $action, string $method): View
    {
        return view('admin.resources.form', [
            'title' => $title,
            'action' => $action,
            'method' => $method,
            'resourceRoute' => 'admin.casts',
            'item' => $cast,
            'fields' => [
                ['name' => 'name', 'label' => 'Nama', 'type' => 'text'],
                ['name' => 'age', 'label' => 'Umur', 'type' => 'number'],
                ['name' => 'bio', 'label' => 'Biografi', 'type' => 'textarea'],
            ],
        ]);
    }
}
