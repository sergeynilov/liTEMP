<div class="collections">
    <div class="container">
        <p class="main_gallery__title">
            Подборки
        </p>

        @if( count($compilations) > 0)
            <div class="nomination-new__subtitle">Лучшие фотографии в разных подборках</div>
            <div class="collections__wrap">

                @foreach($compilations as $nextCompilation)

                    @if(!empty($nextCompilation['compilation_media_image_url']) and !empty($nextCompilation['total_photos_count']))

                        <a href="{{ route('frontend_compilation_with_photos', $nextCompilation['slug'].'.'.$nextCompilation['id'])}}" class="collections__item">
                            <div class="collections__img">
                                <img src="{{ $nextCompilation['compilation_media_image_url'] }}" alt="">
                            </div>
                            <div class="collections__descr">
                                <div
                                    class="collections__name">{{ $nextCompilation['id'] . '->'.$nextCompilation['title'] }}</div>
                                <div class="collections__foto">{{ $nextCompilation['total_photos_count'] }} фото</div>
                            </div>
                        </a>
                    @endif

                @endforeach

            </div>
        @endif

    </div>
</div>
