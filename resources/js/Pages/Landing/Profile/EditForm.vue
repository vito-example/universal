<template>
    <form
            class="form width-416 width-sm-full"
            @submit.prevent="submitProfile"

    >
        <div class="form__group form__group--material">
            <c-input id="name" type="text" v-model="profile.name"
                     :placeholder="__('სახელი')"/>
            <c-input-label for="name" :value="__('სახელი')"/>
            <c-input-error :message="profile.errors.name" class="mt-2"/>
        </div>

        <div class="form__group form__group--material margin-top-16">
            <c-input id="surname" type="text" v-model="profile.surname"
                     :placeholder="__('გვარი')"/>
            <c-input-label for="surname" :value="__('გვარი')"/>
            <c-input-error :message="profile.errors.surname" class="mt-2"/>
        </div>

        <div class="form__group form__group--material margin-top-16">
            <c-input type="email" v-model="profile.email"
                     :placeholder="__('მეილი')"/>
            <c-input-label for="email" :value="__('მეილი')"/>
            <c-input-error :message="profile.errors.email" class="mt-2"/>
        </div>

        <div class="form__group form__group--material margin-top-16">
            <c-input id="mobileNumber" type="text"
                     v-model="profile.phone_number"
                     :placeholder="__('ტელეფონი')"/>
            <c-input-label for="mobileNumber" :value="__('ტელეფონი')"/>
            <c-input-error :message="profile.errors.phone_number" class="mt-2"/>
        </div>
        <c-button
                class="button button--primary button--shadow button--border width-full margin-top-24"
                :class="{ 'opacity-25': profile.processing }" :disabled="profile.processing">
            {{ __('მონაცემების შენახვა') }}
        </c-button>
    </form>
</template>

<script>
import CInput from "@/CoreUi/components/Input"
import CInputError from "@/CoreUi/components/InputError"
import CInputLabel from "@/CoreUi/components/InputLabel"
import CButton from "@/CoreUi/components/Button"

export default {
    components: {
        CInput,
        CInputError,
        CInputLabel,
        CButton,
    },

    props: {
        user: {
            type: Object
        }
    },

    data () {
        return {
            profile: this.$inertia.form({
                name: this.user.name ?? '',
                surname: this.user.surname ?? '',
                email: this.user.email ?? '',
                phone_number: this.user.phone_number ?? '',
            })
        }
    },

    methods: {
        submitProfile() {
            this.profile.put(this.route('user-profile-information.update'), {
                onFinish: () => console.log('updated'),
            })
        }
    }
}
</script>