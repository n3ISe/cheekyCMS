<?php namespace Modules\ReviewImage\Http\Controllers\Admin;

use DB;
use Image;
use Input;
use Storage;
use App\ImageDimension;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Validator;
use Modules\Restaurant\Entities\Restaurant;
use Modules\ReviewImage\Entities\ReviewImage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\ReviewImage\Repositories\ReviewImageRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ReviewImageController extends AdminBaseController
{
    /**
     * @var ReviewImageRepository
     */
    private $reviewimage;

    public function __construct(ReviewImageRepository $reviewimage)
    {
        parent::__construct();

        $this->reviewimage = $reviewimage;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $reviewimages = ReviewImage::select('*')
				->addSelect(DB::raw('(select count(*) from like_photos where module_id="2" and photo_id=review_image.id) as total_like'))
				->where('review_image.active','!=','2')->get();;
		
        return view('reviewimage::admin.reviewimages.index', compact('reviewimages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('reviewimage::admin.reviewimages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->reviewimage->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('reviewimage::reviewimages.title.reviewimages')]));

        return redirect()->route('admin.reviewimage.reviewimage.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ReviewImage $reviewimage
     * @return Response
     */
    public function edit(ReviewImage $reviewimage)
    {
        return view('reviewimage::admin.reviewimages.edit', compact('reviewimage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ReviewImage $reviewimage
     * @param  Request $request
     * @return Response
     */
    public function update(ReviewImage $reviewimage, Request $request)
    {
        $this->reviewimage->update($reviewimage, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('reviewimage::reviewimages.title.reviewimages')]));

        return redirect()->route('admin.reviewimage.reviewimage.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  ReviewImage $reviewimage
     * @return Response
     */
    public function destroy(ReviewImage $reviewimage)
    {
		/*
		$s3 = Storage::disk('s3');
		$ori_filename = $reviewimage->photo;
		$ori_filePath = '/review_photo/original/' . $ori_filename;
		$info = $s3->exists($ori_filePath);
		if ($info)
		{
			$s3->delete($ori_filePath);
		
			$dimensions = ImageDimension::where('status',1)->lists('dimension');
			foreach($dimensions as $dimension)
			{
				//width
				$width_filePath = '/review_photo/width'.$dimension.'/'.$ori_filename;
				$s3->delete($width_filePath);
				
				//height
				$height_filePath = '/review_photo/height'.$dimension.'/'.$ori_filename;
				$s3->delete($height_filePath);
									
				$cap_filePath = '/review_photo/cap'.$dimension.'/'.$ori_filename;
				$s3->delete($cap_filePath); 
				
				foreach($dimensions as $dimension2)
				{
					$filePath = '/review_photo/'.$dimension.'x'.$dimension2.'/'.$ori_filename;
					$s3->delete($filePath); 
				}
			}
		}
		
        $this->reviewimage->destroy($reviewimage);
		*/
		try {
			$temp_reviewimage = ReviewImage::findOrFail($reviewimage->id);
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Review Image not found'));
            return redirect()->route('admin.reviewimage.reviewimage.index');
        }
		$temp_reviewimage->active = 2;
		$temp_reviewimage->save();
		
        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('reviewimage::reviewimages.title.reviewimages')]));

        return redirect()->route('admin.reviewimage.reviewimage.index');
    }
}
