<template>
    <loading-view :loading="loading">
        <to-oh-dear-overview></to-oh-dear-overview>

        <certificate-details
          :certificate-details="certificateDetails"
        ></certificate-details>

        <certificate-checks
          :certificate-checks="certificateChecks"
        ></certificate-checks>

        <certificate-chain-issuers
          :certificate-chain-issuers="certificateChainIssuers"
        ></certificate-chain-issuers>
    </loading-view>
</template>

<script>
import ToOhDearOverview from '../ToOhDearOverview';
import CertificateDetails from './CertificateDetails';
import CertificateChecks from './CertificateChecks';
import CertificateChainIssuers from './CertificateChainIssuers';

import api from '../../api';

export default {
    components: {
        ToOhDearOverview,
        CertificateDetails,
        CertificateChecks,
        CertificateChainIssuers
    },

    props: ['siteId'],

    data: () => ({
        loading: true,
        certificateDetails: {},
        certificateChecks: {},
        certificateChainIssuers: {}
    }),

    async created() {
        let response = await api.getCertificateHealth(this.siteId);
        this.certificateDetails = response.certificate_health.certificateDetails;
        this.certificateChecks = response.certificate_health.certificateChecks;
        this.certificateChainIssuers = response.certificate_health.certificateChainIssuers;

        this.loading = false;
    }
};
</script>
