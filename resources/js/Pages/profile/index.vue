<template>
    <app-layout>

        <personal-top-menu current_page="profile_index"></personal-top-menu>

        <!--        is_photos_container_loaded::{{ is_photos_container_loaded }}<br>-->
        <!--        is_inactive_photos_container_loaded::{{ is_inactive_photos_container_loaded }}<br>-->
        <!--        total_inactive_photos_count::{{ total_inactive_photos_count }}<br>-->

        <modal name="photos-uploading-modal" :height="modalPhotosUploadingHeight" :width="modalPhotosUploadingWidth"
               transition="pop-out">
            <div id="modal-uploading-photos" class="modal modal-uploading-photos" style="display: inline-block;">

                <div class="uploading-photos-uploading">

                    <!--- PHOTOS UPLOADING BLOCK START --->
                    <div class="modal-overlay-one preview-btn-open">
                        <div class="modal-content">
                            <div class="overlay-close ">
                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none"
                                     xmlns="http://www.w3.org/2000/svg" @click.prevent="hidePhotosUploadingModal()">
                                    <path
                                        d="M10 1.17838L8.82162 0L4.99999 3.82161L1.17838 0L0 1.17838L3.82161 4.99999L0 8.82162L1.17838 10L4.99999 6.17839L8.8216 10L9.99997 8.82162L6.17839 4.99999L10 1.17838Z"
                                        fill="#AFAFAF"/>
                                </svg>
                            </div>
                            <div class="modal-content__title">Загрузка фото</div>
                            <div class="modal-content__text">Загрузите фотографии с вашими работами в хорошем качестве
                                в формате .png или .jpg
                            </div>
                            <div class="modal-content__photo">
                                <tr v-for="nextFile in imagePhotosUploadingFiles" :key="nextFile.name">
                                    <div class="modal-content__photo-item active"
                                         @click.prevent="deletePhotosUploading(nextFile.name)">
                                        <img :src="nextFile.blob" class="">
                                    </div>
                                </tr>
                            </div>
                            <label for="file" class="modal-content__download"
                                   v-show="getAllowedPhotosToUploadCount > 0">
                                <svg width="26" height="28" viewBox="0 0 26 28" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2.77818 17.8554C1.79951 17 1.17802 15.8216 1.03275 14.546C0.887492 13.2704 1.22868 11.9872 1.99095 10.9422C2.75322 9.89733 3.88297 9.16417 5.16376 8.88322C4.79318 7.19324 5.12435 5.42853 6.0844 3.9773C7.04446 2.52608 8.55476 1.50722 10.2831 1.14486C12.0114 0.782495 13.8161 1.10632 15.3002 2.04509C16.7843 2.98386 17.8263 4.46067 18.1969 6.15065H18.3301C19.9825 6.14903 21.5766 6.74783 22.8029 7.83082C24.0292 8.9138 24.8002 10.4037 24.9663 12.0113C25.1323 13.6189 24.6816 15.2294 23.7016 16.5303M16.9975 15.2722L12.9996 11.363M12.9996 11.363L9.00173 15.2722M12.9996 11.363V27"
                                        stroke="#1987EF" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>

                                Можно добавить еще {{ getAllowedPhotosToUploadCount }} фото
                            </label>
                            <div v-show="getAllowedPhotosToUploadCount > 0">
                                <!--                                accept="image/png,image/jpeg,image/jpg"-->
                                <file-upload
                                    ref="upload"
                                    v-model="imagePhotosUploadingFiles"
                                    post-action="/post.method"
                                    put-action="/put.method"
                                    @input-file="inputFilePhotosUploading"
                                    @input-filter="inputFilterPhotosUploading"
                                    :multiple="true"
                                    data-cy="file-input"
                                    :maximum="getAllowedPhotosToUploadCount"
                                >
                                </file-upload>
                            </div>

                            <div class="modal-content__tags">
                                <div class="modal-content__tags-title">Добавить теги</div>
                                <div class="modal-content__tags-list">
                                    <template v-for="nextTag in tags" >
                                        <input class="modal-content__tags-input" type="checkbox" :id="'cbx_tag_' + nextTag.id" :key="nextTag.id" v-model="nextTag.is_checked" />
                                        <label class="modal-content__tags-item" :for="'cbx_tag_' + nextTag.id">{{ nextTag.title }}</label>
                                    </template>
                                </div>
                            </div>
                            <div class="modal-content__footer">
                                <a @click.prevent="savePhotosUploadingModal()" class="modal-content__btn"
                                   style="cursor: pointer;">Сохранить</a>
                            </div>
                        </div>
                    </div>
                    <!--- PHOTOS UPLOADING BLOCK END --->


                </div> <!-- uploading-photos-uploading -->
            </div>

        </modal>
        <!-- photos-uploading-modal -->


        <modal name="change-avatar-modal" :height="modalChangeAvatarHeight" :width="modalChangeAvatarWidth"
               transition="pop-out">
            <div id="modal-uploading-avatar" class="modal modal-uploading-avatar" style="display: inline-block;">
                <div class="modal-title">
                    <div class="row">
                        <div class="col-10">
                            Загрузка аватара
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <a class="close-modal" @click.prevent="hideChangeAvatarModal()">
                                <svg viewBox="0 0 10 10" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M10 1.17838L8.82162 0L4.99999 3.82161L1.17838 0L0 1.17838L3.82161 4.99999L0 8.82162L1.17838 10L4.99999 6.17839L8.8216 10L9.99997 8.82162L6.17839 4.99999L10 1.17838Z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="uploading-avatar">
                    <div class="uploading-avatar__photo" v-show="imageFiles.length===0">
                        <img v-show="!$page.props.user.avatar_image_url" src="/img/default-avatar.png"
                             style="max-height: 180px; width: auto; margin: auto; display: block;">
                        <img v-show="$page.props.user.avatar_image_url" :src="avatar_image_url"
                             style="max-height: 180px; width: auto; margin: auto; display: block;">
                    </div>

                    <div class="uploading-avatar__photo" v-show="imageFiles.length>0">
                        <table class="m-2 p-0" v-show="imageFiles.length > 0">
                            <tr v-for="nextFile in imageFiles" :key="nextFile.name">
                                <img :src="nextFile.blob" class="img-preview-wrapper img_full_width_wrapper"
                                     style="max-height: 180px; width: auto"/>
                            </tr>
                        </table>
                    </div>


                    <div class="uploading-avatar__control" v-show="imageFiles.length == 0">
                        <label class="uploading-avatar__uploading">
                            <svg class="icon icon-plus">
                                <use xlink:href="/img/icons.svg#plus"/>
                            </svg>

                            <div>
                                <file-upload
                                    ref="upload"
                                    v-model="imageFiles"
                                    post-action="/post.method"
                                    put-action="/put.method"
                                    @input-file="inputFile"
                                    @input-filter="inputFilter"
                                    :multiple="false"
                                    data-cy="file-input"
                                >
                                    <span>Загрузить новое</span>
                                </file-upload>
                            </div>

                        </label>

                        <button type="button" class="uploading-avatar__remove" @click.prevent="deleteAvatar()">
                            <svg class="icon icon-basket">
                                <use xlink:href="/img/icons.svg#basket"/>
                            </svg>
                            <span>Удалить</span>
                        </button>

                    </div>
                    <div class="uploading-avatar__save" v-show="imageFiles.length > 0">
                        <a @click.prevent="saveAvatar()" class="uploading-avatar__save-btn btn">Сохранить</a>
                    </div>

                </div>
            </div>

        </modal>
        <!-- change-avatar-modal -->


        <div class="photographer_page photographer_profile">
            <div class="container">
                <div class="photographer_page__wrap">
                    <div class="photographer_page__profile">
                        <div class="photographers__user photographer_page__user">
                            <div class="user_info verified pro">
                                <div class="user_info__img">
                                    <img v-show="!avatar_image_url" src="/img/default-avatar.png" alt=""
                                         style="max-height: 200px; margin: auto; display: block;">
                                    <img v-show="avatar_image_url" :src="avatar_image_url" alt=""
                                         style="max-height: 200px; margin: auto; display: block;">

                                    <a class="user_info__img-uploading" @click.prevent="showChangeAvatarModal()">
                                        <svg class="icon icon-photo">
                                            <use xlink:href="/img/icons.svg#photo"/>
                                        </svg>
                                    </a>
                                </div>

                                <div class="user_info__content">

                                    <div class="user_info__head">
                                        <div class="user_info__name">
                                            <p class="user_info__name-text">
                                                {{ loggedUser.name }}
                                            </p>
                                            <span class="user_info__statuses">
                                                <i class="icon icon-verified" title="Пользователь верифицирован"
                                                   data-tooltip=""></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="user_info__position">
                                        <div class="user_info__position-item gold">
                                            <i>1</i>
                                            <p>Место в каталоге</p>
                                        </div>
                                        <div class="user_info__position-item">
                                            <i>12</i>
                                            <template v-if="userProfile.city">
                                                <p>{{ userProfile.city.address }}</p>
                                            </template>
                                        </div>
                                    </div>

                                    <div class="user_info__nominations photographer_page__nominations"
                                         v-if="mostNominatedPhotos.length > 0">
                                        <div class="user_info__nominations-list">

                                            <div class="user_info__nominations-item"
                                                 v-for="nextMostNominatedPhoto in mostNominatedPhotos">
                                                <div
                                                    class="sticker_mark user_info__nominations-sticker_mark tooltipstered"
                                                    :title="nextMostNominatedPhoto.nomination.title"
                                                    :style="'fill : ' +nextMostNominatedPhoto.nomination.color+'  !important; color: white !important;'">
                                                    <svg class="sticker_mark__bg">
                                                        <use xlink:href="/img/sprite.svg#sticker_mark"></use>
                                                    </svg>
                                                    <svg class="sticker_mark__lightning">
                                                        <use xlink:href="/img/sprite.svg#lightning"></use>
                                                    </svg>
                                                </div>

                                                <p class="user_info__nominations-quantity">
                                                    {{ nextMostNominatedPhoto.photo_nominations_count }}
                                                </p>
                                            </div>

                                        </div>

                                        <a href="#" class="user_info__nominations-more" style="cursor: pointer;">ещё
                                            номинации</a>
                                    </div>

                                    <div class="user_info__info" v-if="userProfile.hour_rate">
                                        <a :href="`mailto: ${loggedUser.email}`"
                                           class="user_info__email">{{ loggedUser.email }}</a>
                                        <p class="user_info__price">Цена работы за час: <span>
                                            {{ userProfile.hour_rate }} ₽</span>
                                        </p>
                                    </div>


                                    <div class="user_info__links">
                                        <a :href="userProfile.instagram"
                                           class="user_info__links-btn user_info__links-instagram">
                                            <svg class="icon icon-instagram" viewBox="0 0 21 21" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14.8999 0H6.10017C2.73652 0 0 2.73652 0 6.10017V14.8998C0 18.2635 2.73652 21 6.10017 21H14.8998C18.2635 21 21 18.2635 21 14.8999V6.10017C21 2.73652 18.2635 0 14.8999 0ZM19.3594 14.8998C19.3594 17.3588 17.3588 19.3594 14.8999 19.3594H6.10017C3.64116 19.3594 1.64062 17.3588 1.64062 14.8999V6.10017C1.64062 3.64116 3.64116 1.64062 6.10017 1.64062H14.8998C17.3588 1.64062 19.3594 3.64116 19.3594 6.10017V14.8998Z"
                                                    fill="url(#paint0_linear)"/>
                                                <path
                                                    d="M10.5 4.83984C7.37896 4.83984 4.83984 7.37896 4.83984 10.5C4.83984 13.621 7.37896 16.1602 10.5 16.1602C13.621 16.1602 16.1602 13.621 16.1602 10.5C16.1602 7.37896 13.621 4.83984 10.5 4.83984ZM10.5 14.5195C8.28364 14.5195 6.48047 12.7164 6.48047 10.5C6.48047 8.28364 8.28364 6.48047 10.5 6.48047C12.7164 6.48047 14.5195 8.28364 14.5195 10.5C14.5195 12.7164 12.7164 14.5195 10.5 14.5195Z"
                                                    fill="url(#paint1_linear)"/>
                                                <path
                                                    d="M16.2422 5.57812C16.6952 5.57812 17.0625 5.21086 17.0625 4.75781C17.0625 4.30477 16.6952 3.9375 16.2422 3.9375C15.7891 3.9375 15.4219 4.30477 15.4219 4.75781C15.4219 5.21086 15.7891 5.57812 16.2422 5.57812Z"
                                                    fill="url(#paint2_linear)"/>
                                                <defs>
                                                    <linearGradient id="paint0_linear" x1="19" y1="1.5"
                                                                    x2="-1.16229e-06" y2="21"
                                                                    gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#AF13A4"/>
                                                        <stop offset="0.302083" stop-color="#BF0985"/>
                                                        <stop offset="0.723958" stop-color="#F04815"/>
                                                        <stop offset="1" stop-color="#FED819"/>
                                                    </linearGradient>
                                                    <linearGradient id="paint1_linear" x1="19" y1="1.5"
                                                                    x2="-1.16229e-06" y2="21"
                                                                    gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#AF13A4"/>
                                                        <stop offset="0.302083" stop-color="#BF0985"/>
                                                        <stop offset="0.723958" stop-color="#F04815"/>
                                                        <stop offset="1" stop-color="#FED819"/>
                                                    </linearGradient>
                                                    <linearGradient id="paint2_linear" x1="19" y1="1.5"
                                                                    x2="-1.16229e-06" y2="21"
                                                                    gradientUnits="userSpaceOnUse">
                                                        <stop stop-color="#AF13A4"/>
                                                        <stop offset="0.302083" stop-color="#BF0985"/>
                                                        <stop offset="0.723958" stop-color="#F04815"/>
                                                        <stop offset="1" stop-color="#FED819"/>
                                                    </linearGradient>
                                                </defs>
                                            </svg>
                                            <span style="white-space: pre;">{{ userProfile.instagram }}</span>
                                        </a>
                                    </div>
                                </div>


                                <div class="">
                                    <table class="">
                                        <tr v-if="userProfile.facebook">
                                            <td style="padding: 8px;">
                                                <div class="form-input-social__head">
                                                    <div class="form-input-social__icon">

                                                        <svg class="icon icon-facebook" style="fill : #ff330b;">
                                                            <use xlink:href="/img/icons.svg#facebook"/>
                                                            <defs>
                                                                <linearGradient id="paint0_linear" x1="19" y1="1.5"
                                                                                x2="-1.16229e-06" y2="21"
                                                                                gradientUnits="userSpaceOnUse">
                                                                    <stop stop-color="#AF13A4"/>
                                                                    <stop offset="0.302083" stop-color="#BF0985"/>
                                                                    <stop offset="0.723958" stop-color="#F04815"/>
                                                                    <stop offset="1" stop-color="#FED819"/>
                                                                </linearGradient>
                                                                <linearGradient id="paint1_linear" x1="19" y1="1.5"
                                                                                x2="-1.16229e-06" y2="21"
                                                                                gradientUnits="userSpaceOnUse">
                                                                    <stop stop-color="#AF13A4"/>
                                                                    <stop offset="0.302083" stop-color="#BF0985"/>
                                                                    <stop offset="0.723958" stop-color="#F04815"/>
                                                                    <stop offset="1" stop-color="#FED819"/>
                                                                </linearGradient>
                                                                <linearGradient id="paint2_linear" x1="19" y1="1.5"
                                                                                x2="-1.16229e-06" y2="21"
                                                                                gradientUnits="userSpaceOnUse">
                                                                    <stop stop-color="#AF13A4"/>
                                                                    <stop offset="0.302083" stop-color="#BF0985"/>
                                                                    <stop offset="0.723958" stop-color="#F04815"/>
                                                                    <stop offset="1" stop-color="#FED819"/>
                                                                </linearGradient>
                                                            </defs>
                                                        </svg>
                                                    </div>
                                                    <a :href="userProfile.facebook"
                                                       class="user_info__links-btn user_info__links-facebook">
                                                        <span style="white-space: pre;">{{
                                                                userProfile.facebook
                                                            }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                        <tr>

                                        <tr v-if="userProfile.vk">
                                            <td style="padding: 8px;">
                                                <div class="form-input-social__head">
                                                    <div class="form-input-social__icon">
                                                        <svg class="icon icon-vk" style="fill : red;">
                                                            <use xlink:href="/img/icons.svg#vk"/>
                                                        </svg>
                                                    </div>
                                                    <a :href="userProfile.vk"
                                                       class="user_info__links-btn user_info__links-vk">
                                                        <span style="white-space: pre;">{{ userProfile.vk }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                        <tr>

                                        <tr v-if="userProfile.px500">
                                            <td style="padding: 8px;">
                                                <div class="form-input-social__head row">
                                                    <div class="form-input-social__icon">
                                                        <svg class="icon icon-soc500px" style="fill : red;">
                                                            <use xlink:href="/img/icons.svg#soc500px"/>
                                                        </svg>
                                                    </div>
                                                    <a :href="userProfile.px500"
                                                       class="user_info__links-btn user_info__links-soc500px">
                                                        <span style="white-space: pre;">{{ userProfile.px500 }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr v-if="userProfile.twitter">
                                            <td style="padding: 8px;">
                                                <div class="form-input-social__head row">
                                                    <div class="form-input-social__icon">
                                                        <svg class="icon icon-twitter" style="fill : red;">
                                                            <use xlink:href="/img/icons.svg#twitter"/>
                                                        </svg>
                                                    </div>
                                                    <a :href="userProfile.twitter"
                                                       class="user_info__links-btn user_info__links-twitter">
                                                        <span style="white-space: pre;">{{ userProfile.twitter }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr v-if="userProfile.linkendin">
                                            <td style="padding: 8px;">
                                                <div class="form-input-social__head row">
                                                    <div class="form-input-social__icon">
                                                        <svg class="icon icon-linkendin" style="fill : red;">
                                                            <use xlink:href="/img/icons.svg#linkendin"/>
                                                        </svg>
                                                    </div>
                                                    <a :href="userProfile.linkendin"
                                                       class="user_info__links-btn user_info__links-linkendin">
                                                        <span style="white-space: pre;">{{
                                                                userProfile.linkendin
                                                            }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr v-if="userProfile.unslplash">
                                            <td style="padding: 8px;">
                                                <div class="form-input-social__head row">
                                                    <div class="form-input-social__icon">
                                                        <svg class="icon icon-unslplash" style="fill : red;">
                                                            <use xlink:href="/img/icons.svg#unslplash"/>
                                                        </svg>
                                                    </div>
                                                    <a :href="userProfile.unslplash"
                                                       class="user_info__links-btn user_info__links-unslplash">
                                                        <span style="white-space: pre;">{{
                                                                userProfile.unslplash
                                                            }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr v-if="userProfile.telegram">
                                            <td style="padding: 8px;">
                                                <div class="form-input-social__head row">
                                                    <div class="form-input-social__icon">
                                                        <svg class="icon icon-telegram" style="fill : red;">
                                                            <use xlink:href="/img/icons.svg#telegram"/>
                                                        </svg>
                                                    </div>
                                                    <a :href="userProfile.telegram"
                                                       class="user_info__links-btn user_info__links-telegram">
                                                        <span style="white-space: pre;">{{
                                                                userProfile.telegram
                                                            }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr v-if="userProfile.facebook_messenger">
                                            <td style="padding: 8px;">
                                                <div class="form-input-social__head row">
                                                    <div class="form-input-social__icon">
                                                        <svg aria-hidden="true" focusable="false" data-prefix="fab"
                                                             data-icon="facebook-messenger"
                                                             class="svg-inline--fa fa-facebook-messenger" role="img"
                                                             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                                             style="height: 21px; width: 21px;">
                                                            <path fill="currentColor"
                                                                  d="M256.5 8C116.5 8 8 110.3 8 248.6c0 72.3 29.71 134.8 78.07 177.9 8.35 7.51 6.63 11.86 8.05 58.23A19.92 19.92 0 0 0 122 502.3c52.91-23.3 53.59-25.14 62.56-22.7C337.9 521.8 504 423.7 504 248.6 504 110.3 396.6 8 256.5 8zm149.2 185.1l-73 115.6a37.37 37.37 0 0 1 -53.91 9.93l-58.08-43.47a15 15 0 0 0 -18 0l-78.37 59.44c-10.46 7.93-24.16-4.6-17.11-15.67l73-115.6a37.36 37.36 0 0 1 53.91-9.93l58.06 43.46a15 15 0 0 0 18 0l78.41-59.38c10.44-7.98 24.14 4.54 17.09 15.62z"
                                                                  style="fill : red;">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <a :href="userProfile.facebook_messenger"
                                                       class="user_info__links-btn user_info__links-facebook_messenger">
                                                        <span style="white-space: pre;">{{
                                                                userProfile.facebook_messenger
                                                            }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr v-if="userProfile.viber">
                                            <td style="padding: 8px;">
                                                <div class="form-input-social__head row">
                                                    <div class="form-input-social__icon">
                                                        <svg class="icon icon-viber" style="fill : red;">
                                                            <use xlink:href="/img/icons.svg#viber"/>
                                                        </svg>
                                                    </div>
                                                    <a :href="userProfile.viber"
                                                       class="user_info__links-btn user_info__links-viber">
                                                        <span style="white-space: pre;">{{ userProfile.viber }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr v-if="userProfile.whatsapp">
                                            <td style="padding: 8px;">
                                                <div class="form-input-social__head row">
                                                    <div class="form-input-social__icon">
                                                        <svg class="icon icon-whatsapp" style="fill : red;">
                                                            <use xlink:href="/img/icons.svg#whatsapp"/>
                                                        </svg>
                                                    </div>
                                                    <a :href="userProfile.whatsapp"
                                                       class="user_info__links-btn user_info__links-whatsapp">
                                                        <span style="white-space: pre;">{{
                                                                userProfile.whatsapp
                                                            }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr v-if="userProfile.youtube">
                                            <td style="padding: 8px;">
                                                <div class="form-input-social__head row">
                                                    <div class="form-input-social__icon">
                                                        <svg aria-hidden="true" focusable="false" data-prefix="fab"
                                                             data-icon="youtube" class="svg-inline--fa fa-youtube"
                                                             role="img" xmlns="http://www.w3.org/2000/svg"
                                                             viewBox="0 0 576 512" style="height: 21px; width: 21px;">
                                                            <path fill="currentColor"
                                                                  d="M549.7 124.1c-6.281-23.65-24.79-42.28-48.28-48.6C458.8 64 288 64 288 64S117.2 64 74.63 75.49c-23.5 6.322-42 24.95-48.28 48.6-11.41 42.87-11.41 132.3-11.41 132.3s0 89.44 11.41 132.3c6.281 23.65 24.79 41.5 48.28 47.82C117.2 448 288 448 288 448s170.8 0 213.4-11.49c23.5-6.321 42-24.17 48.28-47.82 11.41-42.87 11.41-132.3 11.41-132.3s0-89.44-11.41-132.3zm-317.5 213.5V175.2l142.7 81.21-142.7 81.2z"
                                                                  style="fill : red;">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <a :href="userProfile.youtube"
                                                       class="user_info__links-btn user_info__links-youtube">
                                                        <span style="white-space: pre;">youtube::{{
                                                                userProfile.youtube
                                                            }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr v-if="userProfile.vk">
                                            <td style="padding: 8px;">
                                                <div class="form-input-social__head row">
                                                    <div class="form-input-social__icon">
                                                        <svg class="icon icon-vk" style="fill : red;">
                                                            <use xlink:href="/img/icons.svg#vk"/>
                                                        </svg>
                                                    </div>
                                                    <a :href="userProfile.vk"
                                                       class="user_info__links-btn user_info__links-vk">
                                                        <span style="white-space: pre;">{{ userProfile.vk }}</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                    </table>


                                </div>

                            </div>
                        </div>


                        <!--<div class="user_info__pro">
                            <div class="user_info__pro-flex">
                                <div class="user_info__pro-progress">
                                    <div style="width: 66%"></div>
                                </div>
                                <div class="user_info__pro-help"
                                     title="Ты на финишной прямой.	&lt;br&gt;Продолжай в том же духе!"
                                     data-tooltip><span>?</span></div>
                            </div>
                            <a href="" class="user_info__pro-button btn">
                                <svg>
                                    <use xlink:href="/img/sprite.svg#lightning"></use>
                                </svg>
                                <span>Перейти на PRO</span>
                            </a>
                        </div>-->
                    </div>
                </div>


                <tabs :options="{ useUrlFragment: false, defaultTabHash: 'Загрузить фотографии' }">
                    <tab :name="get1stAllPhotosTabTitle">
                        <div class="photographer_page__tabs">
                            <div class="photographer_page__tab">

                                <div v-masonry="photos_container_id" transition-duration="0.3s" item-selector=".item"
                                     :origin-top="true"
                                     :horizontal-order="false" v-if="" style="position: relative; height: 100% !important;"
                                     id="div_photos_container_id" v-show="is_photos_container_loaded">

                                    <div class="main_gallery__blocks">


                                        <div v-masonry-tile class="main_gallery__block" v-for="nextPhoto in photos"
                                             :key="nextPhoto.id">
                                            <div class="main_gallery__content">
                                                <a href="#" class="main_gallery__link"></a>
                                                <img class="main_gallery__image" :src="nextPhoto.media_image_url" :alt="nextPhoto.id"
                                                     :title="nextPhoto.id+':'+nextPhoto.name">

                                                <div data-tooltip data-tooltip-theme="theme-dark"
                                                     :title="nextPhoto.id+':'+nextPhoto.name"
                                                     class="sticker_mark main_gallery__sticker_mark"
                                                     style="margin-right:32px !important;"
                                                     v-if="nextPhoto.photo_nominations.length > 0">

                                                    <svg class="sticker_mark__bg">
                                                        <use xlink:href="/img/sprite.svg#sticker_mark"></use>
                                                    </svg>

                                                    <div class="user_info__nominations-item"
                                                         v-for="nextPhotoNomination in nextPhoto.photo_nominations">
                                                        <div
                                                            class="sticker_mark user_info__nominations-sticker_mark tooltipstered"
                                                            :title="nextPhotoNomination.nomination.title"
                                                            :style="'fill : ' +nextPhotoNomination.nomination.color+'  !important; color: white !important;'">
                                                            <svg class="sticker_mark__bg">
                                                                <use xlink:href="/img/sprite.svg#sticker_mark"></use>
                                                            </svg>
                                                            <svg class="sticker_mark__lightning">
                                                                <use xlink:href="/img/sprite.svg#lightning"></use>
                                                            </svg>
                                                        </div>
                                                        <p class="user_info__nominations-quantity">
                                                            {{ nextPhotoNomination.photo_nominations_count }}
                                                        </p>
                                                    </div>

                                                </div>

                                                <div class="main_gallery__info" v-if="nextPhoto.photo_likes_count">
                                                    <div class="main_gallery__likes">
                                                        <svg class="icon icon-like">
                                                            <use xlink:href="/img/icons.svg#like"/>
                                                        </svg>
                                                        <span>{{ nextPhoto.photo_likes_count }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div> <!-- v-masonry="photos_container_id" -->


                            </div>
                        </div>
                    </tab>

                    <tab :name="get2ndPhotosWithNominationsTabTitle">
                        <div class="photographer_page__tabs">
                            <div class="photographer_page__tab">
                                <div class="main_gallery__blocks">
                                    <div class="main_gallery__block height-4"
                                         style="margin-bottom: 20px;"
                                         v-for="(nextNominatedPhoto, index) in nominatedPhotos"
                                         :key="nextNominatedPhoto.id">

                                        <div class="main_gallery__content">
                                            <a href="#" class="main_gallery__link"></a>
                                            <img :src="nextNominatedPhoto.media_image_url"
                                                 :alt="nextNominatedPhoto.id"
                                                 :title="nextNominatedPhoto.id+':'+nextNominatedPhoto.name">

                                            <div data-tooltip data-tooltip-theme="theme-dark"
                                                 :title="nextNominatedPhoto.id+':'+nextNominatedPhoto.name"
                                                 class="sticker_mark main_gallery__sticker_mark color-1"
                                                 style="margin-right:32px !important;"
                                                 v-if="nextNominatedPhoto.photo_nominations.length > 0">

                                                <div class="user_info__nominations-item"
                                                     v-for="nextPhotoNomination in nextNominatedPhoto.photo_nominations">
                                                    <div
                                                        class="sticker_mark user_info__nominations-sticker_mark tooltipstered"
                                                        :title="nextPhotoNomination.nomination.title"
                                                        :style="'fill : ' +nextPhotoNomination.nomination.color+'  !important; color: white !important;'">
                                                        <svg class="sticker_mark__bg">
                                                            <use xlink:href="/img/sprite.svg#sticker_mark"></use>
                                                        </svg>
                                                        <svg class="sticker_mark__lightning">
                                                            <use xlink:href="/img/sprite.svg#lightning"></use>
                                                        </svg>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="main_gallery__info"
                                                 v-if="nextNominatedPhoto.photo_likes_count">
                                                <div class="main_gallery__likes">
                                                    <svg class="icon icon-like">
                                                        <use xlink:href="/img/icons.svg#like"/>
                                                    </svg>
                                                    <span>{{ nextNominatedPhoto.photo_likes_count }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </tab>

                    <tab name="Контактная информация">
                        <div class="photographer_page__contacts">
                            <div class="photographer_page__contacts-item">

                                <template v-if="userProfile.city">
                                    <p class="photographer_page__contacts-title">Страна и город проживания:</p>
                                    <p class="photographer_page__contacts-address">{{ userProfile.city.address }},
                                        {{ userProfile.city.country }}</p>
                                </template>

                            </div>
                            <div class="photographer_page__contacts-item">
                                <p class="photographer_page__contacts-title">Контактный телефон:</p>
                                <p class="photographer_page__contacts-phone">+7 468 998 47 **</p>
                                <a href="#" class="photographer_page__contacts-show_phone">
                                    <svg class="icon icon-eye">
                                        <use xlink:href="/img/icons.svg#eye"/>
                                    </svg>
                                    <span>Показать номер телефона</span>
                                </a>
                            </div>

                            <div class="photographer_page__contacts-item">
                                <p class="photographer_page__contacts-title">Социальные сети:</p>
                                <div class="photographer_page__contacts-socials">

                                    <a class="photographer_page__contacts-socials_link" v-if="userProfile.twitter"
                                       :href="userProfile.twitter">
                                        <svg width="14" height="12">
                                            <use xlink:href="/img/sprite.svg#socials-twitter"></use>
                                        </svg>
                                    </a>

                                    <a class="photographer_page__contacts-socials_link" v-if="userProfile.instagram"
                                       :href="userProfile.instagram">
                                        <svg width="16" height="16">
                                            <use xlink:href="/img/sprite.svg#socials-instagram"></use>
                                        </svg>
                                    </a>

                                    <a class="photographer_page__contacts-socials_link" v-if="userProfile.youtube"
                                       :href="userProfile.youtube">
                                        <svg width="14" height="10">
                                            <use xlink:href="/img/sprite.svg#socials-youtube"></use>
                                        </svg>
                                    </a>

                                    <a class="photographer_page__contacts-socials_link" v-if="userProfile.vk"
                                       :href="userProfile.vk">
                                        <svg width="14" height="8">
                                            <use xlink:href="/img/sprite.svg#socials-vk"></use>
                                        </svg>
                                    </a>

                                </div>
                            </div>
                        </div>
                    </tab>

                    <tab name="Загрузить фотографии">
                        <a @click.prevent="showPhotosUploadingModal()" class="user_info__pro-button btn" style="max-width: 200px !important; margin-bottom: 15px !important; border: 0px dotted red !important;">
                            <svg>
                                <use xlink:href="/img/sprite.svg#lightning"></use>
                            </svg>
                            <span>Загрузить</span>
                        </a>


                        <div class="photographer_page__tabs">
                            <div class="photographer_page__tab">

                                <div v-masonry="photos_container_id" transition-duration="0.3s" item-selector=".item"
                                     :origin-top="true"
                                     :horizontal-order="false" v-if="" style="position: relative; height: 100% !important;"
                                     id="div_inactive_photos_container_id" v-show="is_photos_container_loaded">

                                    <div class="main_gallery__blocks">


                                        <div v-masonry-tile class="main_gallery__block"
                                             v-for="nextInactivePhoto in inactivePhotos"
                                             :key="nextInactivePhoto.id">
                                            <div class="main_gallery__content">
                                                <a href="#" class="main_gallery__link"></a>
                                                <img :src="nextInactivePhoto.media_image_url" :alt="nextInactivePhoto.id"
                                                     :title="nextInactivePhoto.id+':'+nextInactivePhoto.name">

                                                <div data-tooltip data-tooltip-theme="theme-dark"
                                                     :title="nextInactivePhoto.id+':'+nextInactivePhoto.name"
                                                     class="sticker_mark main_gallery__sticker_mark"
                                                     style="margin-right:32px !important;"
                                                     v-if="nextInactivePhoto.photo_nominations.length > 0">

                                                    <svg class="sticker_mark__bg">
                                                        <use xlink:href="/img/sprite.svg#sticker_mark"></use>
                                                    </svg>

                                                    <div class="user_info__nominations-item"
                                                         v-for="nextInactivePhotoNomination in nextInactivePhoto.photo_nominations">
                                                        <div
                                                            class="sticker_mark user_info__nominations-sticker_mark tooltipstered"
                                                            :title="nextInactivePhotoNomination.nomination.title"
                                                            :style="'fill : ' +nextInactivePhotoNomination.nomination.color+'  !important; color: white !important;'">
                                                            <svg class="sticker_mark__bg">
                                                                <use xlink:href="/img/sprite.svg#sticker_mark"></use>
                                                            </svg>
                                                            <svg class="sticker_mark__lightning">
                                                                <use xlink:href="/img/sprite.svg#lightning"></use>
                                                            </svg>
                                                        </div>
                                                        <p class="user_info__nominations-quantity">
                                                            {{ nextInactivePhotoNomination.photo_nominations_count }}
                                                        </p>
                                                    </div>

                                                </div>

                                                <div class="main_gallery__info" v-if="nextInactivePhoto.photo_likes_count">
                                                    <div class="main_gallery__likes">
                                                        <svg class="icon icon-like">
                                                            <use xlink:href="/img/icons.svg#like"/>
                                                        </svg>
                                                        <span>??=> {{ nextInactivePhoto.photo_likes_count }}
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div> <!-- v-masonry="photos_container_id" -->


                            </div>
                        </div>

                    </tab>
                </tabs>
            </div>

        </div>

    </app-layout>

</template>


<script>
import AppLayout from '@Layouts/AppLayout.vue'

import Vue from 'vue';
import {Tabs, Tab} from 'vue-tabs-component';

Vue.component('tabs', Tabs);
Vue.component('tab', Tab);

const VueUploadComponent = require('vue-upload-component')
Vue.component('file-upload', VueUploadComponent)

import PersonalTopMenu from './personal_top_menu.vue'

import VModal from 'vue-js-modal/dist/index.nocss.js'
import 'vue-js-modal/dist/styles.css'

Vue.use(VModal)

import {VueMasonryPlugin} from 'vue-masonry';
Vue.use(VueMasonryPlugin)


export default ({
    props: [
        'loggedUser',
        'userProfile',
        'mostNominatedPhotos',
    ],

    components: {
        AppLayout,
        PersonalTopMenu,
    },

    mounted() {
        this.loadTags()
        this.loadLoggedPhotos()
        this.loadLoggedInactivePhotos()
        this.loadNominatedLoggedPhotos()
        this.avatar_image_url = this.$page.props.user.avatar_image_url
        // this.showPhotosUploadingModal() // DEBUGGING
    },
    data() {
        return {
            tags: [],
            max_photos_to_upload_this_week:0,
            is_photos_container_loaded: false,
            is_inactive_photos_container_loaded: false,
            photos_container_id: null,
            innerWidth: window.innerWidth,
            innerHeight: window.innerHeight,
            photos: [],
            inactivePhotos: [],
            avatar_image_url: null,
            nominatedPhotos: [],
            total_photos_count: 0,
            total_inactive_photos_count: 0,
            total_photo_nominations_count: 0,
            imageFileToUpload: null,
            imageFiles: [],

            imagePhotosUploadingFileToUpload: null,
            imagePhotosUploadingFiles: [],
        }
    },

    watch: {
        imageFiles(theFile) {
            if (typeof theFile[0] === 'undefined') return
            let image = new Image()
            image.src = theFile[0].blob
            image.onload = function () {
                // bus.$emit('imageUploadedEvent', this.width, this.height)
            }
        }
    },


    computed: {
        getAllowedPhotosToUploadCount() {

            return this.max_photos_to_upload_this_week - this.imagePhotosUploadingFiles.length;
        },
        get1stAllPhotosTabTitle() {
            return 'Все фотографии <span class="tab_suffix_blue">+' + this.total_photos_count + "</span>";
        },
        get2ndPhotosWithNominationsTabTitle() {
            return 'Номинации <span class="tab_suffix_red">+' + this.total_photo_nominations_count + "</span>";
        },
        modalChangeAvatarHeight() {
            console.log('modalChangeAvatarHeight this.innerWidth::')
            console.log(this.innerWidth)

            if (this.innerWidth < 420) {
                return 400;
            }
            return 370;
        },
        modalChangeAvatarWidth() {
            if (this.innerWidth < 420) {
                return 280;
            }
            return 400;
        },

        modalPhotosUploadingHeight() {
            if (this.innerWidth < 420) {
                return 400;
            }
            return 480;
        },
        modalPhotosUploadingWidth() {
            if (this.innerWidth < 420) {
                return 280;
            }
            return 500;
        },
    },
    methods: {
        loadTags() {
            Window.axios.get('/get_tags/1')
                .then(resp => {
                    this.tags = resp.data.tags
                })
        }, // loadTags() {

        loadLoggedPhotos() {
            Window.axios.get('/profile/get_photos/1')
                .then(resp => {
                    console.log('/profile/get_photos this.photos::')
                    console.log(this.photos)
                    this.photos = resp.data.photos
                    this.total_photos_count = resp.data.total_photos_count
                    this.$redrawVueMasonry("photos_container_id")
                    setTimeout(setPhotosContainerHeight, 1000);  // But this method really helped
                })
        }, // loadLoggedPhotos() {

        loadLoggedInactivePhotos() {
            console.log('loadLoggedInactivePhotos::')

            Window.axios.get('/profile/get_photos/0')
                .then(resp => {
                    console.log('loadLoggedInactivePhotos /profile/get_photos this.photos::')
                    console.log(this.photos)
                    this.inactivePhotos = resp.data.photos
                    this.total_inactive_photos_count = resp.data.total_photos_count
                    this.$redrawVueMasonry("photos_container_id")
                    setTimeout(setInactivePhotosContainerHeight, 1000);  // But this method really helped
                })
        }, // loadLoggedInactivePhotos() {

        loadNominatedLoggedPhotos() {
            Window.axios.get('/profile/get_nominated_photos')
                .then(resp => {
                    this.nominatedPhotos = resp.data.nominatedPhotos
                    this.total_photo_nominations_count = resp.data.total_photo_nominations_count
                })
        }, // loadNominatedLoggedPhotos() {


        // AVATAR BLOCK START
        saveAvatar() {
            let self = this
            fetch(this.imageFileToUpload.blob).then(function (response) {
                if (response.ok) {
                    return response.blob().then(function (imageBlob) {
                        let imageUploadData = new FormData()
                        imageUploadData.append('image', imageBlob)
                        imageUploadData.append('image_filename', self.imageFileToUpload.name)

                        Window.axios.post('/profile/update/avatar', imageUploadData).then(({data}) => {
                            self.avatar_image_url = data.uploaded_media_image_url
                            self.hideChangeAvatarModal()
                        }).catch((error) => {
                            console.error(error)
                        })
                    })
                } else {
                    return response.json().then(function (jsonError) {
                        console.error(jsonError)
                    })
                }
            }).catch(function (error) {
                console.error(error)
                console.log('There has been a problem with your fetch operation: ', error.message)
            }) // fetch(this.imageFileToUpload.blob).then(function (response) {

        },

        deleteAvatar() {
            Window.axios.delete('/profile/delete/avatar').then(({data}) => {
                this.avatar_image_url = null
                // Swal.fire({
                //     icon: 'success',
                //     title: 'Профайл',
                //     text: 'Аватар успешно удален !'
                // })
                this.hideChangeAvatarModal()
            }).catch((error) => {
                console.error(error)
                // Swal.fire({
                //         title: 'Профайл',
                //         text: 'Ошибка сохранения публичных данных профайла ! ',
                //         icon: 'error'
                //     }
                // )
            })

        },

        showChangeAvatarModal() {
            this.$modal.show('change-avatar-modal');
        },
        hideChangeAvatarModal() {
            this.$modal.hide('change-avatar-modal');
            this.imageFiles = []
            this.imageFileToUpload = null
        },

        inputFile(newFile, oldFile) {
            this.imageFileToUpload = newFile

            if (newFile && oldFile && !newFile.active && oldFile.active) {
                if (newFile.xhr) {
                    console.log('status', newFile.xhr.status)
                }
            }
        },

        inputFilter(newFile, oldFile, prevent) {
            if (newFile && !oldFile) {
                if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
                    return prevent()
                }
            }

            newFile.blob = ''
            let URL = window.URL || window.webkitURL
            if (URL && URL.createObjectURL) {
                newFile.blob = URL.createObjectURL(newFile.file)
            }
        },
        // AVATAR BLOCK END

        // PHOTOS UPLOADING START
        deletePhotosUploading(file_name) {
            console.log('deletePhotosUploading file_name::')
            console.log(file_name)
            this.imagePhotosUploadingFiles.map((nextImagePhotosUploadingFile, index) => {
                console.log('nextImagePhotosUploadingFile::')
                console.log(nextImagePhotosUploadingFile)

                if (nextImagePhotosUploadingFile.name === file_name) {
                    this.imagePhotosUploadingFiles.splice(index, 1)
                    return
                }
            })
        },
        savePhotosUploadingModal() {
            let uploaded_count= 0
            let image_photos_uploading_files_length= this.imagePhotosUploadingFiles.length
            let self = this
            this.imagePhotosUploadingFiles.map((nextImagePhotosUploadingFile, index) => {

                fetch(nextImagePhotosUploadingFile.blob).then(function (response) {
                    if (response.ok) {
                        return response.blob().then(function (imageBlob) {
                            let imageUploadData = new FormData()
                            imageUploadData.append('image', imageBlob)
                            imageUploadData.append('image_filename', nextImagePhotosUploadingFile.name)

                            let tags= [];
                            self.tags.map((nextTag, index) => {
                                if (nextTag.is_checked) {
                                    tags.push(nextTag.id)
                                }
                            })
                            imageUploadData.append('tags', tags)
                            Window.axios.post('/profile/upload_photo', imageUploadData).then(({data}) => {
                                // console.log(' data::')
                                // console.log(data)
                                self.imagePhotosUploadingFiles.splice(index, 1)
                                uploaded_count++
                                // console.log('uploaded_count::')
                                // console.log(uploaded_count)
                                if (uploaded_count >= image_photos_uploading_files_length) {
                                    self.hidePhotosUploadingModal()
                                }
                                self.loadLoggedInactivePhotos()
                            }).catch((error) => {
                                console.error(error)
                                if(typeof error.response.data.errors.image[0] != 'undefined') {
                                    Swal.fire({
                                            title: 'Загрузка фото',
                                            text: error.response.data.errors.image[0],
                                            icon: 'error'
                                        }
                                    )
                                }
                            })
                        })
                    } else {
                        return response.json().then(function (jsonError) {
                            console.error(jsonError)
                        })
                    }
                }).catch(function (error) {
                    console.error(error)
                    console.log('There has been a problem with your fetch operation: ', error.message)
                }) // fetch(nextImagePhotosUploadingFile.blob).then(function (response) {

            }) // this.imagePhotosUploadingFiles.map((nextImagePhotosUploadingFile, index) => {

        }, // savePhotosUploadingModal

        showPhotosUploadingModal() {
            Window.axios.get('/profile/get_free_photos_upload_for_week')
                .then(resp => {
                    this.max_photos_to_upload_this_week= resp.data.max_photos_to_upload_this_week
                })
                .catch(
                    function (error) {
                        console.error(error)
                    }
                )
            this.$modal.show('photos-uploading-modal');
        },
        hidePhotosUploadingModal() {
            this.$modal.hide('photos-uploading-modal');
            this.imagePhotosUploadingFiles = []
            this.imagePhotosUploadingFileToUpload = null
        },

        inputFilePhotosUploading(newFile, oldFile) {
            console.log('inputFilePhotosUploading newFile::')
            console.log(newFile)
            console.log('inputFilePhotosUploading this.getAllowedPhotosToUploadCount::')
            console.log(this.getAllowedPhotosToUploadCount)

            // if (this.getAllowedPhotosToUploadCount >= )
            this.imagePhotosUploadingFileToUpload = newFile

            if (newFile && oldFile && !newFile.active && oldFile.active) {
                if (newFile.xhr) {
                    console.log('status', newFile.xhr.status)
                }
            }
        },

        inputFilterPhotosUploading(newFile, oldFile, prevent) {
            console.log('inputFilterPhotosUploading newFile::')
            console.log(newFile)
            if (newFile && !oldFile) {
                if (!/\.(jpeg|jpe|jpg|gif|png|webp)$/i.test(newFile.name)) {
                    return prevent()
                }
            }

            newFile.blob = ''
            let URL = window.URL || window.webkitURL
            if (URL && URL.createObjectURL) {
                newFile.blob = URL.createObjectURL(newFile.file)
            }
        },
        // PHOTOS UPLOADING BLOCK END

    }, // methods: {

})

function setPhotosContainerHeight() {
    console.log('setPhotosContainerHeight::')
    document.getElementById('div_photos_container_id').setAttribute("style", "height:100% !important");
    this.is_photos_container_loaded = true;
}

function setInactivePhotosContainerHeight() {
    console.log('setInactivePhotosContainerHeight::')
    document.getElementById('div_inactive_photos_container_id').setAttribute("style", "height:100% !important");
    this.is_inactive_photos_container_loaded = true;
}

</script>
