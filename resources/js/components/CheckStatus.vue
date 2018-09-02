<template>
    <span :class="'inline-block rounded-full w-2 h-2 mr-1 bg-'+status"></span>
</template>

<script>
    export default {
        props: ['status']
    }
</script>