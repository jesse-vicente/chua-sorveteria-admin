var adicionais = {
    "frete"    : Number($("#frete").val()),
    "seguro"   : Number($("#seguro").val()),
    "despesas" : Number($("#despesas").val()),
}

const valorPago = Number($("#valor_pago").val());

$(document).ready(function() {
    const tableConta = $("#table-conta").DataTable({
        dom: "<'row options-bar'<'col-md-4'f>l>rtip",
        // bSort: false,
        order: [[ 0, "desc" ]]
    });

    const swalInfo = Swal.mixin({
        customClass: {
            confirmButton: 'swal2-confirm swal2-styled bg-success',
            cancelButton:  'swal2-cancel swal2-styled bg-secondary',
        },
    });

    if ($("#form-compra").length || $("#form-venda").length) {
        gerarListaProdutos();
        gerarListaDuplicatas();
    } else if ($("#form-cancel").length) {
        bloquearCampos();
    } else if ($("#form-conta").length) {
        bloquearCampos();
        $("#forma_pagamento_id, #data_vencimento, #juros, #multa, #desconto").attr("readonly", false);
        $(".btn-search[data-input='#forma_pagamento_id']").attr("disabled", false);
    }

    $("#btn-pagar").click(function(e) {
        e.preventDefault();

        if ($("#data_vencimento").val() !== '') {
            const vencimento = new Date($("#data_vencimento").val());
            const emissao = new Date($("#data_emissao").val());

            const dia = 24 * 60 * 60 * 1000;

            const prazo = Math.round(Math.abs((emissao.getTime() - vencimento.getTime()) / (dia)));

            if (prazo > 30) {
                swalInfo.fire({
                    title: "Atenção!",
                    html: `Esta parcela vencerá daqui <b>${prazo}</b> dias. Deseja continuar?`,
                    icon: "warning",
                    showCloseButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Continuar",
                    cancelButtonText: "Cancelar",
                }).then((result) => {
                    if (result.value) {
                        $("form").submit();
                    }
                });
            } else {
                $("#form-conta").submit();
            }
        }
    });

    $("#btn-receber").click(function(e) {
        e.preventDefault();
        $("#form-conta").submit();
    });

    $("#modelo, #serie, #num_nota, #data_emissao, #data_chegada, #ipt_fornecedor_id").change(function() {
        let vazio = $("#modelo, #serie, #num_nota, #data_emissao, #data_chegada, #ipt_fornecedor_id").filter(function(index, item) {
            return $(item).val() === "";
        });

        console.log(vazio)

        if (vazio.length === 0) {
            $("#ipt_produto_id").eq(0).attr("readonly", false);
            $(".btn-search[data-input='#ipt_produto_id']").eq(0).attr("disabled", false);
        } else {
            $("#ipt_produto_id").eq(0).attr("readonly", true);
            $(".btn-search[data-input='#ipt_produto_id']").eq(0).attr("disabled", true);
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

        if (compra)
            produtosInseridos.push(id);
        else {
            dadosProduto.estoque = Number($("#estoque").val());

            const unidadeText = unidade.toUpperCase();

            if (unidadeText != "KG" && unidadeText != 'L')
                produtosInseridos.push(id);
            // Verifica se a quantidade não excede o estoque
            else {
                const qtdMaxima = dadosProduto.estoque;

                produtosQuantidade.push(dadosProduto);

                const qtdAtual = produtosQuantidade.reduce(function(total, item) {
                    return total += item.qtd;
                }, 0);

                if (qtdAtual > qtdMaxima) {
                    alertDanger.fire({
                        title: "Erro!",
                        text: "Quantidade indisponível.",
                        icon: "error",
                        showCancelButton: false,
                        showCloseButton: true,
                    });

                    produtosQuantidade.pop();

                    return;
                }

                console.table(produtosQuantidade);
            }
        }

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
                $('#produtos-table .selected .btn-danger').click();
                listaProdutos.rows('.selected').remove().draw(false);
                calcularTotal();
                $(this).attr('disabled', true);
            }
        });
    });

    // Contas a pagar
    // $('#data_emissao').change(function() {
    //     const dataEmissao = $(this).val();
    //     const dataVencimento = $('#data_vencimento').val();
    //     const dataPagamento = $('#data_pagamento').val();

    //     console.log(dataVencimento);
    //     console.log(dataEmissao);

    //     if (dataVencimento < dataEmissao)
    //         $('#data_vencimento').val(dataEmissao);

    //     if (dataPagamento < dataEmissao)
    //         $('#data_pagamento').val(dataEmissao);

    //     $('#data_vencimento, #data_pagamento').attr('min', dataEmissao);
    // });

    $('#valor_parcela').keyup(function() {
        const valorParcela = Number($(this).val());

        const readonly = (valorParcela > 0) ? false : true;

        $('#juros, #multa, #desconto').prop('readonly', readonly);

        $('#desconto').attr('max', valorParcela);

        calcularContaPagar(valorParcela);
    });

    $('#juros, #multa, #desconto').keyup(function() {
        calcularContaPagar();
    });
});

function calcularContaPagar(valorParcela = 0) {
    const juros = Number($('#juros').val());
    const multa = Number($('#multa').val());
    const desconto = Number($('#desconto').val());

    let total = valorParcela ? valorParcela : Number($('#valor_parcela').val());

    console.log(valorParcela)

    if (juros > 0)
        total += (total * juros) / 100;

    if (multa > 0)
        total += multa;

    if (desconto > 0)
        total -= desconto;

    $('#valor_pago').val(total.toFixed(2));
}

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

    mostrarDetalhesProduto(detalhesProduto, true);
}

function removerProduto(produto) {
    const id = Number($(produto).parents("tr").find(".produto_id").val());

    const index = produtosInseridos.indexOf(id);

    if (index > -1)
        produtosInseridos.splice(index, 1);

    // provisório
    const qtd = Number($(produto).parents("tr").find(".produto_qtd").val());

    produtosQuantidade = produtosQuantidade.filter(function(item, index) {
        return item.qtd != qtd;
    });

    console.table(produtosQuantidade)

    listaProdutos.row($(produto).parents("tr")).remove().draw();
    calcularTotal();
}
