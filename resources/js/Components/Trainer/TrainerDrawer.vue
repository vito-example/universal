<template>
    <drawer
            v-if="visible"
            :title="trainer?.full_name"
            width="708px"
            :class="{'show': visible}"
    >
        <template v-slot:body>
            <div
                    class="font-weight-300 line-height-default"
                    v-html="trainer?.description"
            />
        </template>
    </drawer>
</template>

<script>
import Drawer from "@/Components/Web/Drawer/Drawer"
import emitter from "@/Plugins/bus"

export default {
    components: {
        Drawer
    },

    data () {
        return {
            visible: false,
            trainer: null
        }
    },

    mounted() {
        emitter.on('showTrainerDrawer', (data) => {
            this.trainer = data
            this.visible = true
        })
    }
}
</script>