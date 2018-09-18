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

            <broken-links v-if="brokenLinksCheck" init-check="brokenLinksCheck">
            </broken-links>
        </div>
    </loading-view>
</template>

<script>
    import api from '../api';
    import BrokenLinks from "./BrokenLinks/BrokenLinks";

    export default {
        components: {BrokenLinks},

        computed: {
            brokenLinksCheck() {
                return this.getCheck('broken_links');
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
                if (! this.viewingSite) {
                    return null;
                }

                console.log('viewingsite', this.viewingSite);

                return this.viewingSite.checks.find(check => check.type === type);
            }
        }
    };
</script>
