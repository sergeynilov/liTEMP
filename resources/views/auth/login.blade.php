@extends('layouts.backend')

@section('content')

    <!-- LOGIN TITLE BLOCK -->
    <div class="bg-body-light">
        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
                <div class="flex-grow-1">
                    <h1 class="h3 fw-bold mb-2">
                        {{ __('Логин') }}
                    </h1>
                    <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                        {{ __('В административную часть') }}
                    </h2>
                </div>
                <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-alt">
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ route('home') }}">{{ __('Домой') }}</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">
                            {{ __('Логин') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <!-- END LOGIN TITLE BLOCK -->

    <!-- LOGIN BLOCK -->
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">{{ __('Введите ваш логин') }}</h3>
            </div>
            <div class="block-content block-content-full">

                @if(!empty($errors->keys() ))
                    <div class="block-title validation_error p-2 my-3">
                        {{ __('Ошибка логина') }}<br>
                        {{ __('Проверьте ваши параметры ввода') }}
                    </div>
                @endif

                @if (session('status'))
                    <div class="block-title validation_error p-2 my-3">
                        {{ session('status') }}
                    </div>
                @endif



                <form action="{{ route('login') }}" method="POST" enctype="multipart/form-data" id="form_login_edit">
                    @csrf

                    <div class="row">

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="email">{{ __('е-мейл') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="email" class="form-control" id="email"
                                       name="email" placeholder="{{ __('Введите ваш е-мейл') }}">
                                @error('email')
                                <p class="validation_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="password">{{ __('Пароль') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input type="password" class="form-control" id="password"
                                       name="password" placeholder="{{ __('Введите ваш пароль') }}">
                                @error('password')
                                <p class="validation_error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="form-label" for="login_remember_me">{{ __('Запомнить меня') }}</label>
                            </div>
                            <div class="col-lg-8">
                                <input class="form-check-input" type="checkbox" value="1"
                                       id="login_remember_me" name="login_remember_me">
                                <label class="form-check-label" for="login_remember_me"></label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <div class="mr-auto">&nbsp;</div>
                            <div class="m-2" >
                                <button type="button" href="{{ route('home') }}" class="btn btn-secondary">{{ __('Домой') }}</button>
                            </div>
                            <div class="m-2">
                                <button type="submit" class="btn btn-primary mx-4 ">{{ __('Логин') }}</button>
                            </div>
                        </div>

                    </div>

                </form>
            </div>
        </div>

    </div>
    <!-- END LOGIN BLOCK -->

@endsection
