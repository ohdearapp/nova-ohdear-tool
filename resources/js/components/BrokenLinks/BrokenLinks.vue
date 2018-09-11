<template>

    <div>
        <heading class="mb-6">
            Broken links
        </heading>
        <card class="mb-6">


            <table cellpadding="0" cellspacing="0" class="table w-full">
                <thead>
                <tr>
                    <th class="text-left">
                        Status code
                    </th>
                    <th class="text-left">
                        Broken link
                    </th>
                    <th class="text-left">
                        Found on
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="brokenLink in brokenLinks">
                        <td>
                            {{ brokenLink.statusCode || 'No response' }}
                        </td>
                        <td>
                            <a :href="brokenLink.crawledUrl">{{ brokenLink.crawledUrl }}</a>
                        </td>
                        <td>
                            <a :href="brokenLink.foundOnUrl">{{ brokenLink.foundOnUrl }}</a>
                        </td>
                    </tr>
                    <tr v-if="brokenLinks.length === 0">
                        <td class="text-center" colspan="4">
                            No broken links found
                        </td>
                    </tr>
                </tbody>
            </table>
        </card>
    </div>
</template>

<script>
export default {
    props: ['brokenLinks']
};
</script>
