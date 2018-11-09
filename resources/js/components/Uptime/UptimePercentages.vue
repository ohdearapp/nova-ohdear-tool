<template>
    <div>
        <heading class="mb-3">Uptime in the past 7 days</heading>
        <card class="mb-8 overflow-hidden">
            <table cellpadding="0" cellspacing="0" class="table w-full">
                <thead>
                    <tr>
                        <th class="text-left">Date</th>
                        <th class="text-left">Uptime</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(uptime, i) in reverse(uptimePastWeek)" :key="i">
                        <td>{{ uptime.datetime | date }}</td>
                        <td>{{ uptime.uptimePercentage }}%</td>
                    </tr>
                </tbody>
            </table>
        </card>

        <heading class="mb-3">Uptime in the past year</heading>
        <card class="mb-8 overflow-hidden">
            <table cellpadding="0" cellspacing="0" class="table w-full">
                <thead>
                    <tr>
                        <th class="text-left">Date</th>
                        <th class="text-left">Uptime</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(uptime, i) in reverse(uptimePastYear)" :key="i">
                        <td>{{ uptime.datetime | monthYear }}</td>
                        <td>{{ uptime.uptimePercentage }}%</td>
                    </tr>
                </tbody>
            </table>
        </card>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    props: ['uptimePastWeek', 'uptimePastYear'],

    filters: {
        date(date) {
            return moment(date).format('YYYY-MM-DD');
        },

        monthYear(date) {
            return moment(date).format('MMMM YYYY');
        }
    },

    methods: {
        reverse(array) {
            return [...array].reverse();
        }
    }
};
</script>
