<template>
    <header class="header">
        <div class="header__container container">
            <logo
                height="44"
                alt="Agrarium"
                :custom-class="'header__brand'"
            />

            <HeaderNavigation />

            <div class="header__profile">
                <button
                    v-if="!isAuth()"
                    type="button"
                    class="button button--secondary button--shadow padding-y-11 border-radius-12"
                    @click="onShowLoginPopup"
                >
                  {{__('ავტორიზაცია')}}
                </button>

              <dropdown
                  v-if="isAuth()"
                  :options="profileOptions"
                  :default="`${firstName()}`"
                  class="select"
              />
            </div>

            <div class="show-md-down">
                <button
                        class="button button--link padding-0"
                        v-if="!burgerMenuVisible"
                        @click="onShowBurgerMenu"
                >
                    <svg width="21" height="24" viewBox="0 0 24 27" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 4H21V6H3V4ZM3 11H21V13H3V11ZM3 18H21V20H3V18Z" fill="black"/>
                    </svg>
                </button>

                <button
                        class="button button--link padding-0"
                        v-if="burgerMenuVisible"
                        @click="onShowBurgerMenu"
                >
                    <svg width="18" height="24" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 13.5L13 1.5M1 1.5L13 13.5" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>

        <burger-menu v-if="burgerMenuVisible" />
    </header>
</template>

<script>
import emitter from "@/Plugins/bus"
import { Inertia } from "@inertiajs/inertia"

// components
import HeaderNavigation from "@/Components/Layout/Header/HeaderNavigation"
import Logo from "@/Components/Layout/Logo/Logo"
import Dropdown from "@/Components/Web/Dropdown/Dropdown"
import BurgerMenu from "@/Components/Layout/Header/BurgerMenu"

export default {
    name: "Header",

    components: {
        HeaderNavigation,
        Logo,
        Dropdown,
        BurgerMenu
    },

    data () {
        return {
            burgerMenuVisible: false
        }
    },

    methods: {
        onShowLoginPopup () {
          emitter.emit('showLoginPopup')
        },

        onShowBurgerMenu () {
            this.burgerMenuVisible = !this.burgerMenuVisible
        }
    },

    mounted () {
        Inertia.on('start', (event) => {
            this.burgerMenuVisible = false
        })
    }
}
</script>
