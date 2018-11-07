<template>
    <check-card :init-check="check">
        <div slot="body" slot-scope="check">
            <p v-if="check.enabled">
                We'll notify you when someone issues a new certificate for your site. This check is always running.
            </p>
            <p v-else>We will not notify you when someone issues a new certificate for your site.</p>
        </div>
        <div slot="link" slot-scope="check">
            <a href="https://ohdear.app/docs/checks/certificate-transparency" class="text-primary dim no-underline">
                Read more about certificate transparancy
            </a>
        </div>
    </check-card>
</template>

<script>
import CheckCard from './CheckCard';

export default {
    props: ['check', 'siteId'],

    components: {
        CheckCard
    }
};
</script>
