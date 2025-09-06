<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    /**
     * Switch application language
     */
    public function switch(Request $request)
    {
        $locale = $request->input('locale');
        
        // Validate locale
        if (!in_array($locale, ['fr', 'en'])) {
            return redirect()->back()->with('error', 'Invalid language selected.');
        }
        
        // Store locale in session
        Session::put('locale', $locale);
        
        // Set application locale
        App::setLocale($locale);
        
        return redirect()->back()->with('success', __('admin.language_switched_successfully', [], $locale));
    }
}
