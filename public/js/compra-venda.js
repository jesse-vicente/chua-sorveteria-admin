var adicionais = {
    "frete"    : Number($("#frete").val()),
    "seguro"   : Number($("#seguro").val()),
    "despesas" : Number($("#despesas").val()),
}

const valorPago = Number($("#valor_pago").val());

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
            const hoje = new Date();

            const dia = 24 * 60 * 60 * 1000;

            const prazo = Math.round(Math.abs((hoje.getTime() - vencimento.getTime()) / (dia)));

            if (prazo > 1) {
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

    $("#modelo, #serie, #num_nota, #data_emissao, #data_chegada, #fornecedor_id").change(function() {
        let vazio = $("#modelo, #serie, #num_nota, #data_emissao, #data_chegada, #fornecedor_id").filter(function(index, item) {
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
            ajustarTotalProduto();
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

        const total = qtd * val;
        ajustarTotalProduto(total)

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

    $("#desconto").keyup(function() {
        const desconto = Number($(this).val());

        const novoValor = valorPago - desconto;

        if (desconto > valorPago || novoValor < 0) {
            $(this).addClass("is-invalid");
            $("#valor_pago").val(valorPago.toFixed(2));
            $("#btn-pagar").attr("disabled", true);
            return;
        }

        $(this).removeClass("is-invalid");
        $("#btn-pagar").attr("disabled", false);
        $("#valor_pago").val(novoValor.toFixed(2));
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

        const valTexto   = formatarReais(val);
        const totalTexto = formatarReais(total);

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

        if (venda)
            dadosProduto.estoque = $("#estoque").val();

        produtosInseridos.push(id);

        listarProdutos(dadosProduto);

        desbloquearAdicionais();

        calcularTotal(total);

        if ($("#card-produtos").hasClass("collapsed-card"))
            $("#card-produtos .card-tools .btn").click();

        $("#condicao_pagamento_id").attr("readonly", false);
        $(".btn-search[data-input='#condicao_pagamento_id']").attr("disabled", false);
    });

    $(document).on("click", "#produtos-table tbody tr", function() {
        const selected = $("#produtos-table tbody .selected").length;

        const btRemover = $("#remove-items");

        console.log(btRemover.css("display"))

        if (selected > 1) {
            btRemover.attr("disabled", false);
            return;
        }

        btRemover.attr("disabled", true);
    });

    // Remove item da lista de produtos (compra e venda)
    $("#remove-items").click(function(e) {
        e.preventDefault();

        alertDanger.fire({
            title: "Atenção!",
            text: "Deseja remover os itens selecionados?",
            icon: "warning",
            showCloseButton: true,
            showCancelButton: true,
            confirmButtonText: "Confirmar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                listaProdutos.rows(".selected").remove().draw(false);
                calcularTotal();
                $(this).attr("disabled", true);
            }
        });
    });
});

function alterarProduto(produto, event) {
    event.preventDefault();

    const row = $(produto).parents("tr");

    const detalhesProduto = {
        "id"         : row.find(".produto_id").val(),
        "descricao"  : row.find(".produto").val(),
        "unidade"    : row.find(".produto_und").val(),
        "categoria"  : row.find(".produto_cat").val(),
        "quantidade" : row.find(".produto_qtd").val(),
        "total"      : Number(row.find(".produto_tot").val()),
    };

    const valorProduto = Number(row.find(".produto_val").val());

    if (compra)
        detalhesProduto.valor = valorProduto;
    else {
        detalhesProduto.preco = valorProduto;
        detalhesProduto.estoque = row.find(".produto_id").data("estoque");
    }

    console.table(detalhesProduto)

    mostrarDetalhesProduto(detalhesProduto, true);
}

function removerProduto(produto) {
    const id = Number($(produto).parents("tr").find(".produto_id").val());
    const index = produtosInseridos.indexOf(id);

    if (index > -1)
        produtosInseridos.splice(index, 1);

    listaProdutos.row($(produto).parents("tr")).remove().draw();
    calcularTotal();
}
