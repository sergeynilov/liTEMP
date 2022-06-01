<template>

    <div class="profile-personal__sidebar">
<!--        <nav :class="'header__nav ' + (is_menu_hidden ? 'active' : '' )">-->

<!--        current_page::{{ current_page }}<br>-->
<!--        is_menu_hidden::{{ is_menu_hidden }}<br>-->
        <div :class="'profile-personal__menu sidebar-menu ' + (is_menu_hidden ? 'active' : '' )">
            <button class="sidebar-menu__button" @click.prevent="togglePersonalMenuSidebarMenu()">Публичные данные</button>
            <ul class="sidebar-menu__list">

                <li :class="current_page == 'personal' ? 'active' : ''">
                    <inertia-link :href="route('profile.edit.personal') ">
                        <span>Публичные данные</span>
                    </inertia-link>
                </li>

                <li :class="current_page == 'contacts' ? 'active' : ''">
                    <inertia-link :href="route('profile.edit.contacts') ">
                        <span>Контакты</span>
                    </inertia-link>
                </li>

                <li :class="current_page == 'password' ? 'active' : ''">
                    <inertia-link :href="route('profile.edit.password') ">
                        <span>Пароль</span>
                    </inertia-link>
                </li>

                <li :class="current_page == 'mailing' ? 'active' : ''">
                    <inertia-link :href="route('profile.edit.mailing') ">
                        <span>Уведомления</span>
                    </inertia-link>
                </li>

            </ul>
        </div>
    </div>

</template>


<script>
export default ({
    props: [
        'current_page',
    ],

    components: {
    },

    methods: {
        togglePersonalMenuSidebarMenu: function () {
            // console.log('togglePersonalMenuSidebarMenu this.is_menu_hidden::')
            // console.log(this.is_menu_hidden)
            this.is_menu_hidden = !this.is_menu_hidden
        },
    },

     mounted() {
    },
    data() {
        return {
            is_menu_hidden: false,
        }
    },


})

</script>
