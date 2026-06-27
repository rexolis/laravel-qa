<template>
    <div class="w-full min-w-0" v-cloak>
        <form v-if="editing" @submit.prevent="update" class="w-full min-w-0 space-y-3">
            <textarea
                v-model="body"
                rows="10"
                required
                class="block w-full min-w-0 max-w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
            ></textarea>
            <div class="flex items-center gap-2">
                <button
                    type="submit"
                    :disabled="isInvalid"
                    class="inline-flex items-center rounded-md border border-transparent bg-gray-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white dark:focus:bg-white dark:focus:ring-offset-gray-800"
                >
                    Update
                </button>
                <button
                    type="button"
                    @click="cancel"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800"
                >
                    Cancel
                </button>
            </div>
        </form>

        <div v-else class="w-full min-w-0">
            <div class="text-gray-700 dark:text-gray-300 leading-relaxed break-words" v-html="bodyHtml"></div>
            <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-4">
                    <button
                        v-if="canUpdate"
                        type="button"
                        @click="edit"
                        class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100"
                    >
                        Edit
                    </button>
                    <form
                        v-if="canDelete"
                        :action="deleteUrl"
                        method="POST"
                        class="inline"
                        @submit="onDelete"
                    >
                        <input type="hidden" name="_token" :value="csrfToken">
                        <input type="hidden" name="_method" value="DELETE">
                        <button
                            type="submit"
                            class="text-sm text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300"
                        >
                            Delete
                        </button>
                    </form>
                </div>
                <UserInfo :model="answer" label="Answered" />
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import UserInfo from './UserInfo.vue';

export default {
    components: {
        UserInfo,
    },

    props: {
        answer: {
            type: Object,
            required: true,
        },
        canUpdate: {
            type: Boolean,
            default: false,
        },
        canDelete: {
            type: Boolean,
            default: false,
        },
        deleteUrl: {
            type: String,
            required: true,
        },
    },

    data() {
        return {
            editing: false,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            questionId: this.answer.question_id,
            beforeEditCache: null,
            csrfToken: document.querySelector('meta[name="csrf-token"]')?.content ?? '',
        };
    },

    computed: {
        isInvalid() {
            return this.body.length < 10;
        },
    },

    methods: {
        edit() {
            this.beforeEditCache = this.body;
            this.editing = true;
        },

        cancel() {
            this.body = this.beforeEditCache;
            this.editing = false;
        },

        update() {
            axios.patch(`/questions/${this.questionId}/answers/${this.id}`, {
                body: this.body,
            }, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': this.csrfToken,
                },
            })
                .then((res) => {
                    this.editing = false;
                    this.bodyHtml = res.data.body_html;
                    this.answer.body = this.body;
                    alert(res.data.message);
                })
                .catch((err) => {
                    alert(err.response?.data?.message ?? 'Something went wrong.');
                });
        },

        onDelete(event) {
            if (! confirm('Are you sure?')) {
                event.preventDefault();
            }
        },
    },
};
</script>
