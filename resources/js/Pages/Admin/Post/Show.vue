<template>
    <Link :href="route('admin.posts.index')" class="bg-gray-900 inline-block text-white px-4 py-3 rounded-lg">
        Назад
    </Link>

    <div class="relative overflow-x-auto mt-4 rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-white">
            <thead class="text-sm text-body bg-white/20 border-b border-white/20">
            <tr>
                <th scope="col" class="px-6 py-3 font-semibold">
                    Post name
                </th>
                <th scope="col" class="px-6 py-3 font-semibold">
                    Post id
                </th>
                <th scope="col" class="px-6 py-3 font-semibold">
                    Category name
                </th>
            </tr>
            </thead>
            <tbody>
            <tr class="text-sm text-body bg-[#101828] border-b border-white/20">
                <td class="px-6 py-4">
                    {{ post.title }}
                </td>
                <td class="px-6 py-4">
                    {{ post.id }}
                </td>
                <td class="px-6 py-4">
                    {{ post.category_name ?? '-' }}
                </td>
            </tr>

            </tbody>
        </table>
    </div>


</template>

<script>
import {defineComponent} from 'vue'
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";

export default defineComponent({
    name: "Index",
    layout: AdminLayout,

    props: {
        post: Object,
    },

    components: {
        Link,
    }
})
</script>

<style scoped>

</style>
