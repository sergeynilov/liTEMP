<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Photo;
use App\Models\Tag;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use Auth;
use DB;
use App\Models\User;


class HomeController extends Controller
{
    public function index()
    {
        // resources/views/frontend/home.blade.php
        return view('frontend.home', [
        ]);
//        return Inertia::renTTTder('home/index', []);
    }

    public function get_years_selection_array(Request $request)
    {

        $yearsSelectionArray= [];
        $current_year =  now()->year;
        $started_year_minus = (int)(config('app.started_year_minus', 80));
        for($year = $current_year; $year>= $current_year- $started_year_minus; $year--) {
            $yearsSelectionArray[$year] = $year;
        }

        return response()->json([
            'yearsSelectionArray' => $yearsSelectionArray,
        ], HTTP_RESPONSE_OK);

    } // public function get_years_selection_array(Request $request)

    public function get_cities_selection_array(Request $request)
    {

        $citiesSelectionArray = City::getCitiesSelectionArray(true);

        return response()->json([
            'citiesSelectionArray' => $citiesSelectionArray,
        ], HTTP_RESPONSE_OK);

    } // public function get_cities_selection_array(Request $request)

    public function get_all_photos(Request $request)
    {

        $sort_by_field = 'photos.published_at';
        $sort_ordering = 'desc';
//        \Log::info(  varDump(0, ' 0 get_all_photos  $photos::') );


        $total_photos_count           = Photo
            ::count();
        $photos           = Photo
//            ->where('photos.id', 2) // Debugging
            ::orderBy($sort_by_field, $sort_ordering)
            ->withCount('photoLikes')
            ->with('photoNominations.nomination')
            ->get();
        foreach ($photos as $nextPhoto) {
            $nextPhoto->created_at_formatted   = getFormattedDateTime($nextPhoto->created_at);
            $nextPhoto->published_at_formatted = getFormattedDateTime($nextPhoto->published_at);
            $nextPhoto->active_label           = Photo::getPhotoStatusLabel($nextPhoto->active);
            $this->media_image_url = '';
            $this->file_name       = '';
            foreach ($nextPhoto->getMedia('photo') as $mediaImage) {
                $nextPhoto->media_image_url = $mediaImage->getUrl();
                $nextPhoto->file_name       = $mediaImage->file_name;
            }
        }

        return response()->json([
            'photos' => $photos,
            'total_photos_count'=> $total_photos_count,
        ], HTTP_RESPONSE_OK);

    } // public function get_all_photos(Request $request)

    public function get_tags($active= null)
    {
        $tags = Tag
            ::getByActive($active)
            ->orderBy('title', 'asc')
            ->get();
        return response()->json([
            'tags' => $tags,
        ], HTTP_RESPONSE_OK);
    } // public function get_tags()



    public function test()
    {
        return Inertia::render('test', []);
    }

    public function test2()
    {
        return Inertia::render('test2', []);
    }
    public function sel_test()
    {

        $yearsSelectionArray= [];
        $current_year =  now()->year;
        $started_year_minus = (int)(config('app.started_year_minus', 80));
        for($year = $current_year - $started_year_minus; $year<= $current_year; $year++) {
            $yearsSelectionArray[$year] = $year;
        }
        return Inertia::render('sel_test', [
            'yearsSelectionArray' => $yearsSelectionArray,
        ]);
    }
    public function masonry_test()
    {

        \Log::info(  varDump(-1, ' -1 /masonry_test::') );
        return view('masonry_test', [
        ]);
    }
}
