<template>
    <app-layout>

        <div class="form-group">
            <div class="form-flex">
                <div class="select-wrapper  form-column form-column-field">

                    <select class="select select-no-search" data-no-search
                            data-placeholder="Выбрать год"
                            v-model="started_year"
                            onfocus="this.size=8;"
                            onblur="this.size=1;"
                            onchange="this.size=1; this.blur();"
                    >
                        <option disabled>- Select Year</option>
                        <option :value="nextYear"
                                v-for="nextYear in yearsSelectionArray"
                                :key="nextYear">
                            {{ nextYear }}
                        </option>
                    </select>

                </div>
                <div class="form-column form-column-text">
                    <div class="form-text">Select input without events
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="form-flex">
                <div class="form-column form-column-field">

                    <select class="select select-no-search" data-no-search
                            data-placeholder="Выбрать год"
                            v-model="started_year"
                            onfocus="this.size=10;"
                            onblur="this.size=1;"
                            onchange="this.size=1; this.blur();"
                    >
                        <option disabled>- Select Year</option>
                        <option :value="nextYear"
                                v-for="nextYear in yearsSelectionArray"
                                :key="nextYear">
                            {{ nextYear }}
                        </option>
                    </select>

                </div>
                <div class="form-column form-column-text">
                    <div class="form-text">Select input having events defined :       onfocus="this.size=10;"
                        onblur="this.size=1;"
                        onchange="this.size=1; this.blur();"
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


export default {
    mixins: [appMixin],

    props: [
        'yearsSelectionArray'
    ],

    components: {
        AppLayout,
    },

    data() {
        return {
            started_year: 1996,

        };
    },

    mounted() {
        // this.loadPhotos()
    },

    computed: {},
    methods: {
        loadPhotos() {

            /*
                        Window.axios.get('/get_all_photos')
                            .then(resp => {
                                this.photos = resp.data.photos
                                this.total_photos_count = resp.data.total_photos_count

                                this.$redrawVueMasonry("containerId")
                                setTimeout(setContainerHeight, 1000);  // But this method really helped

                            })
            */
        }, // loadPhotos() {

    }
};

function setContainerHeight() {
    document.getElementById('div_container_id').setAttribute("style", "height:100% !important");
    this.is_container_loaded = true;
}
</script>

