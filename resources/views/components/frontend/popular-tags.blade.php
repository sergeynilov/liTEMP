<div>

    @if( count($popularTags) > 0 )
    <p class="footer__block-title">Популярные теги:</p>
    <div class="footer__tags">
        @foreach($popularTags as $nextPopularTag)
            <a href="#" class="footer__tags-link">
                #{{ $nextPopularTag['tag']['title'] }}
            </a>
        @endforeach
    </div>
    @endif

</div>
