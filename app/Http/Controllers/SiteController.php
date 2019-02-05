<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Business;
use App\Models\Indicator;
use Carbon\Carbon;

class SiteController extends Controller
{
    //
    public function index(Request $request)
    {
    	// filter data
    	$currentYear = isset($request->currentYear) ? $request->currentYear : Carbon::now()->year;
    	$currentRegionId = isset($request->currentRegionId) ? $request->currentRegionId : -1;

    	// businesses for currentYear
    	$businesses = Business::whereHas('indicators', function($q) use ($currentYear) {
    		$q->where('year', $currentYear);
    	})->get();
    	//$businesses = Business::all();

    	// get indicators with business info
    	$query = Indicator::with(['business', 'business.region']);

    	// get for year or current?
    	$query->where('year', $currentYear);

    	// get for region or all?
    	if ($currentRegionId != -1)  {
    		$query->whereHas('business', function ($q) use ($currentRegionId) {
    			$q->where('region_id', $currentRegionId);
    		});
    	}
    	
    	// only filled ef_fins
    	$query->where('ef_fin', '!=', 0.0);

    	// get
    	$indicators = $query->get();
    	// dd($indicators->toArray());


    	return view('frontend.index', compact('businesses', 'indicators', 'currentYear', 'currentRegionId'));
    }
    
}
