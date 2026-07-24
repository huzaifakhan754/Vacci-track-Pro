<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use App\Models\ParentRequest;
use Illuminate\Http\Request;

class landingController extends Controller
{
    function index(){
        $hospital= Hospital::all()->count();
        $vaccinated= ParentRequest::where('status', 'vaccinated')->count();
        return view('welcome', compact('hospital', 'vaccinated'));
    }
}
