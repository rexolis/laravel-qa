import Alpine from 'alpinejs';
import { createApp } from 'vue';
import { toast } from 'vue-sonner';
import 'vue-sonner/style.css';
import { bindConfirmTriggers } from './confirm';
import ToasterHost from './components/ToasterHost.vue';
import ConfirmModalHost from './components/ConfirmModalHost.vue';
import UserInfo from './components/UserInfo.vue';
import Answer from './components/Answer.vue';
import Favorite from './components/Favorite.vue';

window.Alpine = Alpine;
Alpine.start();

function showFlashMessages() {
    const el = document.getElementById('flash-messages');

    if (! el) {
        return;
    }

    const messages = JSON.parse(el.textContent);

    if (messages.success) {
        toast.success(messages.success);
    }

    if (messages.error) {
        toast.error(messages.error);
    }
}

const toasterEl = document.getElementById('toaster');

if (toasterEl) {
    createApp(ToasterHost).mount(toasterEl);
    showFlashMessages();
}

const confirmModalEl = document.getElementById('confirm-modal');

if (confirmModalEl) {
    createApp(ConfirmModalHost).mount(confirmModalEl);
}

bindConfirmTriggers();

document.querySelectorAll('[data-user-info]').forEach((el) => {
    createApp(UserInfo, {
        model: JSON.parse(el.dataset.model),
        label: el.dataset.label,
    }).mount(el);
});

document.querySelectorAll('[data-vue-answer]').forEach((el) => {
    createApp(Answer, {
        answer: JSON.parse(el.dataset.answer),
        canUpdate: JSON.parse(el.dataset.canUpdate),
        canDelete: JSON.parse(el.dataset.canDelete),
    }).mount(el);
});

document.querySelectorAll('[data-vue-favorite]').forEach((el) => {
    createApp(Favorite, {
        question: JSON.parse(el.dataset.question),
        signedIn: JSON.parse(el.dataset.signedIn),
    }).mount(el);
});
