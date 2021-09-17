<template>
    <footer class="c-footer">
        <div><a style="color: #e34b78;" :href="route('home.index')">{{ __('Medu.ge') }}</a> © {{ new Date().getFullYear() }}</div>
        <div class="mfs-auto">{{ __('Supported by') }}&nbsp;<a style="color: #e34b78;" href="http://nlyc.dev" target="_blank"> {{ __('NLYC.DEV')}}</a></div>
    </footer>
</template>


