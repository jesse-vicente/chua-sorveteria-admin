var adicionais = {
    "frete"    : Number($("#frete").val()),
    "seguro"   : Number($("#seguro").val()),
    "despesas" : Number($("#despesas").val()),
}

$(document).ready(function() {
    $("#table-conta").DataTable({
        dom: "<'row options-bar'<'col-md-4'f>l>rtip",
        bSort: false,
    });

    const swalInfo = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-success mr-2',
            cancelButton:  'btn btn-secondary'
        },
        buttonsStyling: false
    });

    if ($("#form-compra").length || $("#form-venda").length) {
        gerarListaProdutos();
        gerarListaDuplicatas();
    } else if ($("#form-cancel").length) {
        bloquearCampos();
    } else if ($("#form-conta").length) {
        bloquearCampos();
        $("#forma_pagamento_id, #data_vencimento, #data_pagamento, #juros, #multa, #desconto").attr("readonly", false);
        $(".btn-search[data-input='#forma_pagamento_id']").attr("disabled", false);
    }

    $("#btn-pagar").click(function(e) {
        e.preventDefault();

        if ($("#data_vencimento").val() !== '') {
            const vencimento = new Date($("#data_vencimento").val());
            const hoje = new Date($("#data_pagamento").val());

            const dia = 24 * 60 * 60 * 1000;

            const prazo = Math.round(Math.abs((hoje.getTime() - vencimento.getTime()) / (dia)));

            if (prazo > 0) {
                swalInfo.fire({
                    title: "Atenção!",
                    html: `Esta parcela vencerá daqui <b>${prazo}</b> dias. Deseja continuar?`,
                    icon: "warning",
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Sim",
                    cancelButtonText: "Não",
                }).then((result) => {
                    if (result.value) {
                        $("form").submit();
                    }
                });
            } else {
                $("form").submit();
            }
        }
    });

    $("#modelo, #serie, #num_nota, #data_emissao, #data_chegada, #fornecedor_id, #cliente_id").change(function() {
        let vazio = $("#modelo, #serie, #num_nota, #data_emissao, #data_chegada, #fornecedor_id, #cliente_id").filter(function(index, item) {
            return $(item).val() === "";
        });

        if (vazio.length === 0) {
            $("#produto_id").attr("readonly", false);
            $(".btn-search[data-input='#produto_id']").attr("disabled", false);
        } else {
            $("#produto_id").attr("readonly", true);
            $(".btn-search[data-input='#produto_id']").attr("disabled", true);
        }
    });

    $("#quantidade, #valor").keyup(function() {
        const qtd = Number($("#quantidade").val());
        const val = parseFloat(Number($("#valor").val()));

        if (qtd == 0 || val == 0) {
            // $("#total").val('');
            $("#total strong").html("<span class='text-gray'>Total: </span>R$ 0,00");
            $("#add-item").attr("disabled", true);
            return;
        }

        if (venda) {
            const estoque = Number($("#estoque").val());

            if (qtd > estoque) {
                $("#quantidade").addClass("is-invalid");
                $("#add-item").attr("disabled", true);
                return;
            }

            $("#quantidade").removeClass("is-invalid");
        }

        const total = Number(parseFloat(qtd * val));

        // $("#total").val(total.toFixed(2));
        $("#total strong").html(`<span class="text-gray">Total: </span>${formatarValor(total)}`);

        $("#add-item").removeAttr("disabled");
    });

    $("#frete, #seguro, #despesas").keyup(function() {
        const valor = Number($(this).val());

        switch ($(this).attr("id")) {
            case "frete":
                adicionais.frete    = valor;
                break;
            case "seguro":
                adicionais.seguro   = valor;
                break;
            case "despesas":
                adicionais.despesas = valor;
                break;
            default:
                break;
        }

        calcularTotal();
    });

    $("#descontos").keyup(function() {
        descontos = Number($(this).val());
        calcularTotal();
    });

    // Adiciona item à lista de produtos (compra e venda)
    $("#add-item").click(function(e) {
        e.preventDefault();

        const id = Number($("#produto_cod").val());
        const descricao = $("#descricao").val();
        const unidade = $("#unidade").val();
        const categoria = $("#categoria").val();

        const qtd = Number($("#quantidade").val());
        const val = parseFloat(Number($("#valor").val()));

        const total = Number(parseFloat(qtd * val));

        const valTexto   = formatarValor(val);
        const totalTexto = formatarValor(total);

        const dadosProduto = {
            id,
            descricao,
            unidade,
            categoria,
            qtd,
            val,
            valTexto,
            total,
            totalTexto,
        };

        listarProdutos(dadosProduto);

        desbloquearAdicionais();

        calcularTotal(total);

        if ($("#card-produtos").hasClass("collapsed-card"))
            $("#card-produtos .card-tools .btn").click();

        $("#condicao_pagamento_id").attr("readonly", false);
        $(".btn-search[data-input='#condicao_pagamento_id']").attr("disabled", false);
    });

    // Remove item da lista de produtos (compra e venda)
    $("#remove-item").click(function(e) {
        e.preventDefault();
        listaProdutos.rows(".selected").remove().draw(false);
    });
});

function alterarProduto(produto) {
    const row = $(produto).parents("tr");

    const detalhesProduto = {
        "id"         : row.find(".produto_id").val(),
        "descricao"  : row.find(".produto").val(),
        "unidade"    : row.find(".produto_und").val(),
        "categoria"  : row.find(".produto_cat").val(),
        "quantidade" : row.find(".produto_qtd").val(),
        "valor"      : Number(row.find(".produto_val").val()).toFixed(2),
        "total"      : Number(row.find(".produto_tot").val()).toFixed(2),
    };

    mostrarDetalhesProduto(detalhesProduto, true);
}

function removerProduto(produto) {
    listaProdutos.row($(produto).parents("tr")).remove().draw();
    calcularTotal();
}
