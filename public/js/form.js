$(document).ready(function() {

    var table = null;

    var fieldIndex = 0;

    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-danger mr-2',
            cancelButton:  'btn btn-secondary'
        },
        buttonsStyling: false
    });

    // Excluir
    $("#delete-entry").not(".delete").click(function() {
        swalWithBootstrapButtons.fire({
            title: "Aviso!",
            text: "Esta operação não poderá ser revertida.",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Remover",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                $("#form-delete").submit();
            }
        })
    });

    // Submit
    $("button[type='submit']").click(function() {
        $("form").submit();
    });

    $(".modal form").attr("action", "#");
    $(".modal form").attr("onsubmit", "return false");

    $(".btn-save-modal").click(function(e) {
        const form = $(this).parents(".modal").find("form");

        const data = form.serialize();

        return false;

        $.ajax({
            url: $inlineCreateRoute,
            data: $formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (result) {

                $createdEntity = result.data;

                if(!$force_select) {
                    //if developer did not force the created entity to be selected we first try to
                    //check if created is still available upon model re-search.
                    ajaxSearch(element, result.data);

                }else{
                    selectOption(element, result.data);
                }

                $modal.modal('hide');



                new Noty({
                    type: "info",
                    text: 'Related entry has been created and selected.',
                }).show();
            },
            error: function (result) {

                var $errors = result.responseJSON.errors;

                let message = '';
                for (var i in $errors) {
                    message += $errors[i] + ' \n';
                }

                new Noty({
                    type: "error",
                    text: '<strong>Could not create related entry.</strong><br> '+message,
                }).show();

                //revert save button back to normal
                $modalSaveButton.prop('disabled', false);
                $modalSaveButton.html($modalSaveButton.data('original-text'));
            }
        });
    });

    $("#table").DataTable({
        "dom": '<"row justify-content-md-between"<"col-md-4"f>l>rtip',
    });

    // Função que captura o enter
    $.fn.pressEnter = function(fn) {
        return this.each(function() {
            $(this).bind('pressEnter', fn);
            $(this).keyup(function(e) {
                if(e.keyCode == 13)
                {
                  $(this).trigger("pressEnter");
                }
            })
        });
    };

    var idAtual = 0;

    $(document).on("focusin" ,".form-control[id*='_id']", function() {
        idAtual = Number($(this).val());
    });

    // Atualiza o campo ao mudar valor
    $(document).on("focusout", ".form-control[id*='_id'], .form-control[id*='_id[]']", function() {
        const id = Number($(this).val());

        // alert(id)

        if (id === idAtual || id === 0)
            return;

        const route = $(this).data("route");

        const input = $($(this).data("input"));

        $.get(`/${route}/${id}/find`, function(data) {
            (data) ? input.val(data["nome"]) : input.val("Nenhum registro encontrado.");
        });
    });

    // Seleciona item da modal e coloca os valores nos inputs
    $(document).on('click', '.modal-body tbody tr', function() {
        const data = table.rows( { selected: true } ).data()[0];

        const field = $('.modal.show').data('field');

        const id = data[0];
        const descricao = data[1];

        $('.modal.show').modal('hide');

        if (field === 'forma_pagamento[]') {
            $(`input[name='forma_pagamento_id[]']`).eq(fieldIndex).val(id);
            $(`input[name='forma_pagamento[]']`).eq(fieldIndex).val(descricao);
        } else {
            $(`input[name='${field}_id']`).eq(0).val(id);
            $(`input[name='${field}']`).eq(0).val(descricao);
        }
    });

    $('.custom-control-input').click(function() {
        let id = $(this).attr('id');

        if (id === 'fisica') {
            $('#nome_fantasia').prev().text('Apelido');

            $('#cpf_cnpj').prev().text("CPF");
            $('#cpf_cnpj').addClass("cpf");
            $('#cpf_cnpj').removeClass("cnpj");

            $('#cpf_cnpj').attr('placeholder', '___.___.___-__');

            $('#rg_inscricao_estadual').prev().text("RG");
        } else if (id === 'juridica') {
            $('#nome_fantasia').prev().text('Nome Fantasia');

            $('#cpf_cnpj').prev().text("CNPJ");
            $('#cpf_cnpj').addClass("cnpj");
            $('#cpf_cnpj').removeClass("cpf");

            $('#cpf_cnpj').attr('placeholder', '__.___.___/____-__');

            $('#rg_inscricao_estadual').prev().text("Inscrição Estadual");
        }
    });

    var route = null;

    $(document).on("click", ".btn-search", function(e) {
        e.preventDefault();

        if (!$('.modal').hasClass('show'))
            route = $(this).data("route");

        if (route === "formas-pagamento")
            fieldIndex = $(this).parents('tr').index();

        const val = $($(this).data('input')).val() ?? '';

        $.get(`/${route}/search`, `q=${val}`, function(data) {

            $(`#modal-${route} .table-responsive`).html(data);

            table = $(`#modal-${route} .table`).DataTable({
                "dom": '<"row justify-content-md-between"<"col-md-6"f>B>rtip',
                select: true,
                buttons: [
                    {
                        text: 'Novo',
                        className: 'btn btn-primary',
                        action: function ( e, dt, node, config ) {
                            $(`#modal-${route}-create`).modal('show');
                        }
                    }
                ],
            });
        });
    });

    $("#form-delete .form-control, #form-delete .btn-search").each(function() {
        $(this).attr("readonly", true)
        $(this).attr("disabled", true)
    });
})
