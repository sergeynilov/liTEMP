@foreach($activeNominations as $nextActiveNomination)
    @if( !empty($nextActiveNomination->title) )

        <div class="main_gallery__content" style="border: 0px dotted red !important;">
            <a href="{{ route('frontend_nomination', $nextActiveNomination->slug.'.'.$nextActiveNomination->id)  }}" class="main_gallery__link"></a>

            @if(!empty($nextActiveNomination->nomination_media_image_url))
                <img src="{{ $nextActiveNomination->nomination_media_image_url }}" alt="">
            @else
                <img src="/img/default-nomination.jpg" alt="">
            @endif
            <div title="{{ $nextActiveNomination->title }}" data-tooltip-theme="theme-dark"
                 class="sticker_mark main_gallery__sticker_mark"
                 style="fill : {{ $nextActiveNomination->color }} !important; color: white !important;"
            >

                <svg class="sticker_mark__bg" >
                    <use xlink:href="img/sprite.svg#sticker_mark"></use>
                </svg>
                <svg class="sticker_mark__lightning">
                    <use xlink:href="img/sprite.svg#lightning"></use>
                </svg>

            </div>
            <div class="main_gallery__info">
                <div class="main_gallery__user">
                    <p class="main_gallery__user-name">{{ $nextActiveNomination->id }}::{{ $nextActiveNomination->title }}</p>
                </div>
            </div>
        </div>

    @endif
@endforeach

