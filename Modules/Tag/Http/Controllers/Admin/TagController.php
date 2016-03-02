<?php namespace Modules\Tag\Http\Controllers\Admin;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use Modules\Tag\Entities\Tag;
use Modules\Restaurant\Entities\Restaurant;
use Modules\Tag\Repositories\TagRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class TagController extends AdminBaseController
{
    /**
     * @var TagRepository
     */
    private $tag;

    public function __construct(TagRepository $tag)
    {
        parent::__construct();

        $this->tag = $tag;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tags = Tag::where('active',1)->orderBy('name','asc')->get();

        return view('tag::admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('tag::admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->tag->create($request->all());

        flash()->success(trans('core::core.messages.resource created', ['name' => trans('tag::tags.title.tags')]));

        return redirect()->route('admin.tag.tag.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Tag $tag
     * @return Response
     */
    public function edit(Tag $tag)
    {
        return view('tag::admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Tag $tag
     * @param  Request $request
     * @return Response
     */
    public function update(Tag $tag, Request $request)
    {
        $this->tag->update($tag, $request->all());

        flash()->success(trans('core::core.messages.resource updated', ['name' => trans('tag::tags.title.tags')]));

        return redirect()->route('admin.tag.tag.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Tag $tag
     * @return Response
     */
    public function destroy(Tag $tag)
    {
        //$this->tag->destroy($tag);
		
		try {
			$temp_tag = Tag::findOrFail($tag->id);
        } catch (ModelNotFoundException $e) {
            flash()->error(trans('Tag not found'));
            return redirect()->route('admin.tag.tag.index');
        }
		$temp_tag->active = 2;
		$temp_tag->save();
		
        flash()->success(trans('core::core.messages.resource deleted', ['name' => trans('tag::tags.title.tags')]));

        return redirect()->route('admin.tag.tag.index');
    }
}
