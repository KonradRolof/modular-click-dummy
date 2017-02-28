// Shorthand for $( document ).ready()
$(function () {
    var $document = $(this);

    // init foundation
    $document.foundation();

    // init device detection
    device.init();
    device.Caps.get();
    device.Caps.addToRootContainer();

    window.isMobile = (device.Helpers.mobile.useragent.any() && device.Helpers.touch.hasTouch());
});