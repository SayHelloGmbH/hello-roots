!function(){var e={738:function(){window.addEventListener("load",(function(){var e=document.querySelector("body").classList;if(e.contains("wp-admin")&&e.contains("block-editor-page")){var t=document.querySelector("body").getAttribute("class").match(/post-type-([a-z_]+)--([a-z_]+)/),o=document.querySelector(".block-editor-block-list__layout");if(t&&o){var n=t[1],r=t[2];o.classList.add("block-editor-block-list__layout--".concat(n),"".concat(r))}}}))}},t={};function o(n){var r=t[n];if(void 0!==r)return r.exports;var i=t[n]={exports:{}};return e[n](i,i.exports,o),i.exports}o.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return o.d(t,{a:t}),t},o.d=function(e,t){for(var n in t)o.o(t,n)&&!o.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},o.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){"use strict";var e=window.wp.blocks;window.addEventListener("load",(function(){(0,e.unregisterBlockStyle)("core/image","default"),(0,e.unregisterBlockStyle)("core/image","rounded")})),o(738),window.addEventListener("load",(function(){var t=[];(0,e.getBlockTypes)().forEach((function(e){t.push(e.name)})),["core-embed/instagram"].forEach((function(o){t.includes(o)&&(0,e.unregisterBlockType)(o)}))}));var t=window.wp.blockEditor,n=window.wp.serverSideRender,r=o.n(n),i=window.wp.i18n,c=window.wp.element,a=window.wp.primitives,l=(0,c.createElement)(a.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,c.createElement)(a.Path,{d:"M6.08 10.103h2.914L9.657 12h1.417L8.23 4H6.846L4 12h1.417l.663-1.897Zm1.463-4.137.994 2.857h-2l1.006-2.857ZM20 16H4v-1.5h16V16Zm-7 4H4v-1.5h9V20Z"})),s="sht/archive-title-search";(0,e.registerBlockType)(s,{apiVersion:2,title:(0,i._x)("Archive Title (Search)","Block title","sha"),icon:l,category:"sht/blocks",keywords:[(0,i._x)("Bilder","Block keyword","sha"),"image","gallery",(0,i._x)("Impressionen","Block keyword","sha")],supports:{align:["wide","full"],html:!1},edit:function(){var e=(0,t.useBlockProps)();return React.createElement("div",e,React.createElement(r(),{block:s}))},save:function(){return null}})}()}();