<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Business;
use App\Models\Indicator;
use App\Models\IndicatorForRegion;
use App\Models\Recommendation;
use Carbon\Carbon;
use JavaScript;

class SiteController extends Controller
{
    //
    public function index(Request $request)
    {
    	// filter data
    	$currentYear = isset($request->currentYear) ? $request->currentYear : IndicatorForRegion::availableYears()[0];
    	$currentRegionId = isset($request->currentRegionId) ? $request->currentRegionId : -1;

    	// businesses for currentYear
    	$businesses = Business::with(['indicators' => function($q) use ($currentYear) {
            $q->where('year', $currentYear);
        }])->whereHas('indicators', function($q) use ($currentYear) {
    		$q->where('year', $currentYear);
    	})->get();
    	// dd([$currentYear, $businesses->toArray()]);

    	// get indicators with business info
    	$query = Indicator::with(['business', 'business.region']);
    	$query->where('year', $currentYear);
    	if ($currentRegionId != -1)  {
    		$query->whereHas('business', function ($q) use ($currentRegionId) {
    			$q->where('region_id', $currentRegionId);
    		});
    	}
    	$query->where('ef_fin', '!=', null);
    	$indicators = $query->get();
    	// dd($indicators->toArray());

        // get indicators for regions
        $query = IndicatorForRegion::with(['region']);
        $query->where('year', $currentYear);
        if ($currentRegionId != -1) {
            $query->where('region_id', $currentRegionId);
        }
        $query->where('ef_fin', '!=', null);
        $indicatorForRegions = $query->get();

        $indicatorsMap = [];
        foreach ($indicatorForRegions as $indicator) {
            $indicatorsMap[$indicator->region->iso] = $indicator->ef_fin;
        }
        // dd($indicatorForRegions->toArray());

        $recommendations = [];
        foreach (Recommendation::get() as $rec) {
            $recommendations[$rec->type] = $rec->desc;
        }

        JavaScript::put([
            'regionIndicators' => $indicatorForRegions->toArray(),
            'indicatorsMap' => $indicatorsMap,
            'recommendations' => $recommendations
        ]);

    	return view('frontend.index', compact('businesses', 'indicators', 'indicatorForRegions', 'currentYear', 'currentRegionId'));
    }
    
}
