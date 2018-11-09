<template>
    <loading-view :loading="loading">
        <heading class="mb-3">Oh Dear!</heading>
        <div class="flex flex-wrap -m-6">
            <div class="p-6 w-1/2">
                <uptime
                    v-if="uptimeCheck"
                    :check="uptimeCheck"
                    :site-id="site.id"
                ></uptime>
            </div>
            <div class="p-6 w-1/2">
                <broken-links
                    v-if="brokenLinksCheck"
                    :check="brokenLinksCheck"
                    :site-id="site.id"
                ></broken-links>
            </div>
            <div class="p-6 w-1/2">
                <certificate-health
                    v-if="certificateHealthCheck"
                    :check="certificateHealthCheck"
                    :site-id="site.id"
                ></certificate-health>
            </div>
            <div class="p-6 w-1/2">
                <mixed-content
                    v-if="mixedContentCheck"
                    :check="mixedContentCheck"
                    :site-id="site.id"
                ></mixed-content>
            </div>
            <div class="p-6 w-1/2">
                <certificate-transparancy
                    v-if="certificateTransparancyCheck"
                    :check="certificateTransparancyCheck"
                    :site-id="site.id"
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

    provide() {
        return {
            refreshSite: () => this.getSite()
        };
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

    data: () => ({
        site: null,
        loading: true
    }),

    async created() {
        if (! this.site) {
            this.loading = true;
        }


        await this.getSite();

        this.loading = false;

        this.startPolling();
    },

    methods: {
        startPolling() {
            const poller = window.setInterval(async () => {
                if (!this.site) {
                    return;
                }

                if (this.loading) {
                    return;
                }

                await this.getSite();
            }, 1000 * 60);

            this.$once('hook:beforeDestroy', () => {
                window.clearInterval(poller);
            });
        },

        async getSite() {
            this.site = await api.getSite();
        },

        getCheck(type) {
            if (!this.site) {
                return null;
            }

            return this.site.checks.find(check => check.type === type);
        }
    }
};
</script>
