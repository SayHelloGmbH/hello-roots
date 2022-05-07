const checkClass = 'c-body--no-outline';
const body = document.querySelector('body');

body.classList.add(checkClass);

window.addEventListener('keydown', event => {
    if (event.key.toLowerCase() === 'tab') {
        body.classList.remove(checkClass);
    }
});

window.addEventListener('mousemove', () => {
    body.classList.add(checkClass);
});
