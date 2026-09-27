<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AlbumCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AlbumCategoryController extends Controller
{
    public function index(): View
    {
        $categories = AlbumCategory::withCount('albums')
            ->orderBy('order_column')
            ->get();

        return view('admin.categories.index', ['categories' => $categories]);
    }

    public function create(): View
    {
        return view('admin.categories.form', ['category' => new AlbumCategory]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        AlbumCategory::create($data);

        return redirect()->route('admin.categories.index')->with('status', 'Categoria criada com sucesso.');
    }

    public function edit(AlbumCategory $category): View
    {
        return view('admin.categories.form', ['category' => $category]);
    }

    public function update(Request $request, AlbumCategory $category): RedirectResponse
    {
        $data = $this->validated($request, $category->id);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('status', 'Categoria atualizada com sucesso.');
    }

    public function destroy(AlbumCategory $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Categoria removida.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:album_categories,slug'.($ignoreId ? ",{$ignoreId}" : '')],
            'description' => ['nullable', 'string'],
            'order_column' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active');
        $data['order_column'] = $data['order_column'] ?? 0;

        return $data;
    }
}
