<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        $settings = SiteSetting::query()->firstOrNew(['single_row_lock' => 1]);

        return view('admin.settings.edit', ['settings' => $settings]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_slogan' => ['nullable', 'string', 'max:255'],
            'color_primary' => ['required', 'string', 'max:7'],
            'color_secondary' => ['required', 'string', 'max:7'],
            'color_accent' => ['required', 'string', 'max:7'],
        ]);

        $settings = SiteSetting::query()->firstOrNew(['single_row_lock' => 1]);
        $settings->fill($data);
        $settings->single_row_lock = 1;
        $settings->save();

        return redirect()->route('admin.settings.edit')->with('status', 'Configurações atualizadas com sucesso.');
    }
}
