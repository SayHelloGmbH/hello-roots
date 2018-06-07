/**
 * rspimg
 */
(function (window, document, undefined) {
	/*jshint eqnull:true */
	'use strict';
	var polyfill;
	var config = (window.lazySizes && lazySizes.cfg) || window.lazySizesConfig;
	var img = document.createElement('img');
	var supportSrcset = ('sizes' in img) && ('srcset' in img);
	var regHDesc = /\s+\d+h/g;
	var fixEdgeHDescriptor = (function () {
		var regDescriptors = /\s+(\d+)(w|h)\s+(\d+)(w|h)/;
		var forEach = Array.prototype.forEach;

		return function (edgeMatch) {
			var img = document.createElement('img');
			var removeHDescriptors = function (source) {
				var ratio;
				var srcset = source.getAttribute(lazySizesConfig.srcsetAttr);
				if (srcset) {
					if (srcset.match(regDescriptors)) {
						if (RegExp.$2 == 'w') {
							ratio = RegExp.$1 / RegExp.$3;
						} else {
							ratio = RegExp.$3 / RegExp.$1;
						}

						if (ratio) {
							source.setAttribute('data-aspectratio', ratio);
						}
					}
					source.setAttribute(lazySizesConfig.srcsetAttr, srcset.replace(regHDesc, ''));
				}
			};
			var handler = function (e) {
				var picture = e.target.parentNode;

				if (picture && picture.nodeName == 'PICTURE') {
					forEach.call(picture.getElementsByTagName('source'), removeHDescriptors);
				}
				removeHDescriptors(e.target);
			};

			var test = function () {
				if (!!img.currentSrc) {
					document.removeEventListener('lazybeforeunveil', handler);
				}
			};

			if (edgeMatch[1]) {
				document.addEventListener('lazybeforeunveil', handler);

				if (true || edgeMatch[1] > 14) {
					img.onload = test;
					img.onerror = test;

					img.srcset = 'data:,a 1w 1h';

					if (img.complete) {
						test();
					}
				}
			}
		};
	})();


	if (!config) {
		config = {};
		window.lazySizesConfig = config;
	}

	if (!config.supportsType) {
		config.supportsType = function (type/*, elem*/) {
			return !type;
		};
	}

	if (window.picturefill || config.pf) {
		return;
	}

	if (window.HTMLPictureElement && supportSrcset) {

		if (document.msElementsFromPoint) {
			fixEdgeHDescriptor(navigator.userAgent.match(/Edge\/(\d+)/));
		}

		config.pf = function () {
		};
		return;
	}

	config.pf = function (options) {
		var i, len;
		if (window.picturefill) {
			return;
		}
		for (i = 0, len = options.elements.length; i < len; i++) {
			polyfill(options.elements[i]);
		}
	};

	// partial polyfill
	polyfill = (function () {
		var ascendingSort = function (a, b) {
			return a.w - b.w;
		};
		var regPxLength = /^\s*\d+\.*\d*px\s*$/;
		var reduceCandidate = function (srces) {
			var lowerCandidate, bonusFactor;
			var len = srces.length;
			var candidate = srces[len - 1];
			var i = 0;

			for (i; i < len; i++) {
				candidate = srces[i];
				candidate.d = candidate.w / srces.w;

				if (candidate.d >= srces.d) {
					if (!candidate.cached && (lowerCandidate = srces[i - 1]) &&
						lowerCandidate.d > srces.d - (0.13 * Math.pow(srces.d, 2.2))) {

						bonusFactor = Math.pow(lowerCandidate.d - 0.6, 1.6);

						if (lowerCandidate.cached) {
							lowerCandidate.d += 0.15 * bonusFactor;
						}

						if (lowerCandidate.d + ((candidate.d - srces.d) * bonusFactor) > srces.d) {
							candidate = lowerCandidate;
						}
					}
					break;
				}
			}
			return candidate;
		};

		var parseWsrcset = (function () {
			var candidates;
			var regWCandidates = /(([^,\s].[^\s]+)\s+(\d+)w)/g;
			var regMultiple = /\s/;
			var addCandidate = function (match, candidate, url, wDescriptor) {
				candidates.push({
					c: candidate,
					u: url,
					w: wDescriptor * 1
				});
			};

			return function (input) {
				candidates = [];
				input = input.trim();
				input
					.replace(regHDesc, '')
					.replace(regWCandidates, addCandidate)
				;

				if (!candidates.length && input && !regMultiple.test(input)) {
					candidates.push({
						c: input,
						u: input,
						w: 99
					});
				}

				return candidates;
			};
		})();

		var runMatchMedia = function () {
			if (runMatchMedia.init) {
				return;
			}

			runMatchMedia.init = true;
			addEventListener('resize', (function () {
				var timer;
				var matchMediaElems = document.getElementsByClassName('lazymatchmedia');
				var run = function () {
					var i, len;
					for (i = 0, len = matchMediaElems.length; i < len; i++) {
						polyfill(matchMediaElems[i]);
					}
				};

				return function () {
					clearTimeout(timer);
					timer = setTimeout(run, 66);
				};
			})());
		};

		var createSrcset = function (elem, isImage) {
			var parsedSet;
			var srcSet = elem.getAttribute('srcset') || elem.getAttribute(config.srcsetAttr);

			if (!srcSet && isImage) {
				srcSet = !elem._lazypolyfill ?
					(elem.getAttribute(config.srcAttr) || elem.getAttribute('src')) :
					elem._lazypolyfill._set
				;
			}

			if (!elem._lazypolyfill || elem._lazypolyfill._set != srcSet) {

				parsedSet = parseWsrcset(srcSet || '');
				if (isImage && elem.parentNode) {
					parsedSet.isPicture = elem.parentNode.nodeName.toUpperCase() == 'PICTURE';

					if (parsedSet.isPicture) {
						if (window.matchMedia) {
							lazySizes.aC(elem, 'lazymatchmedia');
							runMatchMedia();
						}
					}
				}

				parsedSet._set = srcSet;
				Object.defineProperty(elem, '_lazypolyfill', {
					value: parsedSet,
					writable: true
				});
			}
		};

		var getX = function (elem) {
			var dpr = window.devicePixelRatio || 1;
			var optimum = lazySizes.getX && lazySizes.getX(elem);
			return Math.min(optimum || dpr, 2.5, dpr);
		};

		var matchesMedia = function (media) {
			if (window.matchMedia) {
				matchesMedia = function (media) {
					return !media || (matchMedia(media) || {}).matches;
				};
			} else {
				return !media;
			}

			return matchesMedia(media);
		};

		var getCandidate = function (elem) {
			var sources, i, len, media, source, srces, src, width;

			source = elem;
			createSrcset(source, true);
			srces = source._lazypolyfill;

			if (srces.isPicture) {
				for (i = 0, sources = elem.parentNode.getElementsByTagName('source'), len = sources.length; i < len; i++) {
					if (config.supportsType(sources[i].getAttribute('type'), elem) && matchesMedia(sources[i].getAttribute('media'))) {
						source = sources[i];
						createSrcset(source);
						srces = source._lazypolyfill;
						break;
					}
				}
			}

			if (srces.length > 1) {
				width = source.getAttribute('sizes') || '';
				width = regPxLength.test(width) && parseInt(width, 10) || lazySizes.gW(elem, elem.parentNode);
				srces.d = getX(elem);
				if (!srces.src || !srces.w || srces.w < width) {
					srces.w = width;
					src = reduceCandidate(srces.sort(ascendingSort));
					srces.src = src;
				} else {
					src = srces.src;
				}
			} else {
				src = srces[0];
			}

			return src;
		};

		var p = function (elem) {
			if (supportSrcset && elem.parentNode && elem.parentNode.nodeName.toUpperCase() != 'PICTURE') {
				return;
			}
			var candidate = getCandidate(elem);

			if (candidate && candidate.u && elem._lazypolyfill.cur != candidate.u) {
				elem._lazypolyfill.cur = candidate.u;
				candidate.cached = true;
				elem.setAttribute(config.srcAttr, candidate.u);
				elem.setAttribute('src', candidate.u);
			}
		};

		p.parse = parseWsrcset;

		return p;
	})();

	if (config.loadedClass && config.loadingClass) {
		(function () {
			var sels = [];
			['img[sizes$="px"][srcset].', 'picture > img:not([srcset]).'].forEach(function (sel) {
				sels.push(sel + config.loadedClass);
				sels.push(sel + config.loadingClass);
			});
			config.pf({
				elements: document.querySelectorAll(sels.join(', '))
			});
		})();

	}
})(window, document);

/**
 * Some versions of iOS (8.1-) do load the first candidate of a srcset candidate list, if width descriptors with the sizes attribute is used.
 * This tiny extension prevents this wasted download by creating a picture structure around the image.
 * Note: This extension is already included in the ls.respimg.js file.
 *
 * Usage:
 *
 * <img
 *    class="lazyload"
 *    data-sizes="auto"
 *    data-srcset="small.jpg 640px,
 *        medium.jpg 980w,
 *        large.jpg 1280w"
 *    />
 */

(function (document) {
	'use strict';
	var regPicture;
	var img = document.createElement('img');

	if (('srcset' in img) && !('sizes' in img) && !window.HTMLPictureElement) {
		regPicture = /^picture$/i;
		document.addEventListener('lazybeforeunveil', function (e) {
			var elem, parent, srcset, sizes, isPicture;
			var picture, source;
			if (e.defaultPrevented ||
				lazySizesConfig.noIOSFix ||
				!(elem = e.target) ||
				!(srcset = elem.getAttribute(lazySizesConfig.srcsetAttr)) ||
				!(parent = elem.parentNode) ||
				(
					!(isPicture = regPicture.test(parent.nodeName || '')) &&
					!(sizes = elem.getAttribute('sizes') || elem.getAttribute(lazySizesConfig.sizesAttr))
				)
			) {
				return;
			}

			picture = isPicture ? parent : document.createElement('picture');

			if (!elem._lazyImgSrc) {
				Object.defineProperty(elem, '_lazyImgSrc', {
					value: document.createElement('source'),
					writable: true
				});
			}
			source = elem._lazyImgSrc;

			if (sizes) {
				source.setAttribute('sizes', sizes);
			}

			source.setAttribute(lazySizesConfig.srcsetAttr, srcset);
			elem.setAttribute('data-pfsrcset', srcset);
			elem.removeAttribute(lazySizesConfig.srcsetAttr);

			if (!isPicture) {
				parent.insertBefore(picture, elem);
				picture.appendChild(elem);
			}
			picture.insertBefore(source, elem);
		});
	}
})(document);

/**
 * BGSet
 */
(function () {
	'use strict';
	if (!window.addEventListener) {
		return;
	}

	var regWhite = /\s+/g;
	var regSplitSet = /\s*\|\s+|\s+\|\s*/g;
	var regSource = /^(.+?)(?:\s+\[\s*(.+?)\s*\])?$/;
	var regBgUrlEscape = /\(|\)|'/;
	var allowedBackgroundSize = {contain: 1, cover: 1};
	var proxyWidth = function (elem) {
		var width = lazySizes.gW(elem, elem.parentNode);

		if (!elem._lazysizesWidth || width > elem._lazysizesWidth) {
			elem._lazysizesWidth = width;
		}
		return elem._lazysizesWidth;
	};
	var getBgSize = function (elem) {
		var bgSize;

		bgSize = (getComputedStyle(elem) || {
			getPropertyValue: function () {
			}
		}).getPropertyValue('background-size');

		if (!allowedBackgroundSize[bgSize] && allowedBackgroundSize[elem.style.backgroundSize]) {
			bgSize = elem.style.backgroundSize;
		}

		return bgSize;
	};
	var createPicture = function (sets, elem, img) {
		var picture = document.createElement('picture');
		var sizes = elem.getAttribute(lazySizesConfig.sizesAttr);
		var ratio = elem.getAttribute('data-ratio');
		var optimumx = elem.getAttribute('data-optimumx');

		if (elem._lazybgset && elem._lazybgset.parentNode == elem) {
			elem.removeChild(elem._lazybgset);
		}

		Object.defineProperty(img, '_lazybgset', {
			value: elem,
			writable: true
		});
		Object.defineProperty(elem, '_lazybgset', {
			value: picture,
			writable: true
		});

		sets = sets.replace(regWhite, ' ').split(regSplitSet);

		picture.style.display = 'none';
		img.className = lazySizesConfig.lazyClass;

		if (sets.length == 1 && !sizes) {
			sizes = 'auto';
		}

		sets.forEach(function (set) {
			var source = document.createElement('source');

			if (sizes && sizes != 'auto') {
				source.setAttribute('sizes', sizes);
			}

			if (set.match(regSource)) {
				source.setAttribute(lazySizesConfig.srcsetAttr, RegExp.$1);
				if (RegExp.$2) {
					source.setAttribute('media', lazySizesConfig.customMedia[RegExp.$2] || RegExp.$2);
				}
			}
			picture.appendChild(source);
		});

		if (sizes) {
			img.setAttribute(lazySizesConfig.sizesAttr, sizes);
			elem.removeAttribute(lazySizesConfig.sizesAttr);
			elem.removeAttribute('sizes');
		}
		if (optimumx) {
			img.setAttribute('data-optimumx', optimumx);
		}
		if (ratio) {
			img.setAttribute('data-ratio', ratio);
		}

		picture.appendChild(img);

		elem.appendChild(picture);
	};

	var proxyLoad = function (e) {
		if (!e.target._lazybgset) {
			return;
		}

		var image = e.target;
		var elem = image._lazybgset;
		var bg = image.currentSrc || image.src;

		if (bg) {
			elem.style.backgroundImage = 'url(' + (regBgUrlEscape.test(bg) ? JSON.stringify(bg) : bg) + ')';
		}

		if (image._lazybgsetLoading) {
			lazySizes.fire(elem, '_lazyloaded', {}, false, true);
			delete image._lazybgsetLoading;
		}
	};

	addEventListener('lazybeforeunveil', function (e) {
		var set, image, elem;

		if (e.defaultPrevented || !(set = e.target.getAttribute('data-bgset'))) {
			return;
		}

		elem = e.target;
		image = document.createElement('img');

		image.alt = '';

		image._lazybgsetLoading = true;
		e.detail.firesLoad = true;

		createPicture(set, elem, image);

		setTimeout(function () {
			lazySizes.loader.unveil(image);

			lazySizes.rAF(function () {
				lazySizes.fire(image, '_lazyloaded', {}, true, true);
				if (image.complete) {
					proxyLoad({target: image});
				}
			});
		});

	});

	document.addEventListener('load', proxyLoad, true);

	window.addEventListener('lazybeforesizes', function (e) {
		if (e.target._lazybgset && e.detail.dataAttr) {
			var elem = e.target._lazybgset;
			var bgSize = getBgSize(elem);

			if (allowedBackgroundSize[bgSize]) {
				e.target._lazysizesParentFit = bgSize;

				lazySizes.rAF(function () {
					e.target.setAttribute('data-parent-fit', bgSize);
					if (e.target._lazysizesParentFit) {
						delete e.target._lazysizesParentFit;
					}
				});
			}
		}
	}, true);

	document.documentElement.addEventListener('lazybeforesizes', function (e) {
		if (e.defaultPrevented || !e.target._lazybgset) {
			return;
		}
		e.detail.width = proxyWidth(e.target._lazybgset);
	});
})();

/**
 * Core
 **/
(function(window, factory) {
	var lazySizes = factory(window, window.document);
	window.lazySizes = lazySizes;
	if(typeof module == 'object' && module.exports){
		module.exports = lazySizes;
	}
}(window, function l(window, document) {
		'use strict';
		/*jshint eqnull:true */
		if(!document.getElementsByClassName){return;}

		var lazysizes, lazySizesConfig;

		var docElem = document.documentElement;

		var Date = window.Date;

		var supportPicture = window.HTMLPictureElement;

		var _addEventListener = 'addEventListener';

		var _getAttribute = 'getAttribute';

		var addEventListener = window[_addEventListener];

		var setTimeout = window.setTimeout;

		var requestAnimationFrame = window.requestAnimationFrame || setTimeout;

		var requestIdleCallback = window.requestIdleCallback;

		var regPicture = /^picture$/i;

		var loadEvents = ['load', 'error', 'lazyincluded', '_lazyloaded'];

		var regClassCache = {};

		var forEach = Array.prototype.forEach;

		var hasClass = function(ele, cls) {
			if(!regClassCache[cls]){
				regClassCache[cls] = new RegExp('(\\s|^)'+cls+'(\\s|$)');
			}
			return regClassCache[cls].test(ele[_getAttribute]('class') || '') && regClassCache[cls];
		};

		var addClass = function(ele, cls) {
			if (!hasClass(ele, cls)){
				ele.setAttribute('class', (ele[_getAttribute]('class') || '').trim() + ' ' + cls);
			}
		};

		var removeClass = function(ele, cls) {
			var reg;
			if ((reg = hasClass(ele,cls))) {
				ele.setAttribute('class', (ele[_getAttribute]('class') || '').replace(reg, ' '));
			}
		};

		var addRemoveLoadEvents = function(dom, fn, add){
			var action = add ? _addEventListener : 'removeEventListener';
			if(add){
				addRemoveLoadEvents(dom, fn);
			}
			loadEvents.forEach(function(evt){
				dom[action](evt, fn);
			});
		};

		var triggerEvent = function(elem, name, detail, noBubbles, noCancelable){
			var event = document.createEvent('CustomEvent');

			if(!detail){
				detail = {};
			}

			detail.instance = lazysizes;

			event.initCustomEvent(name, !noBubbles, !noCancelable, detail);

			elem.dispatchEvent(event);
			return event;
		};

		var updatePolyfill = function (el, full){
			var polyfill;
			if( !supportPicture && ( polyfill = (window.picturefill || lazySizesConfig.pf) ) ){
				polyfill({reevaluate: true, elements: [el]});
			} else if(full && full.src){
				el.src = full.src;
			}
		};

		var getCSS = function (elem, style){
			return (getComputedStyle(elem, null) || {})[style];
		};

		var getWidth = function(elem, parent, width){
			width = width || elem.offsetWidth;

			while(width < lazySizesConfig.minSize && parent && !elem._lazysizesWidth){
				width =  parent.offsetWidth;
				parent = parent.parentNode;
			}

			return width;
		};

		var rAF = (function(){
			var running, waiting;
			var firstFns = [];
			var secondFns = [];
			var fns = firstFns;

			var run = function(){
				var runFns = fns;

				fns = firstFns.length ? secondFns : firstFns;

				running = true;
				waiting = false;

				while(runFns.length){
					runFns.shift()();
				}

				running = false;
			};

			var rafBatch = function(fn, queue){
				if(running && !queue){
					fn.apply(this, arguments);
				} else {
					fns.push(fn);

					if(!waiting){
						waiting = true;
						(document.hidden ? setTimeout : requestAnimationFrame)(run);
					}
				}
			};

			rafBatch._lsFlush = run;

			return rafBatch;
		})();

		var rAFIt = function(fn, simple){
			return simple ?
				function() {
					rAF(fn);
				} :
				function(){
					var that = this;
					var args = arguments;
					rAF(function(){
						fn.apply(that, args);
					});
				}
				;
		};

		var throttle = function(fn){
			var running;
			var lastTime = 0;
			var gDelay = lazySizesConfig.throttleDelay;
			var rICTimeout = lazySizesConfig.ricTimeout;
			var run = function(){
				running = false;
				lastTime = Date.now();
				fn();
			};
			var idleCallback = requestIdleCallback && rICTimeout > 49 ?
				function(){
					requestIdleCallback(run, {timeout: rICTimeout});

					if(rICTimeout !== lazySizesConfig.ricTimeout){
						rICTimeout = lazySizesConfig.ricTimeout;
					}
				} :
				rAFIt(function(){
					setTimeout(run);
				}, true)
			;

			return function(isPriority){
				var delay;

				if((isPriority = isPriority === true)){
					rICTimeout = 33;
				}

				if(running){
					return;
				}

				running =  true;

				delay = gDelay - (Date.now() - lastTime);

				if(delay < 0){
					delay = 0;
				}

				if(isPriority || delay < 9){
					idleCallback();
				} else {
					setTimeout(idleCallback, delay);
				}
			};
		};

		//based on http://modernjavascript.blogspot.de/2013/08/building-better-debounce.html
		var debounce = function(func) {
			var timeout, timestamp;
			var wait = 99;
			var run = function(){
				timeout = null;
				func();
			};
			var later = function() {
				var last = Date.now() - timestamp;

				if (last < wait) {
					setTimeout(later, wait - last);
				} else {
					(requestIdleCallback || run)(run);
				}
			};

			return function() {
				timestamp = Date.now();

				if (!timeout) {
					timeout = setTimeout(later, wait);
				}
			};
		};

		(function(){
			var prop;

			var lazySizesDefaults = {
				lazyClass: 'lazyload',
				loadedClass: 'lazyloaded',
				loadingClass: 'lazyloading',
				preloadClass: 'lazypreload',
				errorClass: 'lazyerror',
				//strictClass: 'lazystrict',
				autosizesClass: 'lazyautosizes',
				srcAttr: 'data-src',
				srcsetAttr: 'data-srcset',
				sizesAttr: 'data-sizes',
				//preloadAfterLoad: false,
				minSize: 40,
				customMedia: {},
				init: true,
				expFactor: 1.5,
				hFac: 0.8,
				loadMode: 2,
				loadHidden: true,
				ricTimeout: 0,
				throttleDelay: 125,
			};

			lazySizesConfig = window.lazySizesConfig || window.lazysizesConfig || {};

			for(prop in lazySizesDefaults){
				if(!(prop in lazySizesConfig)){
					lazySizesConfig[prop] = lazySizesDefaults[prop];
				}
			}

			window.lazySizesConfig = lazySizesConfig;

			setTimeout(function(){
				if(lazySizesConfig.init){
					init();
				}
			});
		})();

		var loader = (function(){
			var preloadElems, isCompleted, resetPreloadingTimer, loadMode, started;

			var eLvW, elvH, eLtop, eLleft, eLright, eLbottom;

			var defaultExpand, preloadExpand, hFac;

			var regImg = /^img$/i;
			var regIframe = /^iframe$/i;

			var supportScroll = ('onscroll' in window) && !(/glebot/.test(navigator.userAgent));

			var shrinkExpand = 0;
			var currentExpand = 0;

			var isLoading = 0;
			var lowRuns = -1;

			var resetPreloading = function(e){
				isLoading--;
				if(e && e.target){
					addRemoveLoadEvents(e.target, resetPreloading);
				}

				if(!e || isLoading < 0 || !e.target){
					isLoading = 0;
				}
			};

			var isNestedVisible = function(elem, elemExpand){
				var outerRect;
				var parent = elem;
				var visible = getCSS(document.body, 'visibility') == 'hidden' || getCSS(elem, 'visibility') != 'hidden';

				eLtop -= elemExpand;
				eLbottom += elemExpand;
				eLleft -= elemExpand;
				eLright += elemExpand;

				while(visible && (parent = parent.offsetParent) && parent != document.body && parent != docElem){
					visible = ((getCSS(parent, 'opacity') || 1) > 0);

					if(visible && getCSS(parent, 'overflow') != 'visible'){
						outerRect = parent.getBoundingClientRect();
						visible = eLright > outerRect.left &&
							eLleft < outerRect.right &&
							eLbottom > outerRect.top - 1 &&
							eLtop < outerRect.bottom + 1
						;
					}
				}

				return visible;
			};

			var checkElements = function() {
				var eLlen, i, rect, autoLoadElem, loadedSomething, elemExpand, elemNegativeExpand, elemExpandVal, beforeExpandVal;

				var lazyloadElems = lazysizes.elements;

				if((loadMode = lazySizesConfig.loadMode) && isLoading < 8 && (eLlen = lazyloadElems.length)){

					i = 0;

					lowRuns++;

					if(preloadExpand == null){
						if(!('expand' in lazySizesConfig)){
							lazySizesConfig.expand = docElem.clientHeight > 500 && docElem.clientWidth > 500 ? 500 : 370;
						}

						defaultExpand = lazySizesConfig.expand;
						preloadExpand = defaultExpand * lazySizesConfig.expFactor;
					}

					if(currentExpand < preloadExpand && isLoading < 1 && lowRuns > 2 && loadMode > 2 && !document.hidden){
						currentExpand = preloadExpand;
						lowRuns = 0;
					} else if(loadMode > 1 && lowRuns > 1 && isLoading < 6){
						currentExpand = defaultExpand;
					} else {
						currentExpand = shrinkExpand;
					}

					for(; i < eLlen; i++){

						if(!lazyloadElems[i] || lazyloadElems[i]._lazyRace){continue;}

						if(!supportScroll){unveilElement(lazyloadElems[i]);continue;}

						if(!(elemExpandVal = lazyloadElems[i][_getAttribute]('data-expand')) || !(elemExpand = elemExpandVal * 1)){
							elemExpand = currentExpand;
						}

						if(beforeExpandVal !== elemExpand){
							eLvW = innerWidth + (elemExpand * hFac);
							elvH = innerHeight + elemExpand;
							elemNegativeExpand = elemExpand * -1;
							beforeExpandVal = elemExpand;
						}

						rect = lazyloadElems[i].getBoundingClientRect();

						if ((eLbottom = rect.bottom) >= elemNegativeExpand &&
							(eLtop = rect.top) <= elvH &&
							(eLright = rect.right) >= elemNegativeExpand * hFac &&
							(eLleft = rect.left) <= eLvW &&
							(eLbottom || eLright || eLleft || eLtop) &&
							(lazySizesConfig.loadHidden || getCSS(lazyloadElems[i], 'visibility') != 'hidden') &&
							((isCompleted && isLoading < 3 && !elemExpandVal && (loadMode < 3 || lowRuns < 4)) || isNestedVisible(lazyloadElems[i], elemExpand))){
							unveilElement(lazyloadElems[i]);
							loadedSomething = true;
							if(isLoading > 9){break;}
						} else if(!loadedSomething && isCompleted && !autoLoadElem &&
							isLoading < 4 && lowRuns < 4 && loadMode > 2 &&
							(preloadElems[0] || lazySizesConfig.preloadAfterLoad) &&
							(preloadElems[0] || (!elemExpandVal && ((eLbottom || eLright || eLleft || eLtop) || lazyloadElems[i][_getAttribute](lazySizesConfig.sizesAttr) != 'auto')))){
							autoLoadElem = preloadElems[0] || lazyloadElems[i];
						}
					}

					if(autoLoadElem && !loadedSomething){
						unveilElement(autoLoadElem);
					}
				}
			};

			var throttledCheckElements = throttle(checkElements);

			var switchLoadingClass = function(e){
				addClass(e.target, lazySizesConfig.loadedClass);
				removeClass(e.target, lazySizesConfig.loadingClass);
				addRemoveLoadEvents(e.target, rafSwitchLoadingClass);
				triggerEvent(e.target, 'lazyloaded');
			};
			var rafedSwitchLoadingClass = rAFIt(switchLoadingClass);
			var rafSwitchLoadingClass = function(e){
				rafedSwitchLoadingClass({target: e.target});
			};

			var changeIframeSrc = function(elem, src){
				try {
					elem.contentWindow.location.replace(src);
				} catch(e){
					elem.src = src;
				}
			};

			var handleSources = function(source){
				var customMedia;

				var sourceSrcset = source[_getAttribute](lazySizesConfig.srcsetAttr);

				if( (customMedia = lazySizesConfig.customMedia[source[_getAttribute]('data-media') || source[_getAttribute]('media')]) ){
					source.setAttribute('media', customMedia);
				}

				if(sourceSrcset){
					source.setAttribute('srcset', sourceSrcset);
				}
			};

			var lazyUnveil = rAFIt(function (elem, detail, isAuto, sizes, isImg){
				var src, srcset, parent, isPicture, event, firesLoad;

				if(!(event = triggerEvent(elem, 'lazybeforeunveil', detail)).defaultPrevented){

					if(sizes){
						if(isAuto){
							addClass(elem, lazySizesConfig.autosizesClass);
						} else {
							elem.setAttribute('sizes', sizes);
						}
					}

					srcset = elem[_getAttribute](lazySizesConfig.srcsetAttr);
					src = elem[_getAttribute](lazySizesConfig.srcAttr);

					if(isImg) {
						parent = elem.parentNode;
						isPicture = parent && regPicture.test(parent.nodeName || '');
					}

					firesLoad = detail.firesLoad || (('src' in elem) && (srcset || src || isPicture));

					event = {target: elem};

					if(firesLoad){
						addRemoveLoadEvents(elem, resetPreloading, true);
						clearTimeout(resetPreloadingTimer);
						resetPreloadingTimer = setTimeout(resetPreloading, 2500);

						addClass(elem, lazySizesConfig.loadingClass);
						addRemoveLoadEvents(elem, rafSwitchLoadingClass, true);
					}

					if(isPicture){
						forEach.call(parent.getElementsByTagName('source'), handleSources);
					}

					if(srcset){
						elem.setAttribute('srcset', srcset);
					} else if(src && !isPicture){
						if(regIframe.test(elem.nodeName)){
							changeIframeSrc(elem, src);
						} else {
							elem.src = src;
						}
					}

					if(isImg && (srcset || isPicture)){
						updatePolyfill(elem, {src: src});
					}
				}

				if(elem._lazyRace){
					delete elem._lazyRace;
				}
				removeClass(elem, lazySizesConfig.lazyClass);

				rAF(function(){
					if( !firesLoad || (elem.complete && elem.naturalWidth > 1)){
						if(firesLoad){
							resetPreloading(event);
						} else {
							isLoading--;
						}
						switchLoadingClass(event);
					}
				}, true);
			});

			var unveilElement = function (elem){
				var detail;

				var isImg = regImg.test(elem.nodeName);

				//allow using sizes="auto", but don't use. it's invalid. Use data-sizes="auto" or a valid value for sizes instead (i.e.: sizes="80vw")
				var sizes = isImg && (elem[_getAttribute](lazySizesConfig.sizesAttr) || elem[_getAttribute]('sizes'));
				var isAuto = sizes == 'auto';

				if( (isAuto || !isCompleted) && isImg && (elem[_getAttribute]('src') || elem.srcset) && !elem.complete && !hasClass(elem, lazySizesConfig.errorClass) && hasClass(elem, lazySizesConfig.lazyClass)){return;}

				detail = triggerEvent(elem, 'lazyunveilread').detail;

				if(isAuto){
					autoSizer.updateElem(elem, true, elem.offsetWidth);
				}

				elem._lazyRace = true;
				isLoading++;

				lazyUnveil(elem, detail, isAuto, sizes, isImg);
			};

			var onload = function(){
				if(isCompleted){return;}
				if(Date.now() - started < 999){
					setTimeout(onload, 999);
					return;
				}
				var afterScroll = debounce(function(){
					lazySizesConfig.loadMode = 3;
					throttledCheckElements();
				});

				isCompleted = true;

				lazySizesConfig.loadMode = 3;

				throttledCheckElements();

				addEventListener('scroll', function(){
					if(lazySizesConfig.loadMode == 3){
						lazySizesConfig.loadMode = 2;
					}
					afterScroll();
				}, true);
			};

			return {
				_: function(){
					started = Date.now();

					lazysizes.elements = document.getElementsByClassName(lazySizesConfig.lazyClass);
					preloadElems = document.getElementsByClassName(lazySizesConfig.lazyClass + ' ' + lazySizesConfig.preloadClass);
					hFac = lazySizesConfig.hFac;

					addEventListener('scroll', throttledCheckElements, true);

					addEventListener('resize', throttledCheckElements, true);

					if(window.MutationObserver){
						new MutationObserver( throttledCheckElements ).observe( docElem, {childList: true, subtree: true, attributes: true} );
					} else {
						docElem[_addEventListener]('DOMNodeInserted', throttledCheckElements, true);
						docElem[_addEventListener]('DOMAttrModified', throttledCheckElements, true);
						setInterval(throttledCheckElements, 999);
					}

					addEventListener('hashchange', throttledCheckElements, true);

					//, 'fullscreenchange'
					['focus', 'mouseover', 'click', 'load', 'transitionend', 'animationend', 'webkitAnimationEnd'].forEach(function(name){
						document[_addEventListener](name, throttledCheckElements, true);
					});

					if((/d$|^c/.test(document.readyState))){
						onload();
					} else {
						addEventListener('load', onload);
						document[_addEventListener]('DOMContentLoaded', throttledCheckElements);
						setTimeout(onload, 20000);
					}

					if(lazysizes.elements.length){
						checkElements();
						rAF._lsFlush();
					} else {
						throttledCheckElements();
					}
				},
				checkElems: throttledCheckElements,
				unveil: unveilElement
			};
		})();


		var autoSizer = (function(){
			var autosizesElems;

			var sizeElement = rAFIt(function(elem, parent, event, width){
				var sources, i, len;
				elem._lazysizesWidth = width;
				width += 'px';

				elem.setAttribute('sizes', width);

				if(regPicture.test(parent.nodeName || '')){
					sources = parent.getElementsByTagName('source');
					for(i = 0, len = sources.length; i < len; i++){
						sources[i].setAttribute('sizes', width);
					}
				}

				if(!event.detail.dataAttr){
					updatePolyfill(elem, event.detail);
				}
			});
			var getSizeElement = function (elem, dataAttr, width){
				var event;
				var parent = elem.parentNode;

				if(parent){
					width = getWidth(elem, parent, width);
					event = triggerEvent(elem, 'lazybeforesizes', {width: width, dataAttr: !!dataAttr});

					if(!event.defaultPrevented){
						width = event.detail.width;

						if(width && width !== elem._lazysizesWidth){
							sizeElement(elem, parent, event, width);
						}
					}
				}
			};

			var updateElementsSizes = function(){
				var i;
				var len = autosizesElems.length;
				if(len){
					i = 0;

					for(; i < len; i++){
						getSizeElement(autosizesElems[i]);
					}
				}
			};

			var debouncedUpdateElementsSizes = debounce(updateElementsSizes);

			return {
				_: function(){
					autosizesElems = document.getElementsByClassName(lazySizesConfig.autosizesClass);
					addEventListener('resize', debouncedUpdateElementsSizes);
				},
				checkElems: debouncedUpdateElementsSizes,
				updateElem: getSizeElement
			};
		})();

		var init = function(){
			if(!init.i){
				init.i = true;
				autoSizer._();
				loader._();
			}
		};

		lazysizes = {
			cfg: lazySizesConfig,
			autoSizer: autoSizer,
			loader: loader,
			init: init,
			uP: updatePolyfill,
			aC: addClass,
			rC: removeClass,
			hC: hasClass,
			fire: triggerEvent,
			gW: getWidth,
			rAF: rAF,
		};

		return lazysizes;
	}
));