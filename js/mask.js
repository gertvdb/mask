import Imask from 'imask';

(function ($, Drupal) {

    'use strict';

    /**
     * Contructor.
     *
     * @param $element
     *   The jQuery element that wraps the mask form element.
     * @param $masked
     *   The jQuery element that is being masked.
     * @param $unmasked
     *   The jQuery element that hold the unmasked value.
     * @param settings
     *   The settings array.
     */
    Drupal.Mask = function($element, $masked, $unmasked, settings) {
        let that = this;

        that.$element = $element;
        that.$masked = $masked;
        that.$unmasked = $unmasked;

        let parsedSettings = JSON.parse(settings);
        let definitions = parsedSettings['definitions'] || {};
        Object.keys(definitions).forEach(function(key) {
            let pattern = definitions[key];
            parsedSettings['definitions'][key] = new RegExp(pattern);
        });

        that.settings = parsedSettings;
        let mask = Imask(that.$masked.get(0), that.getSettings());

        mask.on("accept", function(){
            that.$unmasked.val(mask.unmaskedValue);
        });

        mask.on("complete", function(){
            that.$unmasked.val(mask.unmaskedValue);
        });
    };

    /**
     * Get the mask settings.
     */
    Drupal.Mask.prototype.getSettings = function() {
        let that = this;
        return that.settings;
    };


})(jQuery, Drupal);
