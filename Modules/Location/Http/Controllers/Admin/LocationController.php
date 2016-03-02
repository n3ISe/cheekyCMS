<?php namespace Modules\Location\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Location\Entities\Location;
use Modules\Location\Repositories\LocationRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class LocationController extends AdminBaseController
{
    /**
     * @var LocationRepository
     */
    private $location;

    public function __construct(LocationRepository $location)
    {
        parent::__construct();

        $this->location = $location;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $locations = Location::where('active',1)->orderBy('name','asc')->get();

        return view('location::admin.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('location::admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->location->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('location::locations.title.locations')]));

        return redirect()->route('admin.location.location.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Location $location
     * @return Response
     */
    public function edit(Location $location)
    {
        return view('location::admin.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Location $location
     * @param  Request $request
     * @return Response
     */
    public function update(Location $location, Request $request)
    {
        $this->location->update($location, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('location::locations.title.locations')]));

        return redirect()->route('admin.location.location.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Location $location
     * @return Response
     */
    public function destroy(Location $location)
    {
        //$this->location->destroy($location);
        try {
			$temp_location = Location::findOrFail($location->id);
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Asset not found'));
            return redirect()->route('admin.location.location.index');
        }
		$temp_location->active = 2;
		$temp_location->save();

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('location::locations.title.locations')]));

        return redirect()->route('admin.location.location.index');
    }
}
