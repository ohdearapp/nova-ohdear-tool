<template>

    <div>
        <heading class="mb-6">
            Monthly uptime
        </heading>
        <card class="mb-6">


            <table cellpadding="0" cellspacing="0" class="table w-full">
                <thead>
                <tr>
                    <th class="text-left">
                        Month
                    </th>
                    <th class="text-left">
                        Percentage
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="uptimePeriod in uptimePeriods">
                    <td>
                        {{ uptimePeriod.datetime }}
                    </td>
                    <td>
                        {{ uptimePeriod.uptimePercentage }}
                    </td>
                </tr>
                </tbody>
            </table>
        </card>
    </div>
</template>

<script>
    export default {
        props: ['uptimePeriods']
    }
</script>