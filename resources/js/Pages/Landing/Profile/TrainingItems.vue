<template>
    <div>
        <div class="flex-sm-up items-center space-between margin-bottom-34"
             v-for="(training,index) in trainings" v-if="trainings.length">
            <div>
                <inertia-link :href="training.show_url" class="color-black text-decoration-none">
                    <div class="font-weight-600 width-sm-full">{{training.title}}</div>
                </inertia-link>

                <div class="flex margin-top-18">
                    <div
                            v-if="training.form === 'online'"
                            class="label label--light-outline border-color-middle-green-yellow color-middle-green-yellow flex items-center">
                        <div class="label__icon line-height-0 padding-right-8">
                            <video-icon width="16" height="16"/>
                        </div>

                        {{__('Online')}}
                    </div>
                    <div class="label label--light-outline flex items-center"
                         v-bind:class="{ 'margin-left-12': training.form ==='online' }">
                        <div class="label__icon line-height-0 padding-right-8">
                            <calendar-icon width="16" height="16"/>
                        </div>

                        {{ training.start_time }} {{training.start_time_hour}} {{__('სთ')}}
                    </div>
                    <div class="flex items-center margin-left-12 cursor-pointer">
                        <a @click="handleShowInfoTraining(training)">
                            <span><alert-icon width="24" height="24"/></span>
                        </a>
                    </div>
                </div>
            </div>

            <div v-if="training.form === 'online'">
                <a :href="training.link"
                   target="_blank"
                   class="button button--primary button--border text-center"
                   :class="{'is-disabled': isActive(training)}">
                    {{ __('ტრენინგის ლინკი') }}
                </a>
            </div>
            <div v-else-if="training.place">
                <a href="" disabled
                   class="button button--primary is-disabled button--border text-center hide-sm-down">

                    {{ training.place }}
                </a>
            </div>
        </div>

        <info-popup/>
    </div>
</template>

<script>
import LocationIcon from "@/Components/Web/Icons/Location";
import InfoPopup from "@/Components/Web/Popup/InfoTraining";
import CalendarIcon from "@/Components/Web/Icons/Calendar";
import AlertIcon from "@/Components/Web/Icons/Alert";
import emitter from "@/Plugins/bus";

export default {
    components: {
        LocationIcon,
        InfoPopup,
        CalendarIcon,
        AlertIcon
    },

    props: {
        trainings: {
            type: Array
        }
    },
    methods: {
        isActive(item) {
            let now = new Date('YYYY-MM-DD HH:mm:ss');
            if (now > item.start_date && now < item.end_date && item.link) return false;
            return true;
        },
        handleShowInfoTraining(training) {
            emitter.emit('showInfoTrainingPopup', training)
        },
    }
}
</script>
