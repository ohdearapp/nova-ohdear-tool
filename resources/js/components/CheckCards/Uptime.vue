<template>
    <div>
        <check-card :init-check="check">
            <div slot="body" slot-scope="check">
                <div v-if="check.enabled">
                    <div v-if="check.latestRunEndedAt">
                        <p v-if="check.latestRunResult === 'succeeded'">
                            Your site is up. We last checked
                            <relative-time :datetime="check.latestRunEndedAt"></relative-time>
                            .
                        </p>
                        <p v-else>
                            Your site is down. We last checked
                            <relative-time :datetime="check.latestRunEndedAt"></relative-time>
                            .
                        </p>
                    </div>
                    <p v-else>
                        We will run this check for the first time soon.
                    </p>
                </div>
                <p v-else>
                    We are not monitoring your site's uptime.
                </p>
            </div>
            <div slot="link" slot-scope="check">
                <router-link tag="a" :to="`/oh-dear/uptime/${siteId}`">
                    View the latest report
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
        RelativeTime
    }
};
</script>
