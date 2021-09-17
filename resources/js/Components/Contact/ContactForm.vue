<template>
    <form
            class="form"
            @submit.prevent="submit"
    >
        <div class="form__group form__group--material margin-y-20">
            <c-input
                    id="surname"
                    type="text"
                    v-model="form.name"
                    :placeholder="__('თქვენი სახელი')"
            />
            <c-input-label for="surname" :value="__('თქვენი სახელი')"/>
            <c-input-error :message="form.errors.name" class="mt-2"/>
        </div>

        <div class="form__group form__group--material margin-y-20">
            <c-input
                    id="surname"
                    type="text"
                    v-model="form.email"
                    :placeholder="__('თქვენი მეილი')"
            />
            <c-input-label for="surname" :value="__('თქვენი მეილი')"/>
            <c-input-error :message="form.errors.email" class="mt-2"/>
        </div>

        <textarea-limit :value="form.message.length">
            <div class="form__group form__group--material form__group--textarea margin-y-20">
            <textarea
                    name="message"
                    rows="7" class="form__element"
                    id="message"
                    v-model="form.message"
                    :placeholder="__('თქვენი შეტყობინება')"
                    autocomplete="off"
                    maxlength="400"
            />
                <label class="form__label" for="message">{{ __('თქვენი შეტყობინება') }}</label>
                <c-input-error :message="form.errors.message" class="mt-2"/>
            </div>
        </textarea-limit>

        <button
                class="button button--primary button--shadow button--border margin-top-4 width-full"
                type="submit"
                @click="submit"
        >
            {{ __('გაგზავნა') }}
        </button>
    </form>
</template>

<script>
import TextareaLimit from "@/Components/Web/Form/TextareaLimit"
import CInput from "@/CoreUi/components/Input"
import CInputError from "@/CoreUi/components/InputError"
import CInputLabel from "@/CoreUi/components/InputLabel"

export default {
    components: {
        TextareaLimit,
        CInput,
        CInputError,
        CInputLabel
    },

    props: {
        item: {
            type: Object
        },

        title: {
            type: String
        }
    },

    data() {
        return {
            form: this.$inertia.form({
                name: '',
                email: '',
                message: ''
            })
        }
    },

    methods: {
        submit() {
            this.form.post(this.route('contact.send'))
        }
    }
}
</script>