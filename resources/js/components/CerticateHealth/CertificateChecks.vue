<template>
    <div>
        <heading class="mb-6">
            Certificate checks
        </heading>
        <card class="mb-6">
            <table cellpadding="0" cellspacing="0" class="table w-full">
                <tbody>
                <tr v-for="check in certificateChecks">
                    <td>{{ check.label }}</td>
                    <td>{{ check.passed }}</td>
                </tr>
                </tbody>
            </table>
        </card>
    </div>
</template>

<script>
    export default {
        props: ['certificateChecks'],
    }
</script>