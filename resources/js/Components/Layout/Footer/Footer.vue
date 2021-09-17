<template>
    <footer class="footer">
        <div class="footer__container container">
            <logo
                height="30"
                alt="Agrarium"
                :custom-class="'footer__brand margin-top-sm-28'"
            />

            <div class="footer__nav">
                <ul class="nav nav--horizontal">
                    <li class="nav__item">
                        <inertia-link :href="route('home.index')" class="nav__link" :title="__('მთავარი')">{{ __('მთავარი') }}</inertia-link>
                    </li>
                    <li class="nav__item">
                        <inertia-link :href="route('trainings.index')" class="nav__link" :title="__('ტრენინგები')">{{ __('ტრენინგები') }}</inertia-link>
                    </li>

                    <li class="nav__item">
                        <inertia-link :href="route('trainings.online')" class="nav__link" :title="__('ონლაინ ტრენინგები')">{{ __('ონლაინ ტრენინგები') }}</inertia-link>
                    </li>

                    <li class="nav__item">
                        <inertia-link :href="route('news.index')" class="nav__link" :title="__('სიახლეები')">{{ __('სიახლეები') }}</inertia-link>
                    </li>

                    <li class="nav__item">
                        <inertia-link :href="route('about.index')" class="nav__link" :title="__('ჩვენ შესახებ')">{{ __('ჩვენ შესახებ') }}</inertia-link>
                    </li>

                    <li class="nav__item">
                        <inertia-link :href="route('contact.index')" class="nav__link" :title="__('კონტაქტი')">{{ __('კონტაქტი') }}</inertia-link>
                    </li>
                </ul>
            </div>

            <div class="footer__copy margin-y-sm-24">
                {{ __('ყველა უფლება დაცულია') }}
            </div>
            <landing-language-selector/>

        </div>
    </footer>
</template>

<script>
import Logo from "@/Components/Layout/Logo/Logo"
import LandingLanguageSelector from "../../LandingLanguageSelector";

export default {
    name: "Footer",
    components: {
        Logo,
        LandingLanguageSelector
    },
}
</script>
