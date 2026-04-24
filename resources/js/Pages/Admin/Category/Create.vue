<template>
    <Link :href="route('admin.categories.index')" class="border border-white/20 bg-gray-900 inline-block text-white px-4 py-3 rounded-lg">Назад</Link>

    <div class="w-1/4 flex flex-col gap-2 mt-5">
    <input class="bg-[#101828] border border-white/20 text-white rounded-lg" v-model="category.title" type="text" placeholder="Заголовок">
      <select class="bg-[#101828] border border-white/20 text-white rounded-lg" v-model="category.parent_id">
        <option :value="null" disabled>Выберите родительскую категорию</option>
        <option v-for="category in categoriesData" :value="category.id">{{ category.title }}</option>
      </select>
      <a @click.prevent="storeCategory" class="border border-white/20 bg-gray-900 inline-block text-white px-4 py-3 rounded-lg w-max" href="#">Создать</a>
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
      categories : Array
    },

    data(){
      return{
        category: {
          parent_id: null
        },
        categoriesData: this.categories
      }
    },

    methods: {
      storeCategory(){
          console.log(this.category);
        axios.post(route('admin.categories.store'), this.category)
            .then(res =>{
              this.categoriesData.push(res.data)

              this.category = {
                parent_id: null
              }
            });
      }
    }
})
</script>

<style scoped>

</style>
