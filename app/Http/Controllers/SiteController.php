<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Business;

class SiteController extends Controller
{
    //
    public function index()
    {
    	$businesses = Business::all();
    	//$businesses = Business::all();
    	return view('frontend.index', compact('businesses'));
    }
    
}
