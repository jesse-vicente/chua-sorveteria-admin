var table, listaProdutos, listaDuplicatas = null;
var fieldIndex, idBusca = 0;
var sofreuAlteracao = false;

var adicionais = {
    "frete"    : Number($("#frete").val()),
    "seguro"   : Number($("#seguro").val()),
    "despesas" : Number($("#despesas").val()),
}

var descontos = Number($("#descontos").val());

const compra = $("#form-compra").length;
const venda  = $("#form-venda").length;

$(document).ready(function() {
    tableList = $("#table").DataTable({
        dom: "<'row options-bar'<'col-md-4'f>l>rtip",
        fixedHeader: true,
        bSort: false,
    });

    $(".form-control").change(function() {
        sofreuAlteracao = true;
    });

    // TODO - Filtros
    // $('#table thead tr').clone(true).appendTo( '#table thead' );

    // $('#table thead tr:eq(1) th').each( function (i) {
    //     var title = $(this).text(); //es el nombre de la columna
    //     $(this).html( '<input type="text" placeholder="Search...'+title+'" />' );

    //     $('input', this).on('keyup change', function() {
    //         if (tableList.column(i).search() !== this.value ) {
    //             tableList
    //                 .column(i)
    //                 .search( this.value )
    //                 .draw();
    //         }
    //     });
    // });

    $('#table-filter').on('change', function(){
        table.search(this.value).draw();
    });

    $('[data-toggle="tooltip"]').tooltip();

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var url = window.location.href;

    url = url.replace('/create', '');

    $('ul.nav-sidebar a').filter(function() {
        return this.href == url;
    }).addClass('active');

    $('ul.nav-treeview a').filter(function() {
        return this.href == url;
    }).parentsUntil(".sidebar-menu > .nav-treeview").addClass('menu-open');

    // $('ul.nav-treeview a').filter(function() {
    //     return this.href == url;
    // }).addClass('active');

    // $('li.has-treeview a').filter(function() {
    //     return this.href == url;
    // }).addClass('active');

    $('ul.nav-treeview a').filter(function() {
        return this.href == url;
    }).parentsUntil(".sidebar-menu > .nav-treeview").children(0).addClass('active');

    const confirmDelete = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-danger mr-2',
            cancelButton:  'btn btn-outline-secondary'
        },
        buttonsStyling: false
    });

    const confirmCancel = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-outline-danger',
        },
        buttonsStyling: false
    });

    const confirmCancelForm = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary',
        },
        buttonsStyling: false
    });

    // Botão Cancelar (compra/venda)
    $("#btn-cancel").click(function() {
        confirmCancel.fire({
            title: "Atenção!",
            text: "Os dados referente a este registro serão descartados. Deseja mesmo prosseguir?",
            icon: "warning",
            showCloseButton: true,
            confirmButtonText: "Sim, prosseguir com o cancelamento.",
        }).then((result) => {
            if (result.value) {
                $("#form-cancel").submit();
            }
        })
    });

    // Botão Cancelar (voltar tela consulta)
    $(".btn-outline-secondary").click(function(e) {
        if (sofreuAlteracao) {
            e.preventDefault();

            href = $(this).attr('href');

            confirmCancelForm.fire({
                title: "Atenção!",
                text: "Os dados informados serão perdidos.",
                icon: "warning",
                showCloseButton: true,
                confirmButtonText: "Confirmar",
            }).then((result) => {
                if (result.value)
                    window.location.href = href;
            });
        }
    });

    // Botão Excluir
    $("#btn-delete").not(".delete").click(function() {
        confirmDelete.fire({
            title: "Você tem certeza?",
            text: "Deseja realmente excluir este registro? Esta operação não poderá ser desfeita.",
            icon: "error",
            showCancelButton: true,
            confirmButtonText: "Excluir",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value) {
                $("#form-delete").submit();
            }
        })
    });

    // Submit
    $("button[type='submit']").click(function() {
        $("form").eq(0).submit();
    });

    $("#form-compra, #form-venda").submit(function(e) {
        e.preventDefault();

        $("#form-errors").hide();
        $('#form-errors .list-unstyled li').remove();

        const routeList = ($(this).attr("id") == "form_compra") ? '/compras' : '/vendas';

        $.post("save", $(this).serialize(), function(data) { })

        .done(function(data) {
            if (data.success)
                window.location.href = routeList;
        })

        .fail(function (request, status, error) {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "preventDuplicates": true,
            }

            $.each(request.responseJSON.errors, function(key, value) {
                toastr["error"](value)
            });
        });
    });

    $(".btn-save-modal").click(function(e) {
        e.preventDefault();

        const modal = $(this).parents(".modal");
        const form = modal.find("form");
        const route = form.data("route");

        $.post(`/${route}/save`, form.serialize(), function(data) {

        })

        .done(function(data) {
            if (data.success) {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "preventDuplicates": true,
                }

                toastr["success"](data.message);

                modal.find(".close").click();
            }
        })

        .fail(function (request, status, error) {
            modal.find(".form-control").removeClass("is-invalid");
            modal.find(".invalid-feedback").remove();

            $.each(request.responseJSON.errors, function(key, value) {

                const input = $(`.modal #${key}`);

                const errorHTML = `
                    <span class="invalid-feedback" role="alert">
                        <strong>${value}</strong>
                    </span>
                `;

                input.addClass("is-invalid");

                input.parent().append(errorHTML);
            });
        });
    });

    $(document).on("focusin" ,".form-control[id*='_id']", function() {
        idBusca = Number($(this).val());
    });

    // Atualiza o campo ao mudar valor
    $(document).on("focusout", ".form-control[id*='_id'], .form-control[id*='_id[]']", function() {
        const id = Number($(this).val());

        if (id === idBusca || id === 0)
            return;

        const route = $(this).data("route");
        const input = $($(this).data("input"));

        let action = '';

        if (route == 'produtos')
            action = compra ? 'compra' : 'venda';

        const routeURL = action ? `/${route}/${id}/findById/${action}` : `/${route}/${id}/findById`;

        $.get(routeURL, function(data) {

            let chave = input.attr("id");

            const dados = data[0];

            if (chave.substr(0, 15) == 'forma_pagamento')
                chave = chave.substr(0, 15);

            (dados) ? input.val(dados[chave]) : input.val("Nenhum registro encontrado.");

            if (route === 'produtos') {
                let detalhesProduto = {
                    'id'        : dados['id'],
                    'descricao' : dados['produto'],
                    'categoria' : dados['categoria'],
                    'unidade'   : dados['unidade'],
                };

                if (venda) {
                    detalhesProduto.preco = dados['preco_venda'];
                    detalhesProduto.estoque = dados['estoque'];
                }

                mostrarDetalhesProduto(detalhesProduto)
            } else if (route === 'condicoes-pagamento') {
                //
            } else if (route === 'formas-pagamento') {
                //
            }
        });
    });

    // Seleciona item da modal e coloca os valores nos inputs
    $(document).on('click', '.modal-body tbody tr', function() {

        const data = table.rows({ selected: true }).data()[0];

        const modal = $(this).parents(".modal");

        const field = modal.data('field');

        const id = data[0];
        const descricao = data[1];

        if (field === 'forma_pagamento[]') {
            $('.forma_pagamento_id').eq(fieldIndex).val(id);
            $('.forma_pagamento').eq(fieldIndex).val(descricao);
        }
        else if (field === 'produto') {
            let detalhesProduto = {
                'id'        : id,
                'descricao' : descricao,
                'unidade'   : $(this).find("td").eq(2).text(),
                'categoria' : $(this).find("td").eq(3).text(),
                // 'custoUltimaCompra' : $(this).find("td").eq(5).text(),
                // 'estoque' : $(this).find("td").eq(6).text(),
            };

            if (venda) {
                detalhesProduto.preco = Number($(this).find("td").eq(5).text());
                detalhesProduto.estoque = Number($(this).find("td").eq(6).text());
            }

            mostrarDetalhesProduto(detalhesProduto);
        }
        // Inserir na lista de contas à pagar
        else if (field === 'condicao_pagamento' && $("#total_pagar").length) {
            const totalPagar = Number($("#total_pagar").val());

            const parcelas = data[6];

            let duplicatas = Array();

            parcelas.map(function(parcela) {
                const inputData = $("#form-compra").length ? $("#data_emissao") : $("#data_venda");
                const dataEmissao = new Date(inputData.val());

                var prazo = new Date();

                prazo.setDate(dataEmissao.getDate() + parcela.prazo + 1);

                const numParcela  = `${$("#num_nota").val()}/${parcela.numero}`;
                const formaPagamento = parcela.forma_pagamento;
                const vencimento = prazo.toLocaleDateString();
                const valParcela = getPercentual(totalPagar, parcela.porcentagem);
                const valParcelaTexto = formatarValor(valParcela);

                const duplicata = {
                    numParcela,
                    formaPagamento,
                    vencimento,
                    valParcela,
                    valParcelaTexto,
                };

                console.table(duplicata);

                duplicatas.push(duplicata);
            });

            listarDuplicatas(duplicatas);
        }
        // else {
            $(`input[name='${field}_id']`).eq(0).val(id).change();
            $(`input[name='${field}']`).eq(0).val(descricao).change();
        // }

        modal.modal('hide');
    });

    $(".custom-control-input").click(function() {
        let id = $(this).attr("id");

        if (id === "fisica") {
            $("#nome_fantasia").prev().text("Apelido");

            $("#cpf_cnpj").prev().text("CPF");
            $("#cpf_cnpj").addClass("cpf");
            $("#cpf_cnpj").removeClass("cnpj");

            $("#cpf_cnpj").attr("placeholder", "___.___.___-__");

            $("#rg_inscricao_estadual").prev().text("RG");
        } else if (id === "juridica") {
            $("#nome_fantasia").prev().text("Nome Fantasia");

            $("#cpf_cnpj").prev().text("CNPJ");
            $("#cpf_cnpj").addClass("cnpj");
            $("#cpf_cnpj").removeClass("cpf");

            $("#cpf_cnpj").attr("placeholder", "__.___.___/____-__");

            $("#rg_inscricao_estadual").prev().text("Inscrição Estadual");
        }
    });

    $(document).on("click", ".btn-search", function(e) {
        e.preventDefault();

        let route = null;

        if ($("#table").length)
            route = $("#table").data("route");
        else if (!$(".modal").hasClass("show"))
            route = $(this).data("route");
        else
            route = $(".modal.show").attr("id").replace("modal-", "");

        if (route === "formas-pagamento")
            fieldIndex = $(this).parents("tr").index();

        const val = Number($($(this).data("input")).val());

        let action = '';

        if (route == 'produtos')
            action = compra ? 'compra' : 'venda';

        if (!val) {
            const routeURL = action ? `/${route}/all/${action}` : `/${route}/all`;

            $.get(routeURL, function(data) {

            })

            .done(function(data) {
                fillDataTable(data, route);
            })

            .fail(function() {
                alert("Erro na busca!");
            });
        }
        else {
            const routeURL = action ? `/${route}/${val}/findById/${action}` : `/${route}/${val}/findById`;

            $.get(routeURL, function(data) {

            })

            .done(function(data) {
                fillDataTable(data, route);
            })

            .fail(function() {
                alert("Erro na busca!");
            });;
        }
    });

    $("#form-delete .form-control, #form-delete .btn-search").each(function() {
        $(this).attr("readonly", true)
        $(this).attr("disabled", true)
    });
});

function fillDataTable(result, route) {
    let dados = [];

    if (result && result[0] != null) {
        dados = result.data
            ? result.data.map(obj => Object.values(obj))
            : result.map(obj => Object.values(obj))
    }

    if (!$.fn.DataTable.isDataTable(`#modal-${route} .table`)) {
        table = $(`#modal-${route} .table`).DataTable({
            data: dados,
            dom: '<"row options-bar"<"col-md-6"f>B>rtip',
            select: true,
            buttons: [
                {
                    text: '+ Adicionar',
                    className: 'btn btn-primary',
                    action: function (e, dt, node, config) {
                        $(`#modal-${route}-create`).modal('show');
                    }
                }
            ],
        });
    } else {
        table.clear().draw();
        table.rows.add(dados).draw();
    }
}

function getPercentual(num, per)
{
    return (num / 100) * per;
}

// COMPRA E VENDA
function mostrarDetalhesProduto(detalhesProduto, alterar = false) {
    $("#produto_cod").val(detalhesProduto.id);
    $("#descricao").val(detalhesProduto.descricao);
    $("#unidade").val(detalhesProduto.unidade);
    $("#categoria").val(detalhesProduto.categoria);

    if (alterar) {
        $("#quantidade").val(detalhesProduto.quantidade);
        $("#valor").val(detalhesProduto.valor);
        $("#total").val(detalhesProduto.total);
        $("#add-item").attr("disabled", false);
    } else {
        $("#add-item").attr("disabled", true);
        $("#quantidade, #valor, #total").val('');
    }

    if (venda) {
        $("#valor").val(detalhesProduto.preco.toFixed(2));
        $("#estoque").val(detalhesProduto.estoque);
    }

    $("#modal-detalhes-produto").modal("show");
}

function listarProdutos(dadosProduto) {
    if (listaProdutos) {
        listaProdutos.rows( { selected: true } ).remove().draw(false);
    } else {
        gerarListaProdutos();
    }

    listaProdutos.row.add([
        `<input type='hidden' class='produto_id'  name='produto_id[]'  value='${dadosProduto.id}' /> ${dadosProduto.id}`,
        `<input type='hidden' class='produto'     name='produto[]'     value='${dadosProduto.descricao}' /> ${dadosProduto.descricao}`,
        `<input type='hidden' class='produto_und' name='produto_und[]' value='${dadosProduto.unidade}' /> ${dadosProduto.unidade}`,
        `<input type='hidden' class='produto_cat' name='produto_cat[]' value='${dadosProduto.categoria}' /> ${dadosProduto.categoria}`,
        `<input type='hidden' class='produto_qtd' name='produto_qtd[]' value='${dadosProduto.qtd}' /> ${dadosProduto.qtd}`,
        `<input type='hidden' class='produto_val' name='produto_val[]' value='${dadosProduto.val}' /> ${dadosProduto.valTexto}`,
        `<input type='hidden' class='produto_tot' name='produto_tot[]' value='${dadosProduto.total}' /> ${dadosProduto.totalTexto}`,
    ]).draw(false);
}

function gerarListaProdutos() {
    const tituloValor = $("#form-compra").length ? 'Valor' : 'Preço';

    if (!$.fn.DataTable.isDataTable('#produtos-table')) {
        listaProdutos = $('#produtos-table').DataTable({
            dom: '<"row"<"col-md-4">>rt',
            columns: [
                { title: 'Cód.', width: '5%', className: 'text-center' },
                { title: 'Produto', width: '30%' },
                { title: 'Und.', width: '5%', className: 'text-center' },
                { title: 'Categoria', width: '25%' },
                { title: 'Qtd.', width: '5%', className: 'text-center' },
                { title: tituloValor, width: '15%', className: 'text-right' },
                { title: 'Subtotal', width: '15%', className: 'text-right' },
                {
                    title: 'Ações',
                    className: 'px-2 text-center',
                    render: data =>
                        `<div class="btn-group btn-group-sm">
                            <button class='btn btn-warning' onclick='alterarProduto(this)'>
                                <i class="fa fa-edit text-white"></i>
                            </button>
                            <button class='btn btn-danger' onclick='removerProduto(this)'>
                                <i class="fa fa-trash-alt text-white"></i>
                            </button>
                         </div>`
                }
            ],
            fixedHeader: {
                header: true,
                footer: true,
            },
            bSort: false,
            language: {
              emptyTable: "Nenhum produto selecionado."
            }
        });
    }
}

function listarDuplicatas(duplicatas) {
    !listaDuplicatas ? gerarListaDuplicatas() : listaDuplicatas.rows().remove().draw(false);

    duplicatas.map(function(duplicata) {
        listaDuplicatas.row.add([
            `<input type='hidden' class='parcela'         name='parcela[]'         value='${duplicata.numParcela}' /> ${duplicata.numParcela}`,
            `<input type='hidden' class='forma_pagamento' name='forma_pagamento[]' value='${duplicata.formaPagamento}' /> ${duplicata.formaPagamento}`,
            `<input type='hidden' class='vencimento'      name='vencimento[]'      value='${duplicata.vencimento}' /> ${duplicata.vencimento}`,
            `<input type='hidden' class='valor_parcela'   name='valor_parcela[]'   value='${duplicata.valParcela}' /> ${duplicata.valParcelaTexto}`,
        ]).draw(false);
    });
}

function gerarListaDuplicatas() {
    if (!$.fn.DataTable.isDataTable('#duplicatas-table')) {
        listaDuplicatas = $('#duplicatas-table').DataTable({
            dom: '<"row"<"col-md-4">>rt',
            columns: [
                { title: 'Duplicata' },
                { title: 'Forma de Pagamento' },
                {
                    title: 'Vencimento',
                    className: 'text-center',
                },
                {
                    title: 'Valor da Parcela',
                    className: 'text-right',
                },
            ],
            bSort: false,
            language: {
                emptyTable: "Nenhuma condição de pagamento selecionada."
            }
        });
    }

    // listaDuplicatas.rows.add(duplicatas).draw();

    if ($("#card-duplicatas").hasClass("collapsed-card"))
        $("#card-duplicatas .card-tools .btn").click();
}

function bloquearCampos() {
    $(".form-control").attr("readonly", true);
    $(".btn-search").attr("disabled", true);
}

function desbloquearAdicionais() {
    $("#frete, #seguro, #despesas").attr("readonly", true);
}

function desbloquearAdicionais() {
    $("#frete, #seguro, #despesas").attr("readonly", false);
}

function calcularAdicionais() {
    return adicionais.frete + adicionais.seguro + adicionais.despesas;
}

function calcularDescontos() {
    return descontos;
}

function calcularTotal(total = 0) {
    if (listaProdutos) {
        let totalPagar    = 0;
        let totalProdutos = 0;

        const itens = listaProdutos.$('tbody tr');

        itens.map(function(i, item) {
            const qtd   = Number($(item).find(".produto_qtd").val());
            const val   = Number($(item).find(".produto_val").val());
            const total = Number($(item).find(".produto_tot").val());

            totalProdutos += val * qtd;
            totalPagar += total;
        });

        if (compra)
            totalPagar += calcularAdicionais();
        else
            totalPagar -= calcularDescontos();

        $("#total_produtos").val(totalProdutos.toFixed(2));
        $("#total_pagar, #total_venda").val(totalPagar.toFixed(2));
        $("#card-produtos strong").html(`<span class="mr-2 text-gray">Total à Pagar: </span>${formatarValor(totalPagar)}`);
    }
}

function formatarValor(valor) {
    return valor.toLocaleString("pt-BR", {
        style: "currency",
        currency: "BRL",
    });
}

