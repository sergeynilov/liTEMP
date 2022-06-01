<?php

namespace App\View\Components\Frontend;

use App\Models\UserProfile;
use Illuminate\View\Component;

use DB;
use App\Config;

class CitiesWithUsers extends Component
{

    public $rowsLimit;
    public function __construct($rowsLimit= -1)
    {
        $this->rowsLimit= $rowsLimit;
    }

    public function render()
    {
        $popularCities = UserProfile
            ::orderBy('total_cities_count', 'desc')
            ->limit($this->rowsLimit)
            ->select('city_id', DB::raw('count(*) as total_cities_count'))
            ->groupBy('city_id')
            ->havingRaw('count(*) >= 1')
            ->with('city')
            ->get();
        return view('components.frontend.cities-with-users', [
            'popularCities'=> $popularCities
        ]);
    }
}
