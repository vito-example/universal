<template>
    <div class="service_box border">
        <lazy-image
            :src="image"
            :show-placeholder="true"
            :alt="title"
            class="serbox_bg"
        />
        <div class="text2 bold main_blue transition5">
            {{title}}
        </div>
        <p class="para">
            {{description}}
        </p>
        <inertia-link :href="showUrl">
            <button class="plus flex center transition5">
                <svg
                    class="transition5"
                    id="Layer_2"
                    data-name="Layer 2"
                    xmlns="http://www.w3.org/2000/svg"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                >
                    <g id="plus">
                        <rect
                            id="Rectangle_51"
                            data-name="Rectangle 51"
                            width="24"
                            height="24"
                            transform="translate(24 24) rotate(180)"
                            opacity="0"
                        />
                        <path
                            id="Path_72"
                            data-name="Path 72"
                            d="M19,11H13V5a1,1,0,0,0-2,0v6H5a1,1,0,0,0,0,2h6v6a1,1,0,0,0,2,0V13h6a1,1,0,0,0,0-2Z"
                        />
                    </g>
                </svg>
            </button>
        </inertia-link>
        <span></span>
    </div>
</template>

<script>
import LazyImage from "@/Components/Web/Image/Image"

export default {
    components: {
        LazyImage
    },

    props: {
        item: {
            type: String
        }
    },

    computed: {
        showUrl () {
            return this.item.show_url
        },

        image () {
            return this.item.profile_image
        },
        title () {
            return this.item.title
        },

        description () {
            return this.item.description
        },
    }
}
</script>
