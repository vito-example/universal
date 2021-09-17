<template>
    <div
            class="person width-full"
            @click="handleShowTrainer(showUrl)"
    >
        <div class="person__image cursor-pointer">
            <lazy-image
                    :src="image"
                    :show-placeholder="true"
                    :alt="fullName"
            />

            <div class="person__overlay animate__animated animate__fadeIn animate__faster">
                <div class="person__info animate__animated animate__fadeInUp animate__faster">
                    <h5 class="person__title">{{ fullName }}</h5>
                    <div
                            class="person__text line-height-default"
                            v-html="description"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import LazyImage from "@/Components/Web/Image/Image"
import {getData} from "@/base/mixins/getData";
import {responseParse} from "@/base/mixins/responseParse";
import emitter from "@/Plugins/bus";

export default {
    components: {
        LazyImage
    },

    props: {
        trainer: {
            type: Object
        }
    },

    computed: {
        showUrl () {
            return this.trainer.show_url
        },

        image () {
            return this.trainer.profile_image
        },

        fullName () {
            return this.trainer.full_name
        },

        description () {
            return this.trainer.description
        }
    },

    methods: {
        async handleShowTrainer(showUrl) {
            this.loading = true;

            await getData({
                method: 'GET',
                url: showUrl,
            }).then(response => {
                // Parse response notification.
                responseParse(response, false);

                if (response.status === 200) {
                    // Response data.
                    let data = response.data;

                    emitter.emit('showTrainerDrawer', data.lecturer)
                }
                this.loading = false
            })
        }
    }
}
</script>