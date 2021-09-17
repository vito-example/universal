<template>
    <div class="custom-select" :tabindex="tabindex" @blur="open = false">
        <div class="selected" :class="{ open: open }" @click="open = !open">
            {{ selected }}
        </div>
        <div
            class="items" :class="{ selectHide: !open }">
            <div
                v-for="(option, i) of options"
                :key="i"
                @click="
          selected = getOption(option);
          open = false;
          $emit('input', {model : this.model,selected: option});"
            >
                {{ getOption(option) }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        options: {
            type: Array,
            required: true,
        },
        default: {
            type: String,
            required: false,
            default: null,
        },
        model: {
            type: String,
            required: false,
        },
        tabindex: {
            type: Number,
            required: false,
            default: 0,
        },
    },
    data() {
        return {
            selected: this.default
                ? this.getOption(this.default)
                : this.options.length > 0
                    ? this.getOption(this.options[0])
                    : null,
            open: false,
        };
    },
    methods: {
        getOption(option) {
            if (option.label === undefined) {
                return option;
            }
            return option.label
        }
    },
    mounted() {
        if (this.selected !== this.default) {
            this.$emit("input", {
                model: this.model,
                selected: this.default
            })
        }
    },
};
</script>
