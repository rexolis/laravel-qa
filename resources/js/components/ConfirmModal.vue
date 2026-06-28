<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-300 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="state.open"
                class="fixed inset-0 z-50"
                role="dialog"
                aria-modal="true"
                :aria-labelledby="titleId"
            >
                <div
                    class="fixed inset-0 bg-gray-500 opacity-75 dark:bg-gray-900"
                    aria-hidden="true"
                ></div>

                <div class="fixed inset-0 flex items-center justify-center p-4">
                    <Transition
                        appear
                        enter-active-class="transition duration-300 ease-out"
                        enter-from-class="opacity-0 scale-95 translate-y-2"
                        enter-to-class="opacity-100 scale-100 translate-y-0"
                        leave-active-class="transition duration-200 ease-in"
                        leave-from-class="opacity-100 scale-100 translate-y-0"
                        leave-to-class="opacity-0 scale-95 translate-y-2"
                    >
                        <div
                            class="relative z-10 w-fit overflow-hidden rounded-lg bg-white shadow-xl dark:bg-gray-800"
                        >
                            <div class="p-6">
                                <h2 :id="titleId" class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                    {{ state.title }}
                                </h2>

                                <p v-if="state.message" class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                    {{ state.message }}
                                </p>

                                <div class="mt-6 flex justify-end gap-3">
                                    <button
                                        type="button"
                                        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800"
                                        @click="dismissConfirm"
                                    >
                                        {{ state.cancelText }}
                                    </button>
                                    <button
                                        ref="confirmButton"
                                        type="button"
                                        :class="confirmButtonClass"
                                        @click="acceptConfirm"
                                    >
                                        {{ state.confirmText }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </Transition>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script>
import { acceptConfirm, confirmState, dismissConfirm } from '../confirm';

export default {
    data() {
        return {
            state: confirmState,
            titleId: `confirm-modal-title-${Math.random().toString(36).slice(2, 9)}`,
        };
    },

    computed: {
        confirmButtonClass() {
            const base = 'inline-flex items-center rounded-md border border-transparent px-4 py-2 text-xs font-semibold uppercase tracking-widest transition focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800';

            if (this.state.variant === 'danger') {
                return `${base} bg-red-600 text-white hover:bg-red-500 focus:ring-red-500 dark:bg-red-600 dark:hover:bg-red-500`;
            }

            return `${base} bg-gray-800 text-white hover:bg-gray-700 focus:ring-indigo-500 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white`;
        },
    },

    watch: {
        'state.open'(open) {
            document.body.classList.toggle('overflow-y-hidden', open);

            if (open) {
                this.$nextTick(() => {
                    this.$refs.confirmButton?.focus();
                });
            }
        },
    },

    beforeUnmount() {
        document.body.classList.remove('overflow-y-hidden');
    },

    methods: {
        acceptConfirm,
        dismissConfirm,
    },
};
</script>
