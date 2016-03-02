<?php namespace Modules\Menus\Http\Controllers\Admin;

use DB;
use Image;
use Input;
use Storage;
use App\ImageDimension;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Menus\Entities\Menus;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Validator;
use Modules\Restaurant\Entities\Restaurant;
use Modules\Menus\Repositories\MenusRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class MenusController extends AdminBaseController
{
    /**
     * @var MenusRepository
     */
    private $menus;

    public function __construct(MenusRepository $menus)
    {
        parent::__construct();

        $this->menus = $menus;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $restaurants = Restaurant::select('*',DB::raw('(select count(*) from menus where active=1 and restaurant_id=restaurants.id) as total_menu'))->get();

        return view('menus::admin.menuses.index', compact('restaurants'));
    }
    
    public function imenu($id)
    {
		try {
			$restaurant = Restaurant::findOrFail($id);
			$menus = Menus::where('restaurant_id',$id)->where('active','!=','2')->get();
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Restaurant not found'));
            return redirect()->route('admin.menus.menus.index');
        }

        return view('menus::admin.menuses.imenu', compact('restaurant','menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    
    public function smenu($id) 
    {
        $input = Input::all();
 
        $rules = array(
            'file' => 'image|mimes:png,gif,jpeg',
        );
 
        $validation = Validator::make($input, $rules);
 
        if ($validation->fails()) 
        {
            flash()->error("Upload Fail.");

			return redirect()->route('admin.menus.menus.index');
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
		$ori_filePath = '/menus/original/' . $ori_filename;
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
			$width_filePath = '/menus/width'.$dimension.'/'.$ori_filename;
			$s3->put($width_filePath, $width_image->__toString(),'public'); 
			
			//height						
			$height_image = $height_image->stream();
			$height_filePath = '/menus/height'.$dimension.'/'.$ori_filename;
			$s3->put($height_filePath, $height_image->__toString(),'public'); 
			
			//cap						
			$cap_image = $cap_image->stream();
			$cap_filePath = '/menus/cap'.$dimension.'/'.$ori_filename;
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
				$filePath = '/menus/'.$dimension.'x'.$dimension2.'/'.$ori_filename;
				$s3->put($filePath, $image->__toString(),'public'); 
			}
		}
		
		$menu = new Menus;
		$menu->restaurant_id = $id;
		$menu->width = $width;
		$menu->height= $height;
		$menu->image_name = $ori_filename;							
		$menu->image_md5 = md5(file_get_contents($file));
		$menu->active = 1;
		
        if ($menu->save()) 
        {
			flash()->success("Menu Successfully Uploaded.");

			return redirect()->route('admin.menus.menus.index');
        } else {
            flash()->error("Upload Fail.");

			return redirect()->route('admin.menus.menus.index');
        }
    }
    
    public function create()
    {
        return view('menus::admin.menuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->menus->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('menus::menuses.title.menuses')]));

        return redirect()->route('admin.menus.menus.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Menus $menus
     * @return Response
     */
    public function edit(Menus $menus)
    {
        return view('menus::admin.menuses.edit', compact('menus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Menus $menus
     * @param  Request $request
     * @return Response
     */
    public function update(Menus $menus, Request $request)
    {
        $this->menus->update($menus, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('menus::menuses.title.menuses')]));

        return redirect()->route('admin.menus.menus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Menus $menus
     * @return Response
     */
    public function destroy(Menus $menus)
    {
		$restaurant_id = $menus->restaurant_id;
		/*
		$s3 = Storage::disk('s3');
		$ori_filename = $menus->image_name;
		$ori_filePath = '/menus/original/' . $ori_filename;
		$info = $s3->exists($ori_filePath);
		if ($info)
		{
			$s3->delete($ori_filePath);
			
			$dimensions = ImageDimension::where('status',1)->lists('dimension');
			foreach($dimensions as $dimension)
			{
				//width
				$width_filePath = '/menus/width'.$dimension.'/'.$ori_filename;
				$s3->delete($width_filePath);
				
				//height
				$height_filePath = '/menus/height'.$dimension.'/'.$ori_filename;
				$s3->delete($height_filePath);
									
				$cap_filePath = '/menus/cap'.$dimension.'/'.$ori_filename;
				$s3->delete($cap_filePath); 
				
				foreach($dimensions as $dimension2)
				{
					$filePath = '/menus/'.$dimension.'x'.$dimension2.'/'.$ori_filename;
					$s3->delete($filePath); 
				}
			}
		}
        $this->menus->destroy($menus);
		*/ 
		try {
			$menu = Menus::findOrFail($menus->id);
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Menu not found'));
            return redirect()->route('admin.menus.menus.index');
        }
		$menu->active = 2;
		$menu->save();
		
		flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('menus::menuses.title.menuses')]));

        return redirect()->route('admin.menus.menus.imenu',[$restaurant_id]);
    }
}
