<template>
    <div>
        <heading class="mb-3">Certificate chain issuers</heading>
        <card class="py-3 px-6">
            <div
                v-for="(certificateChainIssuer, i) in certificateChainIssuers"
                class="border-b border-40"
                :class="{ 'border-none': i === certificateChainIssuers.length - 1 }"
                :key="i"
            >
                <div class="py-4">
                    <h4 class="font-normal text-80">{{ certificateChainIssuer }}</h4>
                </div>
            </div>
        </card>
    </div>
</template>

<script>
export default {
    props: ['certificateChainIssuers']
};
</script>
