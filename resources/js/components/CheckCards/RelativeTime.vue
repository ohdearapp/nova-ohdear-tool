<template>
    <time :datetime="$toNovaTimezone(datetime)" :title="$toNovaTimezone(datetime)">{{
        $toNovaTimezoneRelative(datetime)
    }}</time>
</template>

<script>
import Date from '../../utilities/Date';
import upperFirst from 'lodash/upperFirst';

export default {
    props: ['datetime'],

    mixins: [Date],

    created() {
        this.interval = setInterval(() => this.$forceUpdate(), 30 * 1000);
    },

    beforeDestroy() {
        clearInterval(this.interval);
    },

    filters: {
        upperFirst
    }
};
</script>
