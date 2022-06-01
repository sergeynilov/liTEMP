<?php

namespace App\Http\Controllers\Admin;

use App\Models\Photo;
use App\Models\PhotoNomination;
use App\Models\NominationPhotoCover;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

use  App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Nomination;
use App\Http\Requests\NominationRequest;
use DB;
use Illuminate\Support\Facades\Auth;

class NominationsController extends Controller
{

    private $sortFields
        = [
            0 => 'nominations.id',
            1 => 'nominations.title',
            2 => 'nominations.active',
            3 => 'nominations.ordering',
            4 => 'nominations.created_at'
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
                ->with('status', 'You have no permission to enter Nominations.index method');
        }

        return view('admin.nomination.index', []);
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
                ->with('status', 'You have no permission to enter Nominations.getFilteredAjax method');
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

        $sort_by_field = 'nominations.ordering';
        $sort_ordering = 'desc';
        $iSortCol      = $request->iSortCol_0;
        $sSortDir      = $request->sSortDir_0;
        if ( ! empty($iSortCol) and isset($this->sortFields[$iSortCol])) {
            $sort_by_field = $this->sortFields[$iSortCol];
        }
        if ( ! empty($sSortDir)) {
            $sort_ordering = $sSortDir;
        }

        $nominationsCount = Nomination
            ::getByTitle($search_text)
            ->count();

        $nominations = Nomination
            ::getByTitle($search_text)
            ->orderBy($sort_by_field, $sort_ordering)
            ->offset($start)->limit($limit)
            ->get()
            ->map(function ($nominationItem) {
                $nominationItem->created_at_formatted = getFormattedDateTime($nominationItem->created_at);
                $nominationItem->active_label         = Nomination::getNominationStatusLabel($nominationItem->active);
                $nominationItem->edit_url             = route("nominations.edit", $nominationItem->id);

                return $nominationItem;
            });

        return response()->json([
            'iTotalRecords'        => $nominationsCount,
            'iTotalDisplayRecords' => $nominationsCount,
            'aaData'               => $nominations
        ], HTTP_RESPONSE_OK);
    }

    public function edit($id)
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status', 'You have no permission to enter Nominations.edit method');
        }

        $nominationData = Nomination::find($id);
        if (empty($nominationData)) {
            return redirect()->route('nominations.index')->with('error', 'Nomination not found !');
        }

        return view('admin.nomination.edit', [
            'nominationData' => $nominationData,
            'is_insert'      => false
        ]);
    } // public function edit($id)

    public function update(NominationRequest $request)
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status', 'You have no permission to enter Nominations.update method');
        }

        $id             = $request->id;
        $nominationData = Nomination::find($id);
        if (empty($nominationData)) {
            return redirect()->route('nominations.index')->with('error', 'Nomination not found !');
        }

        $nominationData->title      = $request->title;
        $nominationData->slug       = $request->slug;
        $nominationData->ordering   = $request->ordering;
        $nominationData->color      = $request->color;
        $nominationData->active     = $request->active ? true : false;
        $nominationData->updated_at = Carbon::now(config('app.timezone'));

        try {
            DB::beginTransaction();
            $nominationData->save();

            DB::commit();

            return redirect()->route('nominations.index')->with('success_message', 'Nomination updated successfully');
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', 'Run time error : ' . $e->getMessage())->withInput($request->all());
        }
    } // public function update(NominationRequest $request)

    public function set_reordering(request $request)
    {
        $request = request();

        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status', 'You have no permission to enter Nominations.set_reordering method');
        }

        $rowsToReorder = $request->rowsToReorder;

        try {
            $updatedNominations = 0;
            DB::beginTransaction();
            foreach ($rowsToReorder as $nextRowToReorder) {
                $nomination = Nomination::find($nextRowToReorder['id']);
                if ( ! empty($nomination)) {
                    $nomination->ordering   = $nextRowToReorder['new_position'] + 1;
                    $nomination->updated_at = Carbon::now(config('app.timezone'));
                    $nomination->save();
                    $updatedNominations++;
                }
            }
            DB::commit();

            return response()->json(['message' => $updatedNominations . ' nominations updated'], HTTP_RESPONSE_OK);
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
                ->with('status', 'You have no permission to enter Nominations.create method');
        }

        return view('admin.nomination.edit', [
            'nominationData' => null,
            'is_insert'      => true
        ]);
    }

    public function store(NominationRequest $request)
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status', 'You have no permission to enter Nominations.store method');
        }

        $nomination           = new Nomination;
        $nomination->title    = $request->title;
        $nomination->slug     = $request->slug;
        $nomination->ordering = $request->ordering + 1;
        $nomination->color    = $request->color;
        $nomination->active   = $request->active ? true : false;

        try {
            DB::beginTransaction();
            $nomination->save();

            DB::commit();

            return redirect()->route('nominations.index')->with('success_message', 'Nomination added successfully');
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', 'Run time error : ' . $e->getMessage())->withInput($request->all());
        }
    } // public function store(NominationRequest $request)


    public function destroy(Request $request, $nomination_id)
    {
        if ( ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status', 'You have no permission to enter Nominations.destroy method');
        }

        $nomination = Nomination::find($nomination_id);
        try {
            DB::beginTransaction();
            $nomination->delete();

            DB::commit();

            return response()->json([], HTTP_RESPONSE_OK_RESOURCE_DELETED);
        } catch (QueryException $e) {
            DB::rollBack();

            return back()->with('error', 'Run time error : ' . $e->getMessage())->withInput($request->all());
        }
    } // public function destroy(Request $request)

    // NOMINATIONS PHOTO COVERS BLOCK START
    public function get_nomination_photo_covers($nomination_id)
    {
        if ( ! isUserLogged() or ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status', 'You have no permission to enter Photos.get_nomination_photo_covers method');
        }

        $photoNominationCovers = PhotoNomination
            ::getByNominationId($nomination_id)
            ->with('photo')
            ->get();

        \Log::info(  varDump($photoNominationCovers, ' -1 get_nomination_photo_covers  $photoNominationCovers::') );

        foreach ($photoNominationCovers as $nextPhotoNomination) {
            $nextPhoto             = $nextPhotoNomination->photo;
            $photo_media_image_url = '';
            $photo_name            = $nextPhoto->name;
            $photo_slug            = $nextPhoto->slug;
            foreach ($nextPhoto->getMedia('photo') as $mediaImage) {
                $photo_media_image_url = $mediaImage->getUrl();
            }

            $nextPhotoNomination->photo_media_image_url = $photo_media_image_url;
            $nextPhotoNomination->photo_name            = $photo_name;
            $nextPhotoNomination->photo_slug            = $photo_slug;
            $nominationPhotoCover                       = NominationPhotoCover
                ::getByNominationId($nomination_id)
                ->getByPhotoId($nextPhoto->id)
                ->first();
            $nextPhotoNomination->is_selected           = ! empty($nominationPhotoCover);
        }

//        \Log::info(varDump($photoNominationCovers, ' -1 $photoNominationCovers::'));
        $html = view('admin.nomination.nomination_photo_covers',
            ['nomination_id' => $nomination_id, 'photoNominationCovers' => $photoNominationCovers])->render();

        return response()->json(['html' => $html], HTTP_RESPONSE_OK);
    } // public function get_nomination_photo_covers($nomination_id)

    public function assign_to_nomination_photo_covers()
    {
        if ( ! isUserLogged() or ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status', 'You have no permission to enter Photos.assign_to_nomination_photo_covers method');
        }

        $photo_id = $this->requestData['photo_id'] ?? null;
        $nomination_id = $this->requestData['nomination_id'] ?? null;

        $photoData = Photo::find($photo_id);
        if (empty($photoData)) {
            return response()->json(['message' => 'Photo # "' . $photo_id . '" not found !'],
                HTTP_RESPONSE_BAD_REQUEST);
        }

        $nominationData = Nomination::find($nomination_id);
        if (empty($nominationData)) {
            return response()->json(['message' => 'Nomination # "' . $nomination_id . '" not found !'],
                HTTP_RESPONSE_BAD_REQUEST);
        }

        $newNominationPhotoCover                = new NominationPhotoCover();
        $newNominationPhotoCover->photo_id      = $photo_id;
        $newNominationPhotoCover->nomination_id = $nomination_id;
        try {
            DB::beginTransaction();
            $newNominationPhotoCover->save();
            DB::commit();

            return response()->json(['message' => 'Nomination photo cover assigned successfully'], HTTP_RESPONSE_OK);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Run time error : ' . $e->getMessage()], HTTP_RESPONSE_BAD_REQUEST);
        }
    } // public function assign_to_nomination_photo_covers()


    public function revoke_from_nomination_photo_covers()
    {
        if ( ! isUserLogged() or ! Auth::user()->hasAnyPermission([PERMISSION_APP_ADMIN, PERMISSION_APP_MANAGER])) {
            Auth::logout();

            return redirect('/login')
                ->with('status',
                    'You have no permission to enter Photos.revoke_from_nomination_photo_covers method');
        }

        $photo_id = $this->requestData['photo_id'] ?? null;
        $nomination_id = $this->requestData['nomination_id'] ?? null;

        $photoData = Photo::find($photo_id);
        if (empty($photoData)) {
            return response()->json(['message' => 'Photo # "' . $photo_id . '" not found !'],
                HTTP_RESPONSE_BAD_REQUEST);
        }

        $nominationData = Nomination::find($nomination_id);
        if (empty($nominationData)) {
            return response()->json(['message' => 'Nomination # "' . $nomination_id . '" not found !'],
                HTTP_RESPONSE_BAD_REQUEST);
        }

        $NominationPhotoCovers = NominationPhotoCover
            ::getByNominationId($nomination_id)
            ->getByPhotoId($photo_id)
            ->get();
        try {
            DB::beginTransaction();
            foreach ($NominationPhotoCovers as $nextNominationPhotoCover) {
                $nextNominationPhotoCover->delete();
            }
            DB::commit();

            return response()->json(['message' => 'Nomination photo cover revoked successfully'], HTTP_RESPONSE_OK);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Run time error : ' . $e->getMessage()], HTTP_RESPONSE_BAD_REQUEST);
        }
    } // public function revoke_from_nomination_photo_covers()
    // NOMINATIONS PHOTO COVERS BLOCK END


}
