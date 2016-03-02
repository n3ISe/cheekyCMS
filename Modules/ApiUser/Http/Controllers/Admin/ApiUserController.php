<?php namespace Modules\ApiUser\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\ApiUser\Entities\ApiUser;
use Modules\ApiUser\Repositories\ApiUserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ApiUserController extends AdminBaseController
{
    /**
     * @var ApiUserRepository
     */
    private $apiuser;

    public function __construct(ApiUserRepository $apiuser)
    {
        parent::__construct();

        $this->apiuser = $apiuser;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $apiusers = $this->apiuser->all();

        return view('apiuser::admin.apiusers.index', compact('apiusers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('apiuser::admin.apiusers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->apiuser->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('apiuser::apiusers.title.apiusers')]));

        return redirect()->route('admin.apiuser.apiuser.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ApiUser $apiuser
     * @return Response
     */
    public function edit(ApiUser $apiuser)
    {
        return view('apiuser::admin.apiusers.edit', compact('apiuser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ApiUser $apiuser
     * @param  Request $request
     * @return Response
     */
    public function update(ApiUser $apiuser, Request $request)
    {
        $this->apiuser->update($apiuser, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('apiuser::apiusers.title.apiusers')]));

        return redirect()->route('admin.apiuser.apiuser.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ApiUser $apiuser
     * @return Response
     */
    public function destroy(ApiUser $apiuser)
    {
        $this->apiuser->destroy($apiuser);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('apiuser::apiusers.title.apiusers')]));

        return redirect()->route('admin.apiuser.apiuser.index');
    }
}
