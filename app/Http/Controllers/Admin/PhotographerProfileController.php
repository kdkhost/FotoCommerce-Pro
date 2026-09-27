<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhotographerProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PhotographerProfileController extends Controller
{
    public function edit(): View
    {
        $profile = PhotographerProfile::query()->firstOrNew(['user_id' => Auth::id()]);

        return view('admin.profile.edit', ['profile' => $profile]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_title' => ['required', 'string', 'max:255'],
            'site_subtitle' => ['required', 'string', 'max:255'],
            'about_text' => ['required', 'string'],
            'bio' => ['nullable', 'string'],
            'whatsapp_number' => ['required', 'string', 'max:20'],
            'contact_email' => ['required', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
        ]);

        $profile = PhotographerProfile::query()->firstOrNew(['user_id' => Auth::id()]);
        $profile->fill([
            'site_title' => $data['site_title'],
            'site_subtitle' => $data['site_subtitle'],
            'about_text' => $data['about_text'],
            'bio' => $data['bio'] ?? null,
            'whatsapp_number' => $data['whatsapp_number'],
            'contact_email' => $data['contact_email'],
            'address' => $data['address'] ?? null,
            'social_links' => array_filter([
                'instagram' => $data['instagram'] ?? null,
                'facebook' => $data['facebook'] ?? null,
            ]),
        ]);
        $profile->user_id = Auth::id();
        $profile->save();

        return redirect()->route('admin.profile.edit')->with('status', 'Perfil atualizado com sucesso.');
    }
}
