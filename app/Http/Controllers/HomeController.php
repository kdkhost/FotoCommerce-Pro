<?php

namespace App\Http\Controllers;

use App\Enums\AlbumStatus;
use App\Enums\Visibility;
use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\Photo;
use App\Models\PhotographerProfile;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $settings = SiteSetting::query()->find(1);

        $profile = PhotographerProfile::query()->with('user')->first();

        $categories = AlbumCategory::query()
            ->where('is_active', true)
            ->orderBy('order_column')
            ->get();

        $albums = Album::query()
            ->where('status', AlbumStatus::Published)
            ->where('visibility', Visibility::Public)
            ->whereNotNull('published_at')
            ->orderBy('sort_order')
            ->with('category')
            ->take(9)
            ->get()
            ->each(function (Album $album) {
                $album->cover_url = $album->cover_image
                    ? Storage::disk('photos_public')->url($album->cover_image)
                    : null;
            });

        $portfolioPhotos = Photo::query()
            ->where('status', 'published')
            ->whereHas('album', function ($query) {
                $query->where('status', AlbumStatus::Published)
                    ->where('visibility', Visibility::Public);
            })
            ->with(['files', 'album'])
            ->orderByDesc('is_featured')
            ->orderByDesc('created_at')
            ->take(12)
            ->get()
            ->each(function (Photo $photo) {
                $file = $photo->files->first();
                $photo->image_url = $file ? Storage::disk($file->disk)->url($file->path) : null;
            });

        return view('home', [
            'settings' => $settings,
            'profile' => $profile,
            'categories' => $categories,
            'albums' => $albums,
            'portfolioPhotos' => $portfolioPhotos,
        ]);
    }
}
