!function(e){var t={};function n(r){if(t[r])return t[r].exports;var a=t[r]={i:r,l:!1,exports:{}};return e[r].call(a.exports,a,a.exports,n),a.l=!0,a.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var a in e)n.d(r,a,function(t){return e[t]}.bind(null,a));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=13)}([function(e,t){!function(){e.exports=this.wp.i18n}()},function(e,t){!function(){e.exports=this.wp.components}()},function(e,t,n){var r;
/*!
  Copyright (c) 2017 Jed Watson.
  Licensed under the MIT License (MIT), see
  http://jedwatson.github.io/classnames
*/!function(){"use strict";var n={}.hasOwnProperty;function a(){for(var e=[],t=0;t<arguments.length;t++){var r=arguments[t];if(r){var l=typeof r;if("string"===l||"number"===l)e.push(r);else if(Array.isArray(r)&&r.length){var i=a.apply(null,r);i&&e.push(i)}else if("object"===l)for(var o in r)n.call(r,o)&&r[o]&&e.push(o)}}return e.join(" ")}e.exports?(a.default=a,e.exports=a):void 0===(r=function(){return a}.apply(t,[]))||(e.exports=r)}()},function(e,t){!function(){e.exports=this.wp.hooks}()},function(e,t){!function(){e.exports=this.wp.blockEditor}()},function(e,t){!function(){e.exports=this.wp.compose}()},function(e,t){!function(){e.exports=this.wp.blocks}()},function(e,t){var n=/^(?:0|[1-9]\d*)$/;function r(e,t,n){switch(n.length){case 0:return e.call(t);case 1:return e.call(t,n[0]);case 2:return e.call(t,n[0],n[1]);case 3:return e.call(t,n[0],n[1],n[2])}return e.apply(t,n)}var a,l,i=Object.prototype,o=i.hasOwnProperty,c=i.toString,s=i.propertyIsEnumerable,u=(a=Object.keys,l=Object,function(e){return a(l(e))}),b=Math.max,f=!s.call({valueOf:1},"valueOf");function d(e,t){var n=g(e)||function(e){return function(e){return function(e){return!!e&&"object"==typeof e}(e)&&_(e)}(e)&&o.call(e,"callee")&&(!s.call(e,"callee")||"[object Arguments]"==c.call(e))}(e)?function(e,t){for(var n=-1,r=Array(e);++n<e;)r[n]=t(n);return r}(e.length,String):[],r=n.length,a=!!r;for(var l in e)!t&&!o.call(e,l)||a&&("length"==l||h(l,r))||n.push(l);return n}function p(e,t,n){var r=e[t];o.call(e,t)&&v(r,n)&&(void 0!==n||t in e)||(e[t]=n)}function h(e,t){return!!(t=null==t?9007199254740991:t)&&("number"==typeof e||n.test(e))&&e>-1&&e%1==0&&e<t}function m(e){var t=e&&e.constructor;return e===("function"==typeof t&&t.prototype||i)}function v(e,t){return e===t||e!=e&&t!=t}var g=Array.isArray;function _(e){return null!=e&&function(e){return"number"==typeof e&&e>-1&&e%1==0&&e<=9007199254740991}(e.length)&&!function(e){var t=O(e)?c.call(e):"";return"[object Function]"==t||"[object GeneratorFunction]"==t}(e)}function O(e){var t=typeof e;return!!e&&("object"==t||"function"==t)}var j,y=(j=function(e,t){if(f||m(t)||_(t))!function(e,t,n,r){n||(n={});for(var a=-1,l=t.length;++a<l;){var i=t[a],o=r?r(n[i],e[i],i,n,e):void 0;p(n,i,void 0===o?e[i]:o)}}(t,function(e){return _(e)?d(e):function(e){if(!m(e))return u(e);var t=[];for(var n in Object(e))o.call(e,n)&&"constructor"!=n&&t.push(n);return t}(e)}(t),e);else for(var n in t)o.call(t,n)&&p(e,n,t[n])},function(e,t){return t=b(void 0===t?e.length-1:t,0),function(){for(var n=arguments,a=-1,l=b(n.length-t,0),i=Array(l);++a<l;)i[a]=n[t+a];a=-1;for(var o=Array(t+1);++a<t;)o[a]=n[a];return o[t]=i,r(e,this,o)}}((function(e,t){var n=-1,r=t.length,a=r>1?t[r-1]:void 0,l=r>2?t[2]:void 0;for(a=j.length>3&&"function"==typeof a?(r--,a):void 0,l&&function(e,t,n){if(!O(n))return!1;var r=typeof t;return!!("number"==r?_(n)&&h(t,n.length):"string"==r&&t in n)&&v(n[t],e)}(t[0],t[1],l)&&(a=r<3?void 0:a,r=1),e=Object(e);++n<r;){var i=t[n];i&&j(e,i,n,a)}return e})));e.exports=y},function(e,t){!function(){e.exports=this.wp.element}()},function(e,t){!function(){e.exports=this.wp.domReady}()},function(e,t){!function(){e.exports=this.wp.data}()},function(e,t){!function(){e.exports=this.wp.editPost}()},function(e,t){!function(){e.exports=this.wp.plugins}()},function(e,t,n){"use strict";n.r(t);var r=n(9),a=n.n(r),l=n(7),i=n.n(l),o=n(2),c=n.n(o),s=n(3),u=n(0),b=n(5),f=n(8),d=n(4),p=n(1);var h=function(){return React.createElement("svg",{width:"24",height:"24",viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg","fill-rule":"evenodd","clip-rule":"evenodd","stroke-linecap":"round","stroke-linejoin":"round","stroke-miterlimit":"1.5"},React.createElement("path",{"stroke-width":"2",d:"M4.393 5.966h15.603v12.476H4.393z",transform:"matrix(.89724 0 0 .80153 1.05873 2.21781)"}),React.createElement("path",{d:"M9.171465 4.99992275l2.82835582-2.82835581 2.828409 2.828409-2.82815786-.0079592-2.82860695.007906zM14.828535 19.00008515l-2.82835582 2.82835581-2.828409-2.828409 2.82815786.0079592 2.82860695-.007906z"}))},m={"core/heading":"standard","core/paragraph":"small"},v=[{label:Object(u.__)("0","sht"),title:Object(u.__)("Kein Abstand","sht"),value:"none"},{label:Object(u.__)("S","sht"),title:Object(u.__)("Klein","sht"),value:"small"},{label:Object(u.__)("R","sht"),title:Object(u.__)("Normal","sht"),value:"standard"},{label:Object(u.__)("M","sht"),title:Object(u.__)("Mittelgross","sht"),value:"medium"},{label:Object(u.__)("L","sht"),title:Object(u.__)("Gross","sht"),value:"large"},{label:Object(u.__)("XL","sht"),title:Object(u.__)("Extragross","sht"),value:"xlarge"}],g=Object(b.createHigherOrderComponent)((function(e){return function(t){var n=t.attributes.shtMargin;if(t.attributes.className){var r=t.attributes.className.trim().split(" ");Object.keys(v).map((function(e){r=r.filter((function(t,n,r){return t!=="has-block-margin--"+v[e].value}))})),t.attributes.className=c()(r)}var a=[];return Object.keys(v).map((function(e){a.push(function(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}({},"has-block-margin--"+v[e].value,v[e].value===n))})),m[t.name]!==n&&(t.attributes.className=c()(t.attributes.className,a)),React.createElement(f.Fragment,null,React.createElement(d.BlockControls,null,React.createElement(_,{value:n,onChange:function(e){t.setAttributes({shtMargin:e})}})),React.createElement(e,t),React.createElement(d.InspectorControls,null,React.createElement(p.PanelBody,{title:Object(u.__)("Aussenabstände","sht"),initialOpen:!1},React.createElement("div",{className:"components-base-control"},React.createElement("label",{class:"components-base-control__label"},Object(u.__)("Vertikaler Abstand ändern","sht")),React.createElement(p.ButtonGroup,null,Object.keys(v).map((function(e){return React.createElement(p.Tooltip,{text:v[e].title},React.createElement(p.Button,{isSecondary:v[e].value!==n,isPrimary:v[e].value===n,onClick:function(){t.setAttributes({shtMargin:v[e].value})}},v[e].label))})))))))}}),"addMarginControl"),_=function(e){var t=e.value,n=e.onChange;return React.createElement(p.Toolbar,{isCollapsed:!0,icon:h,label:Object(u.__)("Vertikaler Abstand ändern","sht"),popoverProps:{position:"bottom right",isAlternate:!0},controls:v.map((function(e){return{title:e.title,icon:h,size:e.value,isActive:t===e.value,role:"menuitemradio",onClick:(r=e.value,function(){return n(t===r?void 0:r)})};var r}))})};Object(s.addFilter)("blocks.registerBlockType","sht/attribute/block-margin",(function(e,t){var n="standard";return t in m&&(n=m[t]),e.attributes=i()(e.attributes,{shtMargin:{type:"string",default:n}}),e})),Object(s.addFilter)("editor.BlockEdit","sht/control/block-margin",g);var O=function(){return React.createElement("svg",{"aria-hidden":"true",role:"img",focusable:"false",xmlns:"http://www.w3.org/2000/svg",width:"24",height:"24",viewBox:"0 0 24 24"},React.createElement("g",{fill:"none","fill-rule":"evenodd"},React.createElement("path",{d:"M18 2H6C4.89 2 4 2.9 4 4V20C4 21.11 4.89 22 6 22H18C19.11 22 20 21.11 20 20V4C20 2.9 19.11 2 18 2M18 20H6V16H18V20M18 8H6V4H18V8Z",fill:"currentColor","fill-rule":"nonzero"})))},j={"core/group":"standard","core/cover":"standard"},y=[{label:Object(u.__)("0","sht"),title:Object(u.__)("Kein Innenabstand","sht"),value:"none"},{label:Object(u.__)("S","sht"),title:Object(u.__)("Klein","sht"),value:"small"},{label:Object(u.__)("R","sht"),title:Object(u.__)("Normal","sht"),value:"standard"},{label:Object(u.__)("M","sht"),title:Object(u.__)("Mittelgross","sht"),value:"medium"},{label:Object(u.__)("L","sht"),title:Object(u.__)("Gross","sht"),value:"large"},{label:Object(u.__)("XL","sht"),title:Object(u.__)("Extragross","sht"),value:"xlarge"}],E=Object(b.createHigherOrderComponent)((function(e){return function(t){if(!(t.name in j))return React.createElement(e,t);var n=t.attributes.shtPadding;if(t.attributes.className){var r=t.attributes.className.trim().split(" ");Object.keys(y).map((function(e){r=r.filter((function(t,n,r){return t!=="has-block-vertical-padding--"+y[e].value}))})),t.attributes.className=c()(r)}var a=[];return Object.keys(y).map((function(e){a.push(function(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}({},"has-block-vertical-padding has-block-vertical-padding--"+y[e].value,y[e].value===n))})),j[t.name]!==n&&(t.attributes.className=c()(t.attributes.className,a)),React.createElement(f.Fragment,null,React.createElement(d.BlockControls,null,React.createElement(k,{value:n,onChange:function(e){t.setAttributes({shtPadding:e})}})),React.createElement(e,t),React.createElement(d.InspectorControls,null,React.createElement(p.PanelBody,{title:Object(u.__)("Innenabstände","sht"),initialOpen:!1},React.createElement("div",{className:"components-base-control"},React.createElement("label",{class:"components-base-control__label"},Object(u.__)("Vertikaler Innenabstand ändern","sht")),React.createElement(p.ButtonGroup,null,Object.keys(y).map((function(e){return React.createElement(p.Button,{isSecondary:y[e].value!==n,isPrimary:y[e].value===n,onClick:function(){t.setAttributes({shtPadding:y[e].value})}},y[e].label)})))))))}}),"addPaddingControl"),k=function(e){var t=e.value,n=e.onChange;return React.createElement(p.Toolbar,{isCollapsed:!0,icon:O,label:Object(u.__)("Vertikaler Innenabstand ändern","sht"),popoverProps:{position:"bottom right",isAlternate:!0},controls:y.map((function(e){return{title:e.title,icon:O,size:e.value,isActive:t===e.value,role:"menuitemradio",onClick:(r=e.value,function(){return n(t===r?void 0:r)})};var r}))})};Object(s.addFilter)("blocks.registerBlockType","sht/attribute/block-padding",(function(e,t){var n="standard";return t in j&&(n=j[t]),e.attributes=i()(e.attributes,{shtPadding:{type:"string",default:n}}),e})),Object(s.addFilter)("editor.BlockEdit","sht/control/block-padding",E);var R=function(){return React.createElement("svg",{"aria-hidden":"true",role:"img",focusable:"false",xmlns:"http://www.w3.org/2000/svg",width:"24",height:"24",viewBox:"0 0 24 24"},React.createElement("g",{fill:"none","fill-rule":"evenodd"},React.createElement("path",{d:"M18.5,5.37867966 L20.6213203,7.5 L19.9142136,8.20710678 L18.9996406,7.29267966 L18.9996406,16.3276797 L19.9142139,15.4142136 L20.6213207,16.1213203 L18.5000003,18.2426407 L16.37868,16.1213203 L17.0857868,15.4142136 L17.9996406,16.3276797 L17.9996406,7.29267966 L17.0857864,8.20710678 L16.3786797,7.5 L18.5,5.37867966 Z M10.6865234,5.76464844 L15.0195312,18 L12.2470703,18 L11.4584961,15.4848633 L6.95117188,15.4848633 L6.10449219,18 L3.43164062,18 L7.79785156,5.76464844 L10.6865234,5.76464844 Z M9.21728516,8.56201172 L7.64013672,13.3764648 L10.7446289,13.3764648 L9.21728516,8.56201172 Z",fill:"currentColor","fill-rule":"nonzero"})))},w={"core/heading":"regular","core/paragraph":"regular"},x=[{label:Object(u.__)("S","sht"),title:Object(u.__)("Klein","sht"),value:"small"},{label:Object(u.__)("R","sht"),title:Object(u.__)("Normal","sht"),value:"regular"},{label:Object(u.__)("M","sht"),title:Object(u.__)("Mittelgross","sht"),value:"medium"},{label:Object(u.__)("L","sht"),title:Object(u.__)("Gross","sht"),value:"large"},{label:Object(u.__)("XL","sht"),title:Object(u.__)("Extra gross","sht"),value:"xlarge"}],C=Object(b.createHigherOrderComponent)((function(e){return function(t){if(!(t.name in w))return React.createElement(e,t);var n=t.attributes.shtFontSize;if(t.attributes.className){var r=t.attributes.className.trim().split(" ");Object.keys(x).map((function(e){r=r.filter((function(t,n,r){return t!=="has-font-size-"+x[e].value}))})),t.attributes.className=c()(r)}var a=[];return Object.keys(x).map((function(e){a.push(function(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}({},"has-font-size-"+x[e].value,x[e].value===n))})),w[t.name]!==n&&(t.attributes.className=c()(t.attributes.className,a)),React.createElement(f.Fragment,null,React.createElement(d.BlockControls,null,React.createElement(P,{value:n,onChange:function(e){t.setAttributes({shtFontSize:e})}})),React.createElement(e,t),React.createElement(d.InspectorControls,null,React.createElement(p.PanelBody,{title:Object(u.__)("Schriftgrösse ändern","sht"),initialOpen:!1},React.createElement("div",{className:"components-base-control"},React.createElement("label",{class:"components-base-control__label"},Object(u.__)("Schriftgrösse ändern","sht")),React.createElement(p.ButtonGroup,null,Object.keys(x).map((function(e){return React.createElement(p.Button,{isSecondary:x[e].value!==n,isPrimary:x[e].value===n,isPressed:x[e].value===n,onClick:function(){t.setAttributes({shtFontSize:x[e].value})}},x[e].label)})))))))}}),"addFontSizeControl"),P=function(e){var t=e.value,n=e.onChange;return React.createElement(p.Toolbar,{isCollapsed:!0,icon:R,label:Object(u.__)("Schriftgrösse ändern","sht"),popoverProps:{position:"bottom right",isAlternate:!0},controls:x.map((function(e){return{title:e.title,icon:R,size:e.value,isActive:t===e.value,role:"menuitemradio",onClick:(r=e.value,function(){return n(t===r?void 0:r)})};var r}))})};Object(s.addFilter)("blocks.registerBlockType","sht/attribute/font-size",(function(e,t){return t in w?(e.attributes=i()(e.attributes,{shtFontSize:{type:"string",default:w[t]}}),e):e})),Object(s.addFilter)("editor.BlockEdit","sht/control/font-size",C);var L=n(6);a()((function(){Object(L.registerBlockStyle)("core/cover",{name:"aspect-21",label:"2:1"}),Object(L.registerBlockStyle)("core/cover",{name:"aspect-31",label:"3:1"}),Object(L.registerBlockStyle)("core/cover",{name:"aspect-41",label:"4:1"}),Object(L.registerBlockStyle)("core/cover",{name:"aspect-169",label:"16:9"}),Object(L.registerBlockStyle)("core/cover",{name:"full-height",label:"Full height"})}));var S=n(11),B=n(10),A=n(12),M=["page","post"],N=Object(b.compose)([Object(B.withSelect)((function(e){return{hide_title:e("core/editor").getEditedPostAttribute("meta").hide_title,post_type:e("core/editor").getCurrentPostType()}})),Object(B.withDispatch)((function(e){return{onUpdateHideTitle:function(t){e("core/editor").editPost({meta:{hide_title:t}})}}}))])((function(e){var t,n=e.hide_title,r=e.post_type,a=e.onUpdateHideTitle;return t=r,M.includes(t)?React.createElement(S.PluginDocumentSettingPanel,{title:Object(u._x)("Sichtbarkeit Inhalt","Editor sidebar panel title","sht"),initialOpen:!0,icon:"invalid-name-no-icon"},React.createElement(p.ToggleControl,{label:Object(u._x)("Beitragstitel verstecken","ToggleControl label","sha"),help:n?Object(u._x)("Der Beitragstitel ist auf der öffentlichen Ansicht ausgeblendet. Es für die Suchmaschinenoptimierung ratsam, eine Überschrift mit der Ebene H1 in den Inhalt einzufügen.","Warning text","sha"):"",checked:n,onChange:function(e){return a(e)}})):null}));Object(A.registerPlugin)("sht-page-controls",{render:N}),window.onload=function(){Object(L.unregisterBlockType)("core/media-text")}}]);