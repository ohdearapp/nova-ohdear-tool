<template>
    <loading-view :loading="loading">
        <to-oh-dear-overview></to-oh-dear-overview>
        <broken-links :broken-links="brokenLinks"></broken-links>
    </loading-view>
</template>

<script>
import BrokenLinks from './BrokenLinks';
import ToOhDearOverview from '../ToOhDearOverview';
import api from '../../api';

export default {
    components: {
        BrokenLinks,
        ToOhDearOverview,
    },

    props: ['siteId'],

    data: () => ({
        loading: true,
        brokenLinks: []
    }),

    async created() {
        let response = await api.getBrokenLinks(this.siteId);

        this.brokenLinks = response.brokenLinks;

        this.loading = false;
    }
};
</script>
