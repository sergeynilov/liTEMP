<div class="main_gallery__blocks">

    @foreach($photosOfCompilation as $nextPhotosOfCompilation)
        @if(!empty($nextPhotosOfCompilation->media_image_url) and !empty($nextPhotosOfCompilation->photo->name) )

            <div class="main_gallery__block grid-compilation-image">
                <div class="main_gallery__content">

                    <a href="{{ route('one_photo', [ $nextPhotosOfCompilation->photo->slug.'.'.$nextPhotosOfCompilation->photo_id, 'compilations.' . $nextPhotosOfCompilation->compilation_id ]) }}" class="main_gallery__link"></a>

                    {{--                    <a href="{{ route('', $nextPhotosOfCompilation->slug.'.'.$nextPhotosOfCompilation->id)  }}"--}}
{{--                       class="main_gallery__link"></a>--}}

                    <img src="{{ $nextPhotosOfCompilation->media_image_url }}" alt="">

                    @foreach($nextPhotosOfCompilation->photo->photoNominations as $nextPhotoNomination)
                        <div data-tooltip data-tooltip-theme="theme-dark"
                             title="{{$nextPhotoNomination->nomination->title}}"
                             class="sticker_mark main_gallery__sticker_mark color-1"
                             style="fill : {{ $nextPhotoNomination->nomination->color }} !important; color: white !important;"
                        >
                            <svg class="sticker_mark__bg">
                                <use xlink:href="/img/sprite.svg#sticker_mark"></use>
                            </svg>
                            <svg class="sticker_mark__lightning">
                                <use xlink:href="/img/sprite.svg#lightning"></use>
                            </svg>
                        </div>
                    @endforeach


                    <div class="main_gallery__info">
                        <div class="main_gallery__user">
                            <img src="{{ $nextPhotosOfCompilation->avatar_media_image_url }}" alt="">
                            <p class="main_gallery__user-name"><a
                                    href="photographer_page.html">{{  $nextPhotosOfCompilation->photo->id  }}->{{ $nextPhotosOfCompilation->photo->owner['name'] ?? '' }}</a>
                            </p>
                        </div>

                        @if($nextPhotosOfCompilation->photo_likes_count > 0)
                            <div class="main_gallery__likes">
                                <svg class="icon icon-like">
                                    <use xlink:href="/img/icons.svg#like"/>
                                </svg>
                                <span> {{ $nextPhotosOfCompilation->photo_likes_count }}</span>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        @endif
    @endforeach

</div>
