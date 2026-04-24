<template>
    <Link :href="route('admin.posts.index')"
          class="border border-white/20 bg-gray-900 inline-block text-white px-4 py-3 rounded-lg">
        Назад
    </Link>

    <div class="w-1/4 flex flex-col gap-2 mt-5 gap-4">
        <input
            class="bg-[#101828] border border-white/20 text-white rounded-lg"
            v-model="post.title"
            type="text"
            placeholder="Заголовок"
        >
        <input
            class="bg-[#101828] border border-white/20 text-white rounded-lg"
            v-model="post.excerpt"
            type="text"
            placeholder="Краткое описание"
        >
        <textarea
            class="bg-[#101828] border border-white/20 text-white rounded-lg"
            v-model="post.content"
            placeholder="Контент"
        ></textarea>
        <select
            class="bg-[#101828] border border-white/20 text-white rounded-lg"
            v-model.number="post.category_id"
        >
            <option :value="null">Без категории</option>
            <option v-for="cat in categoriesData" :value="cat.id">
                {{ cat.title }}
            </option>
        </select>
        <img v-if="imagePreview" :src="imagePreview" :alt="post.title">
        <input
            type="file"
            @change="handleImage"
            class="text-white"
        />

        <button
            @click.prevent="storePost('publish')"
            class="border mt-5 border-green-500 bg-green-700/50 inline-block text-white px-4 py-3 rounded-lg w-max"
            :disabled="!canPublish"
        >
            Создать
        </button>

    </div>
</template>

<script>
import {defineComponent} from 'vue'
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {Link} from "@inertiajs/vue3";

export default defineComponent({
    name: "Index",
    layout: AdminLayout,

    components: {
        Link,
    },

    props: {
        categories: Array,
        canPublish: Boolean
    },

    data() {
        return {
            post: {
                title: '',
                excerpt: '',
                content: '',
                category_id: null,
                image: null,
                action: 'draft'
            },
            categoriesData: this.categories,
            imagePreview: null
        }
    },

    methods: {
        handleImage(e) {
            const file = e.target.files[0];
            this.post.image = file;
            this.imagePreview = URL.createObjectURL(file);
        },

        storePost(action) {
            this.post.action = action;

            let formData = new FormData();

            for (let key in this.post) {
                if (this.post[key] !== null) {
                    formData.append(key, this.post[key]);
                }
            }

            axios.post(route('admin.posts.store'), formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(() => {
                this.post = {
                    title: '',
                    excerpt: '',
                    content: '',
                    category_id: null,
                    image: null,
                    action: 'draft'
                }
            });
        }
    }
})
</script>

<style scoped>

</style>
