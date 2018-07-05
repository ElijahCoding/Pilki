<?php

namespace App\Http\Controllers\Api\Crm;

use App\Exceptions\Api\UnknownException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Crm\EmployerServiceStoreRequest;
use App\Models\Employer;
use App\Repositories\EmployerRepository;
use Illuminate\Http\Request;

class EmployerServiceController extends Controller
{

    protected $repository;

    public function __construct(EmployerRepository $employerRepository)
    {
        $this->repository = $employerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($employerId)
    {
        /** @var Employer $employer */
        $employer = $this->repository->with(['services', 'serviceCategories'])->find($employerId);

        return response()->json([
            'result' => 'success',
            'data'   => [
                'services'           => $employer->services,
                'service_categories' => $employer->serviceCategories,
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmployerServiceStoreRequest|Request $request
     * @param $employerId
     * @return \Illuminate\Http\Response
     * @throws UnknownException
     */
    public function store(EmployerServiceStoreRequest $request, $employerId)
    {
        /** @var Employer $employer */
        $employer = $this->repository->find($employerId);

        switch ($request->type) {
            case 'category':
                $employer->serviceCategories()->syncWithoutDetaching([
                    $request->id => ['enabled' => $request->enabled]
                ]);
                // $employer->serviceCategories()->attach($request->id, [
                //     'enabled' => $request->enabled,
                // ]);
                break;
            case 'service':
                $employer->services()->syncWithoutDetaching([
                    $request->id => ['enabled' => $request->enabled]
                ]);
                // $employer->services()->attach($request->id, [
                //     'enabled' => $request->enabled,
                // ]);
                break;
            default:
                throw new UnknownException('unknown type');
        }

        return response()->json([
            'result' => 'success',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmployerServiceStoreRequest|Request $request
     * @param $employerId
     * @param $serviceId
     * @return \Illuminate\Http\Response
     * @throws UnknownException
     */
    public function update(EmployerServiceStoreRequest $request, $employerId, $serviceId)
    {
        /** @var Employer $employer */
        $employer = $this->repository->find($employerId);

        switch ($request->type) {
            case 'category':
                $employer->serviceCategories()->updateExistingPivot($serviceId, [
                    'enabled' => $request->enabled,
                ]);
                break;
            case 'service':
                $employer->services()->updateExistingPivot($serviceId, [
                    'enabled' => $request->enabled,
                ]);
                break;
            default:
                throw new UnknownException('unknown type');
        }

        return response()->json([
            'result' => 'success',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param $employerId
     * @param $serviceId
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, $employerId, $serviceId)
    {
        /** @var Employer $employer */
        $employer = $this->repository->find($employerId);

        switch ($request->type) {
            case 'category':
                $employer->serviceCategories()->detach($serviceId);
                break;
            case 'service':
                $employer->services()->detach($serviceId);
                break;
            default:
                throw new UnknownException('unknown type');
        }


        return response()->json([
            'result' => 'success',
        ]);
    }

}
