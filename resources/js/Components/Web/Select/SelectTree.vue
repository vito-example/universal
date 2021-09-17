<template>
  <div class="custom-select custom-select--tree" :tabindex="tabindex" @blur="open = false">
    <div class="selected" :class="{ open: open }" @click="open = !open">
      {{ selected }}
    </div>
    <div class="items" :class="{ selectHide: !open }">
      <div>
        <div class="checkbox" v-for="(parent,el) in options">
          <input type="checkbox" :value="parent.id" v-model="model" :id="parent.id">
          <label :for="parent.id" class="font-size-2xs">
              {{parent.label}}
          </label>
            <div class="child" v-if="parent['children'].length">
                <div class="checkbox" v-for="(item,index) in parent['children']">
                    <input type="checkbox" :value="item.id" v-model="model" :id="item.id">
                    <label :for="item.id" class="font-size-2xs">
                        {{item.label}}
                    </label>
                    <div class="child" v-if="item['children'].length">
                        <div class="checkbox" v-for="(child,index) in item['children']">
                            <input type="checkbox" :value="child.id" v-model="model" :id="child.id">
                            <label :for="child.id" class="font-size-2xs">
                                {{child.label}}
                            </label>
                        </div>
                    </div>
                </div>

            </div>
        </div>

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
    tabindex: {
      type: Number,
      required: false,
      default: 0,
    },
      defaultValues: {
        type: Array,
          required: true
      }
  },
  data() {
    return {
      model:  this.defaultValues ?? [],
      selected: this.default
          ? this.default
          : this.options.length > 0
              ? this.options[0]
              : null,
      open: false,
    };
  },
    watch: {
        'model'(value,old) {
            if(value !== old) {
                this.$emit("input",value)
            }
        }
    },
  mounted() {
    if (this.selected !== this.default) {
        // this.$emit("input")
    }
  },
};
</script>
