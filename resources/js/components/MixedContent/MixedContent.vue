<template>
    <div>
        <heading class="mb-6"> Mixed content </heading>
        <card class="mb-6">
            <table cellpadding="0" cellspacing="0" class="table w-full">
                <thead>
                    <tr>
                        <th class="text-left">Found on</th>
                        <th class="text-left">Mixed content element</th>
                        <th class="text-left">Mixed content url</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="mixedContentItem in mixedContent">
                        <td>
                            <a :href="mixedContentItem.foundOnUrl">{{ mixedContentItem.foundOnUrl }}</a>
                        </td>
                        <td>{{ mixedContentItem.elementName }}</td>
                        <td>
                            <a :href="mixedContentItem.mixedContentUrl">{{ mixedContentItem.mixedContentUrl }}</a>
                        </td>
                    </tr>
                    <tr v-if="mixedContent.length === 0">
                        <td class="text-center" colspan="4">No mixed content found</td>
                    </tr>
                </tbody>
            </table>
        </card>
    </div>
</template>

<script>
export default {
    props: ['mixedContent']
};
</script>
