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

const stars = document.querySelectorAll('.stars span');
const ratingInput = document.getElementById('ratingInput');

stars.forEach((star, index) => {
    star.addEventListener('click', () => {
        const value = index + 1;
        ratingInput.value = value;

        stars.forEach((s, i) => {
            s.classList.toggle('active', i < value);
        });
    });
});