<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AlbumStatus;
use App\Enums\Visibility;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\AlbumCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AlbumController extends Controller
{
    public function index(): View
    {
        $albums = Album::with('category')
            ->withCount('photos')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('admin.albums.index', ['albums' => $albums]);
    }

    public function create(): View
    {
        return view('admin.albums.form', [
            'album' => new Album,
            'categories' => AlbumCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $rawPassword = $data['password'];
        unset($data['password']);

        $album = new Album($data);
        $album->user_id = Auth::id();

        if ($album->visibility === Visibility::Password && $rawPassword) {
            $album->password = Hash::make($rawPassword);
        }

        if ($album->status === AlbumStatus::Published && ! $album->published_at) {
            $album->published_at = now();
        }

        if ($request->hasFile('cover_image')) {
            $album->cover_image = $this->storeCover($request);
        }

        $album->save();

        return redirect()->route('admin.albums.index')->with('status', 'Álbum criado com sucesso.');
    }

    public function edit(Album $album): View
    {
        return view('admin.albums.form', [
            'album' => $album,
            'categories' => AlbumCategory::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Album $album): RedirectResponse
    {
        $data = $this->validated($request, $album->id);
        $rawPassword = $data['password'];
        unset($data['password']);

        $album->fill($data);

        if ($album->visibility === Visibility::Password && $rawPassword) {
            $album->password = Hash::make($rawPassword);
        }

        if ($album->status === AlbumStatus::Published && ! $album->published_at) {
            $album->published_at = now();
        }

        if ($request->hasFile('cover_image')) {
            if ($album->cover_image) {
                Storage::disk('photos_public')->delete($album->cover_image);
            }

            $album->cover_image = $this->storeCover($request);
        }

        $album->save();

        return redirect()->route('admin.albums.index')->with('status', 'Álbum atualizado com sucesso.');
    }

    public function destroy(Album $album): RedirectResponse
    {
        if ($album->cover_image) {
            Storage::disk('photos_public')->delete($album->cover_image);
        }

        $album->delete();

        return redirect()->route('admin.albums.index')->with('status', 'Álbum removido.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:albums,slug'.($ignoreId ? ",{$ignoreId}" : '')],
            'description' => ['nullable', 'string'],
            'event_name' => ['nullable', 'string', 'max:255'],
            'event_location' => ['nullable', 'string', 'max:255'],
            'event_date' => ['nullable', 'date'],
            'category_id' => ['nullable', 'exists:album_categories,id'],
            'status' => ['required', 'in:draft,published,private,archived,closed'],
            'visibility' => ['required', 'in:public,private,password'],
            'password' => ['nullable', 'string', 'min:4'],
            'sort_order' => ['nullable', 'integer'],
            'cover_image' => ['nullable', 'image', 'max:8192'],
        ]);

        unset($data['cover_image']);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['status'] = AlbumStatus::from($data['status']);
        $data['visibility'] = Visibility::from($data['visibility']);
        $data['password'] = $data['password'] ?? null;

        return $data;
    }

    private function storeCover(Request $request): string
    {
        $path = 'covers/'.Str::uuid().'.'.$request->file('cover_image')->extension();

        Storage::disk('photos_public')->putFileAs(
            'covers',
            $request->file('cover_image'),
            basename($path)
        );

        return $path;
    }
}
