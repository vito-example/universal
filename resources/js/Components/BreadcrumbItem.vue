<template>
    <section class="main_showcases margin_bottom blog" v-bind:style="{ 'background-image': 'url(' + bannerImage + ')' }">
        <div class="showcase_overlay">
            <div class="wrapper flex center">
                <div class="main_titles">
                    <div class="title_bg bold">{{backgroundTitle}}</div>
                    <div class="title bold white">{{title}}</div>
                </div>
                <div class="paragraph dc" v-html="description">
                </div>
            </div>
        </div>
    </section>

</template>

<script>
export default {
    props: ['item'],
    computed: {
        backgroundTitle () {
            return this.getValueByFields('background_title')
        },

        title () {
            return this.getValueByFields('title')
        },

        description () {
            return this.getValueByFields('description')
        },
        bannerImage () {
            return this.getValueByFields('banner_image')
        }
    },
    methods: {
        getValueByFields(key) {
            return this.item[key].value
        }
    }
}
</script>
