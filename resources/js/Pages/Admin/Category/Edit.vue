<template>
    <Link :href="route('admin.categories.index')" class="border border-white/20 bg-gray-900 inline-block text-white px-4 py-3 rounded-lg">Назад</Link>

    <div class="w-1/4 flex flex-col gap-2 mt-5">
        <input class="bg-[#101828] border border-white/20 text-white rounded-lg" v-model="category.title" type="text" placeholder="Заголовок">
        <select class="bg-[#101828] border border-white/20 text-white rounded-lg" v-model="category.parent_id">
            <option :value="null" disabled>Выберите родительскую категорию</option>
            <option v-for="category in categoriesData" :value="category.id">{{ category.title }}</option>
        </select>
        <a @click.prevent="updateCategory(category)" class="border border-white/20 bg-gray-900 inline-block text-white px-4 py-3 rounded-lg w-max"
           href="#">Обновить</a>
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
        category: Object,
        categories: Array
    },

    data() {
        return {
            categoriesData: this.categories
        }
    },

    methods: {
        updateCategory(category) {
            console.log(category);
            axios.patch(route('admin.categories.update', category.id), category)
                .then(res => {

                });
        }
    }
})
</script>

<style scoped>

</style>
