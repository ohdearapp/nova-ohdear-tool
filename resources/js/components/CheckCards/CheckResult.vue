<template>
    <span
        :is="tag"
        class="check-result"
        :class="className"
    >
        {{ contents }}
    </span>
</template>


<script>
export default {
    props: ['check'],

    computed: {
        tag() {
            return this.hasLatestRun ? 'a' : 'span';
        },

        className() {
            return this.check ? this.check.latestRunResultClass : 'is-disabled';
        },

        hasLatestRun() {
            if (!this.check) {
                return false;
            }

            if (!this.check.enabled) {
                return false;
            }

            return !!this.check.latest_run_id;
        },

        contents() {
            if (!this.check) {
                return 'Disabled';
            }

            if (!this.check.enabled) {
                return 'Disabled';
            }

            if (this.check.alwaysRunning && this.check.enabled) {
                return 'Always running';
            }

            if (this.check.latestRunResult === 'pending') {
                return this.check.latest_run_result_label;
            }

            return this.check.latestRunResultLabel;
        },

        icon() {
            if (!this.check) {
                return 'times-icon';
            }

            if (!this.check.enabled) {
                return 'times-icon';
            }

            return (
                {
                    succeeded: 'check-icon',
                    warning: 'exclamation-icon',
                    failed: 'times-icon',
                    pending: 'clock-icon'
                }[this.check.latest_run_result] || null
            );
        }
    }
};
</script>
