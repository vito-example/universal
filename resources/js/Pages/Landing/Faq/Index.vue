<template>
    <landing>
        <template v-slot:main>
            <div class="sub_header bg_2" v-bind:style="{ backgroundImage: 'url(' + headerImage + ')' }">
                <div id="intro_txt" class="animated fadeInDown">
                    <span class="static-page" v-html="headerTitle"></span>
                </div>
            </div>
            <div class="container_gray_bg">
                <div class="container margin_60">
                    <span v-html="content"></span>
                </div>
            </div>
        </template>
    </landing>
</template>
<script>
import Landing from "@/Layouts/Landing";
export default {
    components: {
        Landing
    },
    props: {
        page: {
            type: Object
        }
    },
    computed: {
        headerImage () {
            return this.fields.header_image.value
        },
        headerTitle () {
            return this.fields.header_title.value
        },
        content () {
            return this.fields.description.value
        },
        fields () {
            return this.page.fields
        }
    }
}
</script>
