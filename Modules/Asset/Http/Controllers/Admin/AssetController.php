<?php namespace Modules\Asset\Http\Controllers\Admin;

use DB;
use Image;
use Input;
use Storage;
use App\ImageDimension;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Asset\Entities\Asset;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Validator;
use Modules\Restaurant\Entities\Restaurant;
use Modules\Asset\Repositories\AssetRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class AssetController extends AdminBaseController
{
    /**
     * @var AssetRepository
     */
    private $asset;

    public function __construct(AssetRepository $asset)
    {
        parent::__construct();

        $this->asset = $asset;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $restaurants = Restaurant::select('*',DB::raw('(select count(*) from restaurant_assets where active=1 and restaurant_id=restaurants.id) as total_asset'))->get();

        return view('asset::admin.assets.index', compact('restaurants'));
    }

	public function iasset($id)
    {
		try {
			$restaurant = Restaurant::findOrFail($id);
			$assets = Asset::where('restaurant_id',$id)->where('active','!=','2')->get();
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Restaurant not found'));
            return redirect()->route('admin.asset.asset.index');
        }

        return view('asset::admin.assets.iasset', compact('restaurant','assets'));
    }
    
    public function sasset($id) 
    {
        $input = Input::all();
 
        $rules = array(
            'file' => 'image|mimes:png,gif,jpeg',
        );
 
        $validation = Validator::make($input, $rules);
 
        if ($validation->fails()) 
        {
            flash()->error("Upload Fail.");

			return redirect()->route('admin.asset.asset.index');
        }
		
		$file = Input::file('file');
		
		$file_extension = $file->getClientOriginalExtension();
		$ori_filename 	= $id."_".md5(file_get_contents($file)).".".$file_extension; //restaurantId_md5.png
		
		$width 	= Image::make(file_get_contents($file))->width();
		$height = Image::make(file_get_contents($file))->height();
		
		$img_mime = Image::make(file_get_contents($file))->mime();
		/* resize to max width 1600 for larger image due to memory limit and processing time */
		if ($width > 1600)
		{
			$width_ratio = 1600 / $width;
			$width	= 1600;
			$height	= round($height * $width_ratio);
			
			if ($img_mime == 'image/jpg' || $img_mime == 'image/jpeg')
			{
				$exif_data = exif_read_data($file);
				//return $exif_data;
				if (isset($exif_data['Orientation']) and $exif_data['Orientation']==2)
				{
					$img = Image::make(file_get_contents($file))->resize($width, $height, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->flip('h');
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==3)
				{
					$img = Image::make(file_get_contents($file))->resize($width, $height, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(180);
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==4)
				{
					$img = Image::make(file_get_contents($file))->resize($width, $height, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(180)->flip('h');
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==5)
				{
					$img = Image::make(file_get_contents($file))->resize($width, $height, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(-90)->flip('h');
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==6)
				{
					$img = Image::make(file_get_contents($file))->resize($width, $height, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(-90);
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==7)
				{
					$img = Image::make(file_get_contents($file))->resize($width, $height, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(-90)->flip('v');
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==8)
				{
					$img = Image::make(file_get_contents($file))->resize($width, $height, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(90);
				}
				else
				{
					$img = Image::make(file_get_contents($file))->resize($width, $height, function ($constraint){$constraint->aspectRatio();$constraint->upsize();});
				}
			}	
			else
			{
				$img = Image::make(file_get_contents($file))->resize($width, $height, function ($constraint){$constraint->aspectRatio();$constraint->upsize();});
			}
		}
		else
		{
			if ($img_mime == 'image/jpg' || $img_mime == 'image/jpeg')
			{
				$exif_data = exif_read_data($file);
				//return $exif_data;
				if (isset($exif_data['Orientation']) and $exif_data['Orientation']==2)
				{
					$img = Image::make(file_get_contents($file))->flip('h');
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==3)
				{
					$img = Image::make(file_get_contents($file))->rotate(180);
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==4)
				{
					$img = Image::make(file_get_contents($file))->rotate(180)->flip('h');
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==5)
				{
					$img = Image::make(file_get_contents($file))->rotate(-90)->flip('h');
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==6)
				{
					$img = Image::make(file_get_contents($file))->rotate(-90);
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==7)
				{
					$img = Image::make(file_get_contents($file))->rotate(-90)->flip('v');
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==8)
				{
					$img = Image::make(file_get_contents($file))->rotate(90);
				}
				else
				{
					$img = Image::make(file_get_contents($file));
				}
			}	
			else
			{
				$img = Image::make(file_get_contents($file));
			}
		}
		
		/* --------------------------------------------------------------------------------- */
		
		$img = $img->stream();
		$s3 = Storage::disk('s3');
		$ori_filePath = '/restaurant_assets_v2/original/' . $ori_filename;
		$s3->put($ori_filePath, $img->__toString(), 'public'); //save ori image to s3 
		
		$dimensions = ImageDimension::where('status',1)->lists('dimension');
		foreach($dimensions as $dimension)
		{
			if ($img_mime == 'image/jpg' || $img_mime == 'image/jpeg')
			{
				if (isset($exif_data['Orientation']) and $exif_data['Orientation']==2)
				{
					$width_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->flip('h');
					$height_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->flip('h');
					if ($width > $height) //landscape image
					{
						$cap_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->flip('h');
					}
					else
					{
						$cap_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->flip('h');
					}
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==3)
				{
					$width_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(180);
					$height_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(180);
					if ($width > $height) //landscape image
					{
						$cap_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(180);
					}
					else
					{
						$cap_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(180);
					}
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==4)
				{
					$width_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(180)->flip('h');
					$height_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(180)->flip('h');
					if ($width > $height) //landscape image
					{
						$cap_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(180)->flip('h');
					}
					else
					{
						$cap_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(180)->flip('h');
					}
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==5)
				{
					$width_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(-90)->flip('h');
					$height_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(-90)->flip('h');
					if ($width > $height) //landscape image
					{
						$cap_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(-90)->flip('h');
					}
					else
					{
						$cap_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(-90)->flip('h');
					}
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==6)
				{
					$width_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(-90);
					$height_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(-90);
					if ($width > $height) //landscape image
					{
						$cap_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(-90);
					}
					else
					{
						$cap_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(-90);
					}
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==7)
				{
					$width_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(-90)->flip('v');
					$height_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(-90)->flip('v');
					if ($width > $height) //landscape image
					{
						$cap_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(-90)->flip('v');
					}
					else
					{
						$cap_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(-90)->flip('v');
					}
				}
				else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==8)
				{
					$width_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(90);
					$height_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(90);
					if ($width > $height) //landscape image
					{
						$cap_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(90);
					}
					else
					{
						$cap_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();})->rotate(90);
					}
				}
				else
				{
					$width_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();});
					$height_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();});
					if ($width > $height) //landscape image
					{
						$cap_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();});
					}
					else
					{
						$cap_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();});
					}
				}
				
			}
			else
			{
				$width_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();});
				$height_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();});
				if ($width > $height) //landscape image
				{
					$cap_image = Image::make(file_get_contents($file))->resize($dimension, null, function ($constraint){$constraint->aspectRatio();$constraint->upsize();});
				}
				else
				{
					$cap_image = Image::make(file_get_contents($file))->resize(null, $dimension, function ($constraint){$constraint->aspectRatio();$constraint->upsize();});
				}
			}
								
			//width						
			$width_image = $width_image->stream();
			$width_filePath = '/restaurant_assets_v2/width'.$dimension.'/'.$ori_filename;
			$s3->put($width_filePath, $width_image->__toString(),'public'); 
			
			//height						
			$height_image = $height_image->stream();
			$height_filePath = '/restaurant_assets_v2/height'.$dimension.'/'.$ori_filename;
			$s3->put($height_filePath, $height_image->__toString(),'public'); 
			
			//cap						
			$cap_image = $cap_image->stream();
			$cap_filePath = '/restaurant_assets_v2/cap'.$dimension.'/'.$ori_filename;
			$s3->put($cap_filePath, $cap_image->__toString(),'public'); 
			
			foreach($dimensions as $dimension2)
			{
				if ($img_mime == 'image/jpg' || $img_mime == 'image/jpeg')
				{
					if (isset($exif_data['Orientation']) and $exif_data['Orientation']==2)
					{
						$image = Image::make(file_get_contents($file))->fit($dimension, $dimension2, function ($constraint){$constraint->upsize();})->flip('h');
					}
					else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==3)
					{
						$image = Image::make(file_get_contents($file))->fit($dimension, $dimension2, function ($constraint){$constraint->upsize();})->rotate(180);
					}
					else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==4)
					{
						$image = Image::make(file_get_contents($file))->fit($dimension, $dimension2, function ($constraint){$constraint->upsize();})->rotate(180)->flip('h');
					}
					else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==5)
					{
						$image = Image::make(file_get_contents($file))->fit($dimension, $dimension2, function ($constraint){$constraint->upsize();})->rotate(-90)->flip('h');
					}
					else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==6)
					{
						$image = Image::make(file_get_contents($file))->fit($dimension, $dimension2, function ($constraint){$constraint->upsize();})->rotate(-90);
						
					}
					else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==7)
					{
						$image = Image::make(file_get_contents($file))->fit($dimension, $dimension2, function ($constraint){$constraint->upsize();})->rotate(-90)->flip('v');
					}
					else if (isset($exif_data['Orientation']) and $exif_data['Orientation']==8)
					{
						$image = Image::make(file_get_contents($file))->fit($dimension, $dimension2, function ($constraint){$constraint->upsize();})->rotate(90);
					}
					else
					{
						$image = Image::make(file_get_contents($file))->fit($dimension, $dimension2, function ($constraint){$constraint->upsize();});
					}
					
				}
				else
				{
					$image = Image::make(file_get_contents($file))->fit($dimension, $dimension2, function ($constraint){$constraint->upsize();});
				}
				
				$image = $image->stream();
				$filePath = '/restaurant_assets_v2/'.$dimension.'x'.$dimension2.'/'.$ori_filename;
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
		
        if ($asset->save()) 
        {
			flash()->success("Asset Successfully Uploaded.");

			return redirect()->route('admin.asset.asset.index');
        } else {
            flash()->error("Upload Fail.");

			return redirect()->route('admin.asset.asset.index');
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('asset::admin.assets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->asset->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('asset::assets.title.assets')]));

        return redirect()->route('admin.asset.asset.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Asset $asset
     * @return Response
     */
    public function edit(Asset $asset)
    {
        return view('asset::admin.assets.edit', compact('asset'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Asset $asset
     * @param  Request $request
     * @return Response
     */
    public function update(Asset $asset, Request $request)
    {
        $this->asset->update($asset, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('asset::assets.title.assets')]));

        return redirect()->route('admin.asset.asset.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Asset $asset
     * @return Response
     */
    public function destroy(Asset $asset)
    {
		$restaurant_id = $asset->restaurant_id;
		/*
		$s3 = Storage::disk('s3');
		$ori_filename = $asset->image_name;
		$ori_filePath = '/restaurant_assets_v2/original/' . $ori_filename;
		$info = $s3->exists($ori_filePath);
		if ($info)
		{
			$s3->delete($ori_filePath);
			
			$dimensions = ImageDimension::where('status',1)->lists('dimension');
			foreach($dimensions as $dimension)
			{
				//width
				$width_filePath = '/restaurant_assets_v2/width'.$dimension.'/'.$ori_filename;
				$s3->delete($width_filePath);
				
				//height
				$height_filePath = '/restaurant_assets_v2/height'.$dimension.'/'.$ori_filename;
				$s3->delete($height_filePath);
									
				$cap_filePath = '/restaurant_assets_v2/cap'.$dimension.'/'.$ori_filename;
				$s3->delete($cap_filePath); 
				
				foreach($dimensions as $dimension2)
				{
					$filePath = '/restaurant_assets_v2/'.$dimension.'x'.$dimension2.'/'.$ori_filename;
					$s3->delete($filePath); 
				}
			}
		}
        $this->asset->destroy($asset);
		*/
		try {
			$temp_asset = Asset::findOrFail($asset->id);
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Asset not found'));
            return redirect()->route('admin.menus.menus.index');
        }
		$temp_asset->active = 2;
		$temp_asset->save();
		
		flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('asset::assets.title.assets')]));

        return redirect()->route('admin.asset.asset.iasset',[$restaurant_id]);
    }
}
