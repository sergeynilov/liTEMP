<div class="main_gallery style-nominations">
    <div class="container main_gallery__container">
        <div class="main_gallery__wrap">

            <div class="main_gallery__head">
                <p class="main_gallery__title"> {{ $defaultCompilation->title ?? '' }}</p>
            </div>

            <div id="div_compilation_with_photos_container" class="compilations-grid-images-container">
            </div>

        </div>

        <div id="div_show_more_photos">
            <a onclick="javascript:loadPhotosOfCompilation(true)" class="nomination-new__btn-more"
               style="cursor: pointer">
                <svg class="nomination-new__arr-down">
                    <use xlink:href="/img/sprite.svg#arr-down"></use>
                </svg>
                Ещё фото
            </a>
        </div>
    </div>
</div>  <!-- main_gallery style-nominations-->

<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

<script>
    var current_page = 1
    jQuery(document).ready(function () {
        loadPhotosOfCompilation(false)

    });

    function loadPhotosOfCompilation(load_next_page) {
        console.log('loadPhotosOfCompilation load_next_page::')
        console.log(load_next_page)
        if (load_next_page) {
            current_page++
        }

        var current_compilation_id = {{ $defaultCompilation->id ?? '' }}
        // console.log('current_compilation_id::')
        // console.log(current_compilation_id)

        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/get_compilation_with_photos_rows/' + current_compilation_id + "/" + current_page,
            success: function (response) {
                // console.log('loadPhotosOfCompilation response::')
                // console.log(response)

                if (current_page === 1) {
                    $("#div_compilation_with_photos_container").html(response.html);
                }
                if (current_page > 1) {
                    $(".main_gallery__block:last").after(response.html);
                }

/*
                console.log('response.compilation_with_photos_total_count::')
                console.log(response.compilation_with_photos_total_count)
                console.log('response.rows_uploaded_count::')
                console.log(response.rows_uploaded_count)
*/

                if (response.rows_uploaded_count >= response.compilation_with_photos_total_count) {
                    $("#div_show_more_photos").css('display', 'none');
                } else {

                    $("#div_show_more_photos").css('display', 'block');
                    $("#div_show_more_photos").css('margin-top', '10px !important;'); //padding-top: 10px !important;
                }

            },
            error: function (error) {
                console.error(error)
            }
        });

    } // function loadPhotosOfCompilation(load_next_page) {


</script>
