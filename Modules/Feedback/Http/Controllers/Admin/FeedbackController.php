<?php namespace Modules\Feedback\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Feedback\Entities\Feedback;
use Modules\Feedback\Repositories\FeedbackRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class FeedbackController extends AdminBaseController
{
    /**
     * @var FeedbackRepository
     */
    private $feedback;

    public function __construct(FeedbackRepository $feedback)
    {
        parent::__construct();

        $this->feedback = $feedback;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $feedbacks = $this->feedback->all();

        return view('feedback::admin.feedbacks.index', compact('feedbacks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('feedback::admin.feedbacks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->feedback->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('feedback::feedbacks.title.feedbacks')]));

        return redirect()->route('admin.feedback.feedback.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Feedback $feedback
     * @return Response
     */
    public function edit(Feedback $feedback)
    {
        return view('feedback::admin.feedbacks.edit', compact('feedback'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Feedback $feedback
     * @param  Request $request
     * @return Response
     */
    public function update(Feedback $feedback, Request $request)
    {
        $this->feedback->update($feedback, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('feedback::feedbacks.title.feedbacks')]));

        return redirect()->route('admin.feedback.feedback.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Feedback $feedback
     * @return Response
     */
    public function destroy(Feedback $feedback)
    {
        $this->feedback->destroy($feedback);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('feedback::feedbacks.title.feedbacks')]));

        return redirect()->route('admin.feedback.feedback.index');
    }
}
