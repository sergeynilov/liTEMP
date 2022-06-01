<div class="visual_screen" style="background: #282828 url('{{ $homepagePhoto->homepage_media_image_url ?? '' }}') center center no-repeat; background-size: cover;">
    <div class="container">
        <div class="visual_screen__wrap">

            @if(!empty($homepagePhoto->photoNominations))
            @foreach( $homepagePhoto->photoNominations as $nextPhotoNomination )
            <div class="visual_screen__mark" style="fill : {{ $nextPhotoNomination->nomination->color }} !important; color: white !important;" title="{{$nextPhotoNomination->nomination->title}}">
                <svg width="7" height="17" style="fill : {{ $nextPhotoNomination->nomination->color }} !important; color: white !important;">
                    <use xlink:href="img/sprite.svg#lightning"></use>
                </svg>
            </div>
            @endforeach
            @endif

            <p class="visual_screen__title">{{ $homepagePhoto->name ?? ''}}</p>
        </div>
    </div>
</div>

