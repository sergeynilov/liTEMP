@extends('layouts.backend')

@section('css_before')
    <link rel="stylesheet" href="/css/bootstrap-colorpicker.min.css">
@endsection

@section('js_after')

    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

    <script type="text/javascript" src="/js/bootstrap-colorpicker.min.js"></script>

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\NominationRequest') !!}









    <script>

        jQuery(document).ready(function () {
            @if(!$is_insert)
            loadNominationPhotoCovers()
            @endif
        });

        function loadNominationPhotoCovers() {
            console.log('loadNominationPhotoCovers::')
            var current_nomination_id = {{ $currentNomination->id ?? '' }}
            console.log('current_nomination_id::')
            console.log(current_nomination_id)
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '/admin/get_nomination_photo_covers/' + '{{ $nominationData->id ?? ''}}',
                success: function (response) {
                    console.log('loadNominationPhotoCovers response::')
                    console.log(response)

                    $("#div_nomination_photo_covers_container").html(response.html);
                },
                error: function (error) {
                    console.error(error)
                }
            });

        } // function loadNominationPhotoCovers() {


        function assignNominationToPhotoCovers( photo_id, nomination_id ) {
            // console.log('assignNominationToPhotoCovers photo_id::')
            // console.log(photo_id)
            // console.log('assignNominationToPhotoCovers nomination_id::')
            // console.log(nomination_id)
            Swal.fire({
                title: "{{ __('Вы хотите прикрепить обложку выбранной фотографии к номинации') }} ?",
                text: "{{ __('Обложка выбранной фотографии будет отображаться для номинации') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('Да, прикрепить') }} !"
            }).then(function (result) {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '/admin/photos/assign_to_nomination_photo_covers',
                        data: {"photo_id": photo_id, "nomination_id": nomination_id, "_token": $('meta[name="csrf-token"]').attr('content')},
                        success: function (response) {
                            Swal.fire({
                                title: '{{ __('Обложка для номинации фотографии') }} !',
                                text: '{{ __('Обложка выбранной фотографии успешно приклеплена к номинации') }} !',
                                icon: 'success',
                            })
                            loadNominationPhotoCovers()
                        },
                        error: function (error) {
                            console.error(error)
                            Swal.fire({
                                title: '{{ __('Ошибка приклепления обложки выбранной фотографии') }} !',
                                text: getErrorMessage(error),
                                type: 'danger',
                                icon: 'warning',
                            })
                        }
                    });
                }

            });
        } // function assignNominationToPhotoCovers( photo_id, nomination_id ) {


        function revokeNominationPhotoCovers( photo_id, nomination_id ) {
            console.log('revokeNominationPhotoCovers photo_id::')
            console.log(photo_id)
            console.log('revokeNominationPhotoCovers nomination_id::')
            console.log(nomination_id)

            Swal.fire({
                title: "{{ __('Вы хотите открепить обложку выбранной фотографии от данной номинации') }} ?",
                text: "{{ __('Обложка выбранной фотографии не будет отображаться для открепленной номинации  ') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('Да, открепить') }} !"
            }).then(function (result) {
                if (result.value) {

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: '/admin/photos/revoke_from_nomination_photo_covers',
                        data: {"photo_id": photo_id, "nomination_id": nomination_id, "_token": $('meta[name="csrf-token"]').attr('content')},
                        success: function (response) {
                            Swal.fire({
                                title: '{{ __('Обложка для номинации фотографии') }} !',
                                text: '{{ __('Обложка выбранной фотографии успешно откреплена от номинации') }} !',
                                icon: 'success',
                            })
                            loadNominationPhotoCovers()
                        },
                        error: function (error) {
                            console.error(error)
                            Swal.fire({
                                title: '{{ __('Ошибка откреплепления обложки выбранной фотографии') }} !',
                                text: getErrorMessage(error),
                                type: 'danger',
                                icon: 'warning',
                            })
                        }
                    });

                }

            });
        }


        function nominationTitleOnChange() {
            var nomination_title = $("#nomination_title").val()
            $("#nomination_slug").val(makeSlug(nomination_title))
        }

        $('#nomination_color').colorpicker({ // https://itsjavi.com/bootstrap-colorpicker/tutorial-p02_Advanced_Examples.html
            popover: false,
        })

        $('#nomination_color').on('change', function (e) {
            $('#icon_nomination_color').css('background-color', this.value);
        });

    </script>

@endsection


@section('content')

    <!-- NOMINATION EDITOR TITLE BLOCK-->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        {{ __('Редактор номинации') }}
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        {{ __($is_insert ? 'Создание новой номинации' : 'Изменение номинации') }}
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('home') }}">{{ __('Домой') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('nominations.index') }}">{{ __('Список номинаций') }}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{ __('Редактор номинации') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END NOMINATION EDITOR TITLE BLOCK-->

    <!-- NOMINATION EDITOR BLOCK -->
    <div class="content">
        <div class="block block-rounded">


            <ul class="nav nav-tabs nav-tabs-alt align-items-center" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" id="nomination_edit_tab_1" data-bs-toggle="tab"
                            data-bs-target="#nomination_edit_form" role="tab"
                            aria-selected="true">Детали номинации
                    </button>
                </li>

                @if(!$is_insert)
                    <li class="nav-item">
                        <button type="button" class="nav-link" id="nomination_photo_covers_tab_2" data-bs-toggle="tab"
                                data-bs-target="#nomination_photo_covers" role="tab"
                                aria-selected="false">Фото для обложки
                        </button>
                    </li>
                @endif
            </ul>

            <div class="block-content tab-content">


                <div class="tab-pane pull-x active" id="nomination_edit_form" role="tabpanel"
                     aria-labelledby="nomination_edit_tab_1">

                    <div class="block-header block-header-default">
                        <h3 class="block-title">{{ __('Заполните все поля номинации') }}</h3>
                    </div>
                    <div class="block-content block-content-full">


                        <form
                            action="{{ route(  'nominations.' . ( $is_insert ? 'store' : 'update' ) , $nominationData->id ?? null ) }}"
                            method="POST" enctype="multipart/form-data" id="form_nomination_edit">
                            @csrf
                            @if(!$is_insert)
                                @method('PUT')
                            @endif

                            <div class="row">

                                @if(!$is_insert)
                                    <div class="row mb-4">
                                        <div class="col-lg-4">
                                            <label class="form-label"
                                                   for="nomination_id">{{ __('ID номинации') }}</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control text-end" id="nomination_id"
                                                   name="id"
                                                   readonly value="{{ $nominationData->id ?? ''}}">
                                        </div>
                                    </div>
                                @endif

                                <div class="row mb-4">
                                    <div class="col-lg-4">
                                        <label class="form-label" for="nomination_title">
                                            {{ __('Наименование номинации') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="nomination_title" name="title"
                                               value="{{ old('title', $nominationData->title ?? '') }}"
                                               placeholder="{{ __('Введите строку описание номинации') }}"
                                               onchange="nominationTitleOnChange()"
                                               autocomplete="off">
                                        <p>
                                            <small class="text-muted mb-2">{{ __('Поле Slug будет сгенерировано автоматически') }}</small>
                                        </p>
                                        @error('title')
                                        <p class="validation_error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-4">
                                        <label class="form-label" for="nomination_slug">
                                            {{ __('Slug') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control mb-2" id="nomination_slug" name="slug"
                                               value="{{ old('slug', $nominationData->slug ?? '') }}"
                                               placeholder="{{ __('Введите slug номинации') }}"
                                               autocomplete="off">
                                        @error('slug')
                                        <p class="validation_error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-4">
                                        <label class="form-label" for="nomination_ordering">
                                            {{ __('Порядковый номер') }}

                                        </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control mb-2" id="nomination_ordering"
                                               name="ordering"
                                               value="{{ old('ordering', $nominationData->ordering ?? '') }}"
                                               placeholder="{{ __('Введите порядковый номер номинации') }}"
                                               autocomplete="off">
                                        @error('ordering')
                                        <p class="validation_error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-4">
                                        <label class="form-label" for="nomination_active">{{ __('Активен') }}</label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input class="form-check-input" type="checkbox" value="1"
                                               @if($nominationData->active ?? '') checked @endif
                                               id="nomination_active" name="active">
                                        <label class="form-check-label" for="nomination_active"></label>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-lg-4">
                                        <label class="form-label flex" for="nomination_color">
                                            {{ __('Цвет иконки') }}
                                            <i class="fa fa-fw fa-bolt fa-2x text-muted fa-lg p-1 mt-1 mb-1"
                                               id="icon_nomination_color"
                                               style="background-color:{{ $nominationData->color ?? '#ffffff' }} !important; color: white !important;"></i>
                                        </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control mb-2" id="nomination_color" name="color"
                                               value="{{ old('color', $nominationData->color ?? '') }}"
                                               placeholder="{{ __('Введите цвет иконки') }}"
                                               autocomplete="off">
                                        @error('color')
                                        <p class="validation_error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>


                                @if(!$is_insert)
                                    <div class="row mb-4">
                                        <div class="col-lg-4">
                                            <label class="form-label"
                                                   for="nomination_created_at">{{ __('Создан') }}</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control"
                                                   id="nomination_created_at" name="created_at" readonly
                                                   value="{{ getFormattedDateTime($nominationData->created_at ?? '') }}">
                                        </div>
                                    </div>
                                @endif



                                @if(!$is_insert && $nominationData->updated_at)
                                    <div class="row mb-4">
                                        <div class="col-lg-4">
                                            <label class="form-label"
                                                   for="nomination_updated_at">{{ __('Изменен') }}</label>
                                        </div>
                                        <div class="col-lg-8">
                                            <input type="text" class="form-control"
                                                   id="nomination_updated_at" name="updated_at" readonly
                                                   value="{{ getFormattedDateTime($nominationData->updated_at ?? '') }}">
                                        </div>
                                    </div>
                                @endif


                                <div class="d-flex justify-content-end">
                                    <div class="mr-auto">&nbsp;</div>
                                    <div class="m-2">
                                        <a type="button" href="{{ route('nominations.index') }}"
                                           class="btn btn-secondary">
                                            {{ __('Отмена') }}
                                        </a>
                                    </div>
                                    <div class="m-2">
                                        <button type="submit" class="btn btn-primary mx-4 ">
                                            {{ __($is_insert ? 'Создать' : 'Изменить') }}
                                        </button>
                                    </div>
                                </div>

                            </div>

                        </form>
                    </div>

                </div>

                <!-- END nomination_edit_tab_1 -->

                @if(!$is_insert)
                    <div class="tab-pane pull-x fs-sm" id="nomination_photo_covers" role="tabpanel" aria-labelledby="nomination_photo_covers_tab_2">
                        <div id="div_nomination_photo_covers_container"></div>
                    </div>
            @endif

            <!-- END nomination_photo_covers_tab_2 -->

            </div>


        </div> <!-- <div class="block block-rounded"> -->


    </div>
    <!-- END NOMINATION EDITOR BLOCK -->

@endsection
