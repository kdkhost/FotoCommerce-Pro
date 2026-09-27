<?php

namespace App\Http\Controllers;

use App\Enums\AlbumStatus;
use App\Enums\Visibility;
use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\PhotographerProfile;
use App\Models\SiteSetting;
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
            ->get();

        return view('home', [
            'settings' => $settings,
            'profile' => $profile,
            'categories' => $categories,
            'albums' => $albums,
        ]);
    }
}
