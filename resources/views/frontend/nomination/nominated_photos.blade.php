@if(!empty($nominatedPhotos))
    <div class="main_gallery__blocks">
        @foreach($nominatedPhotos as $nextNominatedPhoto)
            <div class="main_gallery__block">
                <div class="main_gallery__content">

                    <a href="{{ route('one_photo', [
                                 $nextNominatedPhoto['photo']['slug'] . '.' . $nextNominatedPhoto['photo']['id'],
                                 'nomination.' . $nomination_id ] )
                                  }}"
                       class="main_gallery__link"></a>

                    <img src="{{ $nextNominatedPhoto->media_image_url }}" class="main_gallery__image"  alt="">
                    <div data-tooltip data-tooltip-theme="theme-dark"
                         title="{{ $nextNominatedPhoto->photo->name }}"
                         class="sticker_mark main_gallery__sticker_mark color-1"
                         style="fill : {{ $nextNominatedPhoto->nomination['color'] }} !important; color: white !important;"

                    >
                        <svg class="sticker_mark__bg">
                            <use xlink:href="/img/sprite.svg#sticker_mark"></use>
                        </svg>
                        <svg class="sticker_mark__lightning">
                            <use xlink:href="/img/sprite.svg#lightning"></use>
                        </svg>
                    </div>



                    <div class="main_gallery__info">

                        @if($nextNominatedPhoto->avatar_media_image_url)
                            <div class="main_gallery__user">
                                <img src="{{ $nextNominatedPhoto->avatar_media_image_url }}" alt="{{ $nextNominatedPhoto['photo']['owner']['name'] }}">
                                <p class="main_gallery__user-name">
                                    <a href="">{{ $nextNominatedPhoto['photo']['id'] }}=>{{ $nextNominatedPhoto['photo']['owner']['name'] ?? ''}}</a>
                                </p>
                            </div>
                        @endif

                        @if($nextNominatedPhoto->photo_likes_count > 0)
                            <div class="main_gallery__likes">
                                <svg class="icon icon-like">
                                    <use xlink:href="/img/icons.svg#like" />
                                </svg>
                                <span>{{ $nextNominatedPhoto->photo_likes_count }}</span>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
