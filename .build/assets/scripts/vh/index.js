/**
 * CSS custom properties like --vh are set on the :root and on
 * the BODY element, in order to comply with current WordPress
 * core CSS. This script ensures that the values are set dynamically
 * on both elements, for maximum compatibility.
 *
 * We check for the new unit dvh (dynamic viewport height) since
 * March 2022, as this new unit automatically adjusts to the inner
 * browser viewport height, making this script unnecessary.
 *
 * mark@sayhello.ch 15.3.2022
 *
 */

if (!CSS.supports || !CSS.supports('height', '1dvh')) {
    const setVh = () => {
        document.documentElement.style.setProperty('--vh', `${window.innerHeight / 100}px`);
        document.body.style.setProperty('--vh', `${window.innerHeight / 100}px`);
    };

    setVh();

    window.addEventListener('load', setVh);
    window.addEventListener('resize', setVh);
    window.addEventListener('orientationchange', setVh);
}
