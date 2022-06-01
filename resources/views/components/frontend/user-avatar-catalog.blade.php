<div>

    @if(!empty($user))
    <div class="photo_page__user verified pro">
        @if(!empty($avatar_media_image_url))
        <div class="photo_page__user-photo">
            <a href="photographer_page.html">
                <img src="{{ $avatar_media_image_url }}" alt="">
            </a>
        </div>
        @endif

        <div class="photo_page__user-content">
            <div class="photo_page__user-title">
                <p class="photo_page__user-name"><a href="photographer_page.html">{{$user->name}}</a></p>
                <div class="photo_page__user-statuses"><i class="icon icon-verified tooltipstered" data-tooltip=""></i></div>
            </div>

            <div class="photo_page__user-info">
                <p class="photo_page__user-item"><a href="#">#65 в общем каталоге</a></p>
                <p class="photo_page__user-item"><a href="#">#2 {{ $userProfile->city->address }}</a></p>
            </div>
        </div>
    </div>
    @endif

</div>
