<template>
    <loading-view :loading="loading">
        <to-oh-dear-overview></to-oh-dear-overview>

        <check-details></check-details>

        <broken-links
          :broken-links="brokenLinks"
        ></broken-links>
    </loading-view>
</template>

<script>
import ToOhDearOverview from '../ToOhDearOverview';
import CheckDetails from './CheckDetails';
import BrokenLinks from './BrokenLinks';
import api from '../../api';

export default {
    components: {
        ToOhDearOverview,
        CheckDetails,
        BrokenLinks
    },

    props: ['siteId'],

    data() {
        return {
            loading: true,
            brokenLinks: []
        };
    },

    async created() {
        let response = await api.getBrokenLinks(this.siteId);

        this.brokenLinks = response.brokenLinks;

        this.loading = false;
    }
};
</script>
