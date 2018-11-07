<template>
    <loading-view :loading="loading">
        <to-oh-dear-overview></to-oh-dear-overview>
        <mixed-content :mixed-content="mixedContent"></mixed-content>
    </loading-view>
</template>

<script>
import MixedContent from './MixedContent';
import ToOhDearOverview from '../ToOhDearOverview';
import api from '../../api';

export default {
    components: {
        MixedContent,
        ToOhDearOverview,
    },

    props: ['siteId'],

    data() {
        return {
            loading: true,
            mixedContent: []
        };
    },

    async created() {
        let response = await api.getMixedContent(this.siteId);

        this.mixedContent = response.mixedContent;

        this.loading = false;
    }
};
</script>
