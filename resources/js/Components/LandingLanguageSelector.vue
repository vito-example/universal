<template>
    <div class="languages red_bg part flex center">
        <img src="/landing_resources/img/icons/header/5.png" alt="" />
        <div class="dropdown">
            <a class="lang" :class="{ 'on': isActive('ka') }" :href="route('language', 'ka')">{{__('GEO')}}</a>
            <a class="lang" :class="{ 'on': isActive('en') }" :href="route('language','en')">{{__('ENG')}}</a>
            <a class="lang" :class="{ 'on': isActive('ru') }" :href="route('language', 'ru')">{{__('RUS')}}</a>
            <a class="lang" :class="{ 'on': isActive('fr') }" :href="route('language', 'fr')">{{__('FRN')}}</a>
        </div>
    </div>
</template>

<script>

export default {
    components: {},
    methods: {
        isActive(locale) {
            return this.$page.props.locale === locale ? 'on' : '';
        }
    }
}
</script>
