<template>
    <span>
        <input type="hidden" v-model="inputValue" :name="name">
        <el-date-picker
           clearable
           v-model="value"
           type="date"
           :placeholder="placeholder"
           format="YYYY-MM-DD"
           value-format="YYYY-MM-DD">
        </el-date-picker>
    </span>
</template>

<script>
export default {
    data: function () {
        return {
            value: '',
            inputValue: ''
        }
    },
    mounted: function () {
        this.value = this._value;
    },
    watch: {
        'value' () {
            if (this.value) {
                var date = new Date(this.value);
                let zero = (date.getMonth() + 1) <10 ? '0' : ''
                this.inputValue = date.getFullYear() +`-${zero}`+ (date.getMonth() + 1) + '-' + date.getDate()

            }
        }
    },
    props: [
        '_value',
        'placeholder',
        'name'
    ]
}
</script>
