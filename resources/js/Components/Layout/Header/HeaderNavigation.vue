<template>
    <div class="header__nav">
        <ul class="nav nav--horizontal">
            <ul>
                <header-navigation-item
                    :to="route('trainings.index')"
                    :label="__('ტრენინგები')"
                />

                <header-navigation-item
                    :to="route('trainings.online')"
                    :label="__('ონლაინ ტრენინგები')"
                />

                <header-navigation-item
                    :to="route('news.index')"
                    :label="__('სიახლეები')"
                />

                <header-navigation-item
                    :to="route('about.index')"
                    :label="__('ჩვენ შესახებ')"
                />

                <header-navigation-item
                    :to="route('contact.index')"
                    :label="__('კონტაქტი')"
                />
            </ul>
        </ul>
    </div>
</template>

<script>
import HeaderNavigationItem from "@/Components/Layout/Header/HeaderNavigationItem"
import Dropdown from "@/Components/Web/Dropdown/Dropdown";

export default {
    name: "HeaderNavigation",

    components: {
        HeaderNavigationItem,
        Dropdown
    },

    data () {
        return {
            showBurgerMenu: false
        }
    },

    computed: {
        /**
         *
         * @returns {string}
         */
        logoUrl () {
            return `/logo/logo.svg`
        },
        profileOptions () {
            return [
                {
                    label: 'პროფილი',
                    route: 'profile.show',
                    icon: 'user'
                },
                {
                    label: 'გამოსვლა',
                    route: 'logout',
                    icon: 'logout'
                },
            ];
        }
    },

    methods: {
        handleToggleSwitch () {
            this.showBurgerMenu = !this.showBurgerMenu
        }
    }
}
</script>

<style scoped lang="scss">
    #close_in {
        i {
            color: white !important;
        }
    }
</style>
