<template>
    <loading-view :loading="loading">
        <to-oh-dear-overview></to-oh-dear-overview>

        <check-details></check-details>

        <mixed-content
          :mixed-content="mixedContent"
        ></mixed-content>
    </loading-view>
</template>

<script>
import ToOhDearOverview from '../ToOhDearOverview';
import CheckDetails from './CheckDetails';
import MixedContent from './MixedContent';
import api from '../../api';

export default {
    components: {
        ToOhDearOverview,
        CheckDetails,
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
