<template>
    <Link :href="route('admin.posts.index')" class="border border-white/20 bg-gray-900 inline-block text-white px-4 py-3 rounded-lg">
        Назад
    </Link>
    <div v-if="success"
         class="border border-white/20 bg-emerald-900/60 w-full
         text-white px-4 py-3 rounded-b-lg absolute top-0 text-center left-1/2 -translate-x-1/2">
        Успешно сохранено!
    </div>
    <div class="w-1/4 flex flex-col gap-2 mt-5">
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
        <img v-if="post.image" :src="this.imagePreview" :alt="post.title">
        <input
            type="file"
            @change="handleImage"
            class="text-white"
        />
        <a
            @click.prevent="updatePost(post)"
            class="border border-white/20 bg-gray-900 inline-block text-white px-4 py-3 rounded-lg w-max"
            href="#"
        >
            Сохранить
        </a>

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
        post: Object,
        categories: Array
    },

    data() {
        return {
            categoriesData: this.categories,
            imagePreview: this.post.image
                ? `/storage/${this.post.image}`
                : null,
            success: false,
        }
    },

    methods: {
        handleImage(e) {
            const file = e.target.files[0];
            this.post.image = file;
            this.imagePreview = URL.createObjectURL(file);
        },
        updatePost(post) {
            let formData = new FormData();

            formData.append('_method', 'PATCH');

            formData.append('title', post.title);
            formData.append('excerpt', post.excerpt);
            formData.append('content', post.content);
            formData.append('category_id', post.category_id);

            if (post.image instanceof File) {
                formData.append('image', post.image);
            }

            axios.post(route('admin.posts.update', post.id), formData)
                .then(() => {
                    this.success = true
                });
        }
    },
    watch: {
        post: {
            handler(new_val, old_val){
                this.success = false
            },
            deep: true
        }
    },
})
</script>

<style scoped>

</style>
