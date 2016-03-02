<?php namespace Modules\ReportReason\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\ReportReason\Entities\ReportReason;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\ReportReason\Repositories\ReportReasonRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ReportReasonController extends AdminBaseController
{
    /**
     * @var ReportReasonRepository
     */
    private $reportreason;

    public function __construct(ReportReasonRepository $reportreason)
    {
        parent::__construct();

        $this->reportreason = $reportreason;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $reportreasons = ReportReason::where('status',1)->get();

        return view('reportreason::admin.reportreasons.index', compact('reportreasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('reportreason::admin.reportreasons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->reportreason->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('reportreason::reportreasons.title.reportreasons')]));

        return redirect()->route('admin.reportreason.reportreason.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ReportReason $reportreason
     * @return Response
     */
    public function edit(ReportReason $reportreason)
    {
        return view('reportreason::admin.reportreasons.edit', compact('reportreason'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ReportReason $reportreason
     * @param  Request $request
     * @return Response
     */
    public function update(ReportReason $reportreason, Request $request)
    {
        $this->reportreason->update($reportreason, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('reportreason::reportreasons.title.reportreasons')]));

        return redirect()->route('admin.reportreason.reportreason.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ReportReason $reportreason
     * @return Response
     */
    public function destroy(ReportReason $reportreason)
    {
		try {
			$temp_reportreason = ReportReason::findOrFail($reportreason->id);
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Review not found'));
            return redirect()->route('admin.review.review.index');
        }
		$temp_reportreason->status = 2;
		$temp_reportreason->save();
        //$this->reportreason->destroy($reportreason);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('reportreason::reportreasons.title.reportreasons')]));

        return redirect()->route('admin.reportreason.reportreason.index');
    }
}
