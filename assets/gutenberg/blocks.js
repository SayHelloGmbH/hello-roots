/*! For license information please see blocks.js.LICENSE.txt */
!function(){var e={738:function(){window.addEventListener("load",(function(){var e=document.querySelector("body").classList;if(e.contains("wp-admin")&&e.contains("block-editor-page")){var t=document.querySelector("body").getAttribute("class").match(/post-type-([a-z_]+)--([a-z_]+)/),r=document.querySelector(".block-editor-block-list__layout");if(t&&r){var n=t[1],o=t[2];r.classList.add("block-editor-block-list__layout--".concat(n),"".concat(o))}}}))},184:function(e,t){var r;!function(){"use strict";var n={}.hasOwnProperty;function o(){for(var e=[],t=0;t<arguments.length;t++){var r=arguments[t];if(r){var a=typeof r;if("string"===a||"number"===a)e.push(r);else if(Array.isArray(r)){if(r.length){var l=o.apply(null,r);l&&e.push(l)}}else if("object"===a)if(r.toString===Object.prototype.toString)for(var c in r)n.call(r,c)&&r[c]&&e.push(c);else e.push(r.toString())}}return e.join(" ")}e.exports?(o.default=o,e.exports=o):void 0===(r=function(){return o}.apply(t,[]))||(e.exports=r)}()}},t={};function r(n){var o=t[n];if(void 0!==o)return o.exports;var a=t[n]={exports:{}};return e[n](a,a.exports,r),a.exports}r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,{a:t}),t},r.d=function(e,t){for(var n in t)r.o(t,n)&&!r.o(e,n)&&Object.defineProperty(e,n,{enumerable:!0,get:t[n]})},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){"use strict";var e=window.wp.i18n,t=window.wp.hooks,n=window.wp.element,o=window.wp.compose,a=window.wp.components,l=window.wp.blockEditor,c=r(184),i=r.n(c),s=["core/group","sht/menu-toggler"];(0,t.addFilter)("blocks.registerBlockType","sht/custom-attributes",(function(e){return s.includes(e.name)?lodash.assign({},e,{attributes:lodash.assign({},e.attributes,{hiddenForMobile:{type:"boolean",default:!1},hiddenForTablet:{type:"boolean",default:!1},hiddenForDesktop:{type:"boolean",default:!1}})}):e})),(0,t.addFilter)("editor.BlockEdit","sht/custom-advanced-control",(0,o.createHigherOrderComponent)((function(t){return function(r){var o=r.name,c=r.attributes,i=r.setAttributes,d=r.isSelected,u=c.hiddenForMobile,f=c.hiddenForTablet,h=c.hiddenForDesktop;return d&&s.includes(o)?React.createElement(n.Fragment,null,React.createElement(t,r),React.createElement(l.InspectorControls,null,React.createElement(a.PanelBody,{title:(0,e.__)("Sichtbarkeit","sht"),initialOpen:!0},React.createElement(a.ToggleControl,{label:(0,e.__)("Auf Mobilgeräte verstecken"),checked:!!u,onChange:function(){return i({hiddenForMobile:!u})},help:u?(0,e.__)("Dieser Block ist versteckt auf Mobilgeräte.","sha"):""}),React.createElement(a.ToggleControl,{label:(0,e.__)("Auf Tabletts verstecken"),checked:!!f,onChange:function(){return i({hiddenForTablet:!f})},help:f?(0,e.__)("Dieser Block ist versteckt auf Tabletts.","sha"):""}),React.createElement(a.ToggleControl,{label:(0,e.__)("Auf Desktopcomputer verstecken"),checked:!!h,onChange:function(){return i({hiddenForDesktop:!h})},help:h?(0,e.__)("Dieser Block ist versteckt auf Desktopcomputer.","sha"):""})))):React.createElement(t,r)}}))),(0,t.addFilter)("blocks.getSaveContent.extraProps","sht/applyExtraClass",(function(e,t,r){var n=r.hiddenForMobile,o=r.hiddenForTablet,a=r.hiddenForDesktop;return s.includes(t.name)?(n&&(e.className=i()(e.className,"is-hidden-for--mobile")),o&&(e.className=i()(e.className,"is-hidden-for--tablet")),a&&(e.className=i()(e.className,"is-hidden-for--desktop")),e):e}));var d=window.wp.blocks;window.addEventListener("load",(function(){(0,d.unregisterBlockStyle)("core/image","default"),(0,d.unregisterBlockStyle)("core/image","rounded")}));var u=React.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24"},React.createElement("circle",{cx:"12",cy:"12",r:"12"}),React.createElement("g",{id:"say"},React.createElement("path",{d:"M5.2,5.89a1.19,1.19,0,0,1,1,.48l-.39.37a.81.81,0,0,0-.7-.33c-.26,0-.43.09-.43.26s.21.24.62.33.9.24.9.82-.44.84-1.08.84A1.28,1.28,0,0,1,4,8.12l.39-.37a.91.91,0,0,0,.82.39c.27,0,.46-.08.46-.28s-.19-.26-.59-.34-.94-.24-.94-.82S4.54,5.89,5.2,5.89Z",transform:"translate(0 0)",fill:"#fff"}),React.createElement("path",{d:"M7.93,5.89c.75,0,1.11.35,1.11,1V8.6H8.47V8.23a1,1,0,0,1-.85.42.81.81,0,0,1-.89-.82A.83.83,0,0,1,7.58,7l.73-.08c.11,0,.16,0,.16-.12v0c0-.21-.18-.35-.52-.35s-.6.11-.68.4L6.8,6.52A1.07,1.07,0,0,1,7.93,5.89Zm.54,1.48-.77.1c-.26,0-.38.17-.38.34s.16.34.44.34h0a.67.67,0,0,0,.67-.62Z",transform:"translate(0 0)",fill:"#fff"}),React.createElement("path",{d:"M9.82,9.65l.65-1.42L9.34,6H10l.77,1.62L11.52,6h.61l-1.7,3.7Z",transform:"translate(0 0)",fill:"#fff"})),React.createElement("g",{id:"spickel"},React.createElement("path",{d:"M19.36,17v-.57a2,2,0,0,0,2-2h.58A2.56,2.56,0,0,1,19.36,17Z",transform:"translate(0 0)",fill:"#fff"})),React.createElement("path",{id:"hello",d:"M20.37,7.8a1.66,1.66,0,0,1-.14,1.9.9.9,0,0,1-1.17.2.65.65,0,0,1-.19-1,.77.77,0,0,1,1.26,0,1.47,1.47,0,0,1,.26,1.76,2.22,2.22,0,0,1-2.11,1.14,3,3,0,0,1-2.35-1.34c-.21-.3-.48-1-.06-1.24s.8.14,1,.51a12.23,12.23,0,0,1,.5,2.34,1.78,1.78,0,0,1-.8,2c-.86.44-1.73-.9-1.73-.9a5.73,5.73,0,0,1-1.22-3c.05-1.37.81-1,1-.52a4,4,0,0,1,.06,2,21.4,21.4,0,0,1-.73,2.55,1.62,1.62,0,0,1-1.33,1.2c-.6,0-1-.63-1.17-.95a1.07,1.07,0,0,1,.05-1.05c.13-.2.49-.55.85-.24s.18.81.12,1.11a6.55,6.55,0,0,1-.52,1.37c-.29.58-.43.77-.74.81s-.57-.46-.61-.52-.5-1-.5-1c-.22-.38-.54-.75-.84-.75a.72.72,0,0,0-.65.43,8.59,8.59,0,0,0-.47,1.39c-.1.41-.25,1.8-.25,1.8s0,0,0,0,0,0,0,0l-.45-2.1c-.06-.23-.48-2.27-.48-2.27a8.29,8.29,0,0,1-.18-1.85c.08-.56.48-.63.5-.63s.55-.07.55.64a6.51,6.51,0,0,1-.66,2.05A24.41,24.41,0,0,1,4.28,18",transform:"translate(0 0)",fill:"none",stroke:"#fff","stroke-miterlimit":"10","stroke-width":"0.5"}));(0,d.registerBlockCollection)("sht",{title:"Say Hello Theme",icon:u}),r(738),window.addEventListener("load",(function(){var e=[];(0,d.getBlockTypes)().forEach((function(t){e.push(t.name)})),["core-embed/instagram"].forEach((function(t){e.includes(t)&&(0,d.unregisterBlockType)(t)}))}));var f=window.wp.serverSideRender,h=r.n(f),p=window.wp.primitives,m=(0,n.createElement)(p.SVG,{viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},(0,n.createElement)(p.Path,{d:"M6.08 10.103h2.914L9.657 12h1.417L8.23 4H6.846L4 12h1.417l.663-1.897Zm1.463-4.137.994 2.857h-2l1.006-2.857ZM20 16H4v-1.5h16V16Zm-7 4H4v-1.5h9V20Z"})),k="sht/archive-title-search";(0,d.registerBlockType)(k,{apiVersion:2,title:(0,e._x)("Archive Title (Search)","Block title","sha"),icon:m,category:"sht/blocks",keywords:[(0,e._x)("Bilder","Block keyword","sha"),"image","gallery",(0,e._x)("Impressionen","Block keyword","sha")],supports:{align:["wide","full"],html:!1},edit:function(){var e=(0,l.useBlockProps)();return React.createElement("div",e,React.createElement(h(),{block:k}))},save:function(){return null}})}()}();