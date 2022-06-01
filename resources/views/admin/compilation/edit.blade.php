@extends('layouts.backend')

@section('css_before')
@endsection

@section('js_after')

    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CompilationRequest') !!}

    <script>
        function compilationTitleOnChange() {
            var compilation_title = $("#compilation_title").val()
            $("#compilation_slug").val(makeSlug(compilation_title))
        }
    </script>


@endsection


@section('content')

    <!-- COMPILATION EDITOR TITLE BLOCK-->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        {{ __('Редактор подборки') }}
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        {{ __($is_insert ? 'Создание новой подборки' : 'Изменение подборки') }}
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('home') }}">{{ __('Домой') }}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('compilations.index') }}">{{ __('Список подборок') }}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{ __('Редактор подборки') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END COMPILATION EDITOR TITLE BLOCK-->

    <!-- COMPILATION EDITOR BLOCK -->
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Заполните все поля подборки') }}</h3>
            </div>
            <div class="block-content block-content-full">


                <form
                    action="{{ route(  'compilations.' . ( $is_insert ? 'store' : 'update' ) , $compilationData->id ?? null ) }}"
                    method="POST" enctype="multipart/form-data" id="form_compilation_edit">
                    @csrf
                    @if(!$is_insert)
                        @method('PUT')
                    @endif

                    <div class="row">

                        @if(!$is_insert)
                            <div class="row mb-4">
                                <div class="col-lg-4">
                                    <label class="form-label" for="compilation_id">{{ __('ID подборки') }}</label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control text-end" id="compilation_id" name="id"
                                           readonly value="{{ $compilationData->id ?? ''}}">
                                </div>
                            </div>
                        @endif

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="compilation_title">
                                    {{ __('Наименование подборки') }}
                                    <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="compilation_title" name="title"
                                       value="{{ old('title', $compilationData->title ?? '') }}"
                                       placeholder="{{ __('Введите строку описание подборки') }}"
                                       onchange="compilationTitleOnChange()"
                                       autocomplete="off">

                                <p>
                                    <small
                                        class="text-muted mb-2">{{ __('Поле Slug будет сгенерировано автоматически') }}</small>
                                </p>

                                @error('title')
                                <p class="validation_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="compilation_slug">
                                    {{ __('Slug') }}
                                    <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control mb-2" id="compilation_slug" name="slug"
                                       value="{{ old('slug', $compilationData->slug ?? '') }}"
                                       placeholder="{{ __('Введите slug подборки') }}"
                                       autocomplete="off">
                                @error('slug')
                                <p class="validation_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>


                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="compilation_ordering">
                                    {{ __('Порядковый номер') }}

                                </label>
                            </div>
                            <div class="col-lg-8">
                                <input type="text" class="form-control mb-2" id="compilation_ordering" name="ordering"
                                       value="{{ old('ordering', $compilationData->ordering ?? '') }}"
                                       placeholder="{{ __('Введите порядковый номер подборки') }}"
                                       autocomplete="off">
                                @error('ordering')
                                <p class="validation_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="compilation_active">{{ __('Активен') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input class="form-check-input" type="checkbox" value="1"
                                       @if($compilationData->active ?? '') checked @endif
                                       id="compilation_active" name="active">
                                <label class="form-check-label" for="compilation_active"></label>
                            </div>
                        </div>


                        @if(!$is_insert)
                            <div class="row mb-4">
                                <div class="col-lg-4">
                                    <label class="form-label" for="compilation_created_at">{{ __('Создан') }}</label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control"
                                           id="compilation_created_at" name="created_at" readonly
                                           value="{{ getFormattedDateTime($compilationData->created_at ?? '') }}">
                                </div>
                            </div>
                        @endif



                        @if(!$is_insert && $compilationData->updated_at)
                            <div class="row mb-4">
                                <div class="col-lg-4">
                                    <label class="form-label" for="compilation_updated_at">{{ __('Изменен') }}</label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control"
                                           id="compilation_updated_at" name="updated_at" readonly
                                           value="{{ getFormattedDateTime($compilationData->updated_at ?? '') }}">
                                </div>
                            </div>
                        @endif


                        <div class="d-flex justify-content-end">
                            <div class="mr-auto">&nbsp;</div>
                            <div class="m-2">
                                <a type="button" href="{{ route('compilations.index') }}" class="btn btn-secondary">
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

    </div>
    <!-- END COMPILATION EDITOR BLOCK -->

@endsection
