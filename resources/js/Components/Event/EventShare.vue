<template>
    <div>
        <social-share></social-share>
        <c-success-label v-if="isCopied" :status="__('Event Copied successfully' )"></c-success-label>
<!--        <span  v-if="isCopied">{{ }}</span>-->
<!--        <div class="url-sharer mb-4">-->
<!--            <div class="url-sharer-field">-->
<!--                <input v-model="url">-->
<!--            </div>-->

<!--            <div class="url-sharer-addon">-->
<!--                <button v-clipboard="url" v-clipboard:success="clipboardSuccessHandler">-->
<!--                    <i class="pe-7s-copy-file"></i>-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</template>

<script>
import SocialShare from "@/Components/SocialShare";
import CSuccessLabel from "@/CoreUi/components/SuccessLabel";
export default {
    components: {
        SocialShare,
        CSuccessLabel
    },
    props: {
        item: {
            type: Object
        }
    },
    data () {
        return {
            url: window.location.href,
            isCopied: false
        }
    },
    methods: {
        clipboardSuccessHandler () {
            this.isCopied = true
            setTimeout(() => {
                this.isCopied = false
            },4000)
        }
    }
}
</script>
