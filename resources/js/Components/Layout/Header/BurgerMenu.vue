<template>
    <div class="burger-menu">
        <div class="font-size-md font-weight-600 margin-y-10">{{ __('მენიუ') }}</div>
        <ul class="nav">
<!--            <header-navigation-item-->
<!--                    :to="route('trainings.index')"-->
<!--                    :label="__('ტრენინგები')"-->
<!--            />-->
        </ul>
    </div>
</template>

<script>
import emitter from "@/Plugins/bus"
import Dropdown from "@/Components/Web/Dropdown/Dropdown"

export default {
    components: {
        Dropdown
    },

    methods: {
        onShowLoginPopup () {
            emitter.emit('showLoginPopup')
        }
    }
}
</script>
