const mobilemenu = document.querySelector('#mobile-menu');

if (!!mobilemenu) {
    // Ensure that the mobile menu is hidden by default
    if (!mobilemenu.hasAttribute('aria-hidden')) {
        mobilemenu.setAttribute('aria-hidden', 'true');
    }

    // This rule will be applied to the <html> element when the menu is visible
    // This allows us to e.g. block page scrolling.
    mobilemenu.dataset.rootStyle = 'is--mobilemenu--open';
}
