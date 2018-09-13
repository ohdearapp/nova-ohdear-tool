<template>
    <heading class="mb-6">
        Certificate details
    </heading>
    <card class="mb-6">
        <ul>
            <li>Issuer: {{ certificateDetails.issuer_name }}</li>
            <li>Valid from: {{ certificateDetails.valid_from }}</li>
            <li>Valid until: {{ certificateDetails.valid_until }}</li>
        </ul>
    </card>
</template>

<script>
    export default {
        props: ['certificateDetails'],
    }
</script>