<template>
    <app-layout>

        <personal-top-menu current_page="personal"></personal-top-menu>

        <div class="profile-personal">
            <div class="container">
                <div class="profile-personal__flex flex">

                    <personal-menu-sidebar current_page="personal"></personal-menu-sidebar>

                    <div class="profile-personal__content">
                        <div class="profile-personal__form">
                            <form @submit.prevent="updateUserProfilePersonal">
                                <div class="profile-personal__form-content">

                                    <div class="form-group">
                                        <div class="form-box">
                                            <div class="form-box__label"><span>Имя и фамилия</span></div>
                                            <div class="form-box__content">
                                                <input type="text" class="form-control" placeholder="Ваше имя" id="name"
                                                       v-model="form.name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-box">
                                            <div class="form-box__label"><span>Город проживания</span></div>
                                            <div class="form-box__content" style="margin-right: 41px !important;">
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
                                                        selectLabel	=""
                                                        selectedLabel=""
                                                        deselectLabel=""
                                                        :multiple="false"
                                                    >
                                                    </multiselect>
                                                    <!--                                                    selectLabel	="Для выбора элемента нажмите enter"-->
                                                    <!--                                                    selectedLabel="Выбран"-->
                                                    <!--                                                    deselectLabel="Для удаления элемента нажмите enter"-->

                                                    <p class="validation_error">{{ clearErrorMessage(errors[0]) }}</p>
                                                </ValidationProvider>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <div class="form-box">
                                            <div class="form-box__label"><span>Укажите ставку в час</span></div>
                                            <div class="form-box__content">
                                                <div class="form-input-box form-input-rate">
                                                    <input type="text" class="form-control form-input-box__input"
                                                           placeholder="" id="hour_rate" v-model="form.hour_rate">
                                                    <div class="form-input-box__unit">₽</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-box">
                                            <div class="form-box__label"><span>Адрес личного сайта</span></div>
                                            <div class="form-box__content">
                                                <input type="text" class="form-control" placeholder="https://"
                                                       id="website" v-model="form.website">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="profile-personal__form-button flex justify-center">
                                    <button type="submit" class="btn btn--secondary">Сохранить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </app-layout>

</template>


<script>
import AppLayout from '@Layouts/AppLayout.vue'

import PersonalMenuSidebar from './personal_menu_sidebar.vue'
import PersonalTopMenu from './personal_top_menu.vue'

import Vue from 'vue'

import Multiselect from 'vue-multiselect'
import 'vue-multiselect/dist/vue-multiselect.min.css'

import vSelect from "vue-select";
Vue.component("v-select", vSelect);
import "vue-select/dist/vue-select.css";


import appMixin from '../../appMixin'
import {ValidationObserver, ValidationProvider, extend} from 'vee-validate'
import * as rules from 'vee-validate/dist/rules'

Object.keys(rules).forEach(rule => {
    extend(rule, rules[rule])
})
import {localize} from 'vee-validate'

localize({
    en: {
        messages: {
            required: (field) => field + ' is required',
            min: 'Must have no less than {length} characters',
            max: 'Must have no more than {length} characters',
            email: 'Invalid email format',
            confirmed: 'Password and password confirmation must be equal',
        }
    }
})

export default ({
    mixins: [appMixin],

    props: [
        'loggedUser',
        'city_title',
        'userProfile',
        'citiesSelectionArray',
    ],

    components: {
        AppLayout,
        PersonalMenuSidebar,
        PersonalTopMenu,
        ValidationObserver,
        ValidationProvider,
        Multiselect
    },

    mounted() {
        this.form.name = this.loggedUser.name
        this.form.user_id = this.loggedUser.id
        this.form.city_id = this.userProfile.city_id
        this.form.city_title = this.city_title
        this.form.hour_rate = this.userProfile.hour_rate
        this.form.website = this.userProfile.website

        this.citiesSelectionArray.map((nextCitySelectionLabel/*, index*/) => {
            if (nextCitySelectionLabel.code === this.userProfile.city_id) {
                this.selected_city_id = {code: this.userProfile.city_id, label: nextCitySelectionLabel.label}
            }
        })

    },
    data() {
        return {
            selected_city_id: null,
            form: {
                name: '',
                user_id: '',
                city_id: '',
                city_title: '',
                hour_rate: '',
                website: '',
            }
        }
    },

    computed: {},
    methods: {
        selected: function(v1) {
            if (this.isEmpty(v1)) {
                this.form.city_id = ''
            } else{
                this.form.city_id = v1.id
            }
        },

        updateUserProfilePersonal() {
            // console.log('this.selection_city_id.code::')
            // console.log(this.selection_city_id.code)

            this.form.city_id= this.selected_city_id.code
            Window.axios.post('/profile/update/personal', this.form)
                .then(resp => {
                    // console.log('resp::')
                    // console.log(resp)
                    Swal.fire({
                        icon: 'success',
                        title: 'Профайл',
                        text: resp.data.message
                    })
                })
                .catch(
                    function (error) {
                        console.error(error)
                        Swal.fire({
                                title: 'Профайл',
                                text: 'Ошибка сохранения публичных данных профайла ! ',
                                icon: 'error'
                            }
                        )
                    }
                )
        }   // updateUserProfilePersonal() {
    }, // methods: {

})

</script>
