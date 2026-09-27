<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\Photo;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'albumsCount' => Album::count(),
            'categoriesCount' => AlbumCategory::count(),
            'photosCount' => Photo::count(),
            'publishedAlbumsCount' => Album::where('status', 'published')->count(),
        ]);
    }
}
