<template>
    <app-layout>

        <personal-top-menu current_page="password"></personal-top-menu>

        <div class="profile-personal">
            <div class="container">
                <div class="profile-personal__flex flex">

                    <personal-menu-sidebar current_page="password"></personal-menu-sidebar>

                    <div class="profile-personal__content">
                        <div class="profile-personal__form">

                            <ValidationObserver
                                ref="updatePasswordObserverForm"
                                v-slot="{handleSubmit}"
                            >

                                <form @submit.prevent="updateUserProfilePassword">
                                    <div class="profile-personal__form-content">

                                        <div class="form-group">
                                            <div class="form-box">
                                                <div class="form-box__label"><span>Текущий пароль</span></div>
                                                <div class="form-box__content">
                                                    <div class="form-input-box form-input-password">

                                                        <ValidationProvider
                                                            name="current_password"
                                                            :rules="{ required : true, max:50 }"
                                                            v-slot="{ errors }"
                                                        >
                                                            <input :type=" current_password_field_visible ? 'input' : 'password'"
                                                                   class="form-control form-input-box__input"
                                                                   id="current_password"
                                                                   v-model="form.current_password">
                                                            <p class="validation_error">{{clearErrorMessage(errors[0])}}</p>
                                                        </ValidationProvider>

                                                        <a @click="showHideVisiblePassword('current_password')"
                                                           class="form-input-box__control form-input-password__btn-visible">
                                                            <span>
                                                                <svg class="icon icon-visible" v-show="!current_password_field_visible">
                                                                    <use xlink:href="/img/icons.svg#visible"/>
                                                                </svg>
                                                            </span>
                                                            <span>
                                                                <svg class="icon icon-no-visible" v-show="current_password_field_visible">
                                                                    <use xlink:href="/img/icons.svg#no-visible" />
                                                                </svg>
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-box">
                                                <div class="form-box__label"><span>Новый пароль</span></div>
                                                <div class="form-box__content">

                                                    <div class="form-input-box form-input-password">

                                                        <ValidationProvider
                                                            name="new_password"
                                                            :rules="{ required : true, max:50 }"
                                                            v-slot="{ errors }"
                                                        >
                                                            <input :type=" new_password_field_visible ? 'input' : 'password'"
                                                                   class="form-control form-input-box__input"
                                                                   id="new_password"
                                                                   v-model="form.new_password">
                                                            <p class="validation_error">{{
                                                                    clearErrorMessage(errors[0])
                                                                }}</p>
                                                        </ValidationProvider>

                                                        <a @click="showHideVisiblePassword('new_password')"
                                                           class="form-input-box__control form-input-password__btn-visible">
                                                            <span>
                                                                <svg class="icon icon-visible" v-show="!new_password_field_visible">
                                                                    <use xlink:href="/img/icons.svg#visible"/>
                                                                </svg>
                                                            </span>
                                                            <span>
                                                                <svg class="icon icon-no-visible" v-show="new_password_field_visible">
                                                                    <use xlink:href="/img/icons.svg#no-visible" />
                                                                </svg>
                                                            </span>
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="form-box">
                                                <div class="form-box__label"><span>Повтор нового пароля</span></div>
                                                <div class="form-box__content">
                                                    <div class="form-input-box form-input-password">

                                                        <ValidationProvider
                                                            name="confirm_new_password"
                                                            :rules="{ required : true, max:50 }"
                                                            v-slot="{ errors }"
                                                        >
                                                            <input :type=" confirm_new_password_field_visible ? 'input' : 'password'"
                                                                   class="form-control form-input-box__input"
                                                                   id="confirm_new_password"
                                                                   v-model="form.confirm_new_password">
                                                            <p class="validation_error">{{
                                                                    clearErrorMessage(errors[0])
                                                                }}</p>
                                                        </ValidationProvider>

                                                        <a @click="showHideVisiblePassword('confirm_new_password')"
                                                           class="form-input-box__control form-input-password__btn-visible">
                                                            <span>
                                                                <svg class="icon icon-visible" v-show="!confirm_new_password_field_visible">
                                                                    <use xlink:href="/img/icons.svg#visible"/>
                                                                </svg>
                                                            </span>
                                                            <span>
                                                                <svg class="icon icon-no-visible" v-show="confirm_new_password_field_visible">
                                                                    <use xlink:href="/img/icons.svg#no-visible" />
                                                                </svg>
                                                            </span>
                                                        </a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="profile-personal__form-button flex justify-center">
                                        <button type="submit" class="btn btn--secondary">Сохранить</button>
                                    </div>


                                </form>
                            </ValidationObserver>


                        </div>
                        <div class="profile-personal__social">
                            <div class="profile-personal__social-title">Социальные сети для быстрого входа:</div>
                            <div class="profile-personal__social-flex flex flex-wrap">
                                <a href="#" class="social-block social-block--active _vk">
                                    <div class="social-block__icon">
                                        <svg class="icon icon-vk">
                                            <use xlink:href="/img/icons.svg#vk"/>
                                        </svg>
                                    </div>
                                    <div class="social-block__text">Привязано</div>
                                </a>
                                <a href="#" class="social-block _google">
                                    <div class="social-block__icon">
                                        <svg class="icon icon-google">
                                            <use xlink:href="/img/icons.svg#google"/>
                                        </svg>
                                    </div>
                                    <div class="social-block__text">Привязать</div>
                                </a>
                                <a href="#" class="social-block _facebook">
                                    <div class="social-block__icon">
                                        <svg class="icon icon-facebook">
                                            <use xlink:href="/img/icons.svg#facebook"/>
                                        </svg>
                                    </div>
                                    <div class="social-block__text">Привязать</div>
                                </a>
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

import PersonalMenuSidebar from './personal_menu_sidebar.vue'
import PersonalTopMenu from './personal_top_menu.vue'

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


import appMixin from '../../appMixin'

export default ({
    mixins: [appMixin],

    props: [
        'loggedUser',
        'userProfile',
    ],

    components: {
        AppLayout,
        ValidationObserver,
        ValidationProvider,
        PersonalMenuSidebar,
        PersonalTopMenu
    },

    mounted() {
    },
    data() {
        return {
            current_password_field_visible: false,
            new_password_field_visible: false,
            confirm_new_password_field_visible: false,
            form: {
                current_password: '',
                new_password: '',
                confirm_new_password: '',
            }
        }
    },

    computed: {},
    methods: {
        showHideVisiblePassword(field_name) {
            console.log('showHideVisiblePassword field_name::')
            console.log(field_name)
            if (field_name === 'current_password' ) {
                this.current_password_field_visible = !this.current_password_field_visible
            }
            if (field_name === 'new_password' ) {
                this.new_password_field_visible = !this.new_password_field_visible
            }
            if (field_name === 'confirm_new_password' ) {
                this.confirm_new_password_field_visible = !this.confirm_new_password_field_visible
            }
        },

        updateUserProfilePassword() {
            console.log('this.form::')
            console.log(this.form)

            this.$refs.updatePasswordObserverForm.validate().then(success => {
                if (!success) {
                    return
                }

                Window.axios.post('/profile/update/password', this.form).then(({resp}) => {
                    // Swal.fire({
                    //     icon: 'success',
                    //     title: 'Профайл',
                    //     text: resp.data.message
                    // })
                }).catch((error) => {
                    console.error(error)
                    this.$refs.updatePasswordObserverForm.setErrors(error.response.data.errors)
                    // Swal.fire({
                    //         title: 'Профайл',
                    //         text: 'Ошибка измнения пароля к профайлу ! ',
                    //         icon: 'error'
                    //     }
                    // )
                })
            }) // this.$refs.updatePasswordObserverForm.validate().then(success => {


        }   // updateUserProfilePassword() {
    }, // methods: {

})

</script>
