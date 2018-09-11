<template>

    <div>
        <heading class="mb-6">
            Downtime periods
        </heading>
        <card class="mb-6">


            <table cellpadding="0" cellspacing="0" class="table w-full">
                <thead>
                <tr>
                    <th class="text-left">
                        Started at
                    </th>
                    <th class="text-left">
                        Ended at
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="downtimePeriod in downtimePeriods">
                    <td>
                        {{ downtimePeriod.startedAt }}
                    </td>
                    <td>
                        {{ downtimePeriod.endedAt }}
                    </td>
                </tr>
                </tbody>
            </table>
        </card>
    </div>
</template>

<script>
    export default {
        props: ['downtimePeriods']
    }
</script>