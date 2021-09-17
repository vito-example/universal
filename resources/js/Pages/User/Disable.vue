<template>
    <user-disable-layout>
        <template v-slot:main>
            <div class="col-md-12">
                <p>{{ __('Your account is disabled') }}</p>
            </div>
        </template>
    </user-disable-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Portal from "@/Layouts/Portal";
import UserDisableLayout from "@/Layouts/UserDisableLayout";
export default {
    components: {
        UserDisableLayout,
        Portal,
    }
}
</script>
