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

        <div>
            <uptime-periods
              :uptime-periods="viewingSite.uptime"
            ></uptime-periods>
        </div>

        <div>
            <downtime-periods
              :downtime-periods="viewingSite.downtime"
            ></downtime-periods>
        </div>
    </div>
</template>

<script>
    import api from '../api';
    import SiteSummary from './SiteSummary';
    import MixedContent from './MixedContent';
    import BrokenLinks from './BrokenLinks';
    import UptimePeriods from './UptimePeriods';
    import DowntimePeriods from './DowntimePeriods'

    export default {
        components: {
            MixedContent,
            SiteSummary,
            BrokenLinks,
            UptimePeriods,
            DowntimePeriods,
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
