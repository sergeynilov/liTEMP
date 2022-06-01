@extends('layouts.backend')

@section('js_after')
    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\PhotoRequest') !!}


    <script>
        function photoNameOnChange() {
            var photo_name = $("#photo_name").val()
            $("#photo_slug").val(makeSlug(photo_name))
        }

        function showImageModal( image_url, photo_name) {
            $("#photo_image_modal_img").attr("src",image_url);
            $("#photo_image_modal_name").html(photo_name);
            $('#photo_image_modal').modal('show');
        }


        function deletePhoto() {
            Swal.fire({
                title: "{{ __('Вы хотите удалить фото') }} ?",
                text: "{{ __('Вы удалите фото и очистите все связанные данные') }}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "{{ __('Да, удалить фото') }} !"
            }).then(function (result) {
                if (result.value) {

                    $.ajax({
                        type: "DELETE",
                        dataType: "json",
                        url: '/admin/photos/{{ $photoData->id ?? ''}}',
                        data: {"photo": {{ $photoData->id ?? ''}}, "_token": $('meta[name="csrf-token"]').attr('content')},
                        success: function (response) {
                            Swal.fire({
                                title: '{{ __('Редактор фото') }} !',
                                text: '{{ __('Фото удалено') }} !',
                                icon: 'success',
                            })
                            window.location.href = "/admin/photos";
                        },
                        error: function (error) {
                            console.error(error)
                            Swal.fire({
                                title: '{{ __('Ошибка удаления фото') }} ',
                                text: getErrorMessage(error),
                                type: 'danger',
                                icon: 'warning',
                            })
                        }
                    });
                }

            });
        } // function deletePhoto() {

    </script>

@endsection


@section('content')

    <!-- PHOTO EDITOR TITLE BLOCK-->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        {{ __('Редактор фотографии') }}
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        {{ __('Изменение фотографии') }}
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('home') }}">{{ __('Домой') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('photos.index') }}">{{ __('Список фотографий') }}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{ __('Редактор фотографии') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END PHOTO EDITOR TITLE BLOCK-->

    <!-- PHOTO EDITOR BLOCK -->
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Заполните все поля фотографии') }}</h3>
            </div>
            <div class="block-content block-content-full">

                <form action="{{ route( 'photos.update', $photoData->id ?? null ) }}"
                    method="POST" enctype="multipart/form-data" id="form_photo_edit">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="photo_id">{{ __('ID фотографии') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control text-end" id="photo_id" name="id"
                                       readonly value="{{ $photoData->id ?? ''}}" autocomplete="off">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="photo_owner_name">{{ __('Опубликовал') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="photo_owner_name" name="owner_name"
                                       readonly value="{{ $photoData->owner['name'] ?? ''}}" autocomplete="off">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="photo_likes_count">{{ __('Кол-во лайков') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control text-end" id="photo_likes_count" name="likes_count"
                                       readonly value="{{ $photoData->photo_likes_count ?? ''}}" autocomplete="off">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="photo_name">
                                    {{ __('Наименование фотографии') }}
                                    <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="photo_name" name="name"
                                       value="{{ old('name', $photoData->name ?? '') }}"
                                       placeholder="{{ __('Введите строку описание фотографии') }}"
                                       onchange="photoNameOnChange()"
                                       autocomplete="off"
                                >
                                <p><small class="text-muted mb-2">{{ __('Поле Slug будет сгенерировано автоматически') }}</small>
                                </p>
                                @error('name')
                                <p class="validation_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="photo_slug">
                                    {{ __('Slug') }}
                                    <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control mb-2" id="photo_slug" name="slug"
                                       value="{{ old('slug', $photoData->slug ?? '') }}"
                                       placeholder="{{ __('Введите slug фотографии') }}"
                                       autocomplete="off">
                                @error('slug')
                                <p class="validation_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="photo_uploaded_photo">
                                    {{ __('Загруженная фотография') }}

                                </label>
                            </div>
                            <div class="col-lg-8">
                                <img class="img-fluid options-item" src="{{ $photoData->media_image_url }}" alt="{{ $photoData->name }}">
                                <hr>
                                {{ $photoData->name }}, {{ $photoData->mime_type }}, {{ $photoData->size_label }}
                                <hr>
                                <a class="btn btn-sm btn-alt-secondary mt-1 mb-1" onclick="showImageModal('{{ $photoData['media_image_url'] }}')">
                                    {{ __('Просмотр картинки') }}
                                </a>

                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="photo_active">{{ __('Активен') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input class="form-check-input" type="checkbox" value="1"
                                       @if($photoData->active ?? '') checked @endif
                                       id="photo_active" name="active">
                                <label class="form-check-label" for="photo_active"></label>
                            </div>
                        </div>


                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="photo_shown_on_homepage">{{ __('Отображать на главной странице') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input class="form-check-input" type="checkbox" value="1"
                                       @if($photoData->shown_on_homepage ?? '') checked @endif
                                       id="photo_shown_on_homepage" name="shown_on_homepage">
                                <label class="form-check-label" for="photo_shown_on_homepage"></label>
                            </div>
                        </div>


                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="photo_published_at">{{ __('Дата публикации') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="photo_published_at" name="published_at"
                                       readonly
                                       value="{{ getFormattedDateTime($photoData->published_at ?? '') }}">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="photo_created_at">{{ __('Создан') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="photo_created_at" name="created_at"
                                       readonly
                                       value="{{ getFormattedDateTime($photoData->created_at ?? '') }}">
                            </div>
                        </div>

                        @if($photoData->updated_at)
                            <div class="row mb-4">
                                <div class="col-lg-4">
                                    <label class="form-label" for="photo_updated_at">{{ __('Изменен') }}</label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" id="photo_updated_at" name="updated_at"
                                           readonly
                                           value="{{ getFormattedDateTime($photoData->updated_at ?? '') }}">
                                </div>
                            </div>
                        @endif


                        <div class="d-flex justify-content-end">
                            <div class="mr-auto">&nbsp;</div>
                            <div class="m-2 mr-4 pr-4">
                                <button type="button" onclick="deletePhoto()" class="btn btn-danger">
                                    {{ __('Удалить') }}
                                </button>
                            </div>
                            <div class="m-2 mr-4" style="margin-left: 30px !important;">
                                <a type="button" href="{{ route('photos.index') }}" class="btn btn-secondary pl-4">
                                    {{ __('Отмена') }}
                                </a>
                            </div>
                            <div class="m-2">
                                <button type="submit" class="btn btn-primary mx-4 ">
                                    {{ __('Изменить') }}
                                </button>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>

    </div>
    <!-- END PHOTO EDITOR BLOCK -->


    <!-- Photo Image Block Modal -->
    <div class="modal" id="photo_image_modal" tabindex="-1" role="dialog" aria-labelledby="photo_image_modal" aria-hidden="true">
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
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-alt-secondary me-1" data-bs-dismiss="modal">{{ __('Закрыть') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Photo Image Block Modal -->

@endsection
