<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ThemeController extends Controller
{
    public function update(Request $request)
    {
        $theme = $request->input('theme');
        $availableThemes = config('themes.themes');

        if (array_key_exists($theme, $availableThemes)) {
            Session::put('theme', $availableThemes[$theme]);
        }

        return redirect()->back();
    }
}
