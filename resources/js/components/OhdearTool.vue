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

        <div>
            <mixed-content
              :mixed-content="viewingSite.mixedContent"
              :lastest-run-ended-at="viewingSite.latestRunEndedAt"
            ></mixed-content>
        </div>

        <div>
            <broken-links
              :broken-links="viewingSite.brokenLinks"
            ></broken-links>
        </div>
    </div>
</template>

<script>
    import api from '../api';
    import SiteSummary from './SiteSummary';
    import MixedContent from './MixedContent';
    import BrokenLinks from './BrokenLinks';

    export default {
        components: {
            MixedContent,
            SiteSummary,
            BrokenLinks,
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
            }
        },

        async created() {
            this.sites = await api.getSites();

            this.viewingSiteId = this.sites[0]['site_id'];
        },
    };
</script>
