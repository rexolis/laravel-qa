import { reactive } from 'vue';

const defaults = {
    title: 'Are you sure?',
    message: '',
    confirmText: 'Confirm',
    cancelText: 'Cancel',
    variant: 'danger',
};

export const confirmState = reactive({
    open: false,
    title: defaults.title,
    message: defaults.message,
    confirmText: defaults.confirmText,
    cancelText: defaults.cancelText,
    variant: defaults.variant,
});

let resolvePromise = null;

export function confirm(options = {}) {
    const opts = typeof options === 'string'
        ? { title: options }
        : options;

    confirmState.title = opts.title ?? defaults.title;
    confirmState.message = opts.message ?? defaults.message;
    confirmState.confirmText = opts.confirmText ?? defaults.confirmText;
    confirmState.cancelText = opts.cancelText ?? defaults.cancelText;
    confirmState.variant = opts.variant ?? defaults.variant;
    confirmState.open = true;

    return new Promise((resolve) => {
        resolvePromise = resolve;
    });
}

export function acceptConfirm() {
    confirmState.open = false;
    resolvePromise?.(true);
    resolvePromise = null;
}

export function dismissConfirm() {
    confirmState.open = false;
    resolvePromise?.(false);
    resolvePromise = null;
}

export function bindConfirmTriggers() {
    document.addEventListener('click', async (event) => {
        const trigger = event.target.closest('[data-confirm]');

        if (! trigger) {
            return;
        }

        const form = trigger.closest('form');

        if (! form || trigger.type !== 'submit') {
            return;
        }

        event.preventDefault();

        const message = trigger.dataset.confirm || form.dataset.confirm || defaults.title;
        const confirmed = await confirm(message);

        if (confirmed) {
            form.submit();
        }
    });
}
