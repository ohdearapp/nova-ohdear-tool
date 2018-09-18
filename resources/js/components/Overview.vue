<template>
    <loading-view :loading="loading">
        <div>
            <heading class="mb-6">
                Oh Dear
            </heading>

            <router-link tag="li" :to="`/oh-dear/uptime/${viewingSiteId}`">
                <a>View uptime report</a>
            </router-link>

            <router-link tag="li" :to="`/oh-dear/mixed-content/${viewingSiteId}`">
                <a>View mixed content report</a>
            </router-link>

            <router-link tag="li" :to="`/oh-dear/broken-links/${viewingSiteId}`">
                <a>View broken links report</a>
            </router-link>

            <router-link tag="li" :to="`/oh-dear/certificate-health/${viewingSiteId}`">
                <a>View certificate health report</a>
            </router-link>

            <broken-links v-if="brokenLinksCheck"
              :check="brokenLinksCheck"
              :site-id="viewingSiteId"
            ></broken-links>

            <certificate-health v-if="certificateHealthCheck"
              :check="certificateHealthCheck"
              :site-id="viewingSiteId"
            ></certificate-health>
        </div>
    </loading-view>
</template>

<script>
    import api from '../api';
    import BrokenLinks from './CheckCards/BrokenLinks';
    import CertificateHealth from './CheckCards/CertificateHealth';

    export default {
        components: {
            BrokenLinks,
            CertificateHealth,
        },

        computed: {
            brokenLinksCheck() {
                return this.getCheck('broken_links');
            },

            certificateHealthCheck() {
                return this.getCheck('certificate_health');
            },
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
            },
        }
    };
</script>
