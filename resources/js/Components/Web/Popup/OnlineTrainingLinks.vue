<template>
    <popup
        v-if="visible"
        :title="__('ტრენინგის ლინკი')"
        :width="width"
    >
        <div class="flex items-center space-between margin-top-34" v-for="(item,index) in sessions"
             v-if="sessions.length">
            <div>
                <div class="font-weight-600">{{item.title}}</div>

                <div class="flex margin-top-18">
                    <div
                        class="label label--light-outline border-color-middle-green-yellow color-middle-green-yellow flex items-center">
                        <div class="label__icon line-height-0 padding-right-8">
                            <video-icon width="16" height="16"/>
                        </div>

                        Online
                    </div>
                    <div class="label label--light-outline flex items-center margin-left-12">
                        <div class="label__icon line-height-0 padding-right-8">
                            <calendar-icon width="16" height="16"/>
                        </div>

                        {{item.start_time}} {{item.start_time_hour}} {{სთ}}
                    </div>
                </div>
            </div>

            <div>
                <a :href="item.link" target="_blank" class="button button--primary button--border text-center"
                   :class="{'is-disabled': isActive(item)}">
                    {{__('ტრენინგის ლინკი')}}
                </a>
            </div>
        </div>
    </popup>
</template>

<script>
import Popup from "@/Components/Web/Popup/Popup";
import emitter from "@/Plugins/bus";
import CalendarIcon from "@/Components/Web/Icons/Calendar";
import VideoIcon from "@/Components/Web/Icons/Video";
import moment from "moment";

export default {
    props: {
        width: {
            type: String
        }
    },

    components: {
        Popup,
        CalendarIcon,
        VideoIcon
    },

    data() {
        return {
            sessions: [],
            visible: false,
        }
    },

    methods: {
        isActive(item) {
            let now = new Date('YYYY-MM-DD HH:mm:ss');
            if (now > item.start_date && now < item.end_date && item.link) return false;
            return true;
        }
    },

    mounted() {
        emitter.on('showOnlineTrainingLinks', (sessions) => {
            this.sessions = sessions;
            this.visible = true
        })
    }
}
</script>
