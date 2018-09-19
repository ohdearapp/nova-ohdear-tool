<template>
    <loading-view :loading="loading">
        <to-oh-dear-overview></to-oh-dear-overview>

        <div>
            <uptime-percentages
              :uptime-past-week="uptimePastWeek"
              :uptime-past-year="uptimePastYear"
            ></uptime-percentages>

            <downtime-periods
              :downtime-periods="downtimePeriods"
            ></downtime-periods>
        </div>
    </loading-view>
</template>

<script>
import ToOhDearOverview from '../ToOhDearOverview';
import DowntimePeriods from './DowntimePeriods';
import UptimePercentages from './UptimePercentages';
import api from '../../api';

export default {
    components: {
        ToOhDearOverview,
        DowntimePeriods,
        UptimePercentages
    },

    props: ['siteId'],

    data() {
        return {
            loading: true,
            uptimePastWeek: [],
            uptimePastYear: [],
            downtimePeriods: []
        };
    },

    async created() {
        let response = await api.getUptime(this.siteId);

        this.uptimePastWeek = response.uptimePastWeek;
        this.uptimePastYear = response.uptimePastYear;
        this.downtimePeriods = response.downtimePeriods;

        this.loading = false;
    }
};
</script>
