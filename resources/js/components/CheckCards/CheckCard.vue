<template>
    <card class="overflow-hidden h-full flex flex-col">
        <header
            class="flex items-center justify-between border-t-4 px-6 pt-4 pb-2 mb-6"
            :class="`border-${check.color}`"
        >
            <h3>
                <router-link v-if="url" :to="url" class="text-90 no-underline">
                    {{ check.label }}
                </router-link>
                <span v-else>{{ check.label }}</span>
            </h3>
            <check-result :check="check" class="text-80"></check-result>
        </header>
        <div class="flex-1 px-6 mb-6 text-90">
            <slot name="body" v-bind="check"></slot>
        </div>
        <div class="px-6 mb-3">
            <slot v-if="check.enabled" name="link" v-bind="check">
                <router-link v-if="url" :to="url" class="text-primary dim no-underline">
                    View the latest report
                </router-link>
            </slot>
        </div>
        <section class="flex items-center justify-between py-3 px-6 bg-20 rounded-b border-t border-50">
            <enable-check :check="check"></enable-check>
            <check-request-run v-if="check.type !== 'certificate_transparency'" :check="check"></check-request-run>
        </section>
    </card>
</template>

<script>
import EnableCheck from './EnableCheck';
import CheckResult from './CheckResult';
import CheckRequestRun from './CheckRequestRun';
import Check from '../../models/Check';

export default {
    props: ['initCheck', 'url'],

    data: () => ({
        check: null
    }),

    watch: {
        async initCheck() {
            this.check = new Check(this.initCheck);
        }
    },

    components: {
        EnableCheck,
        CheckResult,
        CheckRequestRun
    },

    created() {
        this.check = new Check(this.initCheck);
    }
};
</script>
