<template>
    <span
        :is="tag"
        :href="href"
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

        href() {
            if (!this.check) {
                return '';
            }

            return this.check.latest_run_report_url;
        },

        className() {
            return this.check ? this.check.latest_run_result_class : 'is-disabled';
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

            if (this.check.always_running && this.check.enabled) {
                return 'Always running';
            }

            if (this.check.latest_run_result === 'pending') {
                return this.check.latest_run_result_label;
            }

            return this.check.latest_run_result_label;
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
                    pending: 'clock-icon',
                }[this.check.latest_run_result] || null
            );
        },
    },
};
</script>
