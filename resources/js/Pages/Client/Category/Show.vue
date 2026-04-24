<template>
    <div class="flex gap-6 p-6 flex-col items-center">

        <aside class="w-1/4 flex items-center justify-between gap-10">
            <Link :href="route('home')">На главную</Link>
            <div class="flex items-center gap-2">
                <div v-for="cat in categories" :key="cat.id">
                    <Link :href="route('categories.show', cat.id)">
                        {{ cat.title }}
                    </Link>
                </div>
            </div>
        </aside>

        <main class="w-full">
            <h1 class="mb-6 text-xl font-bold">Посты</h1>
            <div class="grid grid-cols-3 gap-4">
                <div v-for="post in posts" :key="post.id" class="border border-gray-300 flex flex-col justify-between">
                    <div v-if="post.image" class="mb-6">
                        <img
                            :src="`/storage/${post.image}`"
                            :alt="post.title"
                            class="w-full"
                        >
                    </div>
                    <div class="p-4">
                        <Link :href="route('posts.show', post.slug)">
                            <h2 class="text-lg font-semibold hover:underline">
                                {{ post.title }}
                            </h2>
                        </Link>

                        <p class="text-gray-400">{{ post.excerpt }}</p>

                        <div class="text-sm text-gray-500 mt-2">
                            {{ post.author }} | {{ post.category }} | {{ post.created_at }}
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>
</template>

<script>
import {defineComponent} from 'vue'
import {Link} from "@inertiajs/vue3";
import ClientLayout from "@/Layouts/ClientLayout.vue";

export default defineComponent({
    name: "Index",
    layout: ClientLayout,

    components: {
        Link
    },
    props: {
        categories: Array,
        posts: Array
    },

    methods: {
        formatDate(date) {
            return new Date(date).toLocaleDateString()
        }
    },
})
</script>


<style scoped>

</style>
