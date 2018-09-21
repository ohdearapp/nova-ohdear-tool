<template>
    <div>
        <heading class="mb-6">
            Uptime percentages
        </heading>
        <card class="mb-6">

            <h2>Past 7 days</h2>

            <table cellpadding="0" cellspacing="0" class="table w-full">
                <thead>
                <tr>
                    <th class="text-left">
                        Time
                    </th>
                    <th class="text-left">
                        Percentage
                    </th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="uptime in reverse(uptimePastWeek)">
                    <td>
                        {{ uptime.datetime | date }}
                    </td>
                    <td>
                        {{ uptime.uptimePercentage }}
                    </td>
                </tr>
                </tbody>
            </table>

            <h2>Past year</h2>
            <table cellpadding="0" cellspacing="0" class="table w-full">
                <thead>
                <tr>
                    <th class="text-left">
                        Time
                    </th>
                    <th class="text-left">
                        Percentage
                    </th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="uptime in reverse(uptimePastYear)">
                    <td>
                        {{ uptime.datetime | monthYear }}
                    </td>
                    <td>
                        {{ uptime.uptimePercentage }}
                    </td>
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
