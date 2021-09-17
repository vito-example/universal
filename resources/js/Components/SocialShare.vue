<template>
    <div class="social-links">
        <template v-for="network in networks">
            <a :href="network.url.replace(network.urlReplaceKey,network.urlReplaceKey + shareUrl)" target="_blank">
                <i :class="network.icon"></i>
            </a>
        </template>
    </div>
</template>

<script>
export default {
    props: {
        url: {
            type: String,
            default: null
        }
    },
    data () {
        return {
            networks: [
                {
                    key: 'facebook',
                    icon: 'social_facebook',
                    url: 'https://www.facebook.com/sharer.php?u=',
                    urlReplaceKey: 'u='
                },
                {
                    key: 'linkedin',
                    icon: 'social_linkedin',
                    url: 'https://www.linkedin.com/shareArticle?url=',
                    urlReplaceKey: 'url='
                }
            ]
        }
    },
    computed: {
        shareUrl () {
            if (this.url) {
                if (!this.url.includes('https://')) {
                    return window.location.hostname + this.url
                }
                return this.url
            }
            return window.location.href
        }
    }
}
</script>
