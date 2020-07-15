$(document).ready(function() {
    var phoneMask = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },

    phoneOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(phoneMask.apply({}, arguments), options);
        }
    };

    $('#telefone, #whatsapp').mask(phoneMask, phoneOptions);

    var cpfCnpjMask = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '000.000.000-00' : '00.000.000/0000-00';
    },

    phoneOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(cpfCnpjMask.apply({}, arguments), options);
        }
    };

    $("#cep").mask("00000-000");

    $("#cpf").mask('000.000.000-00');

    // $("#rg").mask('00.000.000-0');

    // $("#salario").mask('#.##0,00');

    $("#cpf_cnpj").mask('00.000.000/0000-00');

    // $("input[name='total']").mask('#.##0.00');
});
