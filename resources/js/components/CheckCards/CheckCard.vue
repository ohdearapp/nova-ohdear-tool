<template>
    <article class="card p-4 h-full flex flex-col">
        <header class="mb-4 flex items-center justify-between">
            <h2 class="h1 mb-0 text-lg">
                {{ check.label }}
            </h2>
            <check-result :check="check"></check-result>
        </header>
        <div class="flex-1 flex flex-col py-4 border-b border-t border-grey-lighter min-h-32">
            <div class="flex-1 mb-4">
                <slot name="body" v-bind="check"></slot>
            </div>
            <div>
                <slot name="link" v-bind="check"></slot>
            </div>
        </div>

        <section class="mt-4 flex justify-between">
            <enable-check
              :check="check"
            ></enable-check>
            <check-request-run
              :check="check"
            ></check-request-run>
        </section>
    </article>
</template>

<script>
import EnableCheck from './EnableCheck';
import CheckResult from './CheckResult';
import CheckRequestRun from './CheckRequestRun';
import Check from '../models/Check';

export default {
    props: ['initCheck'],

    data() {
        return {
            check: null
        };
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
