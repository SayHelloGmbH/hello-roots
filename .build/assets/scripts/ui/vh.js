const root_element = document.documentElement;

root_element.style.setProperty('--vh', window.innerHeight / 100 + 'px');

window.addEventListener('resize', () => {
    root_element.style.setProperty('--vh', window.innerHeight / 100 + 'px');
});

window.addEventListener('orientationchange', () => {
    root_element.style.setProperty('--vh', window.innerHeight / 100 + 'px');
});
