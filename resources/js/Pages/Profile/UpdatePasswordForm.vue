<template>
    <div>
        <c-card>
            <template v-slot:header>
                {{ __('Update Password') }}
            </template>
            <template v-slot:body>
<!--                <c-validation-errors />-->
                <form @submit.prevent="updatePassword">
                    <div class="form-group">
                        <c-input-label for="current_password" :value="__('Current Password')"/>
                        <c-input :disabled="isDisableInput" id="current_password" type="password" v-model="form.current_password"
                                 autocomplete="current-password">
                        </c-input>
                        <c-input-error :message="form.errors.current_password" class="mt-2"/>
                    </div>
                    <div class="form-group">
                        <c-input-label for="password" :value="__('Password')"/>
                        <c-input :disabled="isDisableInput" id="password" type="password" v-model="form.password"
                                 autocomplete="current-password">
                        </c-input>
                        <c-input-error :message="form.errors.password" class="mt-2"/>
                    </div>

                    <div class="form-group">
                        <c-input-label for="password_confirmation" :value="__('Password Confirmation')"/>
                        <c-input :disabled="isDisableInput" id="password_confirmation" type="password"
                                 v-model="form.password_confirmation"
                                 autocomplete="current-password">
                        </c-input>
                        <c-input-error :message="form.errors.password_confirmation" class="mt-2"/>
                    </div>
                    <div>
                        <c-action-message
                            :on="form.recentlySuccessful">
                            {{ __('Saved password information')}}
                        </c-action-message>
                        <c-button
                            v-if="!isDisableInput"
                            class="btn btn-success px-4 font-weight-bold"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            {{ __('Save')}}
                        </c-button>
                        <c-button
                            v-if="isDisableInput"
                            @click.prevent="toggleInputDisable"
                            class="btn btn-info px-4 font-weight-bold"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            {{ __('Edit Profile Data') }}
                        </c-button>
                        <inertia-link :href="route('profile.show')" v-else>
                            <c-button
                                class="btn btn-danger font-weight-bold pull-right ml-2">
                                {{ __('Canceled Profile Data Update') }}
                            </c-button>
                        </inertia-link>
                    </div>
                </form>
            </template>
        </c-card>
    </div>
</template>

<script>
    import NSelect from "@/Components/Select";
    import CSuccessLabel from "@/CoreUi/components/SuccessLabel";
    import Authenticate from "@/Layouts/Authenticate";
    import CInput from "@/CoreUi/components/Input";
    import CInputError from "@/CoreUi/components/InputError";
    import CValidationErrors from "@/CoreUi/components/ValidationErrors";
    import CButton from "@/CoreUi/components/Button";
    import CInputLabel from "@/CoreUi/components/InputLabel";
    import CSelect from "@/CoreUi/components/Select";
    import CCheckbox from "@/CoreUi/components/Checkbox";
    import CCard from "@/CoreUi/components/Card";
    import CActionMessage from "@/CoreUi/components/ActionMessage";

    export default {
        components: {
            NSelect,
            CSuccessLabel,
            Authenticate,
            CInput,
            CInputError,
            CValidationErrors,
            CButton,
            CInputLabel,
            CSelect,
            CCheckbox,
            CCard,
            CActionMessage
        },

        data() {
            return {
                form: this.$inertia.form({
                    current_password: '',
                    password: '',
                    password_confirmation: '',
                }),
                isDisableInput: true
            }
        },

        methods: {
            toggleInputDisable () {
                this.isDisableInput = !this.isDisableInput
            },
            updatePassword() {
                this.$page.props.errors = {}
                this.form.put(route('user-password.update'), {
                    errorBag: 'updatePassword',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.toggleInputDisable()
                        this.form.reset()
                    },
                    onError: () => {
                        if (this.form.errors.password) {
                            this.form.reset('password', 'password_confirmation')
                            this.$refs.password.focus()
                        }

                        if (this.form.errors.current_password) {
                            this.form.reset('current_password')
                            this.$refs.current_password.focus()
                        }
                    }
                })
            },
        },
    }
</script>
