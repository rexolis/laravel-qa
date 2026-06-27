import Alpine from 'alpinejs';
import { createApp } from 'vue';
import UserInfo from './components/UserInfo.vue';
import Answer from './components/Answer.vue';

window.Alpine = Alpine;
Alpine.start();

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
        deleteUrl: el.dataset.deleteUrl,
    }).mount(el);
});
