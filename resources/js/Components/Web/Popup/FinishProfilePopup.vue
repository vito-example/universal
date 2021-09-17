<template>
    <popup
        v-if="visible"
        :title="__('რეგისტრაციის დასრულება')"
    >
        <form @submit.prevent="submit" class="form margin-top-25">
            <div class="form__group form__group--material margin-top-16">

                <c-input id="phoneNumber" type="text" v-model="form.phone_number"
                         :placeholder="__('ტელეფონის ნომერი*')"/>
                <c-input-label for="phone_number" :value="__('ტელეფონის ნომერი*')"/>
                <c-input-error :message="form.errors.phone_number" class="mt-2"/>
            </div>

            <div class="form__group form__group--material margin-top-16">
                <c-input id="email" type="email" v-model="form.email" :disabled="emailStatus" :placeholder="__('მეილი*')"/>
                <c-input-label for="email"  :value="__('მეილი*')"/>
                <c-input-error :message="form.errors.email" class="mt-2"/>
            </div>
            <c-button
                class="button button--primary button--shadow button--border width-full margin-top-24"
                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                {{ __('შენახვა') }}
            </c-button>
        </form>
    </popup>
</template>

<script>
import Popup from "@/Components/Web/Popup/Popup";
import emitter from "@/Plugins/bus";
import CInput from "@/CoreUi/components/Input";
import CInputError from "@/CoreUi/components/InputError";
import CInputLabel from "@/CoreUi/components/InputLabel";
import CButton from "@/CoreUi/components/Button";
import FacebookIcon from "@/Components/Web/Icons/Facebook";
import GmailIcon from "@/Components/Web/Icons/Gmail";

export default {
    components: {
        Popup,
        CInput,
        CInputError,
        CInputLabel,
        CButton,
        FacebookIcon,
        GmailIcon
    },
    data() {
        return {
            form: this.$inertia.form({
                phone_number: '',
                email: this.$page.props.user.email
            }),
            emailStatus: this.$page.props.user.email ? 'disabled' : '',
            visible: true,
        }
    },
    created() {
        this.visible = this.$page.props.finishProfileModal;
    },
    methods: {
        submit() {
            this.form.errors = {}
            this.form.post(this.route('profile.finish'),{
                onSuccess: () => {
                    this.visible = false
                    emitter.emit('showVerifyPopup')
                },
            })
        },
    },
    mounted() {
        emitter.on('showFinishProfilePopup', () => this.visible = true)
    }
}
</script>
