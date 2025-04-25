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