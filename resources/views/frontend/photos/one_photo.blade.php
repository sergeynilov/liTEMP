@extends('layouts.frontend')


@section('content')

    <div class="photo_page">
        <div class="container" id="div_one_photo_container"></div>
    </div>

@endsection

@section('scripts')
<script>

    var logged_user_photo_likes_count = {{ $logged_user_photo_likes_count ?? 0}}
    // console.log('resources/views/frontend/photos/one_photo.blade.php::')
    jQuery(document).ready(function () {
        @if(!empty($photo->id))
           loadOnePhoto({{ $photo->id }}, '{{ $source }}' )
        @endif
    });

    function openPreviousImage( prior_photo_id, photo_source ) {
        // console.log('openPreviousImage() prior_photo_id::')
        // console.log(prior_photo_id)
        loadOnePhoto(prior_photo_id, photo_source  )
    }

    function openNextImage( next_photo_id, photo_source ) {
        // console.log('openNextImage() next_photo_id::')
        // console.log(next_photo_id)
        loadOnePhoto(next_photo_id, photo_source  )
    }

    function addPhotoFavorite(is_user_logged) {
        // console.log('addPhotoFavorite is_user_logged::')
        // console.log(is_user_logged)
        if (!is_user_logged) return;

        $.ajax({
            type: "POST",
            dataType: "json",
            url: '/add_photo_favorite',
            data: {"photo_id": {{ $photo->id }}, "_token": $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                $("#span_photo_favorites_count").html(response.photo_favorites_count);
            },
            error: function (error) {
                console.error(error)
            }
        });

    } // function addPhotoFavorite() {

    function addPhotoLike(is_user_logged) {
        // console.log('addPhotoLike is_user_logged::')
        // console.log(is_user_logged)
        if (!is_user_logged) return;

        $.ajax({
            type: "POST",
            dataType: "json",
            url: '/add_photo_like',
            data: {"photo_id": {{ $photo->id }}, "_token": $('meta[name="csrf-token"]').attr('content')},
            success: function (response) {
                $("#span_photo_likes_count").html(response.photo_likes_count);
            },
            error: function (error) {
                console.error(error)
            }
        });

    } // function addPhotoLike() {

    function loadOnePhoto( photo_id, photo_source ) {
        // console.log('loadOnePhoto photo_id::')
        // console.log(photo_id)
        //
        // console.log('loadOnePhoto photo_source::')
        // console.log(photo_source)

        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/load_one_photo/'+photo_id+'/'+photo_source,
            success: function (response) {
                // console.log('loadNominationPhotoCovers response::')
                // console.log(response)
                $("#div_one_photo_container").html(response.html);

            },
            error: function (error) {
                console.error(error)
            }
        });

    } // function loadOnePhoto( photo_id, photo_source ) {

</script>
@endsection
