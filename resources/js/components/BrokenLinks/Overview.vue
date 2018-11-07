<template>
    <loading-view :loading="loading">
        <to-oh-dear-overview></to-oh-dear-overview>

        <broken-links :broken-links="brokenLinks"></broken-links>
    </loading-view>
</template>

<script>
import ToOhDearOverview from '../ToOhDearOverview';
import BrokenLinks from './BrokenLinks';
import api from '../../api';

export default {
    components: {
        ToOhDearOverview,
        BrokenLinks
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
