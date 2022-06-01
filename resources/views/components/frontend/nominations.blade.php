<div>

    @if( count($nominations) > 0 )
        <div class="nomination-new">
            <div class="container">

                <p class="main_gallery__title">Номинации</p>
                <div class="nomination-new__subtitle">Лучшие фотографии в разных категориях</div>
                <div class="nomination-new__wrap" id="div_nominations_rows_container"></div>

                <div id="div_show_more_photos">
                    <a onclick="javascript:loadNominationsMoreRows(true)" class="nomination-new__btn-more" style="cursor: pointer;">
                        <svg class="nomination-new__arr-down">
                            <use xlink:href="img/sprite.svg#arr-down"></use>
                        </svg>
                        Ещё номинации
                    </a>
                </div>

            </div>
        </div>
    @endif

</div>


<script>
    var current_page = 1
    jQuery(document).ready(function () {
        loadNominationsMoreRows(false)

    });

    function loadNominationsMoreRows(load_next_page) {
        console.log('loadNominationsMoreRows load_next_page::')
        console.log(load_next_page)
        if (load_next_page) {
            current_page++
        }

        console.log('loadNominationsMoreRows current_page::')
        console.log(current_page)

        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/get_nominations_more_rows/' + current_page,

            success: function (response) {
                console.log('loadNominationsMoreRows response::')
                console.log(response)

                if (current_page === 1) {
                    $("#div_nominations_rows_container").html(response.html);
                }
                // $('#photo_photo_details_modal').modal('show');
                if (current_page > 1) {
                    // $("#div_nominations_rows_container").html(response.html);
                    $(".main_gallery__content:last").after(response.html);//.show().fadeIn("slow");
                    // $(".post:last").after(response).show().fadeIn("slow");
                }

                console.log('response.active_nominations_total_count::')
                console.log(response.active_nominations_total_count)


                console.log('response.rows_uploaded_count::')
                console.log(response.rows_uploaded_count)

                if (response.rows_uploaded_count >= response.active_nominations_total_count) {
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

    }

</script>
