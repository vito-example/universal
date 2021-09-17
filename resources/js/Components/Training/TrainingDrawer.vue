<template>
    <drawer
            v-if="visible"
            :title="__('ტრენინგის პროგრამა')"
            width="708px"
            :class="{'show': visible}"
    >
        <template v-slot:body>
            <a v-if="training?.files?.length" v-for="(el,key) in training?.files" :href="el.file" :key="key" class="color-fulvous font-size-sm text-decoration-none flex items-center margin-bottom-30">
                <div>
                    <download-icon width="32" height="22"/>
                </div>
                {{__('პროგრამის ჩამოტვირთვა')}}
            </a>

            <div
                    class="font-weight-300 line-height-default"
                    v-html="training?.syllabus"
            />
        </template>
    </drawer>
</template>

<script>
import Drawer from "@/Components/Web/Drawer/Drawer"
import emitter from "@/Plugins/bus"
import DownloadIcon from "@/Components/Web/Icons/Download"

export default {
    components: {
        Drawer,
        DownloadIcon
    },

    data () {
        return {
            visible: false,
            training: null
        }
    },

    mounted() {
        emitter.on('showTrainigDrawer', (data) => {
            this.training = data
            this.visible = true
        })
    }
}
</script>