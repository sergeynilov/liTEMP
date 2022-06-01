<?php

namespace App\View\Components\Frontend;

use App\Models\UserProfile;
use Illuminate\View\Component;

class UserAvatarCatalog extends Component
{
    public $user;
    public $userProfile;
    public $source;
    public $avatar_media_image_url;

    public function __construct( $user= null, $source= null )
    {
        $this->user= $user;
        $this->avatar_media_image_url = '';
        foreach ($this->user->getMedia('avatar') as $mediaImage) {
            $this->avatar_media_image_url = $mediaImage->getUrl();
        }

        $this->userProfile = UserProfile
            ::getByUserId($user->id)
            ->with('city')
            ->first();
        $this->source= $source;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        return view('components.frontend.user-avatar-catalog');
    }
}
