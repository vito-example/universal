<template>
    <div>
        <c-card class="card-accent-primary">
            <template v-slot:header>
                {{ __('Conference Questions') }}
            </template>
            <template v-slot:body>
                <general-error :message="form.error"></general-error>
                <general-success :message="form.success"></general-success>
                <div class="direct-chat-messages">
                    <template v-for="(question,key) in questions">
                        <div class="direct-chat-msg my-2">
                            <div class="d-flex align-items-start">
                                <span class="badge rounded-pill avatar">
                                    {{ nameInitial() }}
                                </span>

                                <div class="c-header-profile-info font-weight-bold ml-3">
                                    {{ question.customer.name }} {{ question.customer.surname }}
                                    <small class="d-block">{{ question.created_at }}</small>

                                    <div class="d-block mt-2 font-weight-normal">
                                        {{ question.content }}
                                    </div>
                                </div>

                            </div>

                            <!--<div class="direct-chat-info clearfix"><span
                                class="direct-chat-name pull-left">{{
                                    question.customer.name
                                }} {{ question.customer.surname }}</span> <span
                                class="direct-chat-timestamp pull-right">{{ question.created_at }}</span></div>
                            <img
                                :src="question.customer.profile_photo_path"
                                alt="message user image" class="direct-chat-img">
                            <div class="direct-chat-text">
                                {{ question.content }}
                            </div>-->
                        </div>
                    </template>
                </div>

                <template v-if="item.can_add_question">
                    <div class="form-group">
                        <textarea :placeholder="__('Type question')" required="required" class="form-control" v-model="form.content"></textarea>
                    </div>

                    <c-button
                        @click="sendQuestion"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing || !form.content"
                        class="btn btn-success ml-auto">
                        {{ __('Send Question') }}
                    </c-button>
                </template>
            </template>
            <template v-slot:footer v-if="item.can_add_question">

            </template>
        </c-card>
    </div>
</template>

<script>
import CCard from "@/CoreUi/components/Card";
import CButton from "@/CoreUi/components/Button";
import NProgress from 'nprogress'
import GeneralSuccess from "@/Components/Event/GeneralSuccess";
import GeneralError from "@/Components/GeneralError";

export default {
    props: {
        item: {
            type: Object
        }
    },
    components: {
        GeneralSuccess,
        GeneralError,
        CCard,
        CButton
    },
    data () {
        return {
            form: this.$inertia.form({
                id: this.item ? this.item.id : null,
                content: ''
            }),
            allQuestions: this.item.questions
        }
    },
    computed: {
        questions() {
            return this.allQuestions ? this.allQuestions : []
        }
    },
    methods: {
        sendQuestion () {
            NProgress.start()
            this.form.processing = true;
            this.form.error = ''
            this.form.success = ''
            axios.post(this.route('event.question.store', this.form.id),this.form).then(response => {
                if (response.data) {
                    this.form.success = response.data.message
                    this.allQuestions = response.data.data.questions
                    this.form.content = ''
                }
                this.form.processing = false;
                NProgress.done()
            }).catch((error) => {
                this.form.processing = false;
                if (error.response.data) {
                    this.form.error = error.response.data.message
                }
                NProgress.done()
                NProgress.remove()
            })
        }
    }
}
</script>
