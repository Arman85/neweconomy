<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIndicatorRequest;
use App\Http\Requests\UpdateIndicatorRequest;
use App\Repositories\IndicatorRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use DB;
use App\Models\Indicator;

class IndicatorController extends AppBaseController
{
    /** @var  IndicatorRepository */
    private $indicatorRepository;

    public function __construct(IndicatorRepository $indicatorRepo)
    {
        $this->indicatorRepository = $indicatorRepo;
    }

    /**
     * Display a listing of the Indicator.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->indicatorRepository->pushCriteria(new RequestCriteria($request));
        // $indicators = $this->indicatorRepository->all();
        $indicators = Indicator::with('business')->orderBy('year', 'desc')->get();

        return view('indicators.index')
            ->with('indicators', $indicators);
    }

    /**
     * Show the form for creating a new Indicator.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        $businessId = $request->get('business_id');

        return view('indicators.create', compact('businessId'));
    }

    /**
     * Store a newly created Indicator in storage.
     *
     * @param CreateIndicatorRequest $request
     *
     * @return Response
     */
    public function store(CreateIndicatorRequest $request)
    {
        $input = $request->all();

        DB::transaction(function () use ($input)
        {
            $indicator = $this->indicatorRepository->create($input);

            // get results for previous years
            $year = $indicator->year;
            $previousYear = $year - 1;
            // dd([$year, $previousYear, $indicator->business_id]);

            $previousIndicator = Indicator::where('year', $previousYear)->where('business_id', $indicator->business_id)->first();
            // dd($previousIndicator);
            if ($previousIndicator != null)
            {
                // get ef_fin
                $indicator->ef_fin = (($indicator->if / $previousIndicator->if) * ($indicator->as / $previousIndicator->as) * ($indicator->p / $previousIndicator->p) * ($indicator->i / $previousIndicator->i))/ ($indicator->z / $previousIndicator->z);
                $indicator->save();
            }

        });

        Flash::success('Indicator saved successfully.');

        return redirect(route('indicators.index'));
    }

    /**
     * Display the specified Indicator.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $indicator = $this->indicatorRepository->findWithoutFail($id);

        if (empty($indicator)) {
            Flash::error('Indicator not found');

            return redirect(route('indicators.index'));
        }

        return view('indicators.show')->with('indicator', $indicator);
    }

    /**
     * Show the form for editing the specified Indicator.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $indicator = $this->indicatorRepository->findWithoutFail($id);

        if (empty($indicator)) {
            Flash::error('Indicator not found');

            return redirect(route('indicators.index'));
        }

        $businessId = null;
        return view('indicators.edit', compact('indicator', 'businessId'));
    }

    /**
     * Calculate indicator's ef_fin
     */
    public function calculate($id)
    {
        $indicator = $this->indicatorRepository->findWithoutFail($id);

        if (empty($indicator)) {
            Flash::error('Indicator not found');

            return redirect(route('indicators.index'));
        }

        DB::transaction(function () use ($indicator)
        {
            // get results for previous years
            $year = $indicator->year;
            $previousYear = $year - 1;
            // dd([$year, $previousYear, $indicator->business_id]);

            $previousIndicator = Indicator::where('year', $previousYear)->where('business_id', $indicator->business_id)->first();
            // dd($previousIndicator);
            if ($previousIndicator != null)
            {
                // get ef_fin
                $indicator->ef_fin = (($indicator->if / $previousIndicator->if) * ($indicator->as / $previousIndicator->as) * ($indicator->p / $previousIndicator->p) * ($indicator->i / $previousIndicator->i))/ ($indicator->z / $previousIndicator->z);
                $indicator->save();
            }

        });

        return redirect(route('indicators.index'));
    }

    /**
     * Update the specified Indicator in storage.
     *
     * @param  int              $id
     * @param UpdateIndicatorRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateIndicatorRequest $request)
    {
        $indicator = $this->indicatorRepository->findWithoutFail($id);

        if (empty($indicator)) {
            Flash::error('Indicator not found');

            return redirect(route('indicators.index'));
        }

        $indicator = $this->indicatorRepository->update($request->all(), $id);

        Flash::success('Indicator updated successfully.');

        return redirect(route('indicators.index'));
    }

    /**
     * Remove the specified Indicator from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $indicator = $this->indicatorRepository->findWithoutFail($id);

        if (empty($indicator)) {
            Flash::error('Indicator not found');

            return redirect(route('indicators.index'));
        }

        $this->indicatorRepository->delete($id);

        Flash::success('Indicator deleted successfully.');

        return redirect(route('indicators.index'));
    }
}
