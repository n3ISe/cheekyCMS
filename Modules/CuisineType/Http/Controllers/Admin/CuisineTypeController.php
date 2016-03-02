<?php namespace Modules\CuisineType\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\CuisineType\Entities\CuisineType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\CuisineType\Repositories\CuisineTypeRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CuisineTypeController extends AdminBaseController
{
    /**
     * @var CuisineTypeRepository
     */
    private $cuisinetype;

    public function __construct(CuisineTypeRepository $cuisinetype)
    {
        parent::__construct();

        $this->cuisinetype = $cuisinetype;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
		$cuisinetypes = CuisineType::where('active',1)->orderBy('name','asc')->get();
		
        return view('cuisinetype::admin.cuisinetypes.index', compact('cuisinetypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('cuisinetype::admin.cuisinetypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->cuisinetype->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('cuisinetype::cuisinetypes.title.cuisinetypes')]));

        return redirect()->route('admin.cuisinetype.cuisinetype.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  CuisineType $cuisinetype
     * @return Response
     */
    public function edit(CuisineType $cuisinetype)
    {
        return view('cuisinetype::admin.cuisinetypes.edit', compact('cuisinetype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CuisineType $cuisinetype
     * @param  Request $request
     * @return Response
     */
    public function update(CuisineType $cuisinetype, Request $request)
    {
        $this->cuisinetype->update($cuisinetype, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('cuisinetype::cuisinetypes.title.cuisinetypes')]));

        return redirect()->route('admin.cuisinetype.cuisinetype.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  CuisineType $cuisinetype
     * @return Response
     */
    public function destroy(CuisineType $cuisinetype)
    {
        //$this->cuisinetype->destroy($cuisinetype);
		try {
			$temp_cuisinetype = CuisineType::findOrFail($cuisinetype->id);
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Cuisine Type not found'));
            return redirect()->route('admin.cuisinetype.cuisinetype.index');
        }
		$temp_cuisinetype->active = 2;
		$temp_cuisinetype->save();

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('cuisinetype::cuisinetypes.title.cuisinetypes')]));

        return redirect()->route('admin.cuisinetype.cuisinetype.index');
    }
}
