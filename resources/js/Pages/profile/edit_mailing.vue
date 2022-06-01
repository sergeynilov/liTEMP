<template>
    <app-layout>

        <personal-top-menu current_page="personal"></personal-top-menu>

        <div class="profile-personal">
            <div class="container">
                <div class="profile-personal__flex flex">

                    <personal-menu-sidebar current_page="mailing"></personal-menu-sidebar>

                    <div class="profile-personal__content">

                        <div class="profile-personal__form">
                            <form @submit.prevent="updateUserProfileMailing">

                                <div class="profile-personal__settings">
                                    <div class="profile-personal__settings-item">
                                        <label class="profile-personal__settings-checkbox checkbox-toggle">
                                    <span
                                        class="checkbox-toggle__text">Отправлять копию сообщений от администрации</span>
                                            <input type="checkbox" class="checkbox-toggle__input"
                                                   id="send_message_copy_from_administration"
                                                   v-model="form.send_message_copy_from_administration">
                                            <div class="checkbox-toggle__icon"></div>
                                        </label>
                                    </div>
                                    <div class="profile-personal__settings-item">
                                        <label class="profile-personal__settings-checkbox checkbox-toggle">
                                            <span class="checkbox-toggle__text">Уведомлять о новых сообщениях от других пользователей</span>
                                            <input type="checkbox" class="checkbox-toggle__input"
                                                   id="notify_about_messages_from_other_users"
                                                   v-model="form.notify_about_messages_from_other_users">
                                            <div class="checkbox-toggle__icon"></div>
                                        </label>
                                    </div>
                                    <div class="profile-personal__settings-item">
                                        <label class="profile-personal__settings-checkbox checkbox-toggle">
                                            <span class="checkbox-toggle__text">Получение номинации</span>
                                            <input type="checkbox" class="checkbox-toggle__input"
                                                   id="getting_nomination" v-model="form.getting_nomination">
                                            <div class="checkbox-toggle__icon"></div>
                                        </label>
                                    </div>
                                    <div class="profile-personal__settings-item">
                                        <label class="profile-personal__settings-checkbox checkbox-toggle">
                                            <span class="checkbox-toggle__text">Новые комментарии под фотографией</span>
                                            <input type="checkbox" class="checkbox-toggle__input"
                                                   id="new_comments_below_photo"
                                                   v-model="form.new_comments_below_photo">
                                            <div class="checkbox-toggle__icon"></div>
                                        </label>
                                    </div>
                                    <div class="profile-personal__settings-item">
                                        <label class="profile-personal__settings-checkbox checkbox-toggle">
                                            <span
                                                class="checkbox-toggle__text">Новые комментарии к моей теме на форуме</span>
                                            <input type="checkbox" class="checkbox-toggle__input" checked
                                                   id="new_comments_on_thread_on_forum"
                                                   v-model="form.new_comments_on_thread_on_forum">
                                            <div class="checkbox-toggle__icon"></div>
                                        </label>
                                    </div>
                                    <div class="profile-personal__settings-item">
                                        <label class="profile-personal__settings-checkbox checkbox-toggle">
                                    <span
                                        class="checkbox-toggle__text">Новые комментарии к отслеживаемой теме на форуме</span>
                                            <input type="checkbox" class="checkbox-toggle__input" checked
                                                   id="new_comments_on_tracked_topic_in_forum"
                                                   v-model="form.new_comments_on_tracked_topic_in_forum">
                                            <div class="checkbox-toggle__icon"></div>
                                        </label>
                                    </div>

                                    <div class="profile-personal__settings-item">
                                        <label class="profile-personal__settings-checkbox checkbox-toggle">
                                            <span class="checkbox-toggle__text">Новые фотографии на странице отслеживаемого фотографа</span>
                                            <input type="checkbox" class="checkbox-toggle__input"
                                                   id="new_photos_on_tracked_photographer_page"
                                                   v-model="form.new_photos_on_tracked_photographer_page">
                                            <div class="checkbox-toggle__icon"></div>
                                        </label>
                                    </div>

                                    <div class="profile-personal__settings-item">
                                        <label class="profile-personal__settings-checkbox checkbox-toggle">
                                            <span class="checkbox-toggle__text">Подборка фотографий за неделю от редакции</span>
                                            <input type="checkbox" class="checkbox-toggle__input"
                                                   id="selection_of_photos_from_editorial_board_in_week"
                                                   v-model="form.selection_of_photos_from_editorial_board_in_week">
                                            <div class="checkbox-toggle__icon"></div>
                                        </label>
                                    </div>

                                    <div class="profile-personal__settings-item">
                                        <label class="profile-personal__settings-checkbox checkbox-toggle">
                                            <span class="checkbox-toggle__text">Получать письма о новых событиях и предложениях</span>
                                            <input type="checkbox" class="checkbox-toggle__input"
                                                   id="receive_emails_about_new_events_and_offers"
                                                   v-model="form.receive_emails_about_new_events_and_offers">
                                            <div class="checkbox-toggle__icon"></div>
                                        </label>
                                    </div>

                                    <div class="profile-personal__settings-item">
                                        <label class="profile-personal__settings-checkbox checkbox-toggle">
                                    <span
                                        class="checkbox-toggle__text">Уведомлять меня о новых сообщениях по email</span>
                                            <input type="checkbox" class="checkbox-toggle__input"
                                                   id="notify_me_of_new_messages_by_email"
                                                   v-model="form.notify_me_of_new_messages_by_email">
                                            <div class="checkbox-toggle__icon"></div>
                                        </label>
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
        'userProfile',
        'citiesSelectionArray',
    ],

    components: {
        AppLayout,
        PersonalMenuSidebar,
        PersonalTopMenu
    },

    mounted() {
        this.form.user_id = this.userProfile.user_id
        this.form.send_message_copy_from_administration = this.userProfile.send_message_copy_from_administration
        this.form.notify_about_messages_from_other_users = this.userProfile.notify_about_messages_from_other_users
        this.form.getting_nomination = this.userProfile.getting_nomination
        this.form.new_comments_below_photo = this.userProfile.new_comments_below_photo
        this.form.new_comments_on_thread_on_forum = this.userProfile.new_comments_on_thread_on_forum
        this.form.new_comments_on_tracked_topic_in_forum = this.userProfile.new_comments_on_tracked_topic_in_forum
        this.form.new_photos_on_tracked_photographer_page = this.userProfile.new_photos_on_tracked_photographer_page
        this.form.selection_of_photos_from_editorial_board_in_week = this.userProfile.selection_of_photos_from_editorial_board_in_week
        this.form.receive_emails_about_new_events_and_offers = this.userProfile.receive_emails_about_new_events_and_offers
        this.form.notify_me_of_new_messages_by_email = this.userProfile.notify_me_of_new_messages_by_email
    },
    data() {
        return {
            form: {
                user_id: '',
                send_message_copy_from_administration: false,
                notify_about_messages_from_other_users: false,
                getting_nomination: false,
                new_comments_below_photo: false,
                new_comments_on_thread_on_forum: false,
                new_comments_on_tracked_topic_in_forum: false,
                new_photos_on_tracked_photographer_page: false,
                selection_of_photos_from_editorial_board_in_week: false,
                receive_emails_about_new_events_and_offers: false,
                notify_me_of_new_messages_by_email: false,
            }
        }
    },

    computed: {},
    methods: {
        updateUserProfileMailing() {

            Window.axios.post('/profile/update/mailing', this.form)
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
                                text: 'Ошибка сохранения уведомлений профайла ! ',
                                icon: 'error'
                            }
                        )
                    }
                )
        }   // updateUserProfileMailing() {
    }, // methods: {

})

</script>
