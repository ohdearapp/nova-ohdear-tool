<template>
    <loading-view :loading="loading">
        <to-oh-dear-overview></to-oh-dear-overview>

        <check-details></check-details>
    </loading-view>
</template>

<script>
    import ToOhDearOverview from '../ToOhDearOverview';
    import CheckDetails from './CheckDetails';
    import api from '../../api';

    export default {
        components: {
            ToOhDearOverview,
            CheckDetails,
        },

        props: ['siteId'],

        data() {
            return {
                loading: true,
                certificateDetails: {},
                certificateChecks: {},
                certificateChainIssuers: {},
            };
        },

        async created() {
            let response = await api.getCertificateHealth(this.siteId);

            this.certificateDetails = response.certificate_health.certificate_details;
            this.certificateChecks = response.certificate_health.certificate_checks;
            this.certificateChainIssuers = response.certificate_health.certificate_chain_issuers;

            this.loading = false;
        }
    };
</script>
