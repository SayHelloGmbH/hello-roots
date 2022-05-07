import theme_json from '../../../../../theme.json';
import sht_settings from '../../../../../assets/settings.json';

// Code which still uses jQuery
// If you need to use this, you will need to add jQuery as a
// dependency in the Assets Package. jQuery is not enqueued
// by default

// import 'jquery-easing';
// import './jquery.bez.js';

// jQuery.easing.def = jQuery.bez(sht_settings.easing_bezier);
// jQuery.fx.speeds = {
//     slow: sht_settings.easing_speed_slow,
//     fast: sht_settings.easing_speed_fast,
//     _default: sht_settings.easing_speed,
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

    const found = theme_json.settings.color.palette.find(entry => {
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

export const is_mobile = () => {
    return window.matchMedia(`(max-width: ${sht_settings.breakpoints.tablet - 0.1}px)`).matches;
};
