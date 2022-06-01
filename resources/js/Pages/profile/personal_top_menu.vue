<template>
    <div class="profile-menu">
        <div class="container">
            <button class="profile-menu__button"><span>Настройки</span></button>
            <ul class="profile-menu__list">

                <li class="profile-menu__item"  :class="current_page == 'profile_index' ? 'active' : ''">
                    <inertia-link :href="route('profile.index') ">
                        <span>Моя страница</span>
                    </inertia-link>
                </li>

                <li class="profile-menu__item ">
                    <a href="messages.html"><span>Сообщения</span><sup>3</sup></a></li>

                <li class="profile-menu__item">
                    <a href="profile_favorits_photos.html"><span>Избранные</span></a>
                </li>

                <li class="profile-menu__item">
                    <a href="pro.html"><span>PRO</span></a>
                </li>

                <li class="profile-menu__item" :class="current_page == 'personal' ? 'active' : ''">
                    <inertia-link :href="route('profile.edit.personal') ">
                        <span>Настройки</span>
                    </inertia-link>
                </li>

                <li class="profile-menu__item profile-menu__item--logout">
                    <a @click.prevent="logout()"><span>Выход</span></a>
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
        logout() {
            this.$inertia.post(route('logout'));
            window.location.href = window.location.origin;
        },
    },

     mounted() {
    },
    data() {
        return {
        }
    },


})

</script>
