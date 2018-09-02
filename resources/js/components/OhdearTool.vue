<template>
    <div>

        <heading class="mb-6">
            Oh Dear
        </heading>

        <div v-if="viewingSite">
            <site-summary
                :site="viewingSite.site"
                >
            </site-summary>
        </div>
    </div>
</template>

<script>
    import api from '../api';
    import SiteSummary from './SiteSummary'

    export default {
        components: {SiteSummary},
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
            }
        },

        async created() {
            this.sites = await api.getSites();

            this.viewingSiteId = this.sites[0]['site_id'];
        },
    };
</script>
