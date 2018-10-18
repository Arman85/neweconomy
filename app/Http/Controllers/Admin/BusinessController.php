<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateBusinessRequest;
use App\Http\Requests\Admin\UpdateBusinessRequest;
use App\Repositories\Admin\BusinessRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class BusinessController extends AppBaseController
{
    /** @var  BusinessRepository */
    private $businessRepository;

    public function __construct(BusinessRepository $businessRepo)
    {
        $this->businessRepository = $businessRepo;
    }

    /**
     * Display a listing of the Business.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->businessRepository->pushCriteria(new RequestCriteria($request));
        $businesses = $this->businessRepository->all();

        return view('admin.businesses.index')
            ->with('businesses', $businesses);
    }

    /**
     * Show the form for creating a new Business.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin.businesses.create');
    }

    /**
     * Store a newly created Business in storage.
     *
     * @param CreateBusinessRequest $request
     *
     * @return Response
     */
    public function store(CreateBusinessRequest $request)
    {
        $input = $request->all();

        $business = $this->businessRepository->create($input);

        Flash::success('Business saved successfully.');

        return redirect(route('admin.businesses.index'));
    }

    /**
     * Display the specified Business.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $business = $this->businessRepository->findWithoutFail($id);

        if (empty($business)) {
            Flash::error('Business not found');

            return redirect(route('admin.businesses.index'));
        }

        return view('admin.businesses.show')->with('business', $business);
    }

    /**
     * Show the form for editing the specified Business.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $business = $this->businessRepository->findWithoutFail($id);

        if (empty($business)) {
            Flash::error('Business not found');

            return redirect(route('admin.businesses.index'));
        }

        return view('admin.businesses.edit')->with('business', $business);
    }

    /**
     * Update the specified Business in storage.
     *
     * @param  int              $id
     * @param UpdateBusinessRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBusinessRequest $request)
    {
        $business = $this->businessRepository->findWithoutFail($id);

        if (empty($business)) {
            Flash::error('Business not found');

            return redirect(route('admin.businesses.index'));
        }

        $business = $this->businessRepository->update($request->all(), $id);

        Flash::success('Business updated successfully.');

        return redirect(route('admin.businesses.index'));
    }

    /**
     * Remove the specified Business from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $business = $this->businessRepository->findWithoutFail($id);

        if (empty($business)) {
            Flash::error('Business not found');

            return redirect(route('admin.businesses.index'));
        }

        $this->businessRepository->delete($id);

        Flash::success('Business deleted successfully.');

        return redirect(route('admin.businesses.index'));
    }
}
