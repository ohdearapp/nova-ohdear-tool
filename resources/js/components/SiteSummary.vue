<template>
        <card class="relative p-3 mb-6 w-1/3">
            <ul class="list-reset">
                <li v-for="check in activeChecks">
                    <check-status :status="check.result"></check-status>
                    {{ check.name }}
                </li>
            </ul>
        </card>
</template>

<script>
    import CheckStatus from './CheckStatus';

    export default {
        props: ['site'],

        components: {CheckStatus},

        computed: {
            activeChecks() {
                return this.site.checks
                    .filter(check => check.enabled)
                    .map(check => ({
                        name: _.capitalize(check.type.replace('_', ' ')),
                        result: this.getStatusForRunResult(check.latestsRunResult),
                    }));
            },
        },

        methods: {
            getStatusForRunResult(runResult) {
                if (runResult === 'succeeded') {
                    return 'success';
                }

                if (runResult === 'failed') {
                    return 'danger';
                }

                if (runResult === 'errored-or-timed-out') {
                    return 'danger';
                }

                return 'info';


            }
        }
    }
</script>