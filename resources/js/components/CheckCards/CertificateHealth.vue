<template>
    <div>
        <check-card :init-check="check">
            <div slot="body" slot-scope="check">
                <div v-if="check.enabled">
                    <div v-if="check.latestRunEndedAt">
                        <p v-if="check.latestRunResult === 'succeeded'">
                            Your certificate is healthy. Oh Dear! last checked
                            <relative-time :datetime="check.latestRunEndedAt"></relative-time>
                            .
                        </p>
                        <p v-else>
                            Your certificate is unhealthy. Oh Dear! last checked
                            <relative-time :datetime="check.latestRunEndedAt"></relative-time>
                            .
                        </p>
                    </div>
                    <p v-else>
                        We will run this check for the first time soon.
                    </p>
                </div>
                <p v-else>
                    We are not monitoring the certificate of your site.
                </p>
            </div>
            <div slot="link" slot-scope="check">
                <router-link tag="li" :to="`/oh-dear/certificate-health/${siteId}`">
                    <a>View certificate health report</a>
                </router-link>
            </div>
        </check-card>
    </div>
</template>

<script>
    import CheckCard from './CheckCard';
    import RelativeTime from './RelativeTime';

    export default {
        props: ['check', 'siteId'],

        components: {
            CheckCard,
            RelativeTime,
        }
    }
</script>
