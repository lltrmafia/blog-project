<template>
    <section class="w-full p-4 border-b bg-gray-900 text-white border-[#1e2939]">
        <header class="flex justify-between items-center">
            Admin Logo
            <button @click="logout" class="text-white">
                Выйти
            </button>
        </header>
    </section>
    <section class="flex">
        <aside class="w-1/5 bg-[#030712] min-h-screen border border-[#1e2939] border-t-0">
            <nav>
                <Link :href="route('dashboard')" class="block p-4 text-white">Панель</Link>
                <Link :href="route('admin.posts.index')" class="block p-4 text-white">Посты</Link>
                <Link :href="route('admin.categories.index')" class="block p-4 text-white">Категории</Link>
            </nav>
        </aside>
        <article class="relative p-4 block flex-1 bg-[#030712] ">
            <slot />
        </article>
    </section>
    <section>
        <footer>

        </footer>
    </section>
</template>

<script>
import {Link} from "@inertiajs/vue3";

export default {
    name: "AdminLayout",

    components: {
        Link
    },
    methods: {
        logout() {
            this.$inertia.post(route('logout'))
        }
    }
}
</script>

<style scoped>

</style>
