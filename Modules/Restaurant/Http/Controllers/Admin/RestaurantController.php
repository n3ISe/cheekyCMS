<?php namespace Modules\Restaurant\Http\Controllers\Admin;

use DB;
use Input;
use App\OperatingHour;
use App\RestaurantTag;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Tag\Entities\Tag;
use Modules\Location\Entities\Location;
use Modules\Category\Entities\Category;
use Modules\Restaurant\Entities\Restaurant;
use Modules\CuisineType\Entities\CuisineType;
use Modules\Restaurant\Repositories\RestaurantRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Illuminate\Support\Facades\Request as Request2;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RestaurantController extends AdminBaseController
{
    /**
     * @var RestaurantRepository
     */
    private $restaurant;


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $restaurants = Restaurant::with('location')
			->select('*')
			->addSelect(DB::raw('(select count(*) from likes where restaurant_id=restaurants.id) as total_like'))
			->addSelect(DB::raw('(select count(*) from bookmarks where restaurant_id=restaurants.id) as total_bookmark'))
			->addSelect(DB::raw('(select count(*) from visits where restaurant_id=restaurants.id) as total_visit'))
			->where('active','!=','2')
			->orderBy('id','desc')->get();

        return view('restaurant::admin.restaurants.index', compact('restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
		$locations 	= [''=>'Please select location'] + Location::where('active',1)->orderBy('name','asc')->lists('name', 'id')->all();
		$categories = [''=>'Please select category'] + Category::where('active',1)->orderBy('name','asc')->lists('name', 'id')->all();
		$cuisines	= [''=>'Please select cuisine type'] + CuisineType::where('active',1)->orderBy('name','asc')->lists('name', 'id')->all();
		$tags 		= Tag::where('active',1)->get();
        return view('restaurant::admin.restaurants.create', compact('locations','categories','cuisines','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request2 $request)
    {
		$restaurant = new Restaurant;
		$restaurant->name 			= Request2::get('name');
		$restaurant->location_id 	= Request2::get('location_id');
		$restaurant->phone_number 	= Request2::get('phone_number');
		$restaurant->category_id 	= Request2::get('category_id');
		$restaurant->cuisine_type_id= Request2::get('cuisine_type_id');
		$restaurant->coord_lat		= Request2::get('coord_lat');
		$restaurant->coord_long		= Request2::get('coord_long');
		$restaurant->address		= Request2::get('address');
		$restaurant->description	= Request2::get('description');
		$restaurant->active			= Request2::get('active');
		$restaurant->save();

		$tags = Request2::get('tags');
		if (!empty($tags)) 
        {
			foreach ($tags as $tag) 
			{
				$dataSet[] = [
					'restaurant_id'  => $restaurant->id,
					'tag_id'    => $tag,
				];
			}
			
			RestaurantTag::insert($dataSet);
        }
        
        for ($i = 0; $i <=6 ; $i++)
		{
			$day		= Request2::get('day')[$i];
			$timezone	= Request2::get('timezone')[$i];
			$open		= Request2::get('open')[$i];
			$close		= Request2::get('close')[$i];
			if ($open === '') 
			{
				$open = NULL; 
			}
			if ($close === '') 
			{
				$close = NULL; 
			}
			DB::table('operating_hours')->insert(['restaurant_id'  => $restaurant->id,'day'=>$day,'timezone' => $timezone,'open' => $open,'close' => $close]);
		}
        
        flash()->success($restaurant->name.' created.');

        return redirect()->route('admin.restaurant.restaurant.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Restaurant $restaurant
     * @return Response
     */
    public function edit($id)
    {
		try {
			$restaurant = Restaurant::findOrFail($id);
			$locations = [''=>'Please select location'] + Location::where('active',1)->orderBy('name','asc')->lists('name', 'id')->all();
			$categories = [''=>'Please select category'] + Category::where('active',1)->orderBy('name','asc')->lists('name', 'id')->all();
			$cuisines	= [''=>'Please select cuisine type'] + CuisineType::where('active',1)->orderBy('name','asc')->lists('name', 'id')->all();
			$selected = Input::old('location_id') ? Input::old('location_id') : $restaurant->location_id;
			$tags = Tag::where('active',1)->get();
			$operatings = OperatingHour::where('restaurant_id',$id)->orderBy('day','asc')->get();
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Restaurant not found'));
            return redirect()->route('admin.restaurant.restaurant.index');
        }
		//$restaurant = Restaurant::findOrFail($id);
        return view('restaurant::admin.restaurants.edit', compact('restaurant','locations','selected','categories','cuisines', 'tags', 'operatings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Restaurant $restaurant
     * @param  Request $request
     * @return Response
     */
    public function update($id, Request $request, Request2 $request2)
    {
		try {
           $restaurant = Restaurant::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Restaurant not found'));
            return redirect()->route('admin.restaurant.restaurant.index');
        }
        
        $tags = Request2::get('tags');
        $restaurant = new Restaurant;
        $restaurant->updateAndSyncTags($id, $request->all(), $tags);
        
        for ($i = 0; $i <=6 ; $i++)
		{
			$timezone	= Request2::get('timezone')[$i];
			$open		= Request2::get('open')[$i];
			$close		= Request2::get('close')[$i];
			if ($open === '') 
			{
				$open = NULL; 
			}
			if ($close === '') 
			{
				$close = NULL; 
			}
			DB::table('operating_hours')->where('day', ($i+1))->where('restaurant_id',$id)->update(array('timezone' => $timezone,'open' => $open,'close' => $close));
		}
		
        
        flash()->success('Restaurant updated', ['name' => $restaurant->name]);

        return redirect()->route('admin.restaurant.restaurant.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Restaurant $restaurant
     * @return Response
     */
    public function destroy($id)
    {
		try {
			$restaurant = Restaurant::findOrFail($id);
          // $restaurant->delete();
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Restaurant not found'));
            return redirect()->route('admin.restaurant.restaurant.index');
        }
		$restaurant->active = 2;
		$restaurant->save();

        flash()->success('Restaurant deleted');

        return redirect()->route('admin.restaurant.restaurant.index');
    }
}
