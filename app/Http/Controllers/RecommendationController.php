<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRecommendationRequest;
use App\Http\Requests\UpdateRecommendationRequest;
use App\Repositories\RecommendationRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class RecommendationController extends AppBaseController
{
    /** @var  RecommendationRepository */
    private $recommendationRepository;

    public function __construct(RecommendationRepository $recommendationRepo)
    {
        $this->recommendationRepository = $recommendationRepo;
    }

    /**
     * Display a listing of the Recommendation.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->recommendationRepository->pushCriteria(new RequestCriteria($request));
        $recommendations = $this->recommendationRepository->all();

        return view('recommendations.index')
            ->with('recommendations', $recommendations);
    }

    /**
     * Show the form for creating a new Recommendation.
     *
     * @return Response
     */
    public function create()
    {
        return view('recommendations.create');
    }

    /**
     * Store a newly created Recommendation in storage.
     *
     * @param CreateRecommendationRequest $request
     *
     * @return Response
     */
    public function store(CreateRecommendationRequest $request)
    {
        $input = $request->all();

        $recommendation = $this->recommendationRepository->create($input);

        Flash::success('Recommendation saved successfully.');

        return redirect(route('recommendations.index'));
    }

    /**
     * Display the specified Recommendation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $recommendation = $this->recommendationRepository->findWithoutFail($id);

        if (empty($recommendation)) {
            Flash::error('Recommendation not found');

            return redirect(route('recommendations.index'));
        }

        return view('recommendations.show')->with('recommendation', $recommendation);
    }

    /**
     * Show the form for editing the specified Recommendation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $recommendation = $this->recommendationRepository->findWithoutFail($id);

        if (empty($recommendation)) {
            Flash::error('Recommendation not found');

            return redirect(route('recommendations.index'));
        }

        return view('recommendations.edit')->with('recommendation', $recommendation);
    }

    /**
     * Update the specified Recommendation in storage.
     *
     * @param  int              $id
     * @param UpdateRecommendationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRecommendationRequest $request)
    {
        $recommendation = $this->recommendationRepository->findWithoutFail($id);

        if (empty($recommendation)) {
            Flash::error('Recommendation not found');

            return redirect(route('recommendations.index'));
        }

        $recommendation = $this->recommendationRepository->update($request->all(), $id);

        Flash::success('Recommendation updated successfully.');

        return redirect(route('recommendations.index'));
    }

    /**
     * Remove the specified Recommendation from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $recommendation = $this->recommendationRepository->findWithoutFail($id);

        if (empty($recommendation)) {
            Flash::error('Recommendation not found');

            return redirect(route('recommendations.index'));
        }

        $this->recommendationRepository->delete($id);

        Flash::success('Recommendation deleted successfully.');

        return redirect(route('recommendations.index'));
    }
}
