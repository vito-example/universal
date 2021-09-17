import emitter from "@/Plugins/bus";

export default {
    methods: {
        getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        },
        showBetaModal() {
            if (!this.getCookie('betaModal')) {
                // document.cookie = "betaModal=1; path=/; expires=-1;";
                // emitter.emit('betaModalShow')
            }
        },
        clearBetaShowModal () {
            document.cookie = "betaModal=; path=/; expires=-1;";
        },
        isAuth() {
            return this.$page.props.user
        },
        userEmail() {
            return this.$page.props.user.email ?? ''
        },
        isVerify() {
            return this.$page.props.user.verified_at ?? false;
        },
        firstName() {
            return this.isAuth().name
        },

        nameInitial() {
            return `${this.isAuth().name.charAt(0)}${this.isAuth().surname.charAt(0)}`
        },

        /**
         *
         * @param e
         * @returns {boolean}
         */
        isLatinAlphabet(e) {
            // let char = String.fromCharCode(e.keyCode);
            //
            // if (/^[A-Za-z]+$/.test(char)) {
            //     emitter.emit('nonLatinCharacter', { status: false, id: e.target.id })
            //     return true
            // } else {
            //     emitter.emit('nonLatinCharacter', { status: true, id: e.target.id })
            //     e.preventDefault()
            // }
        },
        /**
         *
         * @param e
         * @param preventDefault
         */
        isNumberValidate(e, preventDefault = true) {
            let char = String.fromCharCode(e.keyCode);
            let isValidated = /^[0-9]+$/.test(char)

            if (preventDefault) {
                if (!isValidated) {
                    e.preventDefault()
                    return false;
                }
                return true
            }

            return isValidated
        },
        /**
         *
         * @param e
         * @param inputData
         * @param length
         * @returns {boolean}
         */
        digitNumber(e, inputData, length = 11) {
            if (!this.isNumberValidate(e, false)) {
                e.preventDefault()
                return false;
            }
            if (inputData && inputData.length >= 11) {
                e.preventDefault()
                return false;
            }

            return true
        },
        /**
         *
         * @param evt
         * @param inputData
         * @returns {boolean}
         */
        isGeorgianPhoneNumber(evt, inputData) {
            evt = (evt) ? evt : window.event;
            if (!inputData && evt.key && evt.key != 5) {
                evt.preventDefault();
                return
            }
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();
            } else {
                if (inputData && inputData.length >= 9) {
                    evt.preventDefault();
                } else {
                    return true;
                }
            }
        },
        setSeoData(seoData) {
            Object.keys(seoData).map((key) => {
                let value = seoData[key]
                switch (key) {
                    case 'title':
                        document.title = value;
                        break;
                    case 'description':
                        document.getElementsByTagName('meta')['description'].content = value
                        break;
                    case 'keywords':
                        document.getElementsByTagName('meta')['keywords'].content = value
                        break;
                    case 'og_title':
                        document.querySelector('meta[property="og:title"]').setAttribute("content", value);
                        break;
                    case 'og_description':
                        document.querySelector('meta[property="og:description"]').setAttribute("content", value);
                        break;
                    case 'image':
                        document.querySelector('meta[property="og:image"]').setAttribute("content", value);
                        break;
                    case 'locale':
                        document.documentElement.setAttribute('lang', value)
                        break;
                }
            });

            document.querySelector('meta[property="og:url"]').setAttribute("content", window.location.href);
        }
    },

    created () {
        if (this.form) {
            emitter.on('nonLatinCharacter', (request) => {
                if (request.status) {
                    this.form.errors[request.id] = this.__('NonLatin Input Text')
                } else {
                    this.form.errors[request.id] = ''
                }
            })
        }
    }
}
