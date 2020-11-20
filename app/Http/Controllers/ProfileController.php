<?php

namespace App\Http\Controllers;

use Auth;

class ProfileController extends Controller {

    public function show() {
        $user = Auth::user();

        return view('profile', compact('user'));
    }
}