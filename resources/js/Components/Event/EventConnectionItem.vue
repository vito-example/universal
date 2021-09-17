<template>
    <div class="col-md-6 col-sm-4">
        <ul class="list_teachers">
            <li :class="hasImageClass">
                <figure v-if="item.image_url">
                    <img :src="item.image_url" alt="" class="img-rounded">
                </figure>
                <h5>{{ item.label }}</h5>
                <Tooltip :tooltipText="item.sub_title" v-if="item.sub_title">
                    <button class="font-xl mt-2"><i class="pe-7s-info"></i></button>
                </Tooltip>
            </li>
        </ul>
    </div>
</template>

<script>
import Tooltip from "@/Components/Tooltip";

export default {
    components: {
        Tooltip
    },

    props: {
        item: {
            type: Object
        }
    },

    computed: {
        hasImageClass () {
            return this.item.image_url ? 'has-image' : ''
        }
    }
}
</script>
