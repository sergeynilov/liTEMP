<div>
    @if(count($homeNominations) > 0)

        <div class="main_gallery main_gallery--home">
            <div class="container main_gallery__container">
                <div class="main_gallery__wrap">
                    <div class="main_gallery__head">
                        <p class="main_gallery__title">Номинации</p>
                    </div>
                    <div class="main_gallery__blocks">
                        @foreach($homeNominations as $nextHomeNomination)
                            <div class="main_gallery__block">
                                <div class="main_gallery__content">
                                    <a href="{{ route('frontend_nomination', $nextHomeNomination->slug . '.'. $nextHomeNomination->id) }}" class="main_gallery__link"></a>
                                    @if(!empty($nextHomeNomination->nomination_media_image_url))
                                        <img src="{{$nextHomeNomination->nomination_media_image_url}}" class="main_gallery__img-home" alt="">
                                    @else
                                        <img src="img/default-nomination.jpg" class="main_gallery__img-home" alt="">
                                    @endif
                                    <p class="main_gallery__description">{{$nextHomeNomination->id}}::{{$nextHomeNomination->title}}</p>
                                    <div data-tooltip="" data-tooltip-theme="theme-dark" title="{{$nextHomeNomination->title}}"
                                         class="sticker_mark main_gallery__sticker_mark"
                                         style="fill : {{ $nextHomeNomination->color }} !important; color: white !important;"
                                    >
                                        <svg class="sticker_mark__bg">
                                            <use xlink:href="img/sprite.svg#sticker_mark"></use>
                                        </svg>
                                        <svg class="sticker_mark__lightning">
                                            <use xlink:href="img/sprite.svg#lightning"></use>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <a href="{{ route('frontend_nominations_list') }}" class="main_gallery__more btn">
                        <span>Смотреть все номинации</span>
                    </a>
                </div>
            </div>
        </div>

    @endif
</div>
