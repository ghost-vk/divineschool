/**
 * @namespace Utils
 */
var Utils = Utils || {};


/**
 * Method returns localized data generated in enqueue.php
 * @param _object {'objectName'}
 * @param key {string}
 * @return {Object}
 */
Utils.getLocalizeData = (_object, key) => {
    if (typeof window[_object] !== "undefined") {
        return window[_object][key];
    }
    return {};
};