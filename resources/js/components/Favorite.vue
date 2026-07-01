<template>
    <a
        href="#"
        title="Click to mark as favorite question (Click again to undo)"
        :class="classes"
        @click.prevent="toggle"
    >
        <svg class="w-6 h-6 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005z" clip-rule="evenodd" />
        </svg>
        <span class="block text-xs mt-0.5">{{ count }}</span>
    </a>
</template>

<script>
import axios from 'axios';
import { toast } from 'vue-sonner';

export default {
    props: {
        question: {
            type: Object,
            required: true,
        },
        signedIn: {
            type: Boolean,
            default: false,
        },
    },

    data() {
        return {
            isFavorited: this.question.is_favorited,
            count: this.question.favorites_count,
            id: this.question.id,
            csrfToken: document.querySelector('meta[name="csrf-token"]')?.content ?? '',
        };
    },

    computed: {
        classes() {
            if (! this.signedIn) {
                return 'block mt-2 text-gray-300 dark:text-gray-600 cursor-default';
            }

            return [
                'block mt-2 cursor-pointer',
                this.isFavorited
                    ? 'text-amber-400 hover:text-amber-500'
                    : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200',
            ];
        },

        endpoint() {
            return `/questions/${this.id}/favorites`;
        },
    },

    methods: {
        requestHeaders() {
            return {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': this.csrfToken,
            };
        },

        toggle() {
            if (! this.signedIn) {
                toast.warning('Please login to favorite this question');
                return;
            }

            this.isFavorited ? this.destroy() : this.create();
        },

        destroy() {
            axios.delete(this.endpoint, {
                headers: this.requestHeaders(),
            }).then(() => {
                this.count--;
                this.isFavorited = false;
            });
        },

        create() {
            axios.post(this.endpoint, null, {
                headers: this.requestHeaders(),
            }).then(() => {
                this.count++;
                this.isFavorited = true;
            });
        },
    },
};
</script>
