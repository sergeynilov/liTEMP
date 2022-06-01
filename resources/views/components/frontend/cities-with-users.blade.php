<div>

    @if( count($popularCities) > 0 )
    <p class="footer__block-title">Найди фотографа в своём городе:</p>
    <div class="footer__cities">
        @foreach($popularCities as $nextPopularCity)
        <a href="#" class="footer__cities-link">{{ $nextPopularCity['city']['city'] }}</a>
        @endforeach
   </div>
   @endif

</div>
