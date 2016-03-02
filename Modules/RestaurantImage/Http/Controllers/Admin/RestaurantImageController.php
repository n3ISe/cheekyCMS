<?php namespace Modules\RestaurantImage\Http\Controllers\Admin;

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
use Modules\RestaurantImage\Entities\RestaurantImage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\RestaurantImage\Repositories\RestaurantImageRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class RestaurantImageController extends AdminBaseController
{
    /**
     * @var RestaurantImageRepository
     */
    private $restaurantimage;

    public function __construct(RestaurantImageRepository $restaurantimage)
    {
        parent::__construct();

        $this->restaurantimage = $restaurantimage;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $restaurants = Restaurant::select('*',DB::raw('(select count(*) from restaurant_image where active="1" and restaurant_id=restaurants.id) as total_image'))->get();

        return view('restaurantimage::admin.restaurantimages.index', compact('restaurants'));
    }

	public function image($id)
    {
		try {
			$restaurant = Restaurant::findOrFail($id);
			$images = RestaurantImage::where('restaurant_id',$id)->where('active','!=','2')->get();
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Restaurant not found'));
            return redirect()->route('admin.restaurantimage.restaurantimage.index');
        }

        return view('restaurantimage::admin.restaurantimages.image', compact('restaurant','images'));
    }
     public function simage($id) 
    {
		/*  //KIV, cannot create restaurant photo in cms as user_id in line 131 is refer to users but not cms_users
        $input = Input::all();
 
        $rules = array(
            'file' => 'image|mimes:png,gif,jpeg',
        );
 
        $validation = Validator::make($input, $rules);
 
        if ($validation->fails()) 
        {
            flash()->error("Upload Fail.");

			return redirect()->route('admin.restaurantimage.restaurantimage.index');
        }
		
		$file = Input::file('file');
		
		$file_extension = $file->getClientOriginalExtension();
		$ori_filename 	= $id."_".md5(file_get_contents($file)).".".$file_extension; //restaurantId_md5.png
		$thumbnail_filename = "thumbnail_".$id."_".md5(file_get_contents($file)).".".$file_extension;
		
		$width 	= Image::make(file_get_contents($file))->width();
		$height = Image::make(file_get_contents($file))->height();
		
		$s3 = Storage::disk('s3');
		$ori_filePath = '/restaurant_photo/original/' . $ori_filename;
		$s3->put($ori_filePath, file_get_contents($file), 'public'); //save ori image to s3 
 
		$dimensions = ImageDimension::where('status',1)->lists('dimension');
		foreach($dimensions as $dimension)
		{
			//width
			$width_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();});
			$width_image = $width_image->stream();
			$width_filePath = '/restaurant_photo/width'.$dimension.'/'.$ori_filename;
			$s3->put($width_filePath, $width_image->__toString(),'public'); 
			
			//height
			$height_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();});
			$height_image = $height_image->stream();
			$height_filePath = '/restaurant_photo/height'.$dimension.'/'.$ori_filename;
			$s3->put($height_filePath, $height_image->__toString(),'public'); 
			
			if ($width > $height) //landscape image
			{
				$cap_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();});
			}
			else
			{
				$cap_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();});
			}						
			$cap_image = $cap_image->stream();
			$cap_filePath = '/restaurant_photo/cap'.$dimension.'/'.$ori_filename;
			$s3->put($cap_filePath, $cap_image->__toString(),'public'); 
			
			foreach($dimensions as $dimension2)
			{
				$image = Image::make(file_get_contents($file))->fit($dimension, $dimension2, function ($constraint){$constraint->upsize();});
				$image = $image->stream();
				$filePath = '/restaurant_photo/'.$dimension.'x'.$dimension2.'/'.$ori_filename;
				$s3->put($filePath, $image->__toString(),'public'); 
			}
		}
		
		$asset = new Asset;
		$asset->restaurant_id = $id;
		$asset->width = $width;
		$asset->height= $height;
		$asset->image_name = $ori_filename;							
		$asset->image_md5 = md5(file_get_contents($file));
		$asset->active = 1;
		
		$restaurantImage = new RestaurantImage;
		$restaurantImage->restaurant_id = $id;
		$restaurantImage->user_id = $user->id;
		$restaurantImage->width = $width;
		$restaurantImage->height= $height;
		$restaurantImage->photo = $ori_filename;						
		$restaurantImage->photo_md5 = md5(file_get_contents($file));
		$restaurantImage->photo_thumbnail = $thumbnail_filename;			
		$restaurantImage->photo_caption = Request2::get('photo_caption')[$key];	
		$restaurantImage->save();
		
        if ($restaurantImage->save()) 
        {
			flash()->success("Restaurant Image Successfully Uploaded.");

			return redirect()->route('admin.restaurantimage.restaurantimage.index');
        } else {
            flash()->error("Upload Fail.");

			return redirect()->route('admin.restaurantimage.restaurantimage.index');
        }
        */
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('restaurantimage::admin.restaurantimages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->restaurantimage->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('restaurantimage::restaurantimages.title.restaurantimages')]));

        return redirect()->route('admin.restaurantimage.restaurantimage.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  RestaurantImage $restaurantimage
     * @return Response
     */
    public function edit(RestaurantImage $restaurantimage)
    {
        return view('restaurantimage::admin.restaurantimages.edit', compact('restaurantimage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RestaurantImage $restaurantimage
     * @param  Request $request
     * @return Response
     */
    public function update(RestaurantImage $restaurantimage, Request $request)
    {
        $this->restaurantimage->update($restaurantimage, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('restaurantimage::restaurantimages.title.restaurantimages')]));

        return redirect()->route('admin.restaurantimage.restaurantimage.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  RestaurantImage $restaurantimage
     * @return Response
     */
    public function destroy(RestaurantImage $restaurantimage)
    {
        $restaurant_id = $restaurantimage->restaurant_id;
		/*
		$s3 = Storage::disk('s3');
		$ori_filename = $restaurantimage->photo;
		$ori_filePath = '/restaurant_photo/original/' . $ori_filename;
		$info = $s3->exists($ori_filePath);
		if ($info)
		{
			$s3->delete($ori_filePath);
			
			$dimensions = ImageDimension::where('status',1)->lists('dimension');
			foreach($dimensions as $dimension)
			{
				//width
				$width_filePath = '/restaurant_photo/width'.$dimension.'/'.$ori_filename;
				$s3->delete($width_filePath);
				
				//height
				$height_filePath = '/restaurant_photo/height'.$dimension.'/'.$ori_filename;
				$s3->delete($height_filePath);
									
				$cap_filePath = '/restaurant_photo/cap'.$dimension.'/'.$ori_filename;
				$s3->delete($cap_filePath); 
				
				foreach($dimensions as $dimension2)
				{
					$filePath = '/restaurant_photo/'.$dimension.'x'.$dimension2.'/'.$ori_filename;
					$s3->delete($filePath); 
				}
			}
		}
        $this->restaurantimage->destroy($restaurantimage);
		*/
		try {
			$temp_restaurantimage = RestaurantImage::findOrFail($restaurantimage->id);
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Restaurant Image not found'));
            return redirect()->route('admin.restaurantimage.restaurantimage.index');
        }
		$temp_restaurantimage->active = 2;
		$temp_restaurantimage->save();
		
        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('restaurantimage::restaurantimages.title.restaurantimages')]));

        return redirect()->route('admin.restaurantimage.restaurantimage.image',[$restaurant_id]);
    }
}
