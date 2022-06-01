<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use  App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\CameraLense;
use App\Http\Requests\CameraLenseRequest;
use DB;
use Illuminate\Support\Facades\Auth;

class CameraLensesController extends Controller
{

    private $sortFields
        = [
            0 => 'camera_lenses.id',
            1 => 'camera_lenses.name',
            2 => 'camera_lenses.active',
            3 => 'camera_lenses.created_at'
        ];

    /**
     *
     * @return type
     */
    public function index()
    {
        return view('admin.camera_lense.index', []);
    }

    /**
     *
     * @param Request $request
     */
    public function getFilteredAjax(Request $request)
    {
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


        $sort_by_field = 'camera_lenses.id';
        $sort_ordering = 'desc';
        $iSortCol      = $request->iSortCol_0;
        $sSortDir      = $request->sSortDir_0;
        if ( ! empty($iSortCol) and isset($this->sortFields[$iSortCol])) {
            $sort_by_field = $this->sortFields[$iSortCol];
        }
        if ( ! empty($sSortDir)) {
            $sort_ordering = $sSortDir;
        }

        $cameraLensesCount = CameraLense
            ::getByName($search_text)
            ->count();

        $cameraLenses = CameraLense
            ::getByName($search_text)
            ->orderBy($sort_by_field, $sort_ordering)
            ->offset($start)->limit($limit)
            ->get()
            ->map(function ($cameraLenseItem) {
                $cameraLenseItem->created_at_formatted = getFormattedDateTime($cameraLenseItem->created_at);
                $cameraLenseItem->active_label         = CameraLense::getCameraLenseStatusLabel($cameraLenseItem->active);
                $cameraLenseItem->edit_url             = route("camera_lenses.edit", $cameraLenseItem->id);

                return $cameraLenseItem;
            });

        return response()->json(['iTotalRecords'        => $cameraLensesCount,
                                 'iTotalDisplayRecords' => $cameraLensesCount,
                                 'aaData'               => $cameraLenses
        ], HTTP_RESPONSE_OK);
    }

    public function edit($id)
    {
        $cameraLenseData = CameraLense::find($id);
        if (empty($cameraLenseData)) {
            return redirect()->route('camera_lenses.index')->with('error', 'CameraLense not found !');
        }

        return view('admin.camera_lenses.edit', [
            'cameraLenseData' => $cameraLenseData,
            'is_insert'       => false
        ]);
    } // public function edit($id)

    public function update(CameraLenseRequest $request)
    {
        $id              = $request->id;
        $cameraLenseData = CameraLense::find($id);
        if (empty($cameraLenseData)) {
            return redirect()->route('camera_lenses.index')->with('error', 'CameraLense not found !');
        }

        $cameraLenseData->name       = $request->name;
        $cameraLenseData->slug       = $request->slug;
        $cameraLenseData->active     = $request->active ? true : false;
        $cameraLenseData->updated_at = Carbon::now(config('app.timezone'));

        try {
            DB::beginTransaction();
            $cameraLenseData->save();

            DB::commit();

            return redirect()->route('camera_lenses.index')->with('success_message',
                'CameraLense updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', 'Run time error : ' . $e->getMessage())->withInput($request->all());
        }
    } // public function update(CameraLenseRequest $request)

    public function create()
    {
        return view('admin.camera_lenses.edit', [
            'cameraLenseData' => null,
            'is_insert'       => true
        ]);
    }

    public function store(CameraLenseRequest $request)
    {
        $cameraLense         = new CameraLense;
        $cameraLense->name   = $request->name;
        $cameraLense->slug   = $request->slug;
        $cameraLense->active = $request->active ? true : false;

        try {
            DB::beginTransaction();
            $cameraLense->save();

            DB::commit();

            return redirect()->route('cameraLenses.index')->with('success_message', 'CameraLense added successfully');
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', 'Run time error : ' . $e->getMessage())->withInput($request->all());
        }
    } // public function store(CameraLenseRequest $request)


    public function destroy(Request $request, $camera_lense_id)
    {
        $cameraLense = CameraLense::find($camera_lense_id);

        try {
            DB::beginTransaction();
            $cameraLense->delete();

            DB::commit();

            return response()->json([], HTTP_RESPONSE_OK_RESOURCE_DELETED);
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', 'Run time error : ' . $e->getMessage())->withInput($request->all());
        }
    } // public function destroy(Request $request)


}
