@if(!empty($photosWithoutNominations))
    <div class="main_gallery__blocks">
        @foreach($photosWithoutNominations as $nextPhotosWithoutNomination)
            <div class="main_gallery__block">
                <div class="main_gallery__content">

                    <a href="{{ route('one_photo', [$nextPhotosWithoutNomination->slug.'.'.$nextPhotosWithoutNomination->id, 'wn']) }}" class="main_gallery__link"></a>

                    <img src="{{ $nextPhotosWithoutNomination->media_image_url }}" alt="">

                    <div class="main_gallery__info">

                        @if($nextPhotosWithoutNomination->avatar_media_image_url)
                            <div class="main_gallery__user">
                                <img src="{{ $nextPhotosWithoutNomination->avatar_media_image_url }}" alt="{{ $nextPhotosWithoutNomination->owner['name'] }}">
                                <p class="main_gallery__user-name"><a href="">{{ $nextPhotosWithoutNomination['id'] }}=>{{ $nextPhotosWithoutNomination->owner['name'] ?? ''}}</a></p>
                            </div>
                        @endif

                        @if($nextPhotosWithoutNomination->photo_likes_count > 0)
                            <div class="main_gallery__likes">
                                <svg class="icon icon-like">
                                    <use xlink:href="/img/icons.svg#like" />
                                </svg>
                                <span>{{ $nextPhotosWithoutNomination->photo_likes_count }}</span>
                            </div>
                        @endif

                    </div>

                </div>
            </div>
        @endforeach
    </div>
@endif
