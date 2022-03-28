// Load script if element.closest or nodelist.forEach are not supported natively
if (
    (window.Element && !Element.prototype.closest) ||
    (window.NodeList && !NodeList.prototype.forEach)
) {
    let script = document.createElement('script');
    script.setAttribute(
        'src',
        `${sht_theme.directory_uri}/assets/scripts/prototypes.min.js?version=${sht_theme.version}`
    );
    document.head.appendChild(script);
}

// Load script if CSS custom properties are not supported natively
if (!CSS.supports || !CSS.supports('(--foo: bar)')) {
    let script = document.createElement('script');
    script.setAttribute(
        'src',
        `${sht_theme.directory_uri}/assets/scripts/cssvars.min.js?version=${sht_theme.version}`
    );
    document.head.appendChild(script);
}

// Load script if object-fit is not supported natively
if (!CSS.supports || !CSS.supports('object-fit', 'cover')) {
    let script = document.createElement('script');
    script.setAttribute(
        'src',
        `${sht_theme.directory_uri}/assets/scripts/object-fit.min.js?version=${sht_theme.version}`
    );
    document.head.appendChild(script);
}

// Load script if dvh is not supported natively
if (!CSS.supports || !CSS.supports('height', '1dvh')) {
    let script = document.createElement('script');
    script.setAttribute(
        'src',
        `${sht_theme.directory_uri}/assets/scripts/vh.min.js?version=${sht_theme.version}`
    );
    document.head.appendChild(script);
}
