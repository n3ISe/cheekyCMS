<?php namespace Modules\ImageDimension\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\ImageDimension\Entities\ImageDimension;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\ImageDimension\Repositories\ImageDimensionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ImageDimensionController extends AdminBaseController
{
    /**
     * @var ImageDimensionRepository
     */
    private $imagedimension;

    public function __construct(ImageDimensionRepository $imagedimension)
    {
        parent::__construct();

        $this->imagedimension = $imagedimension;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $imagedimensions = $this->imagedimension->all();

        return view('imagedimension::admin.imagedimensions.index', compact('imagedimensions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('imagedimension::admin.imagedimensions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->imagedimension->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('imagedimension::imagedimensions.title.imagedimensions')]));

        return redirect()->route('admin.imagedimension.imagedimension.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ImageDimension $imagedimension
     * @return Response
     */
    public function edit(ImageDimension $imagedimension)
    {
        return view('imagedimension::admin.imagedimensions.edit', compact('imagedimension'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ImageDimension $imagedimension
     * @param  Request $request
     * @return Response
     */
    public function update(ImageDimension $imagedimension, Request $request)
    {
        $this->imagedimension->update($imagedimension, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('imagedimension::imagedimensions.title.imagedimensions')]));

        return redirect()->route('admin.imagedimension.imagedimension.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ImageDimension $imagedimension
     * @return Response
     */
    public function destroy(ImageDimension $imagedimension)
    {
        $this->imagedimension->destroy($imagedimension);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('imagedimension::imagedimensions.title.imagedimensions')]));

        return redirect()->route('admin.imagedimension.imagedimension.index');
    }
}
