<template>
    <app-layout>

        is_container_loaded::{{ is_container_loaded}}


        <div v-masonry="containerId" transition-duration="0.3s" item-selector=".item" :origin-top="true"
             :horizontal-order="false" v-if="" style="position: relative;" id="div_container_id" v-show="is_container_loaded">
            <div class="main_gallery__blocks">

                <div v-masonry-tile class=" main_gallery__block" v-for="(nextPhoto, index) in photos">

                    <div class="main_gallery__content d3">
                        <a href="#" class="main_gallery__link d2"></a>
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

    </app-layout>

</template>

<script>
import AppLayout from '@Layouts/AppLayout.vue'
import Vue from 'vue';

import appMixin from "../appMixin";
import PersonalMenuSidebar from "./profile/personal_menu_sidebar";
import PersonalTopMenu from "./profile/personal_top_menu";

import {VueMasonryPlugin} from 'vue-masonry';

Vue.use(VueMasonryPlugin)

export default {
    mixins: [appMixin],


    components: {
        AppLayout,
        PersonalMenuSidebar,
        PersonalTopMenu,
    },

    data() {
        return {
            is_container_loaded:false,
            containerId:null,
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

                    this.$redrawVueMasonry("containerId")
                    setTimeout(setContainerHeight, 1000);  // But this method really helped

                })
        }, // loadPhotos() {

    }
};

function setContainerHeight() {
    document.getElementById('div_container_id').setAttribute("style","height:100% !important");
    this.is_container_loaded = true;
}
</script>

