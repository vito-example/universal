<template>
    <div class="burger-menu">
        <div class="font-size-md font-weight-600 margin-y-10">{{ __('მენიუ') }}</div>
        <ul class="nav">
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

        <hr class="margin-top-16 margin-bottom-32">

        <button
                v-if="!isAuth()"
                type="button"
                class="button button--secondary button--shadow width-full padding-y-11 border-radius-12"
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
</template>

<script>
import emitter from "@/Plugins/bus"
import HeaderNavigationItem from "@/Components/Layout/Header/HeaderNavigationItem"
import Dropdown from "@/Components/Web/Dropdown/Dropdown"

export default {
    components: {
        HeaderNavigationItem,
        Dropdown
    },

    methods: {
        onShowLoginPopup () {
            emitter.emit('showLoginPopup')
        }
    }
}
</script>