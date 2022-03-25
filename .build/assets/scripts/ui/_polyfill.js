if (window.NodeList && !NodeList.prototype.forEach) {
    NodeList.prototype.forEach = function (callback, thisArg) {
        var i;
        var len = this.length;

        thisArg = thisArg || window;

        for (i = 0; i < len; i++) {
            callback.call(thisArg, this[i], i, this);
        }
    };
}

if (window.Element && !Element.prototype.closest) {
    Element.prototype.closest = function (s) {
        var matches = (this.document || this.ownerDocument).querySelectorAll(s),
            i,
            el = this;
        do {
            i = matches.length;
            while (--i >= 0 && matches.item(i) !== el) {}
        } while (i < 0 && (el = el.parentElement));
        return el;
    };
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
