<div>

    <div>
        <div class="main_gallery style-nominations">
            <div class="container main_gallery__container">
                <div class="main_gallery__wrap">

                    <div class="main_gallery__head">
                        <p class="main_gallery__title">Свежие фото</p>
                    </div>

                    <div id="div_photos_without_nominations_container" class="photos-without-nomination-images-container">
                    </div>


                    <div style="margin: 10px !important; " id="div_show_more_photos">
                        <a onclick="javascript:loadPhotosWithoutNominations(true)" class="nomination-new__btn-more"
                           style="cursor: pointer;">
                            <svg class="nomination-new__arr-down">
                                <use xlink:href="/img/sprite.svg#arr-down"></use>
                            </svg>
                            Ещё фото
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <script>
        var current_page = 1
        jQuery(document).ready(function () {
            loadPhotosWithoutNominations(false)
        });

        function loadPhotosWithoutNominations(load_next_page) {
            console.log('loadPhotosWithoutNominations load_next_page::')
            console.log(load_next_page)
            if (load_next_page) {
                current_page++
            }

            console.log('loadPhotosWithoutNominations current_page::')
            console.log(current_page)

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/get_photos_without_nominations/' + current_page,

                success: function (response) {
                    console.log('loadPhotosWithoutNominations response::')
                    console.log(response)

                    if (current_page === 1) {
                        $("#div_photos_without_nominations_container").html(response.html);
                    }
                    // $('#photo_photo_details_modal').modal('show');
                    if (current_page > 1) {
                        // $("#div_photos_without_nominations_container").html(response.html);
                        $(".main_gallery__block:last").after(response.html);//.show().fadeIn("slow");
                        // $(".post:last").after(response).show().fadeIn("slow");
                    }

                    console.log('response.photos_without_nominations_total_count::')
                    console.log(response.photos_without_nominations_total_count)


                    console.log('response.rows_uploaded_count::')
                    console.log(response.rows_uploaded_count)
                    if (response.rows_uploaded_count >= response.photos_without_nominations_total_count) {
                        $("#div_show_more_photos").css('display', 'none');
                    } else {

                        $("#div_show_more_photos").css('display', 'block');
                        //  $($(".para")[1]).css({"color":"yellow"});
                        $("#div_show_more_photos").css('margin-top', '10px !important;'); //padding-top: 10px !important;
                    }

                },
                error: function (error) {
                    console.error(error)
                }
            });

        } // function loadPhotosWithoutNominations(load_next_page) {

    </script>

</div>
