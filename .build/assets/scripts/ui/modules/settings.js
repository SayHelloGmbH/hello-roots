import theme_json from '../../../../../theme.json';
const settings = theme_json.settings;

// import 'jquery-easing';
// import './jquery.bez.js';

// jQuery.easing.def = jQuery.bez(settings.easing_bezier);
// jQuery.fx.speeds = {
//     slow: settings.easing_speed_slow,
//     fast: settings.easing_speed_fast,
//     _default: settings.easing_speed,
// };

/**
 * Usage: console.log(color('primary));
 * Usage: console.log(color('primary', 'dark'));
 *
 * @param {string} mycolor Base slug of the required color
 * @param {string} tone Alternative sub-tone of the required color
 * @returns string | null
 */
export const color = (mycolor, tone = 'base') => {
    if (tone !== '' && tone !== 'base') {
        mycolor = `${mycolor}-${tone}`;
    }

    const found = settings.color.palette.find(entry => {
        return entry.slug === mycolor;
    });

    return !!found ? found.color : false;
};

/**
 * Alias of color()
 */
export const c = (mycolor, tone = 'base') => {
    return color(mycolor, tone);
};

// export const is_mobile = () => {
//     return window.matchMedia(`(min-width: ${settings.custom.breakpoint.tablet}px)`).matches;
// };
