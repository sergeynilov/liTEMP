<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

use  App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Compilation;
use App\Http\Requests\CompilationRequest;
use DB;
use Illuminate\Support\Facades\Auth;

class CompilationsController extends Controller
{

    private $sortFields
        = [
            0 => 'compilations.id',
            1 => 'compilations.title',
            2 => 'compilations.active',
            3 => 'compilations.ordering',
            4 => 'compilations.created_at'
        ];

    /**
     *
     * @return type
     */
    public function index()
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status', 'You have no permission to enter Compilations.index method');
        }

        return view('admin.compilation.index', []);
    }

    /**
     *
     * @param Request $request
     */
    public function getFilteredAjax(Request $request)
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status', 'You have no permission to enter Compilations.getFilteredAjax method');
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

        $sort_by_field = 'compilations.ordering';
        $sort_ordering = 'desc';
        $iSortCol      = $request->iSortCol_0;
        $sSortDir      = $request->sSortDir_0;
        if ( ! empty($iSortCol) and isset($this->sortFields[$iSortCol])) {
            $sort_by_field = $this->sortFields[$iSortCol];
        }
        if ( ! empty($sSortDir)) {
            $sort_ordering = $sSortDir;
        }

        $compilationsCount = Compilation
            ::getByTitle($search_text)
            ->count();

        $compilations = Compilation
            ::getByTitle($search_text)
            ->orderBy($sort_by_field, $sort_ordering)
            ->offset($start)->limit($limit)
            ->get()
            ->map(function ($compilationItem) {
                $compilationItem->created_at_formatted = getFormattedDateTime($compilationItem->created_at);
                $compilationItem->active_label         = Compilation::getCompilationStatusLabel($compilationItem->active);
                $compilationItem->edit_url             = route("compilations.edit", $compilationItem->id);

                return $compilationItem;
            });

        return response()->json([
            'iTotalRecords'        => $compilationsCount,
            'iTotalDisplayRecords' => $compilationsCount,
            'aaData'               => $compilations
        ], HTTP_RESPONSE_OK);
    }

    public function edit($id)
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status', 'You have no permission to enter Compilations.edit method');
        }

        $compilationData = Compilation::find($id);
        if (empty($compilationData)) {
            return redirect()->route('compilations.index')->with('error', 'Compilation not found !');
        }

        return view('admin.compilation.edit', [
            'compilationData' => $compilationData,
            'is_insert'      => false
        ]);
    } // public function edit($id)

    public function update(CompilationRequest $request)
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status', 'You have no permission to enter Compilations.update method');
        }

        $id             = $request->id;
        $compilationData = Compilation::find($id);
        if (empty($compilationData)) {
            return redirect()->route('compilations.index')->with('error', 'Compilation not found !');
        }

        $compilationData->title      = $request->title;
        $compilationData->slug       = $request->slug;
        $compilationData->ordering   = $request->ordering;
        $compilationData->active     = $request->active ? true : false;
        $compilationData->updated_at = Carbon::now(config('app.timezone'));

        try {
            DB::beginTransaction();
            $compilationData->save();

            DB::commit();

            return redirect()->route('compilations.index')->with('success_message', 'Compilation updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', 'Run time error : ' . $e->getMessage())->withInput($request->all());
        }
    } // public function update(CompilationRequest $request)

    public function set_reordering(request $request)
    {
        $request= request();

        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status', 'You have no permission to enter Compilations.set_reordering method');
        }

        $rowsToReorder = $request->rowsToReorder;

        try {
            $updatedCompilations = 0;
            DB::beginTransaction();
            foreach ($rowsToReorder as $nextRowToReorder) {
                $compilation = Compilation::find($nextRowToReorder['id']);
                if ( ! empty($compilation)) {
                    $compilation->ordering   = $nextRowToReorder['new_position'] + 1;
                    $compilation->updated_at = Carbon::now(config('app.timezone'));
                    $compilation->save();
                    $updatedCompilations++;
                }
            }
            DB::commit();

            return response()->json(['message' => $updatedCompilations . ' compilations updated'], HTTP_RESPONSE_OK);
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', 'Run time error : ' . $e->getMessage())->withInput($request->all());
        }

    } // public function set_reordering(TagRequest $request)

    public function create()
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status', 'You have no permission to enter Compilations.create method');
        }

        return view('admin.compilation.edit', [
            'compilationData' => null,
            'is_insert'      => true
        ]);
    }

    public function store(CompilationRequest $request)
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status', 'You have no permission to enter Compilations.store method');
        }

        $compilation           = new Compilation;
        $compilation->title    = $request->title;
        $compilation->slug     = $request->slug;
        $compilation->ordering = $request->ordering + 1;
        $compilation->active   = $request->active ? true : false;

        try {
            DB::beginTransaction();
            $compilation->save();

            DB::commit();

            return redirect()->route('compilations.index')->with('success_message', 'Compilation added successfully');
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', 'Run time error : ' . $e->getMessage())->withInput($request->all());
        }
    } // public function store(CompilationRequest $request)


    public function destroy(Request $request, $compilation_id)
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status', 'You have no permission to enter Compilations.destroy method');
        }

        $compilation = Compilation::find($compilation_id);
        try {
            DB::beginTransaction();
            $compilation->delete();

            DB::commit();

            return response()->json([], HTTP_RESPONSE_OK_RESOURCE_DELETED);
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', 'Run time error : ' . $e->getMessage())->withInput($request->all());
        }
    } // public function destroy(Request $request)


}
