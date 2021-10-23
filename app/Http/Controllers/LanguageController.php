<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    public function swap($lang)
    {
        $id = Auth::id();
        User::where('id',$id)->update(['lang'=>$lang]);
        session()->put('locale', $lang);
        return redirect()->back();
    }
}
