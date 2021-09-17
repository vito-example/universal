<template>
    <guest-layout>
        <div
            class="lg:h-screen grid grid-cols-1 lg:grid-cols-2"
        >
            <div
                style="background-image: url(/images/intro-bg.jpg);"
                class="flex bg-cover mb-8 lg:mb-0"
            >
                <div
                    class="h-full w-full flex flex-col relative lg:shadow-2xl bg-orange-400 bg-opacity-90 justify-center p-20"
                >
                    <div class="font-black text-white">
                        <div class="text-6xl">Boxette.</div>
                        <div class="text-4xl">Your warehouse in the US.</div>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
            <slot></slot>
        </div>
    </guest-layout>
</template>

<script>
import GuestLayout from '@/Layouts/GuestLayout';
import JetInput from '@/Jetstream/Input';
import JetButton from '@/Jetstream/Button';
import JetButtonInverted from '@/Jetstream/ButtonInverted';
import JetLabel from '@/Jetstream/Label';
import JetInputError from '@/Jetstream/InputError';
import JetCheckbox from '@/Jetstream/Checkbox';
export default {
    components: {
        GuestLayout,
        JetInput,
        JetButton,
        JetButtonInverted,
        JetLabel,
        JetInputError,
        JetCheckbox,
    },
    data() {
        return {
            form: this.$inertia.form({
                email: '',
                password: '',
                remember_me: false,
            }),
        }
    },
    methods: {
        onLogin() {
            this.form.post(route('login'));
        }
    }
}
</script>

<style scoped>
</style>
