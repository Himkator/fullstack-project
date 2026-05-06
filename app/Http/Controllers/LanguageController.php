<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller {

    public function switch(Request $request, $locale) {

        if (!in_array($locale, ['en', 'ru', 'kk'])) {
            $locale = 'en';
        }

        session(['locale' => $locale]);

        return redirect()->back();
    }
}