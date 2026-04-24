<template>
    <div class="flex gap-6 p-6 flex-col items-center">

        <aside class="w-3/4 flex justify-between items-center gap-2">
            <PostFilters
                :categories="categories"
                :search="search"
                :activeCategory="activeCategory"
                @search="onSearch"
                @category="filterByCategory"
                @reset="resetFilters"
            />
        </aside>

        <main class="w-full">
            <h1 class="mb-6 text-xl font-bold">Посты</h1>
            <div class="grid grid-cols-3 gap-4">
                <div v-for="post in posts.data" :key="post.id"
                     class="border border-gray-300 flex flex-col justify-between">
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
            <div class="flex gap-2 mt-10">
                <button
                    v-for="link in posts.meta.links"
                    :key="link.label"
                    v-html="link.label"
                    :disabled="!link.url"
                    @click="link.url && $inertia.visit(link.url)"
                    class="px-3 py-1 border"
                />
            </div>
        </main>

    </div>
</template>

<script>
import {defineComponent} from 'vue'
import {Link} from "@inertiajs/vue3";
import ClientLayout from "@/Layouts/ClientLayout.vue";
import PostFilters from "@/Components/PostFilters.vue";
export default defineComponent({
    name: "Index",
    layout: ClientLayout,

    components: {
        Link,
        PostFilters
    },
    data() {
        return {
            search: this.filters.search || '',
            activeCategory: this.filters.category_id || null
        }
    },
    props: {
        posts: Object,
        categories: Array,
        filters: Object
    },
    methods: {
        onSearch(value) {
            this.search = value;

            this.$inertia.get(route('home'), {
                search: this.search,
                category_id: this.activeCategory
            }, {
                preserveState: true,
                replace: true
            });
        },

        filterByCategory(categoryId) {
            this.activeCategory = categoryId;

            this.$inertia.get(route('home'), {
                search: this.search,
                category_id: categoryId
            }, {
                preserveState: true,
                replace: true
            });
        },
        resetFilters() {
            this.search = '';
            this.activeCategory = null;

            this.$inertia.get(route('home'), {}, {
                preserveState: true,
                replace: true
            });
        }
    }
})
</script>


<style scoped>

</style>
