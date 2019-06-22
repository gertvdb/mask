(function ($, Drupal, drupalSettings) {

    'use strict';

    $.jMaskGlobals = {
        maskElements: 'input',
        dataMaskAttr: '',
        dataMask: false,
        watchInterval: 300,
        watchInputs: true,
        watchDataMask: false,
        byPassKeys: [9, 16, 17, 18, 36, 37, 38, 39, 40, 91],
        translation: {}
    };

    /**
     * The mask behavior.
     *
     * @type {{attach: Drupal.behaviors.maskBehavior.attach}}
     */
    Drupal.behaviors.maskBehavior = {
        attach: function (context, drupalSettings) {

            $("[data-class='js--mask']", context).once('initMask').each(function() {
                let $mask = $(this);
                let maskIdentifier = $mask.data('uuid');
                let settings = drupalSettings['maskSettings'][maskIdentifier] || {};
                let Mask = new Drupal.Mask($mask, settings);
                $mask.data('mask', Mask);
            });

        }
    };

})(jQuery, Drupal, drupalSettings);
