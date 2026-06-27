<template>
    <div class="flex items-center gap-3">
        <span class="text-sm text-gray-500 dark:text-gray-400">{{ postDate }}</span>
        <div class="flex items-center gap-2">
            <a :href="user.url">
                <img :src="user.avatar" :alt="user.name" class="h-8 w-8 rounded-full">
            </a>
            <a :href="user.url" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                {{ user.name }}
            </a>
        </div>
    </div>
</template>

<script>
export default {
    props: ['model', 'label'],

    computed: {
        postDate() {
            return this.label + ' ' + this.model.created_date;
        },
    },

    data() {
        return {
            user: this.model.user,
        };
    },
};
</script>
