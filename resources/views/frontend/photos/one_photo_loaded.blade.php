<div class="photo_page__wrap">

    <div class="photo_page__head">

        <x-frontend.user-avatar-catalog :user="$photo->owner" :source="'one_photo'"/>

        <a href="nomination.html" class="photo_page__back">
            <i>
                <svg class="icon icon-arrow-nav">
                    <use xlink:href="/img/icons.svg#arrow-nav"></use>
                </svg>
            </i><span>Номинации</span>
        </a>
    </div>

    {{--    $photo_source::{{ $photo_source }}<br>--}}
    {{--    prior_photo_id::{{ $prior_photo_id }}<br>--}}
    {{--    $photo->id::{{ $photo->id }}<br>--}}
    {{--    next_photo_id::{{ $next_photo_id }}<br>--}}

    <div class="photo_page__block">
        <div class="photo_page__slider slick-initialized slick-slider">

            @if(!empty($prior_photo_id))
                <button class="slick-prev slick-arrow" aria-label="Previous" type="button" onclick="openPreviousImage( {{ $prior_photo_id }}, '{{ $photo_source }}' )">
                    Previous +
                </button>
            @endif

            <div class="slick-list draggable">
                <div class="slick-track"
                     style="opacity: 1;">

                    @if( !empty($photo->media_image_url) )

                        {{--
                                                @foreach( $homepagePhoto->photoNominations as $nextPhotoNomination )
                                                    <div class="visual_screen__mark" style="fill : {{ $nextPhotoNomination->nomination->color }} !important; color: white !important;" title="{{$nextPhotoNomination->nomination->title}}">
                                                        <svg width="7" height="17" style="fill : {{ $nextPhotoNomination->nomination->color }} !important; color: white !important;">
                                                            <use xlink:href="img/sprite.svg#lightning"></use>
                                                        </svg>
                                                    </div>
                                                @endforeach
                        --}}


                        <div class="photo_page__slide slick-slide slick-cloned" data-slick-index="-1" id=""
                             aria-hidden="true" tabindex="-1" >
                            <img src="{{ $photo->media_image_url }}" alt="{{ $photo->name }}">

                            @foreach($photo->photoNominations as $nextPhotoNomination)
                                <div data-tooltip="" data-tooltip-theme="theme-dark"
                                     class="sticker_mark photo_page__mark color-13 tooltipstered">
                                    <svg class="sticker_mark__bg" style="fill : {{ $nextPhotoNomination['nomination']['color'] }} !important; color: white !important;">
                                        <use xlink:href="/img/sprite.svg#sticker_mark"></use>
                                    </svg>
                                    <svg class="sticker_mark__lightning">
                                        <use xlink:href="/img/sprite.svg#lightning"></use>
                                    </svg>
                                </div>
                            @endforeach

                        </div>
                    @endif

                    @if( !empty($photo->media_image_url) )
                        <div class="photo_page__slide slick-slide slick-current slick-active"
                             data-slick-index="0" aria-hidden="false" tabindex="0" >
                            <img src="{{ $photo->media_image_url }}" alt="{{ $photo->name }}">


                            @foreach($photo->photoNominations as $nextPhotoNomination)
                                <div data-tooltip="" data-tooltip-theme="theme-dark"
                                     class="sticker_mark photo_page__mark color-13 tooltipstered">
                                    <svg class="sticker_mark__bg" style="fill : {{ $nextPhotoNomination['nomination']['color'] }} !important; color: white !important;">
                                        <use xlink:href="/img/sprite.svg#sticker_mark"></use>
                                    </svg>
                                    <svg class="sticker_mark__lightning">
                                        <use xlink:href="/img/sprite.svg#lightning"></use>
                                    </svg>
                                </div>
                            @endforeach


                        </div>
                    @endif

                    @if( !empty($photo->media_image_url) )
                        <div class="photo_page__slide slick-slide" data-slick-index="1" aria-hidden="true"
                             tabindex="-1" >
                            <img src="{{ $photo->media_image_url }}" alt="{{ $photo->name }}">


                            @foreach($photo->photoNominations as $nextPhotoNomination)
                                <div data-tooltip="" data-tooltip-theme="theme-dark"
                                     class="sticker_mark photo_page__mark color-13 tooltipstered">
                                    <svg class="sticker_mark__bg" style="fill : {{ $nextPhotoNomination['nomination']['color'] }} !important; color: white !important;">
                                        <use xlink:href="/img/sprite.svg#sticker_mark"></use>
                                    </svg>
                                    <svg class="sticker_mark__lightning">
                                        <use xlink:href="/img/sprite.svg#lightning"></use>
                                    </svg>
                                </div>
                            @endforeach


                        </div>
                    @endif

                    @if( !empty($photo->media_image_url) )
                        <div class="photo_page__slide slick-slide slick-cloned" data-slick-index="2" id=""
                             aria-hidden="true" tabindex="-1" >
                            <img src="{{ $photo->media_image_url }}" alt="{{ $photo->name }}">


                            @foreach($photo->photoNominations as $nextPhotoNomination)
                                <div data-tooltip="" data-tooltip-theme="theme-dark"
                                     class="sticker_mark photo_page__mark color-13 tooltipstered">
                                    <svg class="sticker_mark__bg" style="fill : {{ $nextPhotoNomination['nomination']['color'] }} !important; color: white !important;">
                                        <use xlink:href="/img/sprite.svg#sticker_mark"></use>
                                    </svg>
                                    <svg class="sticker_mark__lightning">
                                        <use xlink:href="/img/sprite.svg#lightning"></use>
                                    </svg>
                                </div>
                            @endforeach


                        </div>
                    @endif

                    @if( !empty($photo->media_image_url) )
                        <div class="photo_page__slide slick-slide slick-cloned" data-slick-index="3" id=""
                             aria-hidden="true" tabindex="-1" >
                            <img src="{{ $photo->media_image_url }}" alt="{{ $photo->name }}">


                            @foreach($photo->photoNominations as $nextPhotoNomination)
                                <div data-tooltip="" data-tooltip-theme="theme-dark"
                                     class="sticker_mark photo_page__mark color-13 tooltipstered">
                                    <svg class="sticker_mark__bg" style="fill : {{ $nextPhotoNomination['nomination']['color'] }} !important; color: white !important;">
                                        <use xlink:href="/img/sprite.svg#sticker_mark"></use>
                                    </svg>
                                    <svg class="sticker_mark__lightning">
                                        <use xlink:href="/img/sprite.svg#lightning"></use>
                                    </svg>
                                </div>
                            @endforeach


                        </div>
                    @endif

                </div>
            </div>

            @if(!empty($next_photo_id))
                <button class="slick-next slick-arrow" aria-label="Next" type="button" onclick="openNextImage( {{ $next_photo_id }}, '{{ $photo_source }}' )">
                    Next -   !!!!!!!!!!!
                </button>
            @endif

        </div>
        <div class="photo_page__block-bottom">

            <x-frontend.photo-tags :id="$photo_id" :source="'one_photo'"/>

            <div class="photo_page__links">
                <a class="photo_page__links-item"  @if($logged_user_photo_favorites_count === 0) onclick="addPhotoFavorite({{ $is_user_logged ? true : false}})" @endif title="{{ $logged_user_photo_favorites_count > 0 ? 'Это фото уже в вашем избранном' : '' }}">
                    <i>
                        <svg class="icon icon-favorite">
                            <use xlink:href="/img/icons.svg#favorite"></use>
                        </svg>
                    </i>
                    <span id="span_photo_favorites_count">
                        {{ $photo->photo_favorites_count }}
                    </span>
                </a>

                <a class="photo_page__links-item" @if($logged_user_photo_likes_count === 0) onclick="addPhotoLike({{ $is_user_logged ? true : false}})" @endif title="{{ $logged_user_photo_likes_count > 0 ? 'Вы уже проголосовали за зто фото' : '' }}">
                    <i>
                        <svg class="icon icon-like">
                            <use xlink:href="/img/icons.svg#like"></use>
                        </svg>
                    </i>
                    <span id="span_photo_likes_count">
                        {{ $photo->photo_likes_count }}
                    </span>
                </a>
            </div>
        </div>
    </div>

    <div class="photo_page__box">

        <x-frontend.photo-comments :id="$photo_id" :source="'one_photo'"/>

        <div class="photo_page__characteristics">
            <div class="photo_page__characteristics-block">
                <i class="photo_page__characteristics-icon">
                    <svg width="24" height="24">
                        <use xlink:href="/img/sprite.svg#characteristics-1"></use>
                    </svg>
                </i>
                <div class="photo_page__characteristics-list">
                    <p class="photo_page__characteristics-item"><a href="#">Sony Alpha a9</a></p>
                </div>
            </div>
            <div class="photo_page__characteristics-block">
                <i class="photo_page__characteristics-icon">
                    <svg width="25" height="25">
                        <use xlink:href="/img/sprite.svg#characteristics-2"></use>
                    </svg>
                </i>
                <div class="photo_page__characteristics-list">
                    <p class="photo_page__characteristics-item">Distagon T* FE 35mm f/1.4 ZA</p>
                </div>
            </div>
            <div class="photo_page__characteristics-block">
                <i class="photo_page__characteristics-icon">
                    <svg width="23" height="23">
                        <use xlink:href="/img/sprite.svg#characteristics-3"></use>
                    </svg>
                </i>
                <div class="photo_page__characteristics-list">
                    <p class="photo_page__characteristics-item">f/1.4</p>
                    <p class="photo_page__characteristics-item">35 mm</p>
                </div>
            </div>
            <div class="photo_page__characteristics-block">
                <i class="photo_page__characteristics-icon">
                    <svg width="18" height="21">
                        <use xlink:href="/img/sprite.svg#characteristics-4"></use>
                    </svg>
                </i>
                <div class="photo_page__characteristics-list">
                    <p class="photo_page__characteristics-item">1/320s</p>
                </div>
            </div>
            <div class="photo_page__characteristics-block">
                <i class="photo_page__characteristics-icon">
                    <svg width="26" height="20">
                        <use xlink:href="/img/sprite.svg#characteristics-5"></use>
                    </svg>
                </i>
                <div class="photo_page__characteristics-list">
                    <p class="photo_page__characteristics-item">100</p>
                </div>
            </div>
        </div>
    </div>
</div>


