<div>
    <div class="main_gallery style-nominations">
        <div class="container main_gallery__container">
            <div class="main_gallery__wrap">


                <div class="main_gallery__head">
                    <p class="main_gallery__title">Номинация</p>

                    <div class="head__dropdown main_gallery__dropdown">


                        @if(!empty($currentNomination))
                            <button class="head__dropdown-btn main_gallery__dropdown-btn">
                                <span>{{ /*$currentNomination->id.'=>'.*/$currentNomination->title }}</span>
                                <div data-tooltip="" data-tooltip-theme="theme-dark"
                                     title="{{ /* $currentNomination->id.'=>'.$currentNomination->color.'=>'.*/ $currentNomination->title }}"
                                     class="sticker_mark"
                                     style="fill : {{ $currentNomination->color }} !important; color: white !important;"
                                >
                                    <svg class="sticker_mark__bg">
                                        <use xlink:href="/img/sprite.svg#sticker_mark"></use>
                                    </svg>
                                    <svg class="sticker_mark__lightning">
                                        <use xlink:href="/img/sprite.svg#lightning"></use>
                                    </svg>
                                </div>
                            </button>
                        @endif

                        <div class="head__dropdown-menu main_gallery__dropdown-menu">
                            <div class="main_gallery__tags">
                                <div class="main_gallery__tags-item"
                                     onclick="redirectToNomination( -1, 'все' )">
                                >
                                    <input type="checkbox" name="main_gallery__tags">
                                    <p>Все</p>
                                </div>

                                @foreach($nominations as $nextNomination)
                                    <div class="main_gallery__tags-item"
                                         onclick="redirectToNomination( {{ $nextNomination->id }}, '{{ $nextNomination->slug }}' )"
                                    >
                                        <input type="checkbox" name="main_gallery__tags">
                                        <p>{{ /*$nextNomination->id.'=>'. */$nextNomination->title }}</p>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>


                @if(!empty($nominatedPhotos))
                    <div class="main_gallery__blocks">
                        @foreach($nominatedPhotos as $nextNominatedPhoto)
                            <div class="main_gallery__block">
                                <div class="main_gallery__content">

                                    <a href="{{ route('one_photo', [
                                 $nextNominatedPhoto['photo']['slug'] . '.' . $nextNominatedPhoto['photo']['id'],
                                 'nomination.' .  $currentNomination->id  ] )
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

                <div class="forum-article__comments-pagination pagination" >
                    {{ $nominatedPhotosPagination->links() }}
                </div>
        </div>

    </div>
</div>

<script>

    function redirectToNomination(nomination_id, nomination_slug) {
        console.log('redirectToNomination nomination_id::')
        console.log(nomination_id)
        console.log('redirectToNomination nomination_slug::')
        console.log(nomination_slug)
        window.location.href = "/nomination/" + nomination_slug + "." + nomination_id;
    }

    var current_page = 1
    jQuery(document).ready(function () {
    });


</script>
