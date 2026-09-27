<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use App\Models\PhotoFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PhotoController extends Controller
{
    public function index(Album $album): View
    {
        $photos = $album->photos()->with('files')->orderBy('sort_order')->get();

        return view('admin.photos.index', ['album' => $album, 'photos' => $photos]);
    }

    public function store(Request $request, Album $album): RedirectResponse
    {
        $request->validate([
            'photos' => ['required', 'array', 'min:1'],
            'photos.*' => ['image', 'max:8192'],
        ]);

        $nextOrder = (int) $album->photos()->max('sort_order');

        foreach ($request->file('photos') as $file) {
            $nextOrder++;

            $path = 'gallery/'.$album->slug.'/'.Str::uuid().'.'.$file->extension();
            Storage::disk('photos_public')->putFileAs(
                dirname($path),
                $file,
                basename($path)
            );

            $photo = Photo::create([
                'album_id' => $album->id,
                'category_id' => $album->category_id,
                'user_id' => Auth::id(),
                'original_filename' => $file->getClientOriginalName(),
                'sort_order' => $nextOrder,
                'status' => 'published',
                'is_featured' => false,
            ]);

            PhotoFile::create([
                'photo_id' => $photo->id,
                'variant' => 'gallery',
                'disk' => 'photos_public',
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size_bytes' => $file->getSize(),
                ...$this->dimensions($file->getRealPath()),
            ]);
        }

        return redirect()->route('admin.albums.photos.index', $album)->with('status', 'Fotos enviadas com sucesso.');
    }

    public function toggleFeatured(Album $album, Photo $photo): RedirectResponse
    {
        $photo->update(['is_featured' => ! $photo->is_featured]);

        return redirect()->route('admin.albums.photos.index', $album)->with('status', 'Foto atualizada.');
    }

    public function destroy(Album $album, Photo $photo): RedirectResponse
    {
        foreach ($photo->files as $file) {
            Storage::disk($file->disk)->delete($file->path);
        }

        $photo->delete();

        return redirect()->route('admin.albums.photos.index', $album)->with('status', 'Foto removida.');
    }

    /**
     * @return array{width: int|null, height: int|null}
     */
    private function dimensions(string $path): array
    {
        $size = @getimagesize($path);

        return [
            'width' => $size[0] ?? null,
            'height' => $size[1] ?? null,
        ];
    }
}
