<template>
    <div>
        <heading class="mb-3">Certificate checks</heading>
        <card class="py-3 px-6">
            <div
                v-for="(check, i) in certificateChecks"
                :key="i"
                class="flex border-b border-40"
                :class="{ 'border-none': i === certificateChecks.length - 1 }"
            >
                <div class="w-1/2 py-4">
                    <h4 class="font-normal text-80">
                        {{ check.label }}
                    </h4>
                </div>
                <div class="w-1/2 py-4">
                    <span
                        class="inline-block rounded-full w-2 h-2"
                        :class="{'bg-success': check.passed, 'bg-danger': !check.passed }"
                    ></span>
                </div>
            </div>
        </card>
    </div>
</template>

<script>
export default {
    props: ['certificateChecks']
};
</script>
