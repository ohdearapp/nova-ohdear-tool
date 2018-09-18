<template>
    <check-card :init-check="check">
        <div slot="body" slot-scope="check">
            <div v-if="check.enabled">
                <div v-if="check.latest_run_ended_at">
                    <p v-if="check.latest_run_result === 'succeeded'">
                        No broken links found. Oh Dear! last checked {{ check.latest_run_ended_at }}.
                    </p>
                    <p v-else>
                        Broken links found. Oh Dear! last checked {{ check.latest_run_ended_at }}.
                    </p>
                </div>
                <p v-else>
                    Oh Dear! will run this check for the first time soon.
                </p>
            </div>
            <p v-else>
                Oh Dear! are not monitoring broken links.
            </p>
        </div>
        <div slot="link" slot-scope="check">
            <router-link tag="li" :to="`/oh-dear/broken-links/${viewingSiteId}`">
                <a>View broken links report</a>
            </router-link>

            <a
              v-if="check.enabled && check.latest_run_ended_at"
              class="text-sm text-grey-dark underline"
              :href="check.latest_run_report_url"
            >
                View the latest report on Oh Dear!
            </a>
        </div>
    </check-card>
</template>

<script>
    export default {
        props: ['check', 'viewingSiteId'],
    }
</script>
