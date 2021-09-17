<template>
    <span>
        <input type="hidden" v-model="value" :name="name">
        <el-select v-model="value" :multiple="multiple" filterable clearable :placeholder="placeholder">
            <el-option
                v-for="item in list"
                :key="item[opValue] ? item[opValue].toString() : item[opValue]"
                :label="item[opName] ? item[opName].toString() : ''"
                :value="item[opValue] ? item[opValue].toString() : ''">
            </el-option>
        </el-select>
    </span>
</template>


<script>
    export default {
        props: [
            'labelName',
            '_value',
            'placeholder',
            'list',
            'name',
            'optionName',
            'optionValue',
            'multiple'
        ],
        data: function() {
            return {
                value: this.multiple ? [] : '',
                opName: 'label',
                opValue: 'value',
            }
        },
        mounted: function () {
            if (this.multiple) {
                this.value = this._value ? this._value.split(',') : [];
            } else {
                this.value = this._value
            }
            if(this.optionName) {
                this.opName = this.optionName;
            }
            if(this.optionValue) {
                this.opValue = this.optionValue;
            }
        },
    }
</script>
