"use strict";

// should be modified to return an object... with different possible color depths set to true/false?
// Select screen attributes
Modernizr.addTest('pr-screenattributes', function () {
  return {
    windowHeight: (window.innerHeight > 0) ? window.innerHeight : screen.width,
    windowWidth: (window.innerWidth > 0) ? window.innerWidth : screen.width,
    colorDepth: screen.colorDepth
  };
});
