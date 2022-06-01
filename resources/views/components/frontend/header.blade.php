<div>

    <div class="header-wrapper">
        <header class="header ">
            <div class="container">
                <div class="header__wrapper">
                    <a href="/" class="header__logo">
                        <svg width="45" height="29">
                            <use xlink:href="/img/sprite.svg#logo"></use>
                        </svg>
                    </a>
                    <nav class="header__nav">
                        <div class="header__nav-menu">
                            <a href="/photos" class="header__nav-link">Фотографии</a>
                            <a href="/nominations" class="header__nav-link">Номинации</a>
                            <a href="/Party" class="header__nav-link color">Party</a>
                            <a href="/photographers" class="header__nav-link">Фотографы</a>
                        </div>
                    </nav>

                    <div class="header__content">

                        <a href="#" class="header__notifications active">
                            <svg width="17" height="17">
                                <use xlink:href="/img/sprite.svg#notifications"></use>
                            </svg>
                            <span class="mark"></span>
                        </a>
                        @if(!isUserLogged())
                            <a href="#modal-signin" class="header__signIn" data-modal>
                                <span>Войти</span>
                            </a>
                            {{--<a onclick="modalSigninOpen(); return false;" class="header__signIn" data-modal><span>Войти</span></a>--}}
                        @else
                            <a href="/profile/index" class="">
                                <img src="{{ getLoggedUserAvatar() }}" class="header__user-img" alt="">
                            </a>
                        @endif

                        <a  onclick="modalSigninOpen(); return false;" class="header__search">
                            <svg width="15" height="15">
                                <use xlink:href="/img/sprite.svg#search"></use>
                            </svg>
                        </a>
                        <button class="header__btn-menu">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </header>
    </div> <!-- header-wrapper -->

    <div id="modal-signin" class="modal modal-signin">
        <div class="modal-title">
            Вход
        </div>
        <div class="form-signin">
            <form action="">
                <div class="form-group">
                    <input type="text" name="login" id="login_email" class="form-control" placeholder="Еmail или телефон" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="login_password" class="form-control" placeholder="Пароль" required>
                </div>

                <div class="form-group form-submit flex justify-center">
                    <button type="button" class="btn btn-submit" onclick="makeLogin()">
                        Войти
                    </button>
                </div>
                <div class="signin-social">
                    <div class="signin-social__title">Войти через соц. сети:</div>
                    <ul class="signin-social__list flex justify-center">
                        <li><a href="" class="google"><svg class="icon icon-google">
                                    <use xlink:href="/img/icons.svg#google" />
                                </svg></a></li>
                        <li><a href="" class="facebook"><svg class="icon icon-facebook">
                                    <use xlink:href="/img/icons.svg#facebook" />
                                </svg></a></li>
                        <li><a href="" class="vk"><svg class="icon icon-vk">
                                    <use xlink:href="/img/icons.svg#vk" />
                                </svg></a></li>
                    </ul>
                </div>
                <div class="form-group form-link">
                    <a href="#modal-registration" data-modal>Регистрация</a>
                </div>
                <div class="restore-password flex justify-center">
                    <a href="#modal-restore-password" class="restore-password__link" data-modal>Восстановить пароль</a>
                </div>
            </form>
        </div>
    </div>
    <div id="modal-registration" class="modal modal-registration">
        <div class="modal-title">
            Регистрация
        </div>
        <div class="form-registration">
            <form action="">

                <div class="form-group">
                    <input type="text" name="login" id="register_email" class="form-control" placeholder="Еmail или телефон" value="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="register_password" class="form-control" placeholder="Пароль" value="">
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" id="register_password_confirmation" class="form-control" placeholder="Пароль" value="">
                </div>

                {{--                <div class="form-group">--}}
                {{--                    <input type="text" name="login" id="register_email" class="form-control" placeholder="Еmail или телефон" value="">--}}
                {{--                </div>--}}
                {{--                <div class="form-group">--}}
                {{--                    <input type="password" name="password" id="register_password" class="form-control" placeholder="Пароль" value="">--}}
                {{--                </div>--}}
                {{--                <div class="form-group">--}}
                {{--                    <input type="password" name="password_confirmation" id="register_password_confirmation" class="form-control" placeholder="Пароль" value="">--}}
                {{--                </div>--}}

                <div class="form-group form-link">
                    <a href="#modal-signin" data-modal>У меня уже есть аккаунт</a>
                </div>
                <div class="form-group form-submit flex">
                    <button type="button" class="btn btn--full btn-submit" id="registration_button_submit" onclick="makeRegisterStep1()">Регистрация</button>
                </div>
                <div class="signin-social">
                    <div class="signin-social__title">Войти через соц. сети:</div>
                    <ul class="signin-social__list flex justify-center">
                        <li><a href="" class="google"><svg class="icon icon-google">
                                    <use xlink:href="/img/icons.svg#google" />
                                </svg></a></li>
                        <li><a href="" class="facebook"><svg class="icon icon-facebook">
                                    <use xlink:href="/img/icons.svg#facebook" />
                                </svg></a></li>
                        <li><a href="" class="vk"><svg class="icon icon-vk">
                                    <use xlink:href="/img/icons.svg#vk" />
                                </svg></a></li>
                    </ul>
                </div>
            </form>
        </div>
    </div>
    <div id="modal-restore-password" class="modal modal-restore">

        <div class="form-restore">
            <form action="">
                <div class="form-restore__main" id="restore_main">
                    <div class="modal-title">
                        Восстановить пароль
                    </div>
                    <div class="form-group form-text">
                        Укажите почту или телефон который использовался при регистрации
                    </div>
                    <div class="form-group">
                        <input type="text" name="login" class="form-control" placeholder="Еmail или телефон">
                    </div>

                    <div class="form-group form-submit flex justify-center">
                        <button type="button" class="btn btn--full btn-submit" id="restore_button_next">Продолжить</button>
                    </div>
                </div>
                <div class="form-restore__confirmation" id="restore_confirmation" style="display:none">
                    <div class="modal-title">
                        Восстановить пароль
                    </div>
                    <div class="form-restore__confirmation-flex">
                        <div class="form-restore__confirmation-number">+7 468 998 47 55</div>
                        <a href="javascript:" class="form-restore__confirmation-edit" id="restore_button_edit_number" title="Редактировать">
                            <svg class="icon icon-edit-2">
                                <use xlink:href="/img/icons.svg#edit-2" />
                            </svg>
                        </a>
                    </div>
                    <div class="form-restore__confirmation-flex">
                        <input type="text" class="form-restore__confirmation-code form-control" placeholder="Код из СМС">
                        <div class="form-restore__confirmation-timer">
                            Код действителен еще:
                            <span>9 мин. 33 сек.</span>
                        </div>
                    </div>


                    <div class="form-group form-submit flex justify-center">
                        <button type="submit" class="btn btn--full btn-submit" id="restore_button_confirmation">Подтвердить</button>
                    </div>
                </div>
                <div class="form-restore__edit" id="restore_edit_number" style="display:none">
                    <div class="modal-title">
                        Редактировать номер
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-restore__edit-number form-control" value="+7 468 998 47 55">
                    </div>
                    <div class="form-group form-submit">
                        <button type="button" class="btn btn--full btn-submit" id="restore_button_edit_save">Сохранить</button>
                        <button type="button" class="btn btn--full form-restore__edit-back" id="restore_button_back">
                            <svg viewBox="0 0 15 8" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0.646446 3.64645C0.451184 3.84171 0.451184 4.15829 0.646446 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82843L1.70711 4L4.53553 1.17157C4.7308 0.976311 4.7308 0.659728 4.53553 0.464466C4.34027 0.269204 4.02369 0.269204 3.82843 0.464466L0.646446 3.64645ZM15 3.5L1 3.5V4.5L15 4.5V3.5Z" />
                            </svg>
                            <span>Назад</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
    <div id="modal-confirmation-email" class="modal modal-confirmation">
        <div class="modal-title">
            Подтверждение почты
        </div>
        <div class="form-confirmation">

            <form action="">
                <div class="form-text">
                    Мы отправили на почту письмо с ссылкой для подтверждения регистрации.
                </div>
                <div class="form-group">
                    <input type="text" name="confirmation_code" id="confirmation_code" class="form-control" placeholder="Введите код">
                </div>
                <div class="form-group form-submit flex justify-center">
                    <button type="button" class="btn btn--full btn-submit" id="button_confirmation_email" onclick="makeRegisterStep2CodeConfirmation()" >Подтвердить</button>
                </div>
            </form>
        </div>
    </div>
    <div id="modal-completion-registration" class="modal modal-completion-registration">
        <div class="completion-registration__progress">
            <div class="completion-registration__progress-item active" data-registration-step="1">
                <div class="completion-registration__progress-number">
                    <span>1</span>
                    <svg class="icon icon-lightning">
                        <use xlink:href="/img/icons.svg#lightning" />
                    </svg>
                </div>
                <div class="completion-registration__progress-text">Личные данные</div>
            </div>

            {{--            <div class="completion-registration__progress-item" data-registration-step="2">--}}
            {{--                <div class="completion-registration__progress-number">--}}
            {{--                    <span>2</span>--}}
            {{--                    <svg class="icon icon-lightning">--}}
            {{--                        <use xlink:href="/img/icons.svg#lightning" />--}}
            {{--                    </svg>--}}
            {{--                </div>--}}
            {{--                <div class="completion-registration__progress-text">Загрузка аватара</div>--}}
            {{--            </div>--}}
            {{--            <div class="completion-registration__progress-item" data-registration-step="1">--}}
            {{--                <div class="completion-registration__progress-number">--}}
            {{--                    <span>3</span>--}}
            {{--                    <svg class="icon icon-lightning">--}}
            {{--                        <use xlink:href="/img/icons.svg#lightning" />--}}
            {{--                    </svg>--}}
            {{--                </div>--}}
            {{--                <div class="completion-registration__progress-text">Загрузка фотографий</div>--}}
            {{--            </div>--}}

        </div>
        <div class="modal-title">
            Завершение регистрации
        </div>
        <div class="completion-registration">
            <form action="">
                <div class="completion-registration__step active" data-step="3">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Ваше имя и фамилия" id="completion_registration_name">
                    </div>
                    <div class="form-group">
                        <select class="select" data-placeholder="Город и страна проживания" id="completion_registration_city_id">
                            <option></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="form-flex">
                            <div class="form-column form-column-field">
                                <input type="text" name="phone" class="form-control" placeholder="Номер телефона" id="completion_registration_phone">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-flex">
                            <div class="form-column form-column-field">
                                <div class="form-input-box form-input-rate">
                                    <input type="text" name="rate" class="form-control form-input-box__input" placeholder="Ставка в час" id="completion_registration_hour_rate">
                                    <div class="form-input-box__unit">₽</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-flex">
                            <div class="form-column form-column-field">
                                <select class="select select-no-search" data-no-search data-placeholder="Выбрать год" id="completion_registration_started_year">
                                    <option></option>
                                </select>
                            </div>
                            <div class="form-column form-column-text">
                                <div class="form-text">Укажите в каком году вы начали заниматься фотографией.</div>
                            </div>
                        </div>

                    </div>
                    <div class="form-group form-submit flex">
                        <button type="button" class="btn btn--full btn-submit" id="registration_button_step_2" onclick="completionRegistrationStep3()">Завершить регистрацию</button>
                    </div>
                </div>

                <div class="completion-registration__stepWWW" dataWWW-step="2" style="display:none">
                    <div class="completion-registration__avatar">
                        <div class="completion-registration__avatar-img">
                            <img src="/img/photo-avatar.png" alt="">
                        </div>
                        <div class="completion-registration__avatar-text">
                            Формат изображения .png или .jpg размером не более 2мб
                        </div>
                    </div>
                    <div class="form-group form-submit">
                        <button type="button" class="btn btn--full btn-submit" id="registration_button_step_3">Продолжить регистрацию</button>
                        <button type="button" class="btn btn--full btn-skip" id="registration_button_skip_3">
                            <span>Пропустить этот шаг</span>
                            <svg viewBox="0 0 15 8" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.3536 3.64645C14.5488 3.84171 14.5488 4.15829 14.3536 4.35355L11.1716 7.53553C10.9763 7.7308 10.6597 7.7308 10.4645 7.53553C10.2692 7.34027 10.2692 7.02369 10.4645 6.82843L13.2929 4L10.4645 1.17157C10.2692 0.976311 10.2692 0.659728 10.4645 0.464466C10.6597 0.269204 10.9763 0.269204 11.1716 0.464466L14.3536 3.64645ZM0 3.5L14 3.5V4.5L0 4.5L0 3.5Z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="completion-registrationWWW__step" dataWWW-step="1" style="display:none">
                    <div class="completion-registration__images">
                        <div class="completion-registration__images-text">
                            Загрузите фотографии с вашими работами в хорошем качестве
                            в&nbsp;формате .png или .jpg
                        </div>
                        <div class="completion-registration__images-gallery">
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-1.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-2.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-3.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-4.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-5.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-6.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-7.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-8.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-9.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-10.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-11.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-12.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-13.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-14.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-15.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-16.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-17.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="upload-image">
                                <div class="upload-image__img">
                                    <img src="/img/gallery-upload/img-18.jpg" alt="">
                                </div>
                                <div class="upload-image__remove" title="Удалить"><svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <label class="completion-registration__images-upload">
                            <svg class="icon icon-cloud">
                                <use xlink:href="/img/icons.svg#cloud" />
                            </svg>
                            <span>Можно добавить 20 фотографий, затем по 2 в неделю. <br>
                Чтобы добавить больше, оформите <a href="">подписку на PRO</a>.</span>
                        </label>

                    </div>
                    <div class="form-group form-submit">
                        <button type="submit" class="btn btn--full btn-submit">Перейти к настройкам фотографий</button>
                        <a href="#" class="btn btn--full btn-skip">
                            <span>Добавить позже в личном кабинете</span>
                            <svg viewBox="0 0 15 8" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.3536 3.64645C14.5488 3.84171 14.5488 4.15829 14.3536 4.35355L11.1716 7.53553C10.9763 7.7308 10.6597 7.7308 10.4645 7.53553C10.2692 7.34027 10.2692 7.02369 10.4645 6.82843L13.2929 4L10.4645 1.17157C10.2692 0.976311 10.2692 0.659728 10.4645 0.464466C10.6597 0.269204 10.9763 0.269204 11.1716 0.464466L14.3536 3.64645ZM0 3.5L14 3.5V4.5L0 4.5L0 3.5Z" />
                            </svg>
                        </a>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <script>

        var entered_register_email= null
        var entered_register_password= null
        function modalSigninOpen() {
            $('#modal-signin').modal('show')
            // $('#modal-signin').show();
        }
        jQuery(document).ready(function () {

            // console.log('var::')
            // console.log($('#completion_registration_started_year').length)

            if ($('#completion_registration_started_year').length) {
                // console.log('-2 .ready::')
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: 'get_years_selection_array',
                    success: function (response) {
                        // console.log('-3 .ready::')
                        var yearsSelectionArray = Object.values(response.yearsSelectionArray)
                        var l = yearsSelectionArray.length
                        for (i = 0; i < l; i++) {
                            var next_year = yearsSelectionArray[i]
                            $('#completion_registration_started_year').append($('<option></option>').val(next_year).text(next_year));
                        }
                        // })
                    },
                    error: function (error) {
                        console.error(error)
                    }
                });

            }

            if (('#completion_registration_city_id').length) {
                // console.log('-4 .ready::')
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: 'get_cities_selection_array',
                    success: function (response) {
                        // console.log('-6 .ready::')
                        var citiesSelectionArray = Object.values(response.citiesSelectionArray)
                        var l = citiesSelectionArray.length

                        for (i = 0; i < l; i++) {
                            var nextCity = citiesSelectionArray[i]
                            $('#completion_registration_city_id').append($('<option></option>').val(nextCity.code).text(nextCity.label));
                        }
                        // })
                    },
                    error: function (error) {
                        console.error(error)
                    }
                });
            }
        });

        function makeLogin(prirly_entered_register_email, prirly_entered_register_password) {
            // console.log('makeLogin login_email::')
            var login_email = null
            var login_password = null
            if (typeof prirly_entered_register_email != 'undefined' && prirly_entered_register_password  != 'undefined') {
                login_email = prirly_entered_register_email
                login_password = prirly_entered_register_password

            } else {
                login_email = $("#login_email").val()
                login_password = $("#login_password").val()
            }
            // console.log(login_email)
            // console.log(login_password)

            $.ajax({   //             Window.axios.post('/login', this.loginForm)
                type: "POST",
                dataType: "json",
                url: '/login',
                data: {email : login_email, password : login_password, "_token": $('meta[name="csrf-token"]').attr('content')},
                success: function (response) {
                    // console.log('response::')
                    // console.log(response)
                    window.location.href = "/profile/index";
                },
                error: function (error) {
                    console.error(error)
                }
            });

        } // function makeLogin() {


        function makeRegisterStep1() {
            var register_email = $("#register_email").val()
            var register_password = $("#register_password").val()
            var register_password_confirmation = $("#register_password_confirmation").val()
            var data= { email : register_email, password : register_password, password_confirmation : register_password_confirmation, "_token": $('meta[name="csrf-token"]').attr('content') }

            $.ajax({
                type: "POST",
                dataType: "json",
                url: '/auth/register',
                data: data,
                success: function (response) {
                    entered_register_password= register_password
                    entered_register_email= register_email
                },
                error: function (error) {
                    // console.error(error)
                    // console.error(error.responseJSON)
                    var error_text = error.responseJSON.message

                    // console.log('error.responseJSON.message::')
                    // console.log(error.responseJSON.message)
                    // console.log(typeof error.responseJSON.message)

                    if ( typeof error.responseJSON.message != undefined && error.responseJSON.message == 'such_user_already_exists') {
                        // console.log(-1)
                        error_text= 'Такой пользователь уже существует. Авторизуйтесь если это вы'
                    }
                    Swal.fire({
                            title: 'Ошибка регистрации',
                            text: error_text,
                            icon: 'error'
                        }
                    )

                    console.error(error)
                }
            });

        } // function makeRegisterStep1() {


        function makeRegisterStep2CodeConfirmation() {
            var confirmation_code = $("#confirmation_code").val()
            var data = { confirmation_code : confirmation_code, email: entered_register_email, password: entered_register_password, "_token": $('meta[name="csrf-token"]').attr('content') }
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '/auth/confirm_code',
                data: data,
                success: function (response) {
                },
                error: function (error) {
                    console.error(error)
                }
            });

        } // function makeRegisterStep2CodeConfirmation() {

        function completionRegistrationStep3() {


            var completion_registration_name = $("#completion_registration_name").val()

            var completion_registration_city_id = $("#completion_registration_city_id").val()

            var completion_registration_hour_rate = $("#completion_registration_hour_rate").val()
            var completion_registration_phone = $("#completion_registration_phone").val()
            var completion_registration_started_year = $("#completion_registration_started_year").val()
            // console.log('completionRegistrationStep3()::')

            var data = {
                email : entered_register_email,
                name : completion_registration_name,
                hour_rate : completion_registration_hour_rate,
                city_id: completion_registration_city_id,
                phone: completion_registration_phone,
                started_year: completion_registration_started_year,
                "_token": $('meta[name="csrf-token"]').attr('content')}
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '/auth/completion_registration',
                data: data,
                success: function (response) {
                    makeLogin(entered_register_email, entered_register_password)
                },
                error: function (error) {
                    console.error(error)
                }

            });

            return false;
        } // function completionRegistrationStep3() {

    </script>
</div>
