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

    if ($("#form-compra").length) {
        gerarListaProdutos();
        gerarListaDuplicatas();
    } else if ($("#form-compra-cancel").length) {
        bloquearCampos();
    } else if ($("#form-conta").length) {
        bloquearCampos();
        $("#forma_pagamento_id, #data_vencimento, #data_pagamento, #juros, #multa, #desconto, #valor_pago").attr("readonly", false);
        $(".btn-search[data-input='#forma_pagamento_id']").attr("disabled", false);
    }

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
            $("#total").val('');
            $("#add-item").attr("disabled", true);
            return;
        }

        const total = Number(parseFloat(qtd * val));

        $("#total").val(total.toFixed(2));

        $("#add-item").removeAttr("disabled");
    });

    $("#frete, #seguro, #despesas").keyup(function() {
        const valor = parseFloat(Number($(this).val()));

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

    $(document).on("click", ".alterar", function() {
        const row = $(this).parents("tr");

        const detalhesProduto = {
            "id"         : row.find(".produto_id").val(),
            "descricao"  : row.find(".produto").val(),
            "unidade"    : row.find(".produto_und").val(),
            "quantidade" : row.find(".produto_qtd").val(),
            "valor"      : Number(row.find(".produto_val").val().replace("R$ ", "")).toFixed(2),
            "total"      : Number(row.find(".produto_tot").val().replace("R$ ", "")).toFixed(2),
        };

        console.table(detalhesProduto)

        mostrarDetalhesProduto(detalhesProduto, true);
    });

	$(document).on("click", ".remover", function() {
        listaProdutos.row($(this).parents("tr")).remove().draw();
        calcularTotal();
    });

    // Adiciona item à lista de produtos (compra e venda)
    $("#add-item").click(function(e) {
        e.preventDefault();

        const id = Number($("#produto_cod").val());
        const descricao = $("#descricao").val();
        const unidade = $("#unidade").val();

        const qtd = Number($("#quantidade").val());
        const val = parseFloat(Number($("#valor").val()));

        const total = Number(parseFloat(qtd * val));

        const valTexto   = `R$ ${val}`;
        const totalTexto = `R$ ${total.toFixed(2)}`;

        const dadosProduto = [
            id,
            descricao,
            unidade,
            qtd,
            valTexto,
            totalTexto,
        ];

        listarProdutos(dadosProduto);

        desbloquearAdicionais();

        calcularTotal(total);

        if ($("#card-produtos").hasClass("collapsed-card"))
            $("#card-produtos .card-tools .btn").click();

        $("#condicao_pagamento_id, .btn-search[data-input='#condicao_pagamento_id']").attr("disabled", false);
    });

    // Remove item da lista de produtos (compra e venda)
    $("#remove-item").click(function(e) {
        e.preventDefault();
        listaProdutos.rows(".selected").remove().draw(false);
    });
});
