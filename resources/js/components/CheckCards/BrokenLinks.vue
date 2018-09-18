<template>
    <div>
        <check-card :init-check="check">
            <div slot="body" slot-scope="check">
                <div v-if="check.enabled">
                    <div v-if="check.latestRunEndedAt">
                        <p v-if="check.latestRunResult === 'succeeded'">
                            No broken links found. Oh Dear! last checked  <relative-time :datetime="check.latestRunEndedAt"></relative-time>.
                        </p>
                        <p v-else>
                            Broken links found. Oh Dear! last checked <relative-time :datetime="check.latestRunEndedAt"></relative-time>.
                        </p>
                    </div>
                    <p v-else>
                        Oh Dear! will run this check for the first time soon.
                    </p>
                </div>
                <p v-else>
                    Oh Dear! is not monitoring broken links.
                </p>
            </div>
            <div slot="link" slot-scope="check">
                <router-link tag="li" :to="`/oh-dear/broken-links/${siteId}`">
                    <a>View broken links report</a>
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
