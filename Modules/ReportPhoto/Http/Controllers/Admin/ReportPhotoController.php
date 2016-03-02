<?php namespace Modules\ReportPhoto\Http\Controllers\Admin;

use DB;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\ReportPhoto\Entities\ReportPhoto;
use Modules\ReviewImage\Entities\ReviewImage;
use Modules\RestaurantImage\Entities\RestaurantImage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\ReportPhoto\Repositories\ReportPhotoRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ReportPhotoController extends AdminBaseController
{
    /**
     * @var ReportPhotoRepository
     */
    private $reportphoto;

    public function __construct(ReportPhotoRepository $reportphoto)
    {
        parent::__construct();

        $this->reportphoto = $reportphoto;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $reportphotos = $this->reportphoto->all();

        return view('reportphoto::admin.reportphotos.index', compact('reportphotos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('reportphoto::admin.reportphotos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->reportphoto->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('reportphoto::reportphotos.title.reportphotos')]));

        return redirect()->route('admin.reportphoto.reportphoto.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ReportPhoto $reportphoto
     * @return Response
     */
    public function edit(ReportPhoto $reportphoto)
    {
        return view('reportphoto::admin.reportphotos.edit', compact('reportphoto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ReportPhoto $reportphoto
     * @param  Request $request
     * @return Response
     */
    public function update(ReportPhoto $reportphoto, Request $request)
    {
        $this->reportphoto->update($reportphoto, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('reportphoto::reportphotos.title.reportphotos')]));

        return redirect()->route('admin.reportphoto.reportphoto.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ReportPhoto $reportphoto
     * @return Response
     */
    public function destroy(ReportPhoto $reportphoto)
    {
		$restaurant_id	= $reportphoto->restaurant_id;
		$module_id		= $reportphoto->module_id;
		$photo_id		= $reportphoto->photo_id;
		
		if ($module_id == 1) //restaurant image
		{
			try {
				$temp_restaurantimage = RestaurantImage::findOrFail($photo_id);
			} catch (ModelNotFoundException $e) {
				flash()->error(trans('Image not found'));
				return redirect()->route('admin.reportphoto.reportphoto.index');
			}
			$temp_restaurantimage->active = 2;
			$temp_restaurantimage->save();
		}
		else if ($module_id == 2) //review image
		{
			try {
				$temp_reviewimage = ReviewImage::findOrFail($photo_id);
			} catch (ModelNotFoundException $e) {
				flash()->error(trans('Image not found'));
				return redirect()->route('admin.reportphoto.reportphoto.index');
			}
			$temp_reviewimage->active = 2;
			$temp_reviewimage->save();
		}
		
        //$this->reportphoto->destroy($reportphoto);
        try {
			$temp_reportimage = ReportPhoto::findOrFail($reportphoto->id);
		} catch (ModelNotFoundException $e) {
			flash()->error(trans('Image not found'));
			return redirect()->route('admin.reportphoto.reportphoto.index');
		}
		$temp_reportimage->active = 2;
		$temp_reportimage->save();

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('reportphoto::reportphotos.title.reportphotos')]));

        return redirect()->route('admin.reportphoto.reportphoto.index');
    }
}
