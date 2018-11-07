<template>
    <div>
        <heading class="mb-3">Downtime periods</heading>
        <card class="overflow-hidden">
            <table cellpadding="0" cellspacing="0" class="table w-full">
                <thead>
                    <tr>
                        <th class="text-left">Started at</th>
                        <th class="text-left">Ended at</th>
                        <th class="text-left">Duration</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="downtimePeriod in downtimePeriods">
                        <td>{{ downtimePeriod.startedAt }}</td>
                        <td>{{ downtimePeriod.endedAt }}</td>
                        <td>{{ duration(downtimePeriod) }}</td>
                    </tr>
                </tbody>
            </table>
        </card>
    </div>
</template>

<script>
export default {
    props: ['downtimePeriods'],

    methods: {
        duration(downtimePeriod) {
            let startedAt = moment(downtimePeriod.startedAt);
            let endedAt = moment(downtimePeriod.endedAt);

            return endedAt.from(startedAt, true);
        }
    }
};
</script>
