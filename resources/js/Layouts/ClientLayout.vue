<template>
    <section class="w-full p-4 border-b bg-gray-900 text-white border-[#1e2939]">
        <header class="flex justify-between items-center">
            Frontend Logo
        </header>
    </section>
    <section class="flex">
        <article class="relative p-4 block flex-1 bg-white text-gray-600 ">
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
    }
}
</script>

<style scoped>

</style>
