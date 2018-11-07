<template>
    <div>
        <heading class="mb-3">Mixed content</heading>
        <card class="overflow-hidden">
            <div class="overflow-x-auto">
                <table cellpadding="0" cellspacing="0" class="table w-full">
                    <thead>
                        <tr>
                            <th class="text-left">Found on</th>
                            <th class="text-left">Element</th>
                            <th class="text-left">URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="mixedContentItem in mixedContent">
                            <td class="py-3">
                                <a :href="mixedContentItem.foundOnUrl" class="text-primary dim no-underline">{{ mixedContentItem.foundOnUrl }}</a>
                            </td>
                            <td class="py-3">{{ mixedContentItem.elementName }}</td>
                            <td class="py-3">
                                <a :href="mixedContentItem.mixedContentUrl" class="text-primary dim no-underline">{{ mixedContentItem.mixedContentUrl }}</a>
                            </td>
                        </tr>
                        <tr v-if="mixedContent.length === 0">
                            <td class="text-center" colspan="4">No mixed content found</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </card>
    </div>
</template>

<script>
export default {
    props: ['mixedContent']
};
</script>
