function loadFont(fontName, woffUrl, woff2Url) {
    function supportsWoff2() {
        if (!('FontFace' in window)) {
            return false;
        }

        var f = new FontFace(
            't',
            'url( "data:font/woff2;base64,d09GMgABAAAAAADwAAoAAAAAAiQAAACoAAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAABmAALAogOAE2AiQDBgsGAAQgBSAHIBuDAciO1EZ3I/mL5/+5/rfPnTt9/9Qa8H4cUUZxaRbh36LiKJoVh61XGzw6ufkpoeZBW4KphwFYIJGHB4LAY4hby++gW+6N1EN94I49v86yCpUdYgqeZrOWN34CMQg2tAmthdli0eePIwAKNIIRS4AGZFzdX9lbBUAQlm//f262/61o8PlYO/D1/X4FrWFFgdCQD9DpGJSxmFyjOAGUU4P0qigcNb82GAAA" ) format( "woff2" )',
            {}
        );
        f.load()['catch'](function () {});

        return f.status.toLowerCase() === 'loading' || f.status.toLowerCase() === 'loaded';
    }

    var nua = navigator.userAgent;

    var noSupport =
        !window.addEventListener ||
        (nua.match(/(Android (2|3|4.0|4.1|4.2|4.3))|(Opera (Mini|Mobi))/) && !nua.match(/Chrome/));
    if (noSupport) {
        return;
    }

    var loSto = {};
    try {
        loSto = localStorage || {};
    } catch (ex) {}

    var localStoragePrefix = fontName;
    var localStorageUrlKey = localStoragePrefix + 'url';
    var localStorageCssKey = localStoragePrefix + 'css';
    var storedFontUrl = loSto[localStorageUrlKey];
    var storedFontCss = loSto[localStorageCssKey];

    var styleElement = document.createElement('style');
    styleElement.rel = 'stylesheet';
    document.head.appendChild(styleElement);

    if (storedFontCss && (storedFontUrl === woffUrl || storedFontUrl === woff2Url)) {
        styleElement.textContent = storedFontCss;
    } else {
        var url = woff2Url && supportsWoff2() ? woff2Url : woffUrl;
        var request = new XMLHttpRequest();
        request.open('GET', url);
        request.onload = function () {
            if (request.status >= 200 && request.status < 400) {
                loSto[localStorageUrlKey] = url;
                loSto[localStorageCssKey] = styleElement.textContent = request.responseText;
            }
        };
        request.send();
    }
}
