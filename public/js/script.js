/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;
/******/
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// identity function for calling harmony imports with the correct context
/******/ 	__webpack_require__.i = function(value) { return value; };
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 42);
/******/ })
/************************************************************************/
/******/ ({

/***/ 10:
/***/ (function(module, exports) {

$(window).load(function () {

	// We are listening to the window.load event, so we can be sure
	// that the images in the slideshow are loaded properly.


	// Testing wether the current browser supports the canvas element:
	var supportCanvas = 'getContext' in document.createElement('canvas');

	// The canvas manipulations of the images are CPU intensive,
	// this is why we are using setTimeout to make them asynchronous
	// and improve the responsiveness of the page.

	var slides = $('#slideshow li'),
	    current = 0,
	    slideshow = { width: 0, height: 0 };

	setTimeout(function () {

		window.console && window.console.time && console.time('Generated In');

		if (supportCanvas) {
			$('#slideshow img').each(function () {

				if (!slideshow.width) {
					// Taking the dimensions of the first image:
					slideshow.width = this.width;
					slideshow.height = this.height;
				}

				// Rendering the modified versions of the images:
				createCanvasOverlay(this);
			});
		}

		window.console && window.console.timeEnd && console.timeEnd('Generated In');

		$('#slideshow .arrow').click(function () {
			var li = slides.eq(current),
			    canvas = li.find('canvas'),
			    nextIndex = 0;

			// Depending on whether this is the next or previous
			// arrow, calculate the index of the next slide accordingly.

			if ($(this).hasClass('next')) {
				nextIndex = current >= slides.length - 1 ? 0 : current + 1;
			} else {
				nextIndex = current <= 0 ? slides.length - 1 : current - 1;
			}

			var next = slides.eq(nextIndex);

			if (supportCanvas) {

				// This browser supports canvas, fade it into view:

				canvas.fadeIn(function () {

					// Show the next slide below the current one:
					next.show();
					current = nextIndex;

					// Fade the current slide out of view:
					li.fadeOut(function () {
						li.removeClass('slideActive');
						canvas.hide();
						next.addClass('slideActive');
					});
				});
			} else {

				// This browser does not support canvas.
				// Use the plain version of the slideshow.

				current = nextIndex;
				next.addClass('slideActive').show();
				li.removeClass('slideActive').hide();
			}
		});
	}, 100);

	// This function takes an image and renders
	// a version of it similar to the Overlay blending
	// mode in Photoshop.

	function createCanvasOverlay(image) {

		var canvas = document.createElement('canvas'),
		    canvasContext = canvas.getContext("2d");

		// Make it the same size as the image
		canvas.width = slideshow.width;
		canvas.height = slideshow.height;

		// Drawing the default version of the image on the canvas:
		canvasContext.drawImage(image, 0, 0);

		// Taking the image data and storing it in the imageData array:
		var imageData = canvasContext.getImageData(0, 0, canvas.width, canvas.height),
		    data = imageData.data;

		// Loop through all the pixels in the imageData array, and modify
		// the red, green, and blue color values.

		for (var i = 0, z = data.length; i < z; i++) {

			// The values for red, green and blue are consecutive elements
			// in the imageData array. We modify the three of them at once:

			data[i] = data[i] < 128 ? 2 * data[i] * data[i] / 255 : 255 - 2 * (255 - data[i]) * (255 - data[i]) / 255;
			data[++i] = data[i] < 128 ? 2 * data[i] * data[i] / 255 : 255 - 2 * (255 - data[i]) * (255 - data[i]) / 255;
			data[++i] = data[i] < 128 ? 2 * data[i] * data[i] / 255 : 255 - 2 * (255 - data[i]) * (255 - data[i]) / 255;

			// After the RGB elements is the alpha value, but we leave it the same.
			++i;
		}

		// Putting the modified imageData back to the canvas.
		canvasContext.putImageData(imageData, 0, 0);

		// Inserting the canvas in the DOM, before the image:
		image.parentNode.insertBefore(canvas, image);
	}
});

/***/ }),

/***/ 42:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(10);


/***/ })

/******/ });