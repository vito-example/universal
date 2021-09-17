export default {
    methods: {
        __(key, replace = {}) {
            let translation = this.$page.props.lang[key] || key;

            Object.keys(replace).forEach(function (key) {
                translation = translation.replace(':' + key, replace[key])
            });

            return translation;
        },
    },
};
