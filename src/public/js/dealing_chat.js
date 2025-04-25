document.addEventListener('DOMContentLoaded', () => {

    const modal = document.querySelector('.modal');
    const openBtn = document.getElementById('openReviewModal');
    const body = document.querySelector('body');

    openBtn.addEventListener('click', () => {
        modal.style.display = 'flex';
        body.style.overflow = 'hidden';
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
            body.style.overflow = 'auto';
        }
    });
});

window.addEventListener('DOMContentLoaded', () => {
    const chatBody = document.querySelector('.chat-messages-container');

    requestAnimationFrame(() => {
        chatBody.scrollTop = chatBody.scrollHeight;
    });
});

function toggleEdit(id) {
    const p = document.getElementById(`chat-text-${id}`);
    const form = document.getElementById(`edit-form-${id}`);
    const saveButton = document.getElementById(`save-${id}`);
    const editButton = document.getElementById(`edit-toggle-${id}`);

    p.classList.toggle('hidden');
    form.classList.toggle('hidden');
    saveButton.classList.toggle('hidden');

    editButton.textContent = form.classList.contains('hidden') ? '編集' : 'キャンセル';
}

document.querySelectorAll('textarea.auto-resize').forEach(textarea => {
    textarea.addEventListener('input', () => {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
    });
});

const draftText = document.querySelector('#message');
const container = document.getElementById('chat-container');
const orderId = container.dataset.orderId;
const key = `chat_draft_${orderId}`;

const savedMessage = sessionStorage.getItem(key);
if (savedMessage) {
    draftText.value = savedMessage;
}

draftText.addEventListener('input', () => {
    sessionStorage.setItem(key, draftText.value);
});

const form = document.querySelector('.chat-form');
form.addEventListener('submit', () => {
    sessionStorage.removeItem(key);
});