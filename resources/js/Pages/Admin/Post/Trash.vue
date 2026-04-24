<template>
    <Link :href="route('admin.posts.index')" class="bg-gray-900 inline-block text-white px-4 py-3 rounded-lg">
        Назад
    </Link>
    <Link :href="route('admin.posts.index')"
          class="inline-block text-gray-500 px-4 py-3 hover:underline">
        Посты ({{postsData.length}})
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
                <th scope="col" class="px-6 py-3 font-semibold">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in trashedPostsData" class="text-sm text-body bg-[#101828] border-b border-white/20">
                <td class="px-6 py-4">
                    {{ item.title }}
                </td>
                <td class="px-6 py-4">
                    {{ item.id }}
                </td>
                <td class="px-6 py-4">
                    {{ item.category_name ?? '-' }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-1 items-start flex-col">
                        <a
                            @click.prevent="item.permissions.forceDelete && deleteForever(item)"
                            :class="[
                                'text-sm',
                                item.permissions.forceDelete
                                    ? 'text-red-600 cursor-pointer'
                                    : 'text-gray-500 cursor-not-allowed'
                            ]"
                            href="#"
                        >
                            Удалить навсегда
                        </a>
                        <a
                            @click.prevent="item.permissions.restore && restorePost(item)"
                            :class="[
                                'text-sm',
                                item.permissions.restore
                                    ? 'text-green-600 cursor-pointer'
                                    : 'text-gray-500 cursor-not-allowed'
                            ]"
                            href="#"
                        >
                            Восстановить
                        </a>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <p class="text-gray-500 p-4" v-if="trashedPostsData.length === 0">Корзина пуста.</p>
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
        trashedPosts: Array,
        posts: Array
    },
    data(){
        return{
            trashedPostsData: [...this.trashedPosts],
            postsData: [...this.posts]
        }
    },

    components: {
        Link,
    },

    methods: {
        deleteForever(post){
            const deletedId = post.id
            axios.delete(route('admin.posts.force-delete', post.id))
                .then(res=>{
                    this.trashedPostsData = this.trashedPostsData.filter(item => item.id !== deletedId)
                })
        },
        restorePost(post){
            axios.post(route('admin.posts.restore', post.id))
                .then(res=> {
                    this.trashedPostsData = this.trashedPostsData.filter(item => item.id !== post.id)
                    this.postsData.push(post);
                })
        }
    },
})
</script>

<style>

</style>
