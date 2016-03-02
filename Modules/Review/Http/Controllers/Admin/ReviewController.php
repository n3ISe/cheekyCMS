<?php namespace Modules\Review\Http\Controllers\Admin;

use DB;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Review\Entities\Review;
use Modules\Restaurant\Entities\Restaurant;
use Modules\ReviewImage\Entities\ReviewImage;
use Modules\Review\Repositories\ReviewRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ReviewController extends AdminBaseController
{
    /**
     * @var ReviewRepository
     */
    private $review;

    public function __construct(ReviewRepository $review)
    {
        parent::__construct();

        $this->review = $review;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //$reviews = $this->review->all();
        $restaurants = Restaurant::select('*',DB::raw('(select count(*) from reviews where active="1" and restaurant_id=restaurants.id) as total_review'))->get();

        return view('review::admin.reviews.index', compact('restaurants'));
    }

	public function ireview($id)
    {
		try {
			$restaurant = Restaurant::findOrFail($id);
			$reviews = Review::with('user')->where('restaurant_id',$id)->get();
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Restaurant not found'));
            return redirect()->route('admin.review.review.index');
        }

        return view('review::admin.reviews.ireview', compact('restaurant','reviews'));
    }
    
	public function show(Review $review)
    {
        $reviewImages = ReviewImage::where('review_id',$review->id)->get();
		return view('review::admin.reviews.show', compact('review','reviewImages'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('review::admin.reviews.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->review->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('review::reviews.title.reviews')]));

        return redirect()->route('admin.review.review.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Review $review
     * @return Response
     */
    public function edit(Review $review)
    {
        return view('review::admin.reviews.edit', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Review $review
     * @param  Request $request
     * @return Response
     */
    public function update(Review $review, Request $request)
    {
        $this->review->update($review, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('review::reviews.title.reviews')]));

        return redirect()->route('admin.review.review.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Review $review
     * @return Response
     */
    public function destroy(Review $review)
    {
        //$this->review->destroy($review);
        try {
			$temp_review = Review::findOrFail($review->id);
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Review not found'));
            return redirect()->route('admin.review.review.index');
        }
		$temp_review->active = 2;
		$temp_review->save();
		DB::table('review_image')->where('review_id', $review->id)->update(['active' => 2]);

        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('review::reviews.title.reviews')]));

        return redirect()->route('admin.review.review.index');
    }
}
