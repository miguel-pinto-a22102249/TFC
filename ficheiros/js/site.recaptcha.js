//====================================================//
//                                                    //
//                     CAPTCHAS                       //
//                                                    //
//====================================================//

/**
 * Exibe o captcha no login quando necessário
 * (movido para este namespace 2.8.2)
 * 
 * @author Mario Cesar 
 * @since 2.8.2
 * @version 1.0
 * 
 * @param {String} imagem_captcha
 */
exibeCaptcha = function(imagem_captcha, $form) {

    if (!$form) {
        $form = $('#form-login');
    }

    var $captchaRow = $form.find('.captcha');

    $captchaRow.find('.captcha-image-wrapper').html(imagem_captcha);
    $captchaRow.find('input').attr('name', 'Captcha').val('');

    $captchaRow.show();
};

/**
 * 
 * @type @exp;jQuery@call;Deferred
 */
_promiseRecaptchaLoaded = jQuery.Deferred();
_recaptchas = {};

/**
 * Callback para o load do Recaptcha
 * (movido para este namespace 2.8.2)
 * 
 * @author Mário César
 * @since 2.8.2
 * @version 1.0
 * @returns {undefined}
 */
onLoadRecaptchaCallback = function() {
    _promiseRecaptchaLoaded.resolve();
};

/**
 * Existe ReCaptcha Google
 * (movido para este namespace 2.8.2)
 * 
 * @author Mário César
 * @since 2.8.2
 * @version 2.2 (2.8.11)
 * 
 * @param {string} idElemento
 * @param {string} public_key
 * @param {jQuery} $form
 * @returns {undefined}
 */
exibeReCaptcha = function(idElemento, public_key, $form) {

    _promiseRecaptchaLoaded.done(function() {

        if ($form && $form.length) {

        } else {
            $form = $('#form-login');
        }

        var $captchaRow = $form.find('.captcha');
        $captchaRow.show();

        //apaga-se o conteudo do elemento
        var inicializado = $('#' + idElemento).children().length && _recaptchas[idElemento] !== undefined;

        if (inicializado) {
            grecaptcha.reset(_recaptchas[idElemento]);
        } else {
            _recaptchas[idElemento] = grecaptcha.render(idElemento, {
                'sitekey': public_key
            });
        }
    });

};