<template>
    <app-layout>


        <fieldset class="blocks d1" style="margin-bottom: 200px !important;">
            <legend class="blocks">Original List of images</legend>

            <div class="photographer_page__tabs">
                <div class="photographer_page__tab">
                    <div class="main_gallery__blocks">

                        <div class="main_gallery__block height-4" v-for="nextPhoto in photos"
                             :key="nextPhoto.id">

                            <div class="main_gallery__content">
                                <a href="#" class="main_gallery__link"></a>
                                <img :src="nextPhoto.media_image_url" :alt="nextPhoto.id"
                                     :title="nextPhoto.id+':'+nextPhoto.name">

                                <div data-tooltip data-tooltip-theme="theme-dark"
                                     :title="nextPhoto.id+':'+nextPhoto.name"
                                     class="sticker_mark main_gallery__sticker_mark"
                                     style="margin-right:32px !important;"
                                     v-if="nextPhoto.photo_nominations.length > 0">

                                    <svg class="sticker_markfi__bg">
                                        <use xlink:href="/img/sprite.svg#sticker_mark"></use>
                                    </svg>

                                    <div class="user_info__nominations-item"
                                         v-for="nextPhotoNomination in nextPhoto.photo_nominations">
                                        <div class="sticker_mark user_info__nominations-sticker_mark tooltipstered"
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
                </div>
            </div>

        </fieldset>


    </app-layout>

</template>

<script>
import AppLayout from '@Layouts/AppLayout.vue'

import appMixin from "../appMixin";
import PersonalMenuSidebar from "./profile/personal_menu_sidebar";
import PersonalTopMenu from "./profile/personal_top_menu";

export default {
    mixins: [appMixin],

    components: {
        AppLayout,
        PersonalMenuSidebar,
        PersonalTopMenu,
    },

    data() {
        return {
            photos: [],
            nominatedPhotos: [],

        };
    },

    mounted() {
        this.loadPhotos()
    },

    computed: {},
    methods: {
        loadPhotos() {
            Window.axios.get('/get_all_photos')
                .then(resp => {
                    this.photos = resp.data.photos
                    this.total_photos_count = resp.data.total_photos_count
                })
        }, // loadPhotos() {

    }
};
</script>

