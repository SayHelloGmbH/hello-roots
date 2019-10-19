import * as settings from '../../../../../assets/settings.json';
import 'jquery-easing';
import './jquery.bez.js';
import verge from 'verge';

jQuery.easing.def = jQuery.bez(settings.easing_bezier);
jQuery.fx.speeds = {
	slow: settings.easing_speed_slow,
	fast: settings.easing_speed_fast,
	_default: settings.easing_speed
};

export const color = (mycolor, tone = 'base') => {
	return settings.theme_colors[mycolor][tone];
};

export const c = (mycolor, tone = 'base') => {
	return color(mycolor, tone);
};

export const is_mobile = () => {
	return (verge.viewportW() <= settings.theme_breakpoints['tablet']);
};

const themeObject = settings;
for(const attrname in ThemeJSVars) {
	themeObject[attrname] = ThemeJSVars[attrname];
}

export const theme = themeObject;