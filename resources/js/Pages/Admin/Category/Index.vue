<template>
    <div>
        <Link :href="route('admin.categories.create')" class="bg-gray-900 inline-block text-white px-4 py-3 rounded-lg">
            Добавить категорию
        </Link>
        <Link :href="route('admin.categories.trash')"
              class="inline-block text-gray-500 px-4 py-3 hover:underline">
            Корзина ({{trashedCategoriesData.length}})
        </Link>
    </div>

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
            <tr v-for="item in categoriesData" class="text-sm text-body bg-[#101828] border-b border-white/20">
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
                    <div class="flex gap-2 items-center">
                        <Link :href="route('admin.categories.show', item.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-4 cursor-pointer text-emerald-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                            </svg>
                        </Link>
                        <Link :href="route('admin.categories.edit', item.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="size-4 cursor-pointer text-emerald-600">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/>
                            </svg>
                        </Link>
                        <svg @click="deleteCategory(item)" xmlns="http://www.w3.org/2000/svg" fill="none"
                             viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="size-4 cursor-pointer text-red-600">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                        </svg>
                    </div>
                </td>
            </tr>

            </tbody>
        </table>
        <p class="text-gray-500 p-4" v-if="categoriesData.length === 0">Нет категорий.</p>
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
        categories: Array,
        trashedCategories: Array
    },
    data() {
        return {
            categoriesData: [...this.categories],
            trashedCategoriesData: [...this.trashedCategories]
        }
    },
    components: {
        Link,
    },
    methods: {
        deleteCategory(category) {
            const deletedId = category.id
            axios.delete(route('admin.categories.destroy', category.id))
                .then(res => {
                    this.categoriesData = this.categoriesData.filter(item => item.id !== deletedId)

                    this.trashedCategoriesData.push(category);
                })
        }
    }
})
</script>

<style scoped>

</style>
