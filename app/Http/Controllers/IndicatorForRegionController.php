<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIndicatorForRegionRequest;
use App\Http\Requests\UpdateIndicatorForRegionRequest;
use App\Repositories\IndicatorForRegionRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Models\IndicatorForRegion;
use DB;

use App\Models\Region;

class IndicatorForRegionController extends AppBaseController
{
    /** @var  IndicatorForRegionRepository */
    private $indicatorForRegionRepository;

    public function __construct(IndicatorForRegionRepository $indicatorForRegionRepo)
    {
        $this->indicatorForRegionRepository = $indicatorForRegionRepo;
    }

    /**
     * Display a listing of the IndicatorForRegion.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->indicatorForRegionRepository->pushCriteria(new RequestCriteria($request));
        // $indicatorForRegions = $this->indicatorForRegionRepository->all();
        $indicatorForRegions = IndicatorForRegion::with('region')->orderBy('year', 'desc')->get();

        return view('indicator_for_regions.index')
            ->with('indicatorForRegions', $indicatorForRegions);
    }

    /**
     * Show the form for creating a new IndicatorForRegion.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $regionId = $request->get('region_id');
    
        return view('indicator_for_regions.create', compact('regionId'));
    }

    /**
     * Store a newly created IndicatorForRegion in storage.
     *
     * @param CreateIndicatorForRegionRequest $request
     *
     * @return Response
     */
    public function store(CreateIndicatorForRegionRequest $request)
    {
        $input = $request->all();

        DB::transaction(function () use ($input)
        {
            $indicatorForRegion = $this->indicatorForRegionRepository->create($input);

            // get results for previous years
            $year = $indicatorForRegion->year;
            $previousYear = $year - 1;
            // dd([$year, $previousYear, $indicatorForRegion->region_id]);

            $previousIndicatorForRegion = IndicatorForRegion::where('year', $previousYear)->where('region_id', $indicatorForRegion->region_id)->first();
            
            // dd($previousIndicatorForRegion);
            if ($previousIndicatorForRegion != null)
            {
                $tmpIF = ($previousIndicatorForRegion->if != 0) ? $indicatorForRegion->if / $previousIndicatorForRegion->if : 1;
                $tmpAS = ($previousIndicatorForRegion->as != 0) ? $indicatorForRegion->as / $previousIndicatorForRegion->as : 1;
                $tmpP = ($previousIndicatorForRegion->p != 0) ? $indicatorForRegion->p / $previousIndicatorForRegion->p : 1;
                $tmpI = ($previousIndicatorForRegion->i != 0) ? $indicatorForRegion->i / $previousIndicatorForRegion->i : 1;

                // get ef_fin
                $indicatorForRegion->ef_fin = 
                    (
                        $tmpIF * $tmpAS * $tmpP * $tmpI
                    ) 
                    / 
                    (
                        $indicatorForRegion->z / $previousIndicatorForRegion->z
                    );

                $indicatorForRegion->save();
            }

        });

        Flash::success('Indicator For Region saved successfully.');

        return redirect(route('indicatorForRegions.index'));
    }

    /**
     * Display the specified IndicatorForRegion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $indicatorForRegion = $this->indicatorForRegionRepository->findWithoutFail($id);

        if (empty($indicatorForRegion)) {
            Flash::error('Indicator For Region not found');

            return redirect(route('indicatorForRegions.index'));
        }

        return view('indicator_for_regions.show')->with('indicatorForRegion', $indicatorForRegion);
    }

    /**
     * Show the form for editing the specified IndicatorForRegion.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $indicatorForRegion = $this->indicatorForRegionRepository->findWithoutFail($id);

        if (empty($indicatorForRegion)) {
            Flash::error('Indicator For Region not found');

            return redirect(route('indicatorForRegions.index'));
        }

        $regionId = null;
        return view('indicator_for_regions.edit', compact('indicatorForRegion', 'regionId'));
    }

    /**
     * Calculate indicator's ef_fin
     */
    public function calculate($id)
    {
        $indicatorForRegion = $this->indicatorForRegionRepository->findWithoutFail($id);

        if (empty($indicatorForRegion)) {
            Flash::error('Indicator For Region not found');

            return redirect(route('indicatorForRegions.index'));
        }

        DB::transaction(function () use ($indicatorForRegion)
        {
            // get results for previous years
            $year = $indicatorForRegion->year;
            $previousYear = $year - 1;
            // dd([$year, $previousYear, $indicatorForRegion->region_id]);

            $previousIndicatorForRegion = IndicatorForRegion::where('year', $previousYear)->where('region_id', $indicatorForRegion->region_id)->first();
            
            // dd($previousIndicatorForRegion);
            if ($previousIndicatorForRegion != null)
            {
                // get ef_fin
                $tmpIF = ($previousIndicatorForRegion->if != 0) ? $indicatorForRegion->if / $previousIndicatorForRegion->if : 1;
                $tmpAS = ($previousIndicatorForRegion->as != 0) ? $indicatorForRegion->as / $previousIndicatorForRegion->as : 1;
                $tmpP = ($previousIndicatorForRegion->p != 0) ? $indicatorForRegion->p / $previousIndicatorForRegion->p : 1;
                $tmpI = ($previousIndicatorForRegion->i != 0) ? $indicatorForRegion->i / $previousIndicatorForRegion->i : 1;

                // get ef_fin
                $indicatorForRegion->ef_fin = 
                    (
                        $tmpIF * $tmpAS * $tmpP * $tmpI
                    ) 
                    / 
                    (
                        $indicatorForRegion->z / $previousIndicatorForRegion->z
                    );
                    
                $indicatorForRegion->save();
            }

        });

        return redirect(route('indicatorForRegions.index'));
    }

    /**
     * Update the specified IndicatorForRegion in storage.
     *
     * @param  int              $id
     * @param UpdateIndicatorForRegionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateIndicatorForRegionRequest $request)
    {
        $indicatorForRegion = $this->indicatorForRegionRepository->findWithoutFail($id);

        if (empty($indicatorForRegion)) {
            Flash::error('Indicator For Region not found');

            return redirect(route('indicatorForRegions.index'));
        }

        $indicatorForRegion = $this->indicatorForRegionRepository->update($request->all(), $id);

        Flash::success('Indicator For Region updated successfully.');

        return redirect(route('indicatorForRegions.index'));
    }

    /**
     * Remove the specified IndicatorForRegion from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $indicatorForRegion = $this->indicatorForRegionRepository->findWithoutFail($id);

        if (empty($indicatorForRegion)) {
            Flash::error('Indicator For Region not found');

            return redirect(route('indicatorForRegions.index'));
        }

        $this->indicatorForRegionRepository->delete($id);

        Flash::success('Indicator For Region deleted successfully.');

        return redirect(route('indicatorForRegions.index'));
    }
}
