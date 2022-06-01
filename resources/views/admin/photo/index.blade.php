@extends('layouts.backend')

@section('css_before')
    <link rel="stylesheet" href="/js/plugins/flatpickr/flatpickr.css">
    <!-- Page JS Plugins CSS -->
@endsection

@section('js_after')

    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="/js/moment.min.js"></script>
    <script src="/js/plugins/flatpickr/flatpickr.js"></script>
    <script src="/js/plugins/flatpickr/l10n/ru.js"></script>

    <script>
        var current_modal_photo_id= null
        var optional_config = {
            dateFormat: "Y-m-d",
            altFormat: "F j, Y",
            altInput : true,
            allowInput: false,
            "locale": 'ru',
            enableTime: false,
            time_24hr: true
        }

        $("#filter_date_from").flatpickr(optional_config);
        $("#filter_date_till").flatpickr(optional_config);

        // showGetPhotoDetailsModal( 6, 'Фотография nemo'); // debugging
        //        showGetPhotoDetailsModal( 2, 'Фотография at') //  DEBUGGING

        function assignNominationToPhoto( nomination_id ) {
            console.log('assignNominationToPhoto current_modal_photo_id::')
            console.log(current_modal_photo_id)
            console.log('assignNominationToPhoto nomination_id::')
            console.log(nomination_id)


            Swal.fire({
                title: "{{ __('Вы хотите прикрепить номинацию к выбранной фотографии') }} ?",
                text: "{{ __('Прикрепленная номинация будет отображаться для выбранной фотографии') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('Да, прикрепить') }} !"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '/admin/photos/assign_to_nomination',
                        data: {"photo_id": current_modal_photo_id, "nomination_id": nomination_id, "_token": $('meta[name="csrf-token"]').attr('content')},
                        success: function (response) {
                            Swal.fire({
                                title: '{{ __('Номинации фотографии') }} !',
                                text: '{{ __('Номинация успешно приклеплена к фотографии') }} !',
                                icon: 'success',
                            })

                            $("#btn_assign_nomination_to_photo_" + nomination_id + '_label' ).css('display', 'none');
                            $("#btn_assign_nomination_to_photo_" + nomination_id).css('display', 'none');
                            $("#btn_revoke_nomination_to_photo_" + nomination_id + '_label' ).removeAttr('display');
                            $("#btn_revoke_nomination_to_photo_" + nomination_id).removeAttr('style');

                            // alert( '-1:' + $("#btn_assign_nomination_to_photo_" + nomination_id).css('display')  )
                            // alert( '-2:' + $("#btn_revoke_nomination_to_photo_" + nomination_id).css('display') )

                        },
                        error: function (error) {
                            console.error(error)
                            Swal.fire({
                                title: '{{ __('Ошибка приклепления к фотографии') }} !',
                                text: getErrorMessage(error),
                                type: 'danger',
                                icon: 'warning',
                            })
                        }
                    });
                }

            });
        } // function assignNominationToPhoto( nomination_id ) {

        function revokeNominationFromPhoto( nomination_id ) {
            console.log('revokeNominationFromPhoto current_modal_photo_id::')
            console.log(current_modal_photo_id)
            // console.log('revokeNominationFromPhoto nomination_id::')
            // console.log(nomination_id)


            Swal.fire({
                title: "{{ __('Вы хотите открепить номинацию от выбранной фотографии') }} ?",
                text: "{{ __('Открепленая номинация не будет отображаться для выбранной фотографии') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('Да, открепить') }} !"
            }).then(function (result) {
                if (result.value) {

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '/admin/photos/revoke_from_nomination',
                        data: {"photo_id": current_modal_photo_id, "nomination_id": nomination_id, "_token": $('meta[name="csrf-token"]').attr('content')},
                        success: function (response) {
                            Swal.fire({
                                title: '{{ __('Номинации фотографии') }} !',
                                text: '{{ __('Номинация успешно откреплена от фотографии') }} !',
                                icon: 'success',
                            })

                            $("#btn_assign_nomination_to_photo_" + nomination_id + '_label' ).css('display', 'inline');
                            $("#btn_assign_nomination_to_photo_" + nomination_id).css('display', 'inline');
                            $("#btn_revoke_nomination_to_photo_" + nomination_id + '_label' ).css('display', 'none');
                            $("#btn_revoke_nomination_to_photo_" + nomination_id).css('display', 'none');

                        },
                        error: function (error) {
                            console.error(error)
                            Swal.fire({
                                title: '{{ __('Ошибка откреплепления от фотографии') }} !',
                                text: getErrorMessage(error),
                                type: 'danger',
                                icon: 'warning',
                            })
                        }
                    });

                }

            });
        } // function revokeNominationFromPhoto( nomination_id ) {

        function showSetNominationsModal() {
            console.log('showSetNominationsModal current_modal_photo_id::')
            console.log(current_modal_photo_id)

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/admin/get_nominations_for_photo/'+current_modal_photo_id,
                success: function (response) {
                    console.log('get_nominations_for_photo response::')
                    console.log(response)

                    $("#photo_image_set_nominations_content").html(response.html);
                    $('#photo_image_set_nominations_modal').modal('show');
                },
                error: function (error) {
                    console.error(error)
                    Swal.fire({
                        title: '{{ __('Ошибка списка номинаций') }} ',
                        text: getErrorMessage(error),
                        type: 'danger',
                        icon: 'warning',
                    })
                }
            });
        } // function showSetNominationsModal() {

        function showSetCompilationsModal() {
            console.log('showSetCompilationsModal current_modal_photo_id::')
            console.log(current_modal_photo_id)

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/admin/get_compilations_for_photo/'+current_modal_photo_id,
                success: function (response) {
                    console.log('get_compilations_for_photo response::')
                    console.log(response)

                    $("#photo_image_set_compilations_content").html(response.html);
                    $('#photo_image_set_compilations_modal').modal('show');
                },
                error: function (error) {
                    console.error(error)
                    Swal.fire({
                        title: '{{ __('Ошибка списка подборок') }} ',
                        text: getErrorMessage(error),
                        type: 'danger',
                        icon: 'warning',
                    })
                }
            });
        } // function showSetCompilationsModal() {

        function showGetPhotoDetailsModal() {
            console.log('showGetDetailsModal current_modal_photo_id::')
            console.log(current_modal_photo_id)

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/admin/get_photo_details/'+current_modal_photo_id,
                success: function (response) {
                    console.log('get_photo_details response::')
                    console.log(response)


                    $("#photo_photo_details_content").html(response.html);
                    $('#photo_photo_details_modal').modal('show');
                },
                error: function (error) {
                    console.error(error)
                    Swal.fire({
                        title: '{{ __('Ошибка чтения деталей фотографии') }} ',
                        text: getErrorMessage(error),
                        type: 'danger',
                        icon: 'warning',
                    })
                }
            });
        } // function showGetDetailsModal() {

        function assignCompilationToPhoto( compilation_id ) {
            console.log('assignCompilationToPhoto current_modal_photo_id::')
            console.log(current_modal_photo_id)
            console.log('assignCompilationToPhoto compilation_id::')
            console.log(compilation_id)


            Swal.fire({
                title: "{{ __('Вы хотите прикрепить подборку к выбранной фотографии') }} ?",
                text: "{{ __('Прикрепленная подборка будет отображаться для выбранной фотографии') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('Да, прикрепить') }} !"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '/admin/photos/assign_to_compilation',
                        data: {"photo_id": current_modal_photo_id, "compilation_id": compilation_id, "_token": $('meta[name="csrf-token"]').attr('content')},
                        success: function (response) {
                            Swal.fire({
                                title: '{{ __('Подборка фотографии') }} !',
                                text: '{{ __('Подборка успешно приклеплена к фотографии') }} !',
                                icon: 'success',
                            })

                            $("#btn_assign_compilation_to_photo_" + compilation_id + '_label' ).css('display', 'none');
                            $("#btn_assign_compilation_to_photo_" + compilation_id).css('display', 'none');
                            $("#btn_revoke_compilation_to_photo_" + compilation_id + '_label' ).removeAttr('display');
                            $("#btn_revoke_compilation_to_photo_" + compilation_id).removeAttr('style');

                            // alert( '-1:' + $("#btn_assign_compilation_to_photo_" + compilation_id).css('display')  )
                            // alert( '-2:' + $("#btn_revoke_compilation_to_photo_" + compilation_id).css('display') )

                        },
                        error: function (error) {
                            console.error(error)
                            Swal.fire({
                                title: '{{ __('Ошибка приклепления к фотографии') }} !',
                                text: getErrorMessage(error),
                                type: 'danger',
                                icon: 'warning',
                            })
                        }
                    });
                }

            });

        }
        function revokeCompilationFromPhoto( compilation_id ) {
            console.log('revokeCompilationFromPhoto current_modal_photo_id::')
            console.log(current_modal_photo_id)
            console.log('revokeCompilationFromPhoto compilation_id::')
            console.log(compilation_id)


            Swal.fire({
                title: "{{ __('Вы хотите открепить подборку от выбранной фотографии') }} ?",
                text: "{{ __('Открепленая подборка не будет отображаться для выбранной фотографии') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('Да, открепить') }} !"
            }).then(function (result) {
                if (result.value) {

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '/admin/photos/revoke_from_compilation',
                        data: {"photo_id": current_modal_photo_id, "compilation_id": compilation_id, "_token": $('meta[name="csrf-token"]').attr('content')},
                        success: function (response) {
                            Swal.fire({
                                title: '{{ __('Подборка фотографии') }} !',
                                text: '{{ __('Подборка успешно откреплена от фотографии') }} !',
                                icon: 'success',
                            })

                            $("#btn_assign_compilation_to_photo_" + compilation_id + '_label' ).css('display', 'inline');
                            $("#btn_assign_compilation_to_photo_" + compilation_id).css('display', 'inline');
                            $("#btn_revoke_compilation_to_photo_" + compilation_id + '_label' ).css('display', 'none');
                            $("#btn_revoke_compilation_to_photo_" + compilation_id).css('display', 'none');

                        },
                        error: function (error) {
                            console.error(error)
                            Swal.fire({
                                title: '{{ __('Ошибка откреплепления от фотографии') }} !',
                                text: getErrorMessage(error),
                                type: 'danger',
                                icon: 'warning',
                            })
                        }
                    });

                }

            });
        }

        function submitFilter() {
            var theForm = $("#form_photos_filter");
            theForm.submit();
        }

        function showImageModal(photo_id, image_url, photo_name) {
            console.log('showImageModal photo_id::')
            console.log(photo_id)
            current_modal_photo_id= photo_id
            $("#photo_image_modal_img").attr("src", image_url);
            $("#photo_image_modal_name").html(photo_name);
            $('#photo_image_modal').modal('show');
        }

    </script>


@endsection

@section('content')


    <!-- Page Content -->
    <div class="content">
        <!-- Toggle Side Content -->
        <!-- Class Toggle, functionality initialized in Helpers.oneToggleClass() -->
        <div class="d-xl-none push">
            <div class="row g-sm">
                <div class="col-6">
                    <button type="button" class="btn btn-alt-secondary w-100" data-toggle="class-toggle"
                            data-target=".js-ecom-div-filters" data-class="d-none">
                        <i class="fa fa-fw fa-filter text-muted me-1"></i> Filters
                    </button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-alt-secondary w-100" data-toggle="class-toggle"
                            data-target=".js-ecom-div-cart" data-class="d-none">
                        <i class="fa fa-fw fa-shopping-cart text-muted me-1"></i> Cart (3)
                    </button>
                </div>
            </div>
        </div>
        <!-- END Toggle Side Content -->

        {{--        $new_photos::{{ $new_photos }}--}}
        <form action="{{ route(  ($new_photos ? 'new_' : '') . 'photos_filter' ) }}" method="POST" enctype="multipart/form-data"
              id="form_photos_filter">
            @csrf
            <div class="row push">
                <div class="col-xl-4 order-xl-1">

                    <input type="hidden" id="new_photos" name="new_photos" value="{{$new_photos}}">
                    <!-- Filters -->

                    <div class="block block-rounded js-ecom-div-filters d-none d-xl-block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                <i class="fa fa-fw fa-tools text-muted me-1"></i>{{ __('Фильтровать данные') }}
                            </h3>
                        </div>
                        <div class="block-content">
                            <div class="mb-4">
                                <select class="form-select" id="filter_owner_id"
                                        name="filter_owner_id" size="1"
                                        onchange="submitFilter()"
                                >
                                    <option value=""> -{{ __('Выберите автора') }}-</option>
                                    @foreach($usersArray as $next_user_id => $next_user_name)
                                        <option value="{{$next_user_id}}"
                                                @if((int)$filter_owner_id === (int)$next_user_id) selected @endif>{{$next_user_name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if(!$new_photos)
                                <div class="mb-4">
                                    <select id="filter_nomination_id" name="filter_nomination_id"
                                            class="form-select" size="1"
                                            onchange="submitFilter()">
                                        <option value="" disabled selected> -{{ __('Выберите номинацию') }}- </option>
                                        @foreach($nominations as $nextNomination)
                                            <option  @if((int)$filter_nomination_id === (int)$nextNomination['id']) selected @endif value="{{$nextNomination['id']}}">{{$nextNomination['id']}}->{{$nextNomination['title']}} ({{ $nextNomination['photo_nominations_count'] }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                            @if(!$new_photos)
                                <div class="mb-4">
                                    <select id="filter_compilation_id" name="filter_compilation_id"
                                            class="form-select" size="1"
                                            onchange="submitFilter()">
                                        <option value="" disabled selected> -{{ __('Выберите подборку') }}- </option>
                                        @foreach($compilations as $nextCompilation)
                                            <option  @if((int)$filter_compilation_id === (int)$nextCompilation['id']) selected @endif value="{{$nextCompilation['id']}}">{{$nextCompilation['id']}}->{{$nextCompilation['title']}} ({{ $nextCompilation['photo_compilations_count'] }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                        </div>
                    </div>

                    <!-- Dates Filters -->
                    <div class="block block-rounded js-ecom-div-filters d-none d-xl-block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                <i class="fa fa-fw fa-coins text-muted me-1"></i> {{ __('Дата публикации') }}
                            </h3>
                        </div>
                        <div class="block-content block-content-full space-y-2">

                            <div class="form-check">
                                <label class="form-label" for="filter_date_from">{{ __('С') }}</label>

                                <input type="text" class="js-flatpickr form-control"
                                       id="filter_date_from" name="filter_date_from"
                                       onchange="submitFilter()"
                                       value="{{ $filter_date_from }}"
                                       placeholder="{{ __('Выберите начальную дату') }}"
                                       autocomplete="off"
                                >
                            </div>
                            <div class="form-check">
                                <label class="form-label" for="filter_date_till">{{ __('До') }}</label>
                                <input type="text" class="js-flatpickr form-control"
                                       id="filter_date_till" name="filter_date_till"
                                       onchange="submitFilter()"
                                       value="{{ $filter_date_till }}"
                                       placeholder="{{ __('Выберите конечную дату') }}"
                                       autocomplete="off"
                                >
                            </div>
                        </div>
                    </div>
                    <!-- END Dates Filters -->

                    <!-- Tags Filters -->
                    <div class="block block-rounded js-ecom-div-filters d-none d-xl-block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">
                                <i class="fa fa-fw fa-boxes text-muted me-1"></i> {{ __('Теги') }}
                            </h3>
                        </div>
                        <div class="block-content">
                            <div class="mb-4">
                                @foreach($tags as $nextTag)
                                    @if($nextTag['photo_tags_count'] > 0)
                                        <div class="form-check">
                                            <input class="form-check-input"
                                                   type="checkbox"
                                                   value="{{ $nextTag['id'] }}"
                                                   id="filter_tag_{{ $nextTag['id'] }}"
                                                   onchange="submitFilter()"
                                                   name="filter_tag_{{ $nextTag['id'] }}"
                                                   @if(in_array($nextTag['id'], $filterTags)) checked @endif
                                            >
                                            <label class="form-check-label" for="filter_tag_{{ $nextTag['id'] }}">
                                                {{--                                                {{ $nextTag['id'] }}::--}}
                                                {{ $nextTag['title'] }}
                                                ({{ $nextTag['photo_tags_count'] }})
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- END Tags Filters -->


                </div>


                @if( (count($photos)) == 0 )
                    <div class="col-xl-8 order-xl-0">
                        <div class="alert alert-warning m-2" role="alert">
                            <h4 class="text-center p-1">
                                {{ __('Фотографий не найдено') }}
                            </h4>
                            <p class="fw-medium fs-sm text-center mb-0">
                                {{ __('Измените критерий поиска') }}
                            </p>
                        </div>
                    </div>
                @endif

                @if( (count($photos)) > 0 )
                    <div class="col-xl-8 order-xl-0">
                        <div class="bg-body-dark fw-semibold rounded p-3 push text-center">
                            {{ count($photos) }} {{ __('фотографий выбрано из') }} {{ $totalPhotosCount }}{{ __(' в базе данных ') }}
                        </div>
                        <!-- Sort and Show Filters -->
                        <div class="d-flex justify-content-between">
                            <div class="mb-3">
                                <select id="rows_per_page" name="rows_per_page" onchange="submitFilter()"
                                        class="form-select form-select-sm" size="1">
                                    <option value="" disabled selected>
                                        -{{ __('Выберите кол-во фотографий на странице') }}-
                                    </option>
                                    <option value="10"  @if($rows_per_page == 10) selected @endif >10</option>
                                    <option value="25" @if($rows_per_page == 25) selected @endif >25</option>
                                    <option value="50" @if($rows_per_page == 50) selected @endif >50</option>
                                    <option value="100" @if($rows_per_page == 100) selected @endif >100</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <select id="rows_sorted_by" name="rows_sorted_by" onchange="submitFilter()"
                                        class="form-select form-select-sm" size="1">
                                    <option value="" disabled selected> -{{ __('Выберите сортировку') }}-</option>
                                    <option value="nominations_count" @if($rows_sorted_by == "nominations_count") selected @endif >{{ __('Кол-во номинаций') }}</option>
                                    <option value="likes_count" @if($rows_sorted_by == "likes_count") selected @endif >{{ __('Кол-во симпатий') }}</option>
                                    <option value="name_asc" @if($rows_sorted_by == "name_asc") selected @endif >{{ __('Наименование (от А до Я)') }}</option>
                                    <option value="name_desc" @if($rows_sorted_by == "name_desc") selected @endif >{{ __('Наименование (от Я до А)') }}</option>
                                    <option value="published_at_date" @if($rows_sorted_by == "published_at_date") selected @endif >{{ __('Дата публикации') }}</option>
                                    <option value="active" @if($rows_sorted_by == "active") selected @endif >{{ __('Активная') }}</option>
                                    <option value="creation_date" @if($rows_sorted_by == "creation_date") selected @endif >{{ __('Дата создания') }}</option>
                                </select>
                            </div>
                        </div>
                        <!-- END Sort and Show Filters -->

                        <!-- Product Results -->
                        <div class="row items-push grid-masonry">

                            @foreach($photos as $nextPhoto)
                                <div class="col-md-6 col-xl-4 grid-item">

                                    <div class="block block-rounded h-100 mb-0">
                                        <div class="block-content p-1 block-content--padding">
                                            <div class="options-container">
                                                <div class="options-container__icons">
                                                @foreach($nextPhoto->photoNominations as $nextPhotoNomination)
                                                    <i class="fa fa-bolt fa-2x p-1 mt-1 mb-1" style="background-color:{{ $nextPhotoNomination['nomination']['color'] }} !important; color: white !important;"></i>
                                                @endforeach
                                                </div>
                                                <img class="img-fluid options-item"
                                                     src="{{ $nextPhoto['media_image_url'] }}"
                                                     alt="{{ $nextPhoto['name'] }}">
                                                <div class="options-overlay bg-black-75">
                                                    <div class="options-overlay-content">
                                                        <a class="btn btn-sm btn-alt-secondary mt-1 mb-1"
                                                           href="{{ route("photos.edit", $nextPhoto['id']) }}">
                                                            {{ __('Редактор фотографии') }}
                                                        </a><br>
                                                        <a class="btn btn-sm btn-alt-secondary mt-1 mb-1"
                                                           onclick="showImageModal({{ $nextPhoto['id'] }}, '{{ $nextPhoto['media_image_url'] }}')">
                                                            {{ __('Просмотр картинки') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            @endforeach


                        </div>
                        <div class="text-end">
                            {{ $photos->appends([])->links() }}
                        </div>
                        <!-- END Product Results -->
                    </div>
                @endif

            </div>
        </form>

    </div>
    <!-- END Page Content -->


    <!-- Photo Details Block Modal -->
    <div class="modal" id="photo_photo_details_modal" tabindex="-1" role="dialog" aria-labelledby="photo_photo_details_modal"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{ __('Фотография детально') }}</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="block-content fs-sm" id="photo_photo_details_content">

                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                data-bs-dismiss="modal">{{ __('Закрыть') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Details Block Modal -->



    <!-- Photo Image Nominations Block Modal -->
    <div class="modal" id="photo_image_set_nominations_modal" tabindex="-1" role="dialog" aria-labelledby="photo_image_set_nominations_modal"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{ __('Установка номинаций') }}</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm" id="photo_image_set_nominations_content">
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                data-bs-dismiss="modal">{{ __('Закрыть') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Photo Image Nominations Block Modal -->


    <!-- Photo Image Compilations Block Modal -->
    <div class="modal" id="photo_image_set_compilations_modal" tabindex="-1" role="dialog" aria-labelledby="photo_image_set_compilations_modal"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{ __('Установка подборок') }}</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm" id="photo_image_set_compilations_content">
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                data-bs-dismiss="modal">{{ __('Закрыть') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Photo Image Compilations Block Modal -->



    <!-- Photo Image Block Modal -->
    <div class="modal" id="photo_image_modal" tabindex="-1" role="dialog" aria-labelledby="photo_image_modal"
         aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="block block-rounded block-transparent mb-0">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{ __('Просмотр фотографии') }}</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content fs-sm">
                        <img class="img-fluid options-item" src="" alt="" id="photo_image_modal_img">
                        <p class="h5 m-2" id="photo_image_modal_name"></p>
                    </div>
                    <div class="block-content block-content-full text-end bg-body flex space-between">
                        <div class="block-content block-memu">
                            <div class="row p-0 m-0">
                                <div class="block-memu__item p-0 m-0">
                                    <i class="fa fa-fw fa-bolt fa-2x text-muted  fa-lg p-1 mt-1 mb-1 action_link" onclick="showSetNominationsModal()" title="{{ __('Номинации') }}"></i>
                                </div>

                                <div class="block-memu__item p-0 m-0">
                                    <i class="fa fa-fw fa-database fa-2x text-muted  fa-lg p-1 mt-1 mb-1 action_link" onclick="showSetCompilationsModal()" title="{{ __('Подборки') }}"></i>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-alt-secondary me-1"
                                data-bs-dismiss="modal">{{ __('Закрыть') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Photo Image Block Modal -->

@endsection
