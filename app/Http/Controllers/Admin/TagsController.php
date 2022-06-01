<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\QueryException;
use  App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Tag;
use App\Http\Requests\TagRequest;
use DB;
use Illuminate\Support\Facades\Auth;

class TagsController extends Controller
{

    private $sortFields
        = [
            0 => 'tags.id',
            1 => 'tags.title',
            2 => 'tags.active',
            3 => 'tags.created_at'
        ];
    /**
     *
     * @return type
     */
    public function index()
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN])) {
            Auth::logout();
            return redirect('/login')
                ->with('status', 'You have no permission to enter Tags.listing method');
        }

        return view('admin.tag.index', []);
    }

    /**
     *
     * @param Request $request
     */
    public function getFilteredAjax(Request $request)
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN])) {
            Auth::logout();
            return redirect('/login')
                ->with('status', 'You have no permission to enter Tags.listing method');
        }

        $start       = 0;
        $limit       = 10;
        $search_text = "";

        if (isset($request->iDisplayStart) && $request->iDisplayStart != "" && is_numeric($request->iDisplayStart)) {
            $start = $request->iDisplayStart;
        }
        if (isset($request->iDisplayLength) && $request->iDisplayLength != "" && is_numeric($request->iDisplayStart)) {
            $limit = $request->iDisplayLength;
        }
        if (isset($request->sSearch) && $request->sSearch != "") {
            $search_text = $request->sSearch;
        }

        $sort_by_field = 'tags.title';
        $sort_ordering = 'desc';
        $iSortCol      = $request->iSortCol_0;
        $sSortDir      = $request->sSortDir_0;
        if ( ! empty($iSortCol) and isset($this->sortFields[$iSortCol])) {
            $sort_by_field = $this->sortFields[$iSortCol];
        }
        if ( ! empty($sSortDir)) {
            $sort_ordering = $sSortDir;
        }

        $tagsCount = Tag
            ::getByTitle($search_text)
            ->count();

        $tags = Tag
            ::getByTitle($search_text)
            ->orderBy($sort_by_field, $sort_ordering)
            ->offset($start)->limit($limit)
            ->get()
            ->map(function ($tagItem) {
                $tagItem->created_at_formatted = getFormattedDateTime($tagItem->created_at);
                $tagItem->active_label         = Tag::getTagStatusLabel($tagItem->active);
                $tagItem->edit_url             = route("tags.edit", $tagItem->id);
                return $tagItem;
            });

        return response()->json(['iTotalRecords' => $tagsCount, 'iTotalDisplayRecords' => $tagsCount, 'aaData' => $tags], HTTP_RESPONSE_OK);
    }

    public function edit($id)
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN])) {
            Auth::logout();
            return redirect('/login')
                ->with('status', 'You have no permission to enter Tags.listing method');
        }

        $tagData = Tag::find($id);
        if (empty($tagData)) {
            return redirect()->route('tags.index')->with('error', 'Tag not found !');
        }

        return view('admin.tag.edit', [
            'tagData'   => $tagData,
            'is_insert' => false
        ]);
    } // public function edit($id)

    public function update(TagRequest $request)
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN])) {
            Auth::logout();
            return redirect('/login')
                ->with('status', 'You have no permission to enter Tags.listing method');
        }

        $id      = $request->id;
        $tagData = Tag::find($id);
        if (empty($tagData)) {
            return redirect()->route('tags.index')->with('error', 'Tag not found !');
        }

        $tagData->title      = $request->title;
        $tagData->slug      = $request->slug;
        $tagData->active     = $request->active ? true : false;
        $tagData->updated_at = Carbon::now(config('app.timezone'));

        try {
            DB::beginTransaction();
            $tagData->save();

            DB::commit();
            return redirect()->route('tags.index')->with('success_message', 'Tag updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', 'Run time error : ' . $e->getMessage())->withInput($request->all());
        }
    } // public function update(TagRequest $request)

    public function create()
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN])) {
            Auth::logout();
            return redirect('/login')
                ->with('status', 'You have no permission to enter Tags.listing method');
        }

        return view('admin.tag.edit', [
            'tagData'   => null,
            'is_insert' => true
        ]);
    }

    public function store(TagRequest $request)
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN])) {
            Auth::logout();
            return redirect('/login')
                ->with('status', 'You have no permission to enter Tags.listing method');
        }

        $tag             = new Tag;
        $tag->title      = $request->title;
        $tag->slug      = $request->slug;
        $tag->active     = $request->active ? true : false;

        try {
            DB::beginTransaction();
            $tag->save();

            DB::commit();
            return redirect()->route('tags.index')->with('success_message', 'Tag added successfully');
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', 'Run time error : ' . $e->getMessage())->withInput($request->all());
        }
    } // public function store(TagRequest $request)


    public function destroy(Request $request, $tag_id)
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN])) {
            Auth::logout();
            return redirect('/login')
                ->with('status', 'You have no permission to enter Tags.listing method');
        }

        $tag = Tag::find($tag_id);

        try {
            DB::beginTransaction();
            $tag->delete();

            DB::commit();
            return response()->json([], HTTP_RESPONSE_OK_RESOURCE_DELETED);
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', 'Run time error : ' . $e->getMessage())->withInput($request->all());
        }
    } // public function destroy(Request $request)


}
