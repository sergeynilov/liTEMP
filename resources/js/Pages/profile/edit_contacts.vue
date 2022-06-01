<template>
    <app-layout>

        <personal-top-menu current_page="personal"></personal-top-menu>

        <div class="profile-personal">
            <div class="container">
                <div class="profile-personal__flex flex">

                    <personal-menu-sidebar current_page="contacts"></personal-menu-sidebar>


                    <div class="profile-personal__content">
                        <div class="profile-personal__form">
                            <form  @submit.prevent="updateUserProfileContacts">
                                <div class="profile-personal__form-content">

                                    <div class="form-group">
                                        <div class="form-box">
                                            <div class="form-box__label"><span>Номер телефона</span></div>
                                            <div class="form-box__content">
                                                <input type="text" class="form-control" id="phone" v-model="form.phone">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-box">
                                            <div class="form-box__label"><span>Электроная почта</span></div>
                                            <div class="form-box__content">

                                                <div class="form-input-box">
                                                    <input type="email" class="form-control form-input-box__input"  id="email" v-model="form.email" disabled>
                                                    <a href="javascript:" class="form-input-box__control"><svg class="icon icon-edit">
                                                        <use xlink:href="/img/icons.svg#edit" />
                                                    </svg></a>
                                                </div>
                                                <div class="form-info">
                                                    <svg class="icon icon-info">
                                                        <use xlink:href="/img/icons.svg#info" />
                                                    </svg>
                                                    <div>Чтобы поменять алрес электронной почты, нужно <a href="">отправить запрос</a> администратору сайта</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-box">
                                            <div class="form-box__label"><span>Социальные сети</span></div>
                                            <div class="form-box__content">
                                                <div class="form-input-box form-input-social">
                                                    <div class="form-input-social__head">
                                                        <div class="form-input-social__icon">
                                                            <svg class="icon icon-instagram">
                                                                <use xlink:href="/img/icons.svg#instagram" />
                                                            </svg>
                                                        </div>
                                                        <div class="form-input-social__name">Instagram</div>
                                                    </div>
                                                    <a href="javascript:" class="form-input-social__anchor">
                                                        <svg class="icon icon-anchor">
                                                            <use xlink:href="/img/icons.svg#anchor" />
                                                        </svg>
                                                    </a>
                                                    <input type="text" class="form-control form-input-box__input" id="instagram" v-model="form.instagram">
                                                </div>
                                                <div class="form-input-box form-input-social">
                                                    <div class="form-input-social__head">
                                                        <div class="form-input-social__icon">
                                                            <svg class="icon icon-facebook">
                                                                <use xlink:href="/img/icons.svg#facebook" />
                                                            </svg>
                                                        </div>
                                                        <div class="form-input-social__name">Facebook</div>
                                                    </div>

                                                    <a href="javascript:" class="form-input-social__anchor">
                                                        <svg class="icon icon-anchor">
                                                            <use xlink:href="/img/icons.svg#anchor" />
                                                        </svg>
                                                    </a>
                                                    <input type="text" class="form-control form-input-box__input" id="facebook" v-model="form.facebook">
                                                </div>
                                                <div class="form-input-box form-input-social">
                                                    <div class="form-input-social__head">
                                                        <div class="form-input-social__icon">
                                                            <svg class="icon icon-vk">
                                                                <use xlink:href="/img/icons.svg#vk" />
                                                            </svg>
                                                        </div>
                                                        <div class="form-input-social__name">VK.com</div>
                                                    </div>

                                                    <a href="javascript:" class="form-input-social__anchor">
                                                        <svg class="icon icon-anchor">
                                                            <use xlink:href="/img/icons.svg#anchor" />
                                                        </svg>
                                                    </a>
                                                    <input type="text" class="form-control form-input-box__input" id="vk" v-model="form.vk">
                                                </div>
                                                <div class="form-input-box form-input-social">
                                                    <div class="form-input-social__head">
                                                        <div class="form-input-social__icon">
                                                            <svg class="icon icon-twitter">
                                                                <use xlink:href="/img/icons.svg#twitter" />
                                                            </svg>
                                                        </div>
                                                        <div class="form-input-social__name">Twitter</div>
                                                    </div>

                                                    <a href="javascript:" class="form-input-social__anchor">
                                                        <svg class="icon icon-anchor">
                                                            <use xlink:href="/img/icons.svg#anchor" />
                                                        </svg>
                                                    </a>
                                                    <input type="text" class="form-control form-input-box__input" id="twitter" v-model="form.twitter">
                                                </div>
                                                <div class="form-input-box form-input-social">
                                                    <div class="form-input-social__head">
                                                        <div class="form-input-social__icon">
                                                            <svg class="icon icon-soc500px">
                                                                <use xlink:href="/img/icons.svg#soc500px" />
                                                            </svg>
                                                        </div>
                                                        <div class="form-input-social__name">500px</div>
                                                    </div>

                                                    <a href="javascript:" class="form-input-social__anchor">
                                                        <svg class="icon icon-anchor">
                                                            <use xlink:href="/img/icons.svg#anchor" />
                                                        </svg>
                                                    </a>
                                                    <input type="text" class="form-control form-input-box__input" id="px500" v-model="form.px500">
                                                </div>
                                                <div class="form-input-box form-input-social">
                                                    <div class="form-input-social__head">
                                                        <div class="form-input-social__icon">
                                                            <svg class="icon icon-linkendin">
                                                                <use xlink:href="/img/icons.svg#linkendin" />
                                                            </svg>
                                                        </div>
                                                        <div class="form-input-social__name">LinkendIn</div>
                                                    </div>

                                                    <a href="javascript:" class="form-input-social__anchor">
                                                        <svg class="icon icon-anchor">
                                                            <use xlink:href="/img/icons.svg#anchor" />
                                                        </svg>
                                                    </a>
                                                    <input type="text" class="form-control form-input-box__input" id="linkendin" v-model="form.linkendin">
                                                </div>
                                                <div class="form-input-box form-input-social">
                                                    <div class="form-input-social__head">
                                                        <div class="form-input-social__icon">
                                                            <svg class="icon icon-unslplash">
                                                                <use xlink:href="/img/icons.svg#unslplash" />
                                                            </svg>
                                                        </div>
                                                        <div class="form-input-social__name">Unslplash</div>
                                                    </div>

                                                    <a href="javascript:" class="form-input-social__anchor">
                                                        <svg class="icon icon-anchor">
                                                            <use xlink:href="/img/icons.svg#anchor" />
                                                        </svg>
                                                    </a>
                                                    <input type="text" class="form-control form-input-box__input" id="unslplash" v-model="form.unslplash">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-box">
                                            <div class="form-box__label"><span>Мессенджеры</span></div>
                                            <div class="form-box__content">
                                                <div class="form-input-box form-input-social">
                                                    <div class="form-input-social__head">
                                                        <div class="form-input-social__icon">
                                                            <svg class="icon icon-telegram">
                                                                <use xlink:href="/img/icons.svg#telegram" />
                                                            </svg>
                                                        </div>
                                                        <div class="form-input-social__name">Telegram</div>
                                                    </div>
                                                    <a href="javascript:" class="form-input-social__anchor">
                                                        <svg class="icon icon-anchor">
                                                            <use xlink:href="/img/icons.svg#anchor" />
                                                        </svg>
                                                    </a>
                                                    <input type="text" class="form-control form-input-box__input" id="telegram" v-model="form.telegram">
                                                </div>
                                                <div class="form-input-box form-input-social">
                                                    <div class="form-input-social__head">
                                                        <div class="form-input-social__icon">
                                                            <svg class="icon icon-facebook-messenger">
                                                                <use xlink:href="/img/icons.svg#facebook-messenger" />
                                                            </svg>
                                                        </div>
                                                        <div class="form-input-social__name">Facebook Messenger</div>
                                                    </div>

                                                    <a href="javascript:" class="form-input-social__anchor">
                                                        <svg class="icon icon-anchor">
                                                            <use xlink:href="/img/icons.svg#anchor" />
                                                        </svg>
                                                    </a>
                                                    <input type="text" class="form-control form-input-box__input" id="facebook_messenger" v-model="form.facebook_messenger">
                                                </div>
                                                <div class="form-input-box form-input-social">
                                                    <div class="form-input-social__head">
                                                        <div class="form-input-social__icon">
                                                            <svg class="icon icon-vk">
                                                                <use xlink:href="/img/icons.svg#vk" />
                                                            </svg>
                                                        </div>
                                                        <div class="form-input-social__name">Viber</div>
                                                    </div>

                                                    <a href="javascript:" class="form-input-social__anchor">
                                                        <svg class="icon icon-anchor">
                                                            <use xlink:href="/img/icons.svg#anchor" />
                                                        </svg>
                                                    </a>
                                                    <input type="text" class="form-control form-input-box__input" id="viber" v-model="form.viber">
                                                </div>
                                                <div class="form-input-box form-input-social">
                                                    <div class="form-input-social__head">
                                                        <div class="form-input-social__icon">
                                                            <svg class="icon icon-whatsapp">
                                                                <use xlink:href="/img/icons.svg#whatsapp" />
                                                            </svg>
                                                        </div>
                                                        <div class="form-input-social__name">WhatsApp</div>
                                                    </div>
                                                    <a href="javascript:" class="form-input-social__anchor">
                                                        <svg class="icon icon-anchor">
                                                            <use xlink:href="/img/icons.svg#anchor" />
                                                        </svg>
                                                    </a>
                                                    <input type="text" class="form-control form-input-box__input" id="whatsapp" v-model="form.whatsapp">
                                                </div>
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

export default ({
    props: [
        'loggedUser',
        'userProfile',
    ],

    components: {
        AppLayout,
        PersonalMenuSidebar,
        PersonalTopMenu
    },

    mounted() {
        this.form.user_id = this.loggedUser.id
        this.form.email = this.loggedUser.email
        this.form.phone = this.userProfile.phone
        this.form.instagram = this.userProfile.instagram
        this.form.facebook = this.userProfile.facebook
        this.form.twitter = this.userProfile.twitter
        this.form.px500 = this.userProfile.px500
        this.form.linkendin = this.userProfile.linkendin
        this.form.unslplash = this.userProfile.unslplash
        this.form.telegram = this.userProfile.telegram
        this.form.facebook_messenger = this.userProfile.facebook_messenger
        this.form.viber = this.userProfile.viber
        this.form.vk = this.userProfile.vk
        this.form.whatsapp = this.userProfile.whatsapp
    },
    data() {
        return {
            form: {
                user_id: '',
                phone: '',
                instagram: '',
                facebook: '',
                twitter: '',
                px500: '',
                linkendin: '',
                unslplash: '',
                telegram: '',
                facebook_messenger: '',
                viber: '',
                vk: '',
                whatsapp: '',
            }
        }
    },

    computed: {},
    methods: {
        updateUserProfileContacts() {

            Window.axios.post('/profile/update/contacts', this.form)
                .then(resp => {
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
        }   // updateUserProfileContacts() {

    }, // methods: {

})

</script>
