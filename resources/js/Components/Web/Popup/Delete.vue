<template>
    <popup
        v-if="visible"
        :title="__('ნამდვილად გსურთ წაშლა?')"
    >
        <div v-if="form.errors.length">
            <p class="padding-top-34" style="color: red">{{ form.errors.validation_error }}</p>
        </div>
        <div class="flex items-center">
            <button type="button" @click="this.visible = !this.visible"
                    class="button button--link color-black width-full margin-top-24">{{ __('დახურვა') }}
            </button>
            <c-button
                @click="submit"
                class="button button--primary button--shadow button--border width-full margin-top-24"
                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{ __('წაშლა') }}
            </c-button>
        </div>
    </popup>
</template>

<script>
import Popup from "@/Components/Web/Popup/Popup";
import emitter from "@/Plugins/bus";
import CInput from "@/CoreUi/components/Input";
import CInputError from "@/CoreUi/components/InputError";
import CInputLabel from "@/CoreUi/components/InputLabel";
import CButton from "@/CoreUi/components/Button";

export default {
    components: {
        Popup,
        CInput,
        CInputError,
        CInputLabel,
        CButton
    },

    data() {
        return {
            form: this.$inertia.form({}),
            visible: false,
            routeUrl: ''
        }
    },
    methods: {
        submit() {
            this.$page.props.errors = {}
            this.form
                .post(this.routeUrl, {
                    onFinish: () => {
                        if (!this.$page.props.errors || !Object.keys(this.$page.props.errors).length) {
                            this.visible = false;
                        }
                    }
                })
        },
        onShowPasswordResetPopup() {
            this.visible = false
            emitter.emit('showPasswordResetPopup')
        }
    },

    mounted() {
        emitter.on('showDeletePopup', (route) => {
            this.routeUrl = route;
            this.visible = true;
        })
    }
}
</script>
