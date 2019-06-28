(function ($, Drupal, drupalSettings) {

    'use strict';

    /**
     * The mask behavior.
     *
     * @type {{attach: Drupal.behaviors.maskBehavior.attach}}
     */
    Drupal.behaviors.maskBehavior = {
        attach: function (context, drupalSettings) {

            $("[data-class='js--mask']", context).once('initMask').each(function() {
                let $mask = $(this);
                let $masked = $mask.find("[data-class='js--mask--masked']");
                let $unmasked = $mask.find("[data-class='js--mask--unmasked']");
                let maskIdentifier = $mask.data('uuid');
                let settings = drupalSettings['maskSettings'][maskIdentifier] || {};
                let Mask = new Drupal.Mask($mask, $masked, $unmasked, settings);
                $mask.data('mask', Mask);
            });

        }
    };

})(jQuery, Drupal, drupalSettings);
