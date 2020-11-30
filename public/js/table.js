$(document).ready(function() {

    const row =
        `<tr>
            <td>
                <input
                    type="number"
                    class="form-control numero-parcela"
                    name="parcelas[]"
                    value="1"
                    required
                    readonly
                >
            </td>
            <td>
                <div class="form-row">
                    <div class="form-group col-xl-2 mb-0">
                        <input
                            type="text"
                            placeholder="Cód."
                            class="form-control forma-pagamento-id"
                            name="forma_pagamento_id[]"
                            id="forma_pagamento_id[]"
                            data-input="#forma_pagamento[]"
                            data-route="formas-pagamento"
                            min="1"
                            step="1"
                            oninput="validity.valid || (value = '');"
                            required
                        >
                    </div>

                    <div class="form-group col-md-10 mb-0">
                        <div class="input-group">

                            <input
                                type="text"
                                class="form-control forma-pagamento"
                                name="forma_pagamento[]"
                                id="forma_pagamento[]"
                                readonly
                                required
                            >

                            <div class="input-group-append">
                                <button
                                    class="btn btn-primary btn-search"
                                    type="button"
                                    data-input="#forma_pagamento_id"
                                    data-route="formas-pagamento"
                                    data-toggle="modal"
                                    data-target="#modal-formas-pagamento"
                                >
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <input
                    type="number"
                    class="form-control prazo"
                    name="prazo[]"
                    min="1"
                    step="1"
                    oninput="validity.valid || (value = '');"
                    required
                >
            </td>
            <td>
                <input
                    type="number"
                    class="form-control porcentagem"
                    name="porcentagem[]"
                    min="1"
                    max="100"
                    step=".01"
                    oninput="validity.valid || (value = '');"
                    required
                >
            </td>
            <td class="text-center">
                <div class="btn-group-sm py-1">
                    <button type="button" class="btn btn-success add" title="Adicionar">
                        <i class="fa fa-check"></i>
                    </button>
                    <button type="button" class="btn btn-warning edit" title="Editar" style="display: none">
                        <i class="fa fa-edit text-white"></i>
                    </button>
                    <button type="button" class="btn btn-danger delete" title="Remover">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </div>
            </td>
        </tr>`;

    var parcelas = Number($("#total_parcelas").val());

    $('#parcelas-table').DataTable({
        dom: '<"row d-none"<"col-md-4"f>l>rtip',
        bSort: false,
        language: {
            emptyTable: 'Nenhuma parcela adicionada'
        }
    });

    // table.clear().draw();

    // $("#parcelas-table .dataTables_empty").text("Nenhuma parcela inserida.").addClass("py-5");
    $("#parcelas-table_wrapper .dataTables_paginate").remove();
    $("#parcelas-table_wrapper #parcelas-table_info").remove();

	// Append table with add row form on add new button click
    $(".add-new").click(function() {

        if (getPercentualAtual() === 100) {
            Swal.fire({
                title: "Erro!",
                text: "Não é possível adicionar mais parcelas.",
                icon: "error",
                showCloseButton: true,
                confirmButtonText: 'Ok',
            });

            return false;
        }

        $(this).attr("disabled", "disabled");

        parcelas++;

        if (parcelas === 1)
            $("#parcelas-table .dataTables_empty").parent().remove();

        let newRow = $(row).clone();

        newRow.find(".numero-parcela").val(parcelas);

        $("#total_parcelas").val(parcelas);

        $("#parcelas-table tbody").append(newRow);

        newRow.find(".add").show();
        newRow.find(".edit").hide();

        const prevRow = newRow.prev();

        const index =  prevRow.index() + 1;

        newRow.find(".forma-pagamento-id").attr("data-input", `#forma_pagamento_${index}`);
        newRow.find(".forma-pagamento").attr("id", `forma_pagamento_${index}`);

        prevRow.find(".btn-search").attr("disabled", "disabled");
    });

	// Add row on add button click
	$(document).on("click", ".add", function() {
		let empty = false;
        const inputs = $(this).parents("tr").find(".form-control");

        inputs.each(function(){
			if(!$(this).val()){
				$(this).addClass("is-invalid");
				empty = true;
			} else{
                $(this).removeClass("is-invalid");
            }
        });

        $(this).parents("tr").find(".is-invalid").first().focus();

		if (!empty) {
            if (getPercentualAtual() > 100) {
                Swal.fire({
                    title: "Erro!",
                    text: "O percentual das parcelas não podem exceder a 100%.",
                    icon: "error",
                    showCloseButton: true,
                    confirmButtonText: 'Ok',
                });

                return false;
            }

			inputs.each(function() {
                $(this).attr("readonly", true);

                $(this).parents('.input-group').find('.btn-search').prop('disabled', true);
            });

            $(this).hide();

            $(".add-new").removeAttr("disabled");

			$(this).parents("tr").find(".edit, .delete").show();
		}
    });

    function getPercentualAtual() {
        let percentual = 0;

        $(".porcentagem").map(function(index, item) {
            percentual += Number($(item).val());

            // if (Math.round(percentual) === 100)
            //     percentual = 100;
        });

        return percentual;
    }

	// Edit row on edit button click
	$(document).on("click", ".edit", function() {
        $(this).parents("tr").find(".btn-search, .form-control").not(".numero-parcela").each(function() {
            $(this).prop("readonly", false);
            $(this).prop("disabled", false);
        });

        $(this).parents("tr").find(".add, .edit").toggle();

        $(".add-new").prop("disabled", "disabled");
    });

	// Delete row on delete button click
	$(document).on("click", ".delete", function() {
        const tr = $(this).parents("tr");

        // tr.prev().find(".btn").removeAttr("disabled");

        tr.remove();

        $("#total_parcelas").val(--parcelas);

        $("#parcelas-table tr").each(function() {
            $(this).find('.numero-parcela').val($(this).index() + 1);
        })

        $(".add-new").removeAttr("disabled");
    });

    $("form").keypress(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

    $('#form-condicao-pagamento').submit(function(e) {
        if (parcelas > 0 && getPercentualAtual() !== 100) {
            Swal.fire({
                title: 'Erro!',
                text: 'O percentual das parcelas devem somar 100%.',
                icon: 'error',
                showCloseButton: true,
                confirmButtonText: 'Ok',
            });

            e.preventDefault();
            return false;
        }
    });

});
