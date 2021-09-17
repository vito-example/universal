<template>
    <div>
        <div class="indent_title_in">
            <i :class="icon" v-if="icon"></i>
            <h3>{{ title }}</h3>
        </div>
        <div class="wrapper_indent">
            <div class="row">
                <template v-for="item in connections">
                   <event-connection-item :item="item"></event-connection-item>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import EventConnectionItem from "@/Components/Event/EventConnectionItem";
export default {
    components: {EventConnectionItem},
    props: {
        title: {
            type: String
        },
        connections: {
            type: Array
        },
        icon: {
            type: String
        }
    }
}
</script>
