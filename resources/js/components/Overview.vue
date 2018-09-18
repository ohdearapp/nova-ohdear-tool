<template>
    <loading-view :loading="loading">
        <div>
            <heading class="mb-6">
                Oh Dear
            </heading>

            <uptime
              v-if="uptimeCheck"
              :check="uptimeCheck"
              :site-id="viewingSiteId"
            ></uptime>

            <certificate-health
              v-if="certificateHealthCheck"
              :check="certificateHealthCheck"
              :site-id="viewingSiteId"
            ></certificate-health>

            <broken-links
              v-if="brokenLinksCheck"
              :check="brokenLinksCheck"
              :site-id="viewingSiteId"
            ></broken-links>

            <mixed-content
              v-if="mixedContentCheck"
              :check="mixedContentCheck"
              :site-id="viewingSiteId"
            ></mixed-content>

        </div>
    </loading-view>
</template>

<script>
import api from '../api';
import Uptime from './CheckCards/Uptime';
import BrokenLinks from './CheckCards/BrokenLinks';
import CertificateHealth from './CheckCards/CertificateHealth';
import MixedContent from './CheckCards/MixedContent';

export default {
    components: {
        Uptime,
        CertificateHealth,
        BrokenLinks,
        MixedContent
    },

    computed: {
        uptimeCheck() {
            return this.getCheck('uptime');
        },

        certificateHealthCheck() {
            return this.getCheck('certificate_health');
        },

        brokenLinksCheck() {
            return this.getCheck('broken_links');
        },

        mixedContentCheck() {
            return this.getCheck('mixed_content');
        }
    },

    watch: {
        async viewingSiteId() {
            this.viewingSite = await api.getSite(this.viewingSiteId);
        }
    },

    data() {
        return {
            sites: [],
            viewingSiteId: null,
            viewingSite: null,
            loading: true
        };
    },

    async created() {
        this.sites = await api.getSites();

        this.viewingSiteId = this.sites[0]['site_id'];

        this.loading = false;
    },

    methods: {
        getCheck(type) {
            if (!this.viewingSite) {
                return null;
            }

            return this.viewingSite.checks.find(check => check.type === type);
        }
    }
};
</script>
