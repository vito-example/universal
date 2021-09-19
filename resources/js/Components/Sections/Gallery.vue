<template>
    <div class="pp_slider_track">
        <div class="slider_project_page flex margin_bottom" >
            <div class="project_view_image" v-for="(slide, index) in gallery" :key="index">
                <img @click="onShowZoom(slide[0].value)" :src="slide[0].value" alt="" />
            </div>
        </div>
        <button class="arr" id="pps_prev">
            <svg
                id="arrow-ios-back"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
            >
                <rect
                    id="Rectangle_28"
                    data-name="Rectangle 28"
                    width="24"
                    height="24"
                    transform="translate(24) rotate(90)"
                    opacity="0"
                />
                <path
                    id="Path_71"
                    data-name="Path 71"
                    d="M13.83,19a1,1,0,0,1-.78-.37l-4.83-6a1,1,0,0,1,0-1.27l5-6a1,1,0,0,1,1.54,1.28L10.29,12l4.32,5.36A1,1,0,0,1,13.83,19Z"
                />
            </svg>
        </button>
        <button class="arr" id="pps_next">
            <svg
                id="arrow-ios-back"
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
            >
                <rect
                    id="Rectangle_28"
                    data-name="Rectangle 28"
                    width="24"
                    height="24"
                    transform="translate(24) rotate(90)"
                    opacity="0"
                />
                <path
                    id="Path_71"
                    data-name="Path 71"
                    d="M13.83,19a1,1,0,0,1-.78-.37l-4.83-6a1,1,0,0,1,0-1.27l5-6a1,1,0,0,1,1.54,1.28L10.29,12l4.32,5.36A1,1,0,0,1,13.83,19Z"
                />
            </svg>
        </button>
    </div>
    <section id="project_popup_view" class="flex center" v-bind:style="{ 'top': showZoom}">
        <div class="image">
            <img :src="zoomImage" alt="" />
            <button id="close_popup" class="flex center">
                <img @click="onShowZoom('')" src="/landing_resources/img/icons/other/close.png" alt="" />
            </button>
        </div>
    </section>

</template>

<script>

export default {
    props: {
        gallery: {
            type: Array
        },

        imageKey: {
            type: String,
            default: 'value'
        }
    },

    data () {
        return {
            zoomImage: '',
            showZoom: '-101%'
        }
    },
    methods: {
        onShowZoom(image) {
            this.showZoom = image ? '0%' : '-101%';
            if (image === '') {
                setTimeout(function(){
                    this.zoomImage = image;
                }, 3000);
            } else {
                this.zoomImage = image;
            }
        }
    }
}
</script>
