/**
 * CSS custom properties like --vh are set on the :root and on
 * the BODY element, in order to comply with current WordPress
 * core CSS. This script ensures that the values are set dynamically
 * on both elements, for maximum compatibility.
 *
 * mark@sayhello.ch 9.2.2022
 *
 */

const setVh = () => {
    document.documentElement.style.setProperty('--vh', `${window.innerHeight / 100}px`);
    document.body.style.setProperty('--vh', `${window.innerHeight / 100}px`);
};

setVh();

window.addEventListener('load', setVh);
window.addEventListener('resize', setVh);
window.addEventListener('orientationchange', setVh);
