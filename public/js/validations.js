 /*
* Translated default messages for the jQuery validation plugin.
* Locale: PT_BR
*/
jQuery.extend(jQuery.validator.messages, {
    required: "Campo obrigatório.",
    remote: "Por favor, corrija este campo.",
    email: "Endereço de e-mail inválido.",
    url: "Endereço URL inválido.",
    date: "Por favor, forne&ccedil;a uma data v&aacute;lida.",
    dateISO: "Por favor, forne&ccedil;a uma data v&aacute;lida (ISO).",
    number: "Por favor, forne&ccedil;a um n&uacute;mero v&aacute;lido.",
    digits: "Por favor, forne&ccedil;a somente d&iacute;gitos.",
    creditcard: "Por favor, forne&ccedil;a um cart&atilde;o de cr&eacute;dito v&aacute;lido.",
    equalTo: "Por favor, forne&ccedil;a o mesmo valor novamente.",
    accept: "Por favor, forne&ccedil;a um valor com uma extens&atilde;o v&aacute;lida.",
    maxlength: jQuery.validator.format("Por favor, forne&ccedil;a n&atilde;o mais que {0} caracteres."),
    minlength: jQuery.validator.format("Por favor, forne&ccedil;a ao menos {0} caracteres."),
    rangelength: jQuery.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1} caracteres de comprimento."),
    range: jQuery.validator.format("Por favor, forne&ccedil;a um valor entre {0} e {1}."),
    max: jQuery.validator.format("Por favor, forne&ccedil;a um valor menor ou igual a {0}."),
    min: jQuery.validator.format("Por favor, forne&ccedil;a um valor maior ou igual a {0}.")
});

$(document).ready(function() {
    $('form').eq(0).validate({
        // rules : {
        //     fornecedor: {
        //         required: true,
        //         minlength: 3,
        //         maxlength: 50,
        //     },
        // },

        // messages:{
        //     telefone: {
        //         minlength: 'Preencha o número corretamente.',
        //         maxlength: 'Preencha o número corretamente.',
        //     },
        //     whatsapp: {
        //         minlength: 'Preencha o número corretamente.',
        //         maxlength: 'Preencha o número corretamente.',
        //     },
        //     logo: {
        //         extension: 'O arquivo deve estar no formato PDF.'
        //     }
        // },

        ignore: ':hidden',
        errorElement: 'strong',
        errorClass: 'is-invalid',
        validClass: 'is-valid',

        errorPlacement: function(error, element) {
            const placement = $(element).data('error');

            placement ? $(placement).append(error) : error.insertAfter(element);
        }
    });

});
