<template>
    <loading-view :loading="loading">
        <to-oh-dear-overview></to-oh-dear-overview>

        <mixed-content
          :mixed-content="mixedContent"
        ></mixed-content>
    </loading-view>
</template>

<script>
import ToOhDearOverview from '../ToOhDearOverview';
import MixedContent from './MixedContent';
import api from '../../api';

export default {
    components: {
        ToOhDearOverview,
        MixedContent
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
