<template>
    <div>
        <heading class="mb-3">Certificate details</heading>
        <card class="py-3 px-6">
            <div class="flex border-b border-40">
                <div class="w-1/4 py-4">
                    <h4 class="font-normal text-80">
                        Issuer
                    </h4>
                </div>
                <div class="w-3/4 py-4">
                    <p class="text-90">
                        {{ certificateDetails.issuer }}
                    </p>
                </div>
            </div>
            <div class="flex border-b border-40">
                <div class="w-1/4 py-4">
                    <h4 class="font-normal text-80">
                        Valid from
                    </h4>
                </div>
                <div class="w-3/4 py-4">
                    <p class="text-90">
                        {{ certificateDetails.valid_from }}
                    </p>
                </div>
            </div>
            <div class="flex border-b border-40 border-none">
                <div class="w-1/4 py-4">
                    <h4 class="font-normal text-80">
                        Valid until
                    </h4>
                </div>
                <div class="w-3/4 py-4">
                    <p class="text-90">
                        {{ certificateDetails.valid_until }}
                    </p>
                </div>
            </div>
        </card>
    </div>
</template>

<script>
export default {
    props: ['certificateDetails']
};
</script>
