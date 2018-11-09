<template>
    <div>
        <heading class="mb-3">Broken links</heading>
        <card class="overflow-hidden">
            <div class="overflow-x-auto">
                <table cellpadding="0" cellspacing="0" class="table w-full">
                    <thead>
                        <tr>
                            <th class="text-left">Status code</th>
                            <th class="text-left">Broken link</th>
                            <th class="text-left">Found on</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(brokenLink, i) in brokenLinks" :key="i">
                            <td>{{ brokenLink.statusCode || 'No response' }}</td>
                            <td>
                                <a :href="brokenLink.crawledUrl" class="text-primary dim no-underline">{{ brokenLink.crawledUrl }}</a>
                            </td>
                            <td>
                                <a :href="brokenLink.foundOnUrl" class="text-primary dim no-underline">{{ brokenLink.foundOnUrl }}</a>
                            </td>
                        </tr>
                        <tr v-if="brokenLinks.length === 0">
                            <td class="text-center" colspan="4">No broken links found</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </card>
    </div>
</template>

<script>
export default {
    props: ['brokenLinks']
};
</script>
