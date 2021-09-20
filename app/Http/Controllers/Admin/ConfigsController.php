<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Intl\Currencies;
use Symfony\Component\Intl\Languages;

class ConfigsController extends Controller
{
    public function create()
    {
        return view('admin.configs', [
            'currencies' => Currencies::getNames(),
            'locales' => Languages::getNames(),
        ]);
    }

    public function store(Request $request)
    {
        foreach ($request->input('config') as $key => $value) {
            Config::setValue($key, $value);
        }

        Cache::forget('app-settings');

        return redirect()->route('settings')
            ->with('success', 'Settings saved!');
    }

    public function clearCache()
    {
        Artisan::command('cache:clear');
    }
}
