<template>
    <Link :href="route('admin.categories.index')" class="bg-gray-900 inline-block text-white px-4 py-3 rounded-lg">
        Назад
    </Link>
    <Link :href="route('admin.categories.index')"
          class="inline-block text-gray-500 px-4 py-3 hover:underline">
        Категории ({{categoriesData.length}})
    </Link>
    <div class="relative overflow-x-auto mt-4 rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-white">
            <thead class="text-sm text-body bg-white/20 border-b border-white/20">
            <tr>
                <th scope="col" class="px-6 py-3 font-semibold">
                    Category name
                </th>
                <th scope="col" class="px-6 py-3 font-semibold">
                    Category id
                </th>
                <th scope="col" class="px-6 py-3 font-semibold">
                    Parent id
                </th>
                <th scope="col" class="px-6 py-3 font-semibold">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in trashedCategoriesData" class="text-sm text-body bg-[#101828] border-b border-white/20">
                <td class="px-6 py-4">
                    {{ item.title }}
                </td>
                <td class="px-6 py-4">
                    {{ item.id }}
                </td>
                <td class="px-6 py-4">
                    {{ item.parent_id ?? '-' }}
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-1 items-start flex-col">
                        <a @click.prevent="deleteForever(item)" class="text-sm text-red-600" href="#">Удалить навсегда</a>
                        <a @click.prevent="restoreCategory(item)" class="text-sm text-green-600" href="#">Восстановить</a>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <p class="text-gray-500 p-4" v-if="trashedCategoriesData.length === 0">Корзина пуста.</p>
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
        trashedCategories: Array,
        categories: Array
    },
    data(){
        return{
            trashedCategoriesData: [...this.trashedCategories],
            categoriesData: [...this.categories]
        }
    },
    components: {
        Link,
    },
    methods: {
        deleteForever(category){
            const deletedId = category.id
            axios.delete(route('admin.categories.force-delete', category.id))
                .then(res=>{
                    this.trashedCategoriesData = this.trashedCategoriesData.map((item) => {
                        if (item.parent_id === deletedId) {
                            return {...item, parent_id: null}
                        }
                        return item;
                    }).filter(item => item.id !== deletedId)
                })
        },
        restoreCategory(category){
            axios.post(route('admin.categories.restore', category.id))
                .then(res=> {
                    this.trashedCategoriesData = this.trashedCategoriesData.filter(item => item.id !== category.id)
                    this.categoriesData.push(category);
                })
        }
    }
})
</script>

<style scoped>

</style>
