<template>
    <heading class="mb-6">
        Certificate chain issuers
    </heading>
    <card class="mb-6">
        <table cellpadding="0" cellspacing="0" class="table w-full">
            <tbody>
            <tr v-for="certificateChainIssuer in certificateChainIssuers">
                <td>{{ certificateChainIssuer }}</td>
            </tr>
            </tbody>
        </table>
    </card>
</template>

<script>
    export default {
        props: ['certificateChainIssuers'],
    }
</script>