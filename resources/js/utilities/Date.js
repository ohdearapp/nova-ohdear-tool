import moment from 'moment-timezone';

export default {
    methods: {
        $toNovaTimezone(dateString) {
            return moment
                .tz(dateString, 'UTC')
                .tz(Nova.config.timezone)
                .format('YYYY-MM-DD HH:mm:ss');
        },

        $toNovaTimezoneRelative(dateString) {
            return moment
                .tz(dateString, 'UTC')
                .tz(Nova.config.timezone)
                .fromNow();
        },
    },
};
