<template>
    <div class="flex justify-between w-full items-center gap-2">
        <div class="flex items-center gap-5 w-1/2">
            <button
                @click="$emit('category', null)"
                :class="!activeCategory ? 'font-bold' : ''"
            >
                Все
            </button>

            <button
                v-for="cat in categories"
                :key="cat.id"
                @click="$emit('category', cat.id)"
                :class="Number(activeCategory) === cat.id ? 'font-bold' : ''"
            >
                {{ cat.title }}
            </button>

            <button
                @click="$emit('reset')"
                class="text-sm text-red-500 underline"
            >
                Сбросить
            </button>
        </div>
        <input
            :value="search"
            @input="onInput"
            placeholder="Поиск..."
            class="border p-2 w-1/2"
        />
    </div>
</template>

<script>
import _ from 'lodash'

export default {
    props: {
        categories: Array,
        search: String,
        activeCategory: [Number, String, null]
    },

    methods: {
        onInput: _.debounce(function (e) {
            this.$emit('search', e.target.value)
        }, 300)
    }
}
</script>

<style scoped>

</style>
