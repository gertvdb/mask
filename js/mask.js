import Imask from 'imask';

(function ($, Drupal) {

    'use strict';

    /**
     * Contructor.
     *
     * @param $element
     *   The jQuery element that wraps the mask form element.
     * @param settings
     *   The settings array.
     */
    Drupal.Mask = function($element, settings) {
        let that = this;
        that.$element = $element;

        that.settings = JSON.parse(settings);
        let definitions = that.settings['definitions'] || {};

        Object.keys(definitions).forEach(function(key) {
            let pattern = definitions[key];
            that.settings['definitions'][key] = new RegExp(pattern);
        });

        Imask(that.$element.find('input').get(0), that.getSettings());
    };

    /**
     * Get the mask settings.
     */
    Drupal.Mask.prototype.getSettings = function() {
        let that = this;
        return that.settings;
    };


})(jQuery, Drupal);
