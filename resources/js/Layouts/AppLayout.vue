<template>

    <div class="wrapper">

        <modal name="modal-completion-registration" :height="modalCompletionRegistrationHeight"
               :width="modalCompletionRegistrationWidth" transition="pop-out" style="">


            <div id="modal-completion-registration" class="modal modal-completion-registration"
                 style="display: inline-block; ">
                <!--                modal_completion_registration_step::{{ modal_completion_registration_step }}-->
                <div class="completion-registration__progress">
                    <div class="completion-registration__progress-item active" data-registration-step="1">
                        <div class="completion-registration__progress-number">
                            <span>1</span>
                            <svg class="icon icon-lightning">
                                <use xlink:href="/img/icons.svg#lightning"/>
                            </svg>
                        </div>
                        <div class="completion-registration__progress-text">Личные данные</div>
                    </div>
                    <div class="completion-registration__progress-item" data-registration-step="2">
                        <div class="completion-registration__progress-number">
                            <span>2</span>
                            <svg class="icon icon-lightning">
                                <use xlink:href="/img/icons.svg#lightning"/>
                            </svg>
                        </div>
                        <div class="completion-registration__progress-text">Загрузка аватара</div>
                    </div>
                    <div class="completion-registration__progress-item" data-registration-step="3">
                        <div class="completion-registration__progress-number">
                            <span>3</span>
                            <svg class="icon icon-lightning">
                                <use xlink:href="/img/icons.svg#lightning"/>
                            </svg>
                        </div>
                        <div class="completion-registration__progress-text">Загрузка фотографий</div>
                    </div>
                </div>

                <div class="modal-title">
                    <div class="row">
                        <div class="col-10">
                            Завершение регистрации
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <a class="close-modal " @click.prevent="hideCompletionRegistrationModal()">
                                <svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10 1.17838L8.82162 0L4.99999 3.82161L1.17838 0L0 1.17838L3.82161 4.99999L0 8.82162L1.17838 10L4.99999 6.17839L8.8216 10L9.99997 8.82162L6.17839 4.99999L10 1.17838Z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="completion-registration">
                    <ValidationObserver
                        ref="completionRegistrationObserverForm"
                        v-slot="{handleSubmit}"
                    >

                        <form @submit.prevent="completionRegistrationStep3">

                            <div class="completion-registration__step active" data-step="1" v-show=" modal_completion_registration_step === 1">
                                <div class="form-group">

                                    <ValidationProvider
                                        name="name"
                                        :rules="{ required : true, max:100 }"
                                        v-slot="{ errors }"
                                    >
                                        <input type="text" name="name" class="form-control"
                                               placeholder="Ваше имя и фамилия"
                                               v-model="completionRegistrationForm.name" autocomplete="off">
                                        <p class="validation_error">{{ clearErrorMessage(errors[0]) }}</p>
                                    </ValidationProvider>

                                </div>
                                <div class="form-group">

                                    <ValidationProvider
                                        name="selected_city_id"
                                        :rules="{ required : true }"
                                        v-slot="{ errors }"
                                    >
                                        <multiselect
                                            v-model="selected_city_id"
                                            :options="citiesSelectionArray"
                                            label="label"
                                            track-by="code"
                                            class="form-control"
                                            placeholder="Выберите город"
                                            selectLabel	="Для выбора элемента нажмите enter"
                                            selectedLabel="Выбран"
                                            deselectLabel="Для удаления элемента нажмите enter"
                                            :multiple="false"
                                        >
                                        </multiselect>
                                        <p class="validation_error">{{ clearErrorMessage(errors[0]) }}</p>
                                    </ValidationProvider>

                                </div>
                                <div class="form-group">
                                    <div class="form-flex">
                                        <div class="form-column form-column-field">

                                            <ValidationProvider
                                                name="phone"
                                                :rules="{ required : true, max:200 }"
                                                v-slot="{ errors }"
                                            >
                                                <input type="text" name="phone" class="form-control"
                                                       placeholder="Номер телефона"
                                                       v-model="completionRegistrationForm.phone"
                                                       autocomplete="off">
                                                <p class="validation_error">{{ clearErrorMessage(errors[0]) }}</p>
                                            </ValidationProvider>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-flex">
                                        <div class="form-column form-column-field">
                                            <div class="form-input-box form-input-rate">

                                                <ValidationProvider
                                                    name="hour_rate"
                                                    :rules="{ required : true, integer : true, max:10 }"
                                                    v-slot="{ errors }"
                                                >
                                                    <input type="text" name="rate"
                                                           class="form-control form-input-box__input"
                                                           placeholder="Ставка в час"
                                                           v-model="completionRegistrationForm.hour_rate"
                                                           autocomplete="off">
                                                    <div class="form-input-box__unit">₽</div>
                                                    <p class="validation_error">{{
                                                            clearErrorMessage(errors[0])
                                                        }}</p>
                                                </ValidationProvider>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-flex">
                                        <div class="select-wrapper form-column form-column-field">

                                            <ValidationProvider
                                                name="started_year"
                                                :rules="{ required : true }"
                                                v-slot="{ errors }"
                                            >
                                                <select class="select select-no-search" data-no-search
                                                        data-placeholder="Выбрать год"
                                                        v-model="completionRegistrationForm.started_year"
                                                        onfocus="this.size=8;"
                                                        onblur="this.size=1;"
                                                        onchange="this.size=1; this.blur();"
                                                >
                                                    <option disabled>- Выбрать год</option>
                                                    <option :value="nextYear"
                                                            v-for="nextYear in yearsSelectionArray"
                                                            :key="nextYear">
                                                        {{ nextYear }}
                                                    </option>
                                                </select>
                                                <p class="validation_error">{{ clearErrorMessage(errors[0]) }}</p>
                                            </ValidationProvider>

                                        </div>
                                        <div class="form-column form-column-text">
                                            <div class="form-text">Укажите в каком году вы начали заниматься
                                                фотографией.
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group form-submit flex">
                                    <button type="submit" class="btn btn--full btn-submit"
                                            id="registration_button_step_2">Продолжить регистрацию
                                    </button>
                                </div>
                            </div>

                            <div class="completion-registration__step" data-step="2"  v-show=" modal_completion_registration_step === 2">
                                <div class="completion-registration__avatar">
                                    <div class="completion-registration__avatar-img">
                                        <img src="/img/photo-avatar.png" alt="">
                                    </div>
                                    <div class="completion-registration__avatar-text">
                                        Формат изображения .png или .jpg размером не более 2мб
                                    </div>
                                </div>
                                <div class="form-group form-submit">
                                    <button type="submit" class="btn btn--full btn-submit"
                                            id="registration_button_step_3">Продолжить регистрацию
                                    </button>
                                    <button type="button" class="btn btn--full btn-skip"
                                            id="registration_button_skip_3">
                                        <span>Пропустить этот шаг</span>
                                        <svg viewBox="0 0 15 8" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.3536 3.64645C14.5488 3.84171 14.5488 4.15829 14.3536 4.35355L11.1716 7.53553C10.9763 7.7308 10.6597 7.7308 10.4645 7.53553C10.2692 7.34027 10.2692 7.02369 10.4645 6.82843L13.2929 4L10.4645 1.17157C10.2692 0.976311 10.2692 0.659728 10.4645 0.464466C10.6597 0.269204 10.9763 0.269204 11.1716 0.464466L14.3536 3.64645ZM0 3.5L14 3.5V4.5L0 4.5L0 3.5Z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="completion-registration__step" data-step="3" v-show=" modal_completion_registration_step === 3">
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
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-2.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-3.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-4.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-5.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-6.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-7.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-8.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-9.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-10.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-11.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-12.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-13.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-14.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-15.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-16.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-17.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="upload-image">
                                            <div class="upload-image__img">
                                                <img src="/img/gallery-upload/img-18.jpg" alt="">
                                            </div>
                                            <div class="upload-image__remove" title="Удалить">
                                                <svg viewBox="0 0 14 16" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M5.5 7.22222V11.8889M8.5 7.22222V11.8889M1 4.11111H13M12.25 4.11111L11.5997 13.5549C11.5728 13.9473 11.4035 14.3146 11.1258 14.5828C10.8482 14.8509 10.4829 15 10.1035 15H3.8965C3.5171 15 3.1518 14.8509 2.87416 14.5828C2.59653 14.3146 2.42719 13.9473 2.40025 13.5549L1.75 4.11111H12.25ZM9.25 4.11111V1.77778C9.25 1.5715 9.17098 1.37367 9.03033 1.22781C8.88968 1.08194 8.69891 1 8.5 1H5.5C5.30109 1 5.11032 1.08194 4.96967 1.22781C4.82902 1.37367 4.75 1.5715 4.75 1.77778V4.11111H9.25Z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <label class="completion-registration__images-upload">
                                        <svg class="icon icon-cloud">
                                            <use xlink:href="/img/icons.svg#cloud"/>
                                        </svg>
                                        <span>Можно добавить 20 фотографий, затем по 2 в неделю. <br>
                Чтобы добавить больше, оформите <a href="">подписку на PRO</a>.</span>
                                    </label>

                                </div>
                                <div class="form-group form-submit">
                                    <button type="submit" class="btn btn--full btn-submit">Перейти к настройкам
                                        фотографий
                                    </button>
                                    <a href="#" class="btn btn--full btn-skip">
                                        <span>Добавить позже в личном кабинете</span>
                                        <svg viewBox="0 0 15 8" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.3536 3.64645C14.5488 3.84171 14.5488 4.15829 14.3536 4.35355L11.1716 7.53553C10.9763 7.7308 10.6597 7.7308 10.4645 7.53553C10.2692 7.34027 10.2692 7.02369 10.4645 6.82843L13.2929 4L10.4645 1.17157C10.2692 0.976311 10.2692 0.659728 10.4645 0.464466C10.6597 0.269204 10.9763 0.269204 11.1716 0.464466L14.3536 3.64645ZM0 3.5L14 3.5V4.5L0 4.5L0 3.5Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                        </form>
                    </ValidationObserver>

                </div>
            </div>
            <!-- modal-completion-registration -->


        </modal>
        <!-- confirmation-code-modal -->

        <modal name="confirmation-code-modal" :height="modalConfirmationCodeHeight" :width="modalConfirmationCodeWidth"
               transition="pop-out">
            <div id="modal-confirmation-email" class="modal modal-confirmation" style="display: inline-block;">
                <div class="modal-title">

                    <div class="row">
                        <div class="col-10">
                            Подтверждение почты
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <a class="close-modal " @click.prevent="hideConfirmationModal()">
                                <svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10 1.17838L8.82162 0L4.99999 3.82161L1.17838 0L0 1.17838L3.82161 4.99999L0 8.82162L1.17838 10L4.99999 6.17839L8.8216 10L9.99997 8.82162L6.17839 4.99999L10 1.17838Z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="form-confirmation">
                    <form @submit.prevent="makeConfirmationCodeStep2">
                        <div class="form-text">
                            Мы отправили на почту письмо с кодом для подтверждения регистрации.
                        </div>
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" placeholder="Введите код"
                                   v-model="confirmation_code" autocomplete="off">
                        </div>
                        <div class="form-group form-submit flex justify-center">
                            <button type="submit" class="btn btn&#45;&#45;full btn-submit"
                                    id="button_confirmation_email">Подтвердить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </modal>
        <!-- confirmation-code-modal -->

        <modal name="register-modal" :height="modalLoginHeight" :width="modalLoginWidth" transition="pop-out">

            <div id="modal-registration" class="modal modal-registration" style="display: inline-block;">
                <div class="modal-title">

                    <div class="row">
                        <div class="col-10">
                            Регистрация
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <a class="close-modal " @click.prevent="hideRegisterModal()">
                                <svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10 1.17838L8.82162 0L4.99999 3.82161L1.17838 0L0 1.17838L3.82161 4.99999L0 8.82162L1.17838 10L4.99999 6.17839L8.8216 10L9.99997 8.82162L6.17839 4.99999L10 1.17838Z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <!--                    -->
                </div>
                <div class="form-registration">

                    <ValidationObserver
                        ref="registerFormObserverForm"
                        v-slot="{handleSubmit}"
                    >
                        <form @submit.prevent="makeRegisterStep1">
                            <!--                                registerForm::{{ registerForm}}-->
                            <div class="form-group">
                                <ValidationProvider
                                    name="email"
                                    :rules="{ required : true, email : true, max:100 }"
                                    v-slot="{ errors }"
                                >
                                    <input type="text" class="form-control" placeholder="Введите свой Email"
                                           id="register_email"
                                           v-model="registerForm.email" autocomplete="off">
                                    <p class="validation_error">{{ clearErrorMessage(errors[0]) }}</p>
                                </ValidationProvider>
                            </div>


                            <div class="form-group">
                                <ValidationProvider
                                    name="password"
                                    rules="required|min:8|confirmed:password_confirmation"
                                    v-slot="{ errors }"
                                >
                                    <input type="password" v-model="registerForm.password" id="password" name="password"
                                           class="form-control editable_field"
                                           placeholder="Введите свой пароль"
                                           ref="password_confirmation"
                                           autocomplete=off
                                    >
                                    <p class="validation_error">{{ clearErrorMessage(errors[0]) }}</p>
                                </ValidationProvider>
                            </div>

                            <div class="form-group">
                                <ValidationProvider
                                    name="password_confirmation"
                                    rules="required|min:8|confirmed:password"
                                    v-slot="{ errors }"
                                >
                                    <input type="password"
                                           v-model="registerForm.password_confirmation"
                                           id="password_confirmation"
                                           name="password_confirmation"
                                           class="form-control editable_field"
                                           placeholder="Введите подтверждение пароля"
                                           autocomplete=off
                                           ref="password"
                                    >
                                    <p class="validation_error">{{ clearErrorMessage(errors[0]) }}</p>
                                </ValidationProvider>
                            </div>

                            <div class="form-group form-link">
                                <a style="cursor: pointer;" @click.prevent="showLoginModal()">
                                    У меня уже есть аккаунт
                                </a>
                            </div>

                            <div class="form-group form-submit flex">
                                <button type="submit" class="btn btn--full btn-submit"
                                        id="registration_button_submit">
                                    Регистрация
                                </button>
                            </div>

                            <div class="signin-social">
                                <div class="signin-social__title">Войти через соц. сети:</div>
                                <ul class="signin-social__list flex justify-center">
                                    <li><a href="" class="google">
                                        <svg class="icon icon-google">
                                            <use xlink:href="/img/icons.svg#google"></use>
                                        </svg>
                                    </a></li>
                                    <li><a href="" class="facebook">
                                        <svg class="icon icon-facebook">
                                            <use xlink:href="/img/icons.svg#facebook"></use>
                                        </svg>
                                    </a></li>
                                    <li><a href="" class="vk">
                                        <svg class="icon icon-vk">
                                            <use xlink:href="/img/icons.svg#vk"></use>
                                        </svg>
                                    </a></li>
                                </ul>
                            </div>
                        </form>
                    </ValidationObserver>


                </div>
            </div>

        </modal>
        <!-- register-modal -->


        <modal name="login-modal" :height="modalLoginHeight" :width="modalLoginWidth" transition="pop-out">
            <div id="modal-signin" class="modal modal-signin" style="display: inline-block;">
                <div class="modal-title">
                    <div class="row">
                        <div class="col-10">
                            Вход
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <a class="close-modal " @click.prevent="hideLoginModal()">
                                <svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10 1.17838L8.82162 0L4.99999 3.82161L1.17838 0L0 1.17838L3.82161 4.99999L0 8.82162L1.17838 10L4.99999 6.17839L8.8216 10L9.99997 8.82162L6.17839 4.99999L10 1.17838Z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="form-signin">
                    <form @submit.prevent="makeLogin">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Email или телефон" required=""
                                   id="login_email"
                                   v-model="loginForm.email" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Пароль" required=""
                                   id="login_password"
                                   v-model="loginForm.password" autocomplete="off">
                        </div>

                        <div class="form-group form-submit flex justify-center">
                            <button type="submit" class="btn btn-submit">Войти</button>
                        </div>
                        <div class="signin-social">
                            <div class="signin-social__title">Войти через соц. сети 3:</div>
                            <ul class="signin-social__list flex justify-center">
                                <li><a href="" class="google">
                                    <svg class="icon icon-google">
                                        <use xlink:href="/img/icons.svg#google"></use>
                                    </svg>
                                </a></li>
                                <li><a href="" class="facebook">
                                    <svg class="icon icon-facebook">
                                        <use xlink:href="/img/icons.svg#facebook"></use>
                                    </svg>
                                </a></li>
                                <li><a href="" class="vk">
                                    <svg class="icon icon-vk">
                                        <use xlink:href="/img/icons.svg#vk"></use>
                                    </svg>
                                </a></li>
                            </ul>
                        </div>
                        <div class="form-group form-link">
                            <a @click.prevent="showRegisterModal()" style="cursor: pointer;">
                                Регистрация
                            </a>
                        </div>
                        <div class="restore-password flex justify-center">
                            <a class="restore-password__link" @click.prevent="showRestorePasswordModal()"
                               style="cursor: pointer;">
                                Восстановить пароль
                            </a>
                        </div>
                    </form>
                </div>
            </div>

        </modal>
        <!-- login-modal -->


        <modal name="restore-password-modal" :height="modalRestorePasswordHeight" :width="modalLoginWidth"
               transition="pop-out">

            <div id="modal-restore-password" class="modal modal-restore" style="display: inline-block;">

                <div class="form-restore">

                    <ValidationObserver
                        ref="restorePasswordObserverForm"
                        v-slot="{handleSubmit}"
                    >

                        <form @submit.prevent="makeRestorePassword">
                            <div class="form-restore__main" id="restore_main">

                                <div class="modal-title">
                                    <div class="row">
                                        <div class="col-10">
                                            Восстановить пароль
                                        </div>
                                        <div class="col-2 d-flex justify-content-end">
                                            <a class="close-modal " @click.prevent="hideRestorePasswordModal()">
                                                <svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M10 1.17838L8.82162 0L4.99999 3.82161L1.17838 0L0 1.17838L3.82161 4.99999L0 8.82162L1.17838 10L4.99999 6.17839L8.8216 10L9.99997 8.82162L6.17839 4.99999L10 1.17838Z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group form-text">
                                    <!--                                    restore_password_email::{{ restore_password_email }}-->
                                    Укажите почту или телефон который использовался при регистрации
                                </div>
                                <div class="form-group">
                                    <input
                                        type="text" name="login" class="form-control"
                                        placeholder="Еmail или телефон"
                                        v-model="restore_password_email"
                                        autocomplete="off"
                                    >
                                </div>

                                <div class="form-group form-submit flex justify-center">
                                    <button type="submit" class="btn btn--full btn-submit" id="restore_button_next">
                                        Продолжить
                                    </button>
                                </div>
                            </div>
                        </form>

                    </ValidationObserver> <!-- restorePasswordObserverForm -->


                    <div class="form-restore__confirmation" id="restore_confirmation" style="display:none">
                        <div class="modal-title">
                            Восстановить пароль
                        </div>
                        <div class="form-restore__confirmation-flex">
                            <div class="form-restore__confirmation-number">+7 468 998 47 55</div>
                            <a href="javascript:" class="form-restore__confirmation-edit"
                               id="restore_button_edit_number" title="Редактировать">
                                <svg class="icon icon-edit-2">
                                    <use xlink:href="img/icons.svg#edit-2"></use>
                                </svg>
                            </a>
                        </div>
                        <div class="form-restore__confirmation-flex">
                            <input type="text" class="form-restore__confirmation-code form-control"
                                   placeholder="Код из СМС">
                            <div class="form-restore__confirmation-timer">
                                Код действителен еще:
                                <span>9 мин. 33 сек.</span>
                            </div>
                        </div>


                        <div class="form-group form-submit flex justify-center">
                            <button type="submit" class="btn btn--full btn-submit"
                                    id="restore_button_confirmation">Подтвердить 1
                            </button>
                        </div>
                    </div>
                    <div class="form-restore__edit" id="restore_edit_number" style="display:none">
                        <div class="modal-title">
                            Редактировать номер
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-restore__edit-number form-control"
                                   value="+7 468 998 47 55"
                                   autocomplete="off">
                        </div>
                        <div class="form-group form-submit">
                            <button type="button" class="btn btn--full btn-submit"
                                    id="restore_button_edit_save">Сохранить 3
                            </button>
                            <!--                                    <button type="button" class="btn btn&#45;&#45;full form-restore__edit-back"-->
                            <!--                                            id="restore_button_back">-->
                            <!--                                        <svg viewBox="0 0 15 8" xmlns="http://www.w3.org/2000/svg">-->
                            <!--                                            <path-->
                            <!--                                                d="M0.646446 3.64645C0.451184 3.84171 0.451184 4.15829 0.646446 4.35355L3.82843 7.53553C4.02369 7.7308 4.34027 7.7308 4.53553 7.53553C4.7308 7.34027 4.7308 7.02369 4.53553 6.82843L1.70711 4L4.53553 1.17157C4.7308 0.976311 4.7308 0.659728 4.53553 0.464466C4.34027 0.269204 4.02369 0.269204 3.82843 0.464466L0.646446 3.64645ZM15 3.5L1 3.5V4.5L15 4.5V3.5Z"></path>-->
                            <!--                                        </svg>-->
                            <!--                                        <span>Назад</span>-->
                            <!--                                    </button>-->
                        </div>
                    </div>

                </div>

            </div>

        </modal>
        <!-- restore-password-modal -->


        <div class="wrapper__content">

            <div class="header-wrapper">
                <header class="header ">
                    <div class="container">
                        <div class="header__wrapper">
                            <a href="/" class="header__logo">
                                <svg width="45" height="29">
                                    <use xlink:href="/img/sprite.svg#logo"></use>
                                </svg>
                            </a>
                            <nav :class="'header__nav ' + (is_menu_hidden ? 'active' : '' )">
                                <div class="header__nav-menu">
                                    <a href="/photos" class="header__nav-link">Фотографии</a>
                                    <a href="/nominations" class="header__nav-link">Номинации</a>
                                    <a href="#" class="header__nav-link color">Party</a>
                                    <a href="photographers.html" class="header__nav-link">Фотографы</a>
                                </div>
                            </nav>
                            <div class="header__content">

                                <template v-if="!$page.props.user">
                                    <a class="header__signIn" @click.prevent="showLoginModal()">
                                        <span>Войти</span>
                                    </a>
                                </template>

                                <a href="#" class="header__notifications active">
                                    <svg width="17" height="17">
                                        <use xlink:href="/img/sprite.svg#notifications"></use>
                                    </svg>
                                    <span class="mark"></span>
                                </a>
                                <a :href="route('profile.index') " class="header__user active">
                                    <svg width="22" height="22" class="header__user-icon">
                                        <use xlink:href="/img/sprite.svg#user"></use>
                                    </svg>
                                    <img src="/img/user.jpg" class="header__user-img" alt="">
                                </a>
                                <a href="photographers.html" class="header__search">
                                    <svg width="15" height="15">
                                        <use xlink:href="/img/sprite.svg#search"></use>
                                    </svg>
                                </a>
                                <button :class="'header__btn-menu ' + (is_menu_hidden ? 'active' : '' )"
                                        @click.prevent="toggleHeaderNavMenu()">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </header>
            </div>

        </div> <!-- <div class="wrapper__content">-->

        <slot></slot>

        <footer class="footer ">
            <div class="footer__box">
                <div class="container">
                    <div class="footer__box_wrap">
                        <div class="footer__block">
                            <p class="footer__block-title">Популярные теги:</p>
                            <div class="footer__tags">
                                <a href="#" class="footer__tags-link">#архитектура</a>
                                <a href="#" class="footer__tags-link">#традиции</a>
                                <a href="#" class="footer__tags-link">#свет</a>
                                <a href="#" class="footer__tags-link">#кольца</a>
                                <a href="#" class="footer__tags-link">#невеста</a>
                                <a href="#" class="footer__tags-link">#жених</a>
                                <a href="#" class="footer__tags-link">#свадьба</a>
                                <a href="#" class="footer__tags-link">#банкет</a>
                                <a href="#" class="footer__tags-link">#море</a>
                                <a href="#" class="footer__tags-link">#луна</a>
                                <a href="#" class="footer__tags-link">#традиции</a>
                                <a href="#" class="footer__tags-link">#свет</a>
                                <a href="#" class="footer__tags-link">#кольца</a>
                                <a href="#" class="footer__tags-link">#невеста</a>
                                <a href="#" class="footer__tags-link">#жених</a>
                            </div>
                        </div>
                        <div class="footer__block">
                            <p class="footer__block-title">Найди фотографа в своём городе:</p>
                            <div class="footer__cities">
                                <a href="#" class="footer__cities-link">Архангельск</a>
                                <a href="#" class="footer__cities-link">Астрахань</a>
                                <a href="#" class="footer__cities-link">Балашиха</a>
                                <a href="#" class="footer__cities-link">Барнаул</a>
                                <a href="#" class="footer__cities-link">Белгород</a>
                                <a href="#" class="footer__cities-link">Брянск</a>
                                <a href="#" class="footer__cities-link">Владивосток</a>
                                <a href="#" class="footer__cities-link">Владимир</a>
                                <a href="#" class="footer__cities-link">Волгоград</a>
                                <a href="#" class="footer__cities-link">Вологда</a>
                                <a href="#" class="footer__cities-link">Воронеж</a>
                                <a href="#" class="footer__cities-link">Екатеринбург</a>
                                <a href="#" class="footer__cities-link">Зеленоград</a>
                                <a href="#" class="footer__cities-link">Иваново</a>
                                <a href="#" class="footer__cities-link">Ижевск</a>
                                <a href="#" class="footer__cities-link">Иркутск</a>
                                <a href="#" class="footer__cities-link">Казань</a>
                                <a href="#" class="footer__cities-link">Калининград</a>
                                <a href="#" class="footer__cities-link">Калуга</a>
                                <a href="#" class="footer__cities-link">Кемерово</a>
                                <a href="#" class="footer__cities-link">Киров</a>
                                <a href="#" class="footer__cities-link">Коломна</a>
                                <a href="#" class="footer__cities-link">Краснодар</a>
                                <a href="#" class="footer__cities-link">Красноярск</a>
                                <a href="#" class="footer__cities-link">Курск</a>
                                <a href="#" class="footer__cities-link">Липецк</a>
                                <a href="#" class="footer__cities-link">Магнитогорск</a>
                                <a href="#" class="footer__cities-link">Махачкала</a>
                                <a href="#" class="footer__cities-link">Москва</a>
                                <a href="#" class="footer__cities-link">Набережные</a>
                                <a href="#" class="footer__cities-link">Челны</a>
                                <a href="#" class="footer__cities-link">Нижний</a>
                                <a href="#" class="footer__cities-link">Новгород</a>
                                <a href="#" class="footer__cities-link">Новокузнецк</a>
                                <a href="#" class="footer__cities-link">Новороссийск</a>
                                <a href="#" class="footer__cities-link">Новосибирск</a>
                                <a href="#" class="footer__cities-link">Омск</a>
                                <a href="#" class="footer__cities-link">Оренбург</a>
                                <a href="#" class="footer__cities-link">Орёл</a>
                                <a href="#" class="footer__cities-link">Пенза</a>
                                <a href="#" class="footer__cities-link">Пермь</a>
                                <a href="#" class="footer__cities-link">Подольск</a>
                                <a href="#" class="footer__cities-link">Пятигорск</a>
                                <a href="#" class="footer__cities-link">Ростов-на-Дону</a>
                                <a href="#" class="footer__cities-link">Рязань</a>
                                <a href="#" class="footer__cities-link">Самара</a>
                                <a href="#" class="footer__cities-link">Санкт-Петербург</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer__content">
                <div class="container">
                    <div class="footer__content_wrap">
                        <div class="footer__left_part">
                            <a href="#" class="footer__logo">
                                <svg width="31" height="32">
                                    <use xlink:href="/img/sprite.svg#logo-footer"></use>
                                </svg>
                            </a>
                            <nav class="footer__nav">
                                <div class="footer__nav_list">
                                    <a href="nomination.html" class="footer__nav-link">Фотографии</a>
                                    <a href="/nominations" class="footer__nav-link">Номинации</a>
                                    <a href="about_us.html" class="footer__nav-link">О нас</a>
                                </div>
                                <div class="footer__nav_list">
                                    <a href="photographers.html" class="footer__nav-link">Фотографы</a>
                                    <a href="#" class="footer__nav-link">Party</a>
                                    <a href="#" class="footer__nav-link">Политика конфиденциальности</a>
                                </div>
                            </nav>
                        </div>
                        <div class="footer__right_part">
                            <div class="footer__socials">
                                <a href="#" class="footer__socials-link">
                                    <svg width="15" height="15">
                                        <use xlink:href="/img/sprite.svg#socials-instagram"></use>
                                    </svg>
                                </a>
                                <a href="#" class="footer__socials-link">
                                    <svg width="14" height="8">
                                        <use xlink:href="/img/sprite.svg#socials-vk"></use>
                                    </svg>
                                </a>
                                <a href="#" class="footer__socials-link">
                                    <svg width="15" height="10">
                                        <use xlink:href="/img/sprite.svg#socials-youtube"></use>
                                    </svg>
                                </a>
                                <a href="#" class="footer__socials-link">
                                    <svg width="14" height="11">
                                        <use xlink:href="/img/sprite.svg#socials-twitter"></use>
                                    </svg>
                                </a>
                            </div>
                            <p class="footer__copyright">© 2021 Платформа для креативных свадебных фотографов</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div> <!-- <div class="wrapper"> -->


</template>


<script>
import Vue from 'vue';

import VModal from 'vue-js-modal/dist/index.nocss.js'
import 'vue-js-modal/dist/styles.css'

Vue.use(VModal)
import appMixin from '../appMixin'


import {ValidationObserver, ValidationProvider, extend} from 'vee-validate'
import * as rules from 'vee-validate/dist/rules'

Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule])
})

import {localize} from 'vee-validate'
import ru from 'vee-validate/dist/locale/ru.json';

import Multiselect from "vue-multiselect";
import 'vue-multiselect/dist/vue-multiselect.min.css'

localize('ru');

localize({
    ru: {
        names: {
            email: 'Электрронная почта',
            password: 'Пароль',
            password_confirmation: 'Подтвердите пароль'
        },
        messages: {
            // required: (field) => field + ' - заполните поле',
            required: 'Заполните поле',
            min: 'Должно иметь не менее {length} символов',
            max: 'Должно иметь не более  {length} символов',
            email: 'Неправильный формат',
            integer: 'Неправильный формат целого числа',
            confirmed: 'Пароль и подтвердите пароль должны быть равными',
        }
    }
})

export default {
    mixins: [appMixin],

    components: {
        ValidationObserver,
        ValidationProvider,
        Multiselect
    },

    data() {
        return {
            innerWidth: window.innerWidth,
            innerHeight: window.innerHeight,
            selected_city_id: null,
            is_menu_hidden: false,
            yearsSelectionArray: [],
            citiesSelectionArray: [],

            modal_completion_registration_step: 1,
            completionRegistrationForm: {
                name: '',
                city_id: null,
                city_title: '',
                phone: '',
                hour_rate: 0,
                started_year: null,
            },
            confirmation_code: '',
            restore_password_email: '',
            registerForm: {
                email: '',
                // email: 'nilovsergey@yahoo.com',
                // email: 'testuser@server.com',
                password: '', // '11t11e1&11s',
                password_confirmation: '', // '11t11e1&11s',
            },
            loginForm: {
                email: '', // 'nilovsergey@yahoo.com',
                password: '', // '11t11e1&11s',
            }

        }
    },

    mounted() {
        // this.showRestorePasswordModal()
        // this.showCompletionRegistrationModal()
        // this.showLoginModal()
        // this.showRegisterModal()
        // this.showCompletionRegistrationModal()
    },

    methods: {
        toggleHeaderNavMenu: function () {
            this.is_menu_hidden = !this.is_menu_hidden
        },

        selected: function (v1) {
            if (this.isEmpty(v1)) {
                this.completionRegistrationForm.city_id = ''
            } else {
                this.completionRegistrationForm.city_id = v1.id
            }
        },


        logout() {
            this.$inertia.post(route('logout'));
        },

        showLoginModal() {
            console.log('showLoginModal::')

            this.hideRegisterModal()
            this.$modal.show('login-modal')
        },

        showCompletionRegistrationModal() {
            console.log('showCompletionRegistrationModal this.yearsSelectionArray::')

            Window.axios.get('/get_years_selection_array')
                .then(resp => {
                    this.yearsSelectionArray = resp.data.yearsSelectionArray
                    // console.log(this.yearsSelectionArray)
                    this.$modal.show('modal-completion-registration');
                })
                .catch(
                    function (error) {
                        console.error(error)
                    }
                )
        },


        /*  LOGIN BLOCK START */
        hideLoginModal() {
            this.$modal.hide('login-modal');
        },

        hideRegisterModal() {
            this.$modal.hide('register-modal');
        },

        hideConfirmationModal() {
            this.$modal.hide('confirmation-code-modal');
        },

        hideCompletionRegistrationModal() {
            this.$modal.hide('modal-completion-registration');
            this.completionRegistrationForm.name
            this.completionRegistrationForm.city_id = ''
            this.completionRegistrationForm.city_title = ''
            this.completionRegistrationForm.phone = ''
            this.completionRegistrationForm.hour_rate = ''
            this.completionRegistrationForm.started_year = ''
        },

        makeLogin(login_from_register, register_email, register_password) {
            // console.log('login_from_register::')
            // console.log(login_from_register)
            console.log(typeof login_from_register)
            if (typeof login_from_register != "undefined" && login_from_register && typeof register_email != "undefined"  && typeof register_password != "undefined" ) {
                // console.log('INSIDE::')
                // console.log('this.registerForm::')
                // console.log(this.registerForm)
                this.loginForm.email = register_email
                this.loginForm.password = register_password
            }
            // console.log('this.loginForm::')
            // console.log(this.loginForm)

            Window.axios.post('/login', this.loginForm)
                .then(resp => {
                    // Swal.fire({
                    //     icon: 'success',
                    //     title: 'Вход в систему',
                    //     text: 'Вы успешно залогинились'
                    // })
                    this.$inertia.visit(route('profile.index'), {method: 'get'});
                })
                .catch(
                    function (error) {
                        console.error(error)
                        // Swal.fire({
                        //         title: 'Вход в систему',
                        //         text: 'Ошибка логина. Проверьте параметры логина ! ',
                        //         icon: 'error'
                        //     }
                        // )
                    }
                )
        },   // makeLogin() {
        /*  LOGIN BLOCK END */


        showRegisterModal() {
            console.log('showRegisterModal this.confirmation_code::')
            console.log( this.confirmation_code )

            console.log('showRegisterModal this.registerForm.email::')
            console.log( this.registerForm.email )

            /*             confirmation_code: '',
            restore_password_email: '',
            registerForm: {
                // email: '',
                email: 'nilovsergey@yahoo.com',
 */
            this.$modal.hide('login-modal');
            // if (this.isEmpty(v1)) {

            if ( !this.isEmpty(this.confirmation_code) && !this.isEmpty(this.registerForm.email) ) {
                this.$modal.show('modal-completion-registration');
            } else {
                this.$modal.show('register-modal');
            }
        },

        makeRegisterStep1() {
            this.$refs.registerFormObserverForm.validate().then(success => {
                if (!success) {
                    return
                }

                Window.axios.post('/auth/register', this.registerForm)
                    .then(resp => {
                        this.$modal.hide('register-modal');
                        this.$modal.show('confirmation-code-modal');

                        // Swal.fire({
                        //     icon: 'success',
                        //     title: 'Регистрация',
                        //     text: resp.data.message
                        // })


                    })
                    .catch(
                        function (error) {
                            console.error(error)
                            Swal.fire({
                                    title: 'Ошибка регистрации',
                                    text: error.response.data.message,
                                    icon: 'error'
                                }
                            )
                        }
                    )

            }) // this.$refs.registerFormObserverForm.validate().then(success => {

        },   // makeRegisterStep1() {

        makeConfirmationCodeStep2() {
            Window.axios.post('/auth/confirm_code', {
                confirmation_code: this.confirmation_code,
                email: this.registerForm.email
            })
                .then(resp => {
                    this.citiesSelectionArray = resp.data.citiesSelectionArray
                    this.$modal.hide('confirmation-code-modal');
                    // this.$modal.show('modal-completion-registration');
                    this.showCompletionRegistrationModal()

                    // Swal.fire({
                    //     icon: 'success',
                    //     title: 'Подтверждение регистрации',
                    //     text: resp.data.message
                    // })
                })
                .catch(
                    function (error) {
                        console.error(error)
                        // Swal.fire({
                        //         title: 'Подтверждение регистрации',
                        //         text: 'Ошибка подтверждения регистрации. Проверьте введенный код ! ',
                        //         icon: 'error'
                        //     }
                        // )
                    }
                )
        },   // makeConfirmationCodeStep2() {


        completionRegistrationStep3() {
            console.log('completionRegistrationStep3 this.modal_completion_registration_step::')
            console.log(this.modal_completion_registration_step)

            if (this.modal_completion_registration_step == 1) {
                this.$refs.completionRegistrationObserverForm.validate().then(success => {
                    if (!success) {
                        return
                    }

                    this.completionRegistrationForm.email = this.registerForm.email
                    this.$refs.completionRegistrationObserverForm.validate().then(success => {
                        if (!success) {
                            return
                        }

                        this.completionRegistrationForm.city_id= this.selected_city_id.code

                        console.log('this.completionRegistrationForm::')
                        console.log(this.completionRegistrationForm)


                        Window.axios.post('/auth/completion_registration', this.completionRegistrationForm)
                            .then(resp => {
                                this.$modal.hide('modal-completion-registration');
                                this.$modal.show('login-modal');

                                // Swal.fire({
                                //     icon: 'success',
                                //     title: 'Завершение регистрации',
                                //     text: resp.data.message
                                // })
                                this.completionRegistrationForm.name = ''
                                this.completionRegistrationForm.city_title = ''
                                this.completionRegistrationForm.phone = ''
                                this.completionRegistrationForm.hour_rate = ''
                                this.completionRegistrationForm.city_id = ''
                                this.completionRegistrationForm.started_year = ''

                                this.makeLogin(true,  this.registerForm.email, this.registerForm.password )
                                this.confirmation_code = ''
                                this.registerForm.email = ''
                                this.registerForm.password = ''
                                this.registerForm.password_confirmation = ''
                            })
                            .catch(
                                function (error) {
                                    console.error(error)
                                    // Swal.fire({
                                    //         title: 'Завершение регистрации',
                                    //         text: 'Ошибка завершение регистрации',
                                    //         icon: 'error'
                                    //     }
                                    // )
                                }
                            )
                    }) // this.$refs.registerForm.validate().then(success => {
                })
            } // this.modal_completion_registration_step

            if (this.modal_completion_registration_step == 2) {
            } //             if (this.modal_completion_registration_step == 2) {

            if (this.modal_completion_registration_step == 3) {
            } //             if (this.modal_completion_registration_step == 3) {


        },  // completionRegistrationStep3() {


        showRestorePasswordModal() {
            // console.log('showRestorePasswordModal::')
            // this.$modal.hide('login-modal');
            // this.$modal.show('restore-password-modal');
        },
        makeRestorePassword() {
            console.log('makeRestorePassword success::')
            this.$refs.restorePasswordObserverForm.validate().then(success => {
                console.log(success)

                if (!success) {
                    return
                }
                console.log('this.restore_password_email::')
                console.log(this.restore_password_email)


                this.restorePasswordForm.email = this.restore_password_email
                this.$refs.restorePasswordObserverForm.validate().then(success => {
                    if (!success) {
                        return
                    }

                    Window.axios.post('/auth/restore_password', this.restore_password_email)
                        .then(resp => {
                            // this.$modal.hide('modal-completion-registration');
                            this.hideRestorePasswordModal = ''
                            // Swal.fire({
                            //     icon: 'success',
                            //     title: 'Восстановления пароля',
                            //     text: resp.data.message
                            // })
                        })
                        .catch(
                            function (error) {
                                console.error(error)
                                // Swal.fire({
                                //         title: 'Восстановления пароля',
                                //         text: 'Ошибка завершение регистрации',
                                //         icon: 'error'
                                //     }
                                // )
                            }
                        )
                }) // this.$refs.registerForm.validate().then(success => {
            })
        },  // makeRestorePassword() {
        hideRestorePasswordModal() {
            this.$modal.hide('confirmation-code-modal');
            this.restore_password_email = ''
        },

    }, // methods

    computed: {
        modalCompletionRegistrationHeight() {
            // console.log('modalCompletionRegistrationHeight this.innerHeight::')
            // console.log(this.innerHeight)
            //
            if(this.innerHeight < 600) {
                return 540;
            }
            return 630;
        },
        modalCompletionRegistrationWidth() {
            // console.log('modalCompletionRegistrationWidth this.innerWidth::')
            // console.log(this.innerWidth)
            if(this.innerWidth < 420) {
                return 280;
            }
            if(this.innerWidth <= 600) {
                return 560;
            }
            return 600;
        },

        modalConfirmationCodeHeight() {
            return 360;
        },
        modalLoginHeight() {
            return 500;
        },
        modalRestorePasswordHeight() {
            return 340;
        },
        modalLoginWidth() {
            // console.log('modalLoginWidth this.innerWidth::')
            // console.log(this.innerWidth)
            if(this.innerWidth < 420) {
                return 280;
            }

            return 400;
        },
        modalConfirmationCodeWidth() {
            // console.log('modalConfirmationCodeWidth this.innerWidth::')
            // console.log(this.innerWidth)
            if(this.innerWidth < 420) {
                return 280;
            }

            return 400;
        }
    }


}
</script>

