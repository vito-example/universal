<template>
    <div class="language-switcher">
        <a
                :href="route('language', [selectable_locale])"
                class="flex items-center"
        >
                <img
                    :src="`/flag/${selectable_locale}.png`"
                    width="16"
                    height="16"
                >
            <div class="font-size-xs font-weight-600">
                {{ selectable_locale === 'ka' ? 'GEO' : 'ENG' }}
            </div>
        </a>
    </div>
</template>

<script>

export default {
    components: {},
    computed: {
        selectable_locale() {
            if (this.$page.props.locale == 'ka') {
                return 'en';
            }
            return 'ka';
        }
    }
}
</script>
