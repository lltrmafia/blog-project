<template>
    <div class="w-3/4 p-4 flex items-start justify-between h-full">
        <div class="w-1/2 flex flex-col justify-between h-full min-h-full">
            <div>
                <h1 class="text-3xl font-bold mb-4">{{ post.title }}</h1>
                <div
                    class="prose prose-invert max-w-none"
                    v-html="post.content"
                ></div>
            </div>
            <div class="text-sm text-gray-400 mb-6">
                <span v-if="post.author">Автор: {{ post.author }}</span>
                <span v-if="post.category"> | Категория: {{ post.category }}</span>
                <span v-if="post.created_at"> | Дата публикации: {{ post.created_at }}</span>
            </div>
        </div>
        <div class="w-1/2">
            <div v-if="post.image" class="mb-6">
                <img
                    :src="`/storage/${post.image}`"
                    :alt="post.title"
                    class="w-full rounded-lg"
                >
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent} from 'vue'
import {Link} from "@inertiajs/vue3";
import ClientLayout from "@/Layouts/ClientLayout.vue";

export default defineComponent({
    name: "Index",
    layout: ClientLayout,

    props: {
        post: Object,
    },
    components: {
        Link
    }
})
</script>


<style scoped>

</style>
