<template>
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
    </div>
</template>

<script>
import api from '../api';

export default {
    watch: {
        async viewingSiteId() {
            this.viewingSite = await api.getSite(this.viewingSiteId);
        }
    },

    data() {
        return {
            sites: [],
            viewingSiteId: null,
            viewingSite: null
        };
    },

    async created() {
        this.sites = await api.getSites();

        this.viewingSiteId = this.sites[0]['site_id'];
    }
};
</script>
