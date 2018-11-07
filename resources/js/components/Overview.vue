<template>
    <loading-view :loading="loading">
        <heading class="mb-3">Oh Dear!</heading>
        <div class="flex flex-wrap -m-6">
            <div class="p-6 w-1/2">
                <uptime
                    v-if="uptimeCheck"
                    :check="uptimeCheck"
                    :site-id="viewingSiteId"
                ></uptime>
            </div>
            <div class="p-6 w-1/2">
                <broken-links
                    v-if="brokenLinksCheck"
                    :check="brokenLinksCheck"
                    :site-id="viewingSiteId"
                ></broken-links>
            </div>
            <div class="p-6 w-1/2">
                <certificate-health
                    v-if="certificateHealthCheck"
                    :check="certificateHealthCheck"
                    :site-id="viewingSiteId"
                ></certificate-health>
            </div>
            <div class="p-6 w-1/2">
                <mixed-content
                    v-if="mixedContentCheck"
                    :check="mixedContentCheck"
                    :site-id="viewingSiteId"
                ></mixed-content>
            </div>
            <div class="p-6 w-1/2">
                <certificate-transparancy
                    v-if="certificateTransparancyCheck"
                    :check="certificateTransparancyCheck"
                    :site-id="viewingSiteId"
                ></certificate-transparancy>
            </div>
        </div>
    </loading-view>
</template>

<script>
import api from '../api';
import Uptime from './CheckCards/Uptime';
import BrokenLinks from './CheckCards/BrokenLinks';
import CertificateHealth from './CheckCards/CertificateHealth';
import MixedContent from './CheckCards/MixedContent';
import CertificateTransparancy from './CheckCards/CertificateTransparancy';

export default {
    components: {
        Uptime,
        CertificateHealth,
        BrokenLinks,
        MixedContent,
        CertificateTransparancy
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
        },
        certificateTransparancyCheck() {
            return this.getCheck('certificate_transparency');
        }
    },

    watch: {
        async viewingSiteId() {
            this.loading = true;

            this.$set(this, 'viewingSite', await api.getSite(this.viewingSiteId));

            this.loading = false;
        }
    },

    data: () => ({
        sites: [],
        viewingSiteId: null,
        viewingSite: null,
        loading: true
    }),

    async created() {
        this.sites = await api.getSites();

        this.viewingSiteId = this.sites[0]['site_id'];

        this.startPolling();
    },

    methods: {
        getCheck(type) {
            if (!this.viewingSite) {
                return null;
            }

            return this.viewingSite.checks.find(check => check.type === type);
        },

        startPolling() {
            const poller = window.setInterval(async () => {
                if (!this.viewingSite) {
                    return;
                }

                if (this.loading) {
                    return;
                }

                this.$set(this, 'viewingSite', await api.getSite(this.viewingSiteId));
            }, 1000 * 60);

            this.$once('hook:beforeDestroy', () => {
                window.clearInterval(poller);
            });
        }
    }
};
</script>
