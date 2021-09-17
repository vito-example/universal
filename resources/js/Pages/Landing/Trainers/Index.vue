<template>
    <landing>
        <template v-slot:main>
            <breadcrumb :active="__('ტრენერები')" />
            <div class="content container">
                <div class="row margin-top-40">
                    <template v-for="item in items.data">
                        <div class="col-3 col-lg-3 col-sm-4 col-xs-12">
                            <trainer-item
                                    :trainer="item"
                                    class="margin-bottom-sm-20"
                            />
                        </div>
                    </template>
                </div>
            </div>

            <trainer-drawer />
        </template>
    </landing>
</template>
<script>
import emitter from "@/Plugins/bus"
import Landing from "@/Layouts/Landing"
import Breadcrumb from "@/Components/Web/Breadcrumb/Breadcrumb"
import TrainerItem from "@/Components/Trainer/TrainerItem"
import TrainerDrawer from "@/Components/Trainer/TrainerDrawer"
import {getData} from "../../../base/mixins/getData"
import {responseParse} from "../../../base/mixins/responseParse"

export default {
    components: {
        Landing,
        Breadcrumb,
        TrainerDrawer,
        TrainerItem
    },
    props: {
        items: {
            type: Array
        },
    },
    data() {
        return {
            trainerShow: {
                full_name : '',
                description: '',
            }
        }
    }
}
</script>
