!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=9)}([function(e,t){!function(){e.exports=this.wp.blocks}()},function(e,t){!function(){e.exports=this.wp.i18n}()},function(e,t){!function(){e.exports=this.wp.blockEditor}()},function(e,t){!function(){e.exports=this.wp.element}()},function(e,t){!function(){e.exports=this.wp.components}()},function(e,t){!function(){e.exports=this.wp.domReady}()},function(e,t){},function(e,t){window.addEventListener("load",(function(){var e=document.querySelector("body").classList;if(e.contains("wp-admin")&&e.contains("block-editor-page")){var t=document.querySelector("body").getAttribute("class").match(/post-type-([a-z_]+)--([a-z_]+)/);if(t){var n=t[1],r=t[2];document.querySelector(".block-editor-block-list__layout").classList.add("block-editor-block-list__layout--"+n),document.querySelector(".block-editor-block-list__layout").classList.add("block-editor-block-list__layout--"+n+"-"+r)}}}))},function(e,t){},function(e,t,n){"use strict";n.r(t);n(6);var r=n(5),o=n.n(r),a=n(0);o()((function(){Object(a.registerBlockStyle)("core/heading",{name:"small-text",label:"Klein"}),Object(a.registerBlockStyle)("core/heading",{name:"large-text",label:"Gross"}),Object(a.registerBlockStyle)("core/heading",{name:"xlarge-text",label:"Extra-gross"})}));n(7),n(8);window.addEventListener("load",(function(){var e=[];Object(a.getBlockTypes)().forEach((function(t){e.push(t.name)})),["core-embed/instagram"].forEach((function(t){e.includes(t)&&Object(a.unregisterBlockType)(t)}))}));var i=n(2),c=n(3),l=n(1),s=React.createElement("svg",{xmlns:"http://www.w3.org/2000/svg",width:"24",height:"24",viewBox:"0 0 24 24"},React.createElement("path",{d:"M134.26,294.4v-5.426A18.6,18.6,0,0,0,152.834,270.4h5.426A24.025,24.025,0,0,1,134.26,294.4Z",transform:"translate(-134.26 -270.4)"})),u=n(4);function p(e){return(p="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function f(){return(f=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var n=arguments[t];for(var r in n)Object.prototype.hasOwnProperty.call(n,r)&&(e[r]=n[r])}return e}).apply(this,arguments)}function m(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function b(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}function d(e,t){return(d=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function y(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}();return function(){var n,r=h(e);if(t){var o=h(this).constructor;n=Reflect.construct(r,arguments,o)}else n=r.apply(this,arguments);return g(this,n)}}function g(e,t){return!t||"object"!==p(t)&&"function"!=typeof t?function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e):t}function h(e){return(h=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}function _(e,t,n,r,o,a,i){try{var c=e[a](i),l=c.value}catch(e){return void n(e)}c.done?t(l):Promise.resolve(l).then(r,o)}var v=function(){var e,t=(e=regeneratorRuntime.mark((function e(t){var n,r=arguments;return regeneratorRuntime.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return n=r.length>1&&void 0!==r[1]?r[1]:"full",e.abrupt("return",new Promise((function(e,r){wp.apiFetch({path:"/hello-roots/v1/lazy-image/".concat(t,"/?size=").concat(n)}).then((function(t){e(t)})).catch((function(e){console.log("reject",e),r(e)}))})));case 2:case"end":return e.stop()}}),e)})),function(){var t=this,n=arguments;return new Promise((function(r,o){var a=e.apply(t,n);function i(e){_(a,r,o,i,c,"next",e)}function c(e){_(a,r,o,i,c,"throw",e)}i(void 0)}))});return function(e){return t.apply(this,arguments)}}(),R=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&d(e,t)}(a,e);var t,n,r,o=y(a);function a(e){var t;return m(this,a),(t=o.apply(this,arguments)).props=e,t}return t=a,(n=[{key:"render",value:function(){if(void 0===this.props.image)return React.createElement("p",null,"Kein Bild gefunden");var e=this.props.image,t=[];Object.keys(e.srcset).forEach((function(n){t.push("".concat(e.srcset[n]," ").concat(n,"w"))})),t=t.reverse().join(", ");var n="o-lazyimage";!0===this.props.background&&(n+=" o-lazyimage--background"),e.svg&&(n+=" o-lazyimage--svg"),this.props.className&&(n+=" "+this.props.className);var r={},o={};return this.props.objectFocalPoint&&(r.objectPosition="".concat(100*this.props.objectFocalPoint.x,"% ").concat(100*this.props.objectFocalPoint.y,"%"),o.objectPosition="".concat(100*this.props.objectFocalPoint.x,"% ").concat(100*this.props.objectFocalPoint.y,"%")),!0===this.props.background?(r.backgroundImage="url('${image.org[0]}')",o.backgroundImage="url('${image.pre}')",this.props.focalPoint&&(r.backgroundPosition="".concat(100*this.props.focalPoint.x,"% ").concat(100*this.props.focalPoint.y,"%"),o.backgroundPosition="".concat(100*this.props.focalPoint.x,"% ").concat(100*this.props.focalPoint.y,"%")),this.props.admin?React.createElement("figure",{className:n},React.createElement("div",f({},e.attributes,{className:"o-lazyimage__image o-lazyimage__image--lazyloaded",style:r}))):React.createElement("figure",{className:n},!e.svg&&React.createElement("div",{className:"o-lazyimage__preview",style:o}),React.createElement("div",f({},e.attributes,{className:"o-lazyimage__image o-lazyimage__image--lazyload",style:r,"data-bgset":t})),React.createElement("noscript",null,React.createElement("div",f({},e.attributes,{className:"o-lazyimage__image",style:r}))))):this.props.admin?React.createElement("figure",{className:n,style:r},React.createElement("img",f({},e.attributes,{className:"o-lazyimage__image o-lazyimage__image--lazyloaded",src:e.org[0],srcset:t,style:r}))):React.createElement("figure",{className:n,style:r},!e.svg&&React.createElement("img",{className:"o-lazyimage__preview",src:e.pre,style:o}),React.createElement("img",f({},e.attributes,{className:"o-lazyimage__image o-lazyimage__image--lazyload","data-sizes":"auto",src:e.pre,"data-srcset":t,style:r})),React.createElement("noscript",null,React.createElement("img",f({},e.attributes,{className:"o-lazyimage__image",src:e.org[0],srcset:t,style:r}))))}}])&&b(t.prototype,n),r&&b(t,r),a}(c.Component);function w(e){return(w="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function j(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}function x(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function E(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}function O(e,t){return(O=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function S(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}();return function(){var n,r=N(e);if(t){var o=N(this).constructor;n=Reflect.construct(r,arguments,o)}else n=r.apply(this,arguments);return k(this,n)}}function k(e,t){return!t||"object"!==w(t)&&"function"!=typeof t?P(e):t}function P(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}function N(e){return(N=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}var U=function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&O(e,t)}(a,e);var t,n,r,o=S(a);function a(e){var t;x(this,a),(t=o.apply(this,arguments)).props=e,t.state={is_uploading:!1};var n=t.props,r=n.attributes,i=(n.setAttributes,n.imageAttribute),c=n.imageExternalURLAttribute,l=n.imageFormat,s=n.allowURL,u=n.accept,p=n.allowedTypes,f=n.labels;return t.accept_types=u||"image/*",t.allowed_types=p||["image"],t.allow_url=!!s,t.image_attribute_key=i||"image",t.image_format=l||"full",t.url_attribute_key=c||"imageExternalURL",t.labels_object=f||{},t.imageExternalURL_attribute=r[t.url_attribute_key],t.onSelectURL=null,s&&(t.onSelectURL=function(e){var n;t.props.setAttributes((j(n={},t.image_attribute_key,{id:!1}),j(n,t.url_attribute_key,e),n)),t.setState({is_uploading:!1})}),t.onSelectURL&&(t.onSelectURL=t.onSelectURL.bind(P(t))),t.onSelect=t.onSelect.bind(P(t)),t.onPreUpload=t.onPreUpload.bind(P(t)),t.clearAttributeValues=t.clearAttributeValues.bind(P(t)),t}return t=a,(n=[{key:"onSelect",value:function(e){var t=this;if(!e.id&&e.url)return 0===e.url.indexOf("blob:")?void this.props.setAttributes(j({},this.url_attribute_key,"")):(this.props.setAttributes(j({},this.url_attribute_key,e.url)),void this.setState({is_uploading:!1}));if(e.id){var n=this.props.setAttributes;v(e.id,this.image_format).then((function(e){n(j({},t.image_attribute_key,e)),t.setState({is_uploading:!1})}))}}},{key:"onPreUpload",value:function(e){this.clearAttributeValues(),this.setState({is_uploading:!0})}},{key:"clearAttributeValues",value:function(){var e;this.props.setAttributes((j(e={},this.url_attribute_key,""),j(e,this.image_attribute_key,{id:!1}),e))}},{key:"render",value:function(){var e=this.props.attributes[this.image_attribute_key],t=this.props.attributes[this.url_attribute_key];return React.createElement(c.Fragment,null,(!!e.id||!!t)&&!this.state.is_uploading&&React.createElement(i.BlockControls,null,React.createElement(u.Toolbar,null,React.createElement(i.MediaReplaceFlow,{name:Object(l._x)("Bild ersetzen","MediaReplaceFlow label","sha"),mediaId:e.id,mediaURL:this.imageExternalURL_attribute,accept:this.accept_types,allowedTypes:this.allowed_types,onFilesUpload:this.onPreUpload,onSelect:this.onSelect,onSelectURL:this.onSelectURL}))),!!this.state.is_uploading&&React.createElement(c.Fragment,null,React.createElement("p",null,Object(l._x)("Datei wird hochgeladen... bitte warten Sie...","Upload message","sha")),React.createElement(u.Spinner,null)),!e.id&&!t&&!this.state.is_uploading&&React.createElement("div",{className:"c-mediaselector c-mediaselector--image components-base-control components-lazy-image-selector"},React.createElement(i.MediaPlaceholder,{icon:"format-image",labels:this.labels_object,multiple:!1,onFilesPreUpload:this.onPreUpload,onSelect:this.onSelect,onSelectURL:this.onSelectURL,accept:this.accept_types,allowedTypes:this.allowed_types})))}}])&&E(t.prototype,n),r&&E(t,r),a}(c.Component);function L(e){return(L="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}function z(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}function T(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}function B(e,t){return(B=Object.setPrototypeOf||function(e,t){return e.__proto__=t,e})(e,t)}function F(e){var t=function(){if("undefined"==typeof Reflect||!Reflect.construct)return!1;if(Reflect.construct.sham)return!1;if("function"==typeof Proxy)return!0;try{return Date.prototype.toString.call(Reflect.construct(Date,[],(function(){}))),!0}catch(e){return!1}}();return function(){var n,r=C(e);if(t){var o=C(this).constructor;n=Reflect.construct(r,arguments,o)}else n=r.apply(this,arguments);return A(this,n)}}function A(e,t){return!t||"object"!==L(t)&&"function"!=typeof t?function(e){if(void 0===e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return e}(e):t}function C(e){return(C=Object.setPrototypeOf?Object.getPrototypeOf:function(e){return e.__proto__||Object.getPrototypeOf(e)})(e)}var D="sht/contact-info",M=Object(a.getBlockDefaultClassName)(D);Object(a.registerBlockType)(D,{title:Object(l._x)("Titel, Text, Bild","Block title","sha"),description:Object(l._x)("Block mit einem Titel, einen Text und einem Bild.","Block title","sha"),icon:s,category:"design",supports:{align:!1,html:!1},example:{attributes:{title:"Lorem ipsum dolor<br>Sit amet consectetur<br>Adipisicing elit sed<br>Do eiusmod tempor<br>Incididunt ut labore",text:"Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",externalURL:"https://sayhello.ch/gutenberg-demo-image-do-not-delete.jpg"}},attributes:{externalURL:{source:"attribute",selector:"img.".concat(M,"__imagefromurl"),attribute:"src"},image:{type:"Object",default:{id:!1}},text:{type:"string"},title:{type:"string"}},edit:function(e){!function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function");e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,writable:!0,configurable:!0}}),t&&B(e,t)}(c,e);var t,n,r,o=F(c);function c(e){var t;return z(this,c),(t=o.apply(this,arguments)).props=e,t}return t=c,(n=[{key:"render",value:function(){var e=Object(a.getBlockDefaultClassName)(D),t=this.props,n=t.attributes,r=t.className,o=t.setAttributes,c=n.externalURL,s=n.image,u=n.text,p=n.title;return[React.createElement("div",{className:r},React.createElement("div",{className:"".concat(e,"__inner")},React.createElement("div",{className:"".concat(e,"__figurewrap")},React.createElement(U,{attributes:n,setAttributes:o,allowedTypes:["image/jpeg"],accept:"image/jpeg",allowURL:!1,labels:{title:Object(l._x)("Bild auswählen","MediaPlaceholder title","sha"),instructions:Object(l._x)("Bitte wählen Sie ein Bild aus. (JPG.)","MediaPlaceholder instructions","sha")}}),!!s.id&&React.createElement(R,{className:"".concat(e,"__figure"),image:s,background:!1,admin:!0}),!!c&&!s.id&&React.createElement("figure",{className:"".concat(e,"__figure")},React.createElement("img",{className:"".concat(e,"__imagefromurl"),src:c,alt:""}))),React.createElement("div",{className:"".concat(e,"__contentwrap")},React.createElement(i.RichText,{tagName:"p",placeholder:Object(l._x)("Schreiben Sie eine Überschrift…","Field placeholder","sha"),className:"".concat(e,"__title"),value:p,allowedFormats:[],multiline:!1,keepPlaceholderOnFocus:!0,onChange:function(e){o({title:e})}}),React.createElement(i.RichText,{tagName:"p",placeholder:Object(l._x)("Schreiben Sie einen Text…","Field placeholder","sha"),className:"".concat(e,"__text"),value:u,allowedFormats:[],multiline:!1,keepPlaceholderOnFocus:!0,onChange:function(e){o({text:e})}}))))]}}])&&T(t.prototype,n),r&&T(t,r),c}(c.Component),save:function(e){var t=e.attributes,n=e.className,r=Object(a.getBlockDefaultClassName)(D),o=t.externalURL,c=t.image,l=t.text,s=t.title;return React.createElement("div",{className:n},React.createElement("div",{className:"".concat(r,"__figurewrap")},!!c.id&&React.createElement(R,{className:"".concat(r,"__figure"),image:c,background:!1,admin:!1}),!!o&&!c.id&&React.createElement("figure",{className:"".concat(r,"__figure")},React.createElement("img",{className:"".concat(r,"__imagefromurl"),src:o,alt:l}))),React.createElement("div",{className:"".concat(r,"__contentwrap")},React.createElement(i.RichText.Content,{className:"".concat(r,"__title"),value:s,tagName:"p"}),React.createElement(i.RichText.Content,{className:"".concat(r,"__text"),value:l,tagName:"p"})))}})}]);