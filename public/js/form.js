var listaProdutos, listaDuplicatas = null;
var fieldIndex, idBusca = 0;
var sofreuAlteracao = false;
var produtosInseridos = Array();
var produtosQuantidade = Array();

var dt = {
    paises: null,
    estados: null,
    cidades: null,
};

var adicionais = {
    "frete"    : Number($("#frete").val()),
    "seguro"   : Number($("#seguro").val()),
    "despesas" : Number($("#despesas").val()),
}

var descontos = Number($("#descontos").val());

const compra = $("#form-compra").length;
const venda  = $("#form-venda").length;

const alertDanger = Swal.mixin({
    customClass: {
        confirmButton: 'swal2-confirm swal2-styled bg-danger',
        cancelButton:  'swal2-cancel swal2-styled bg-secondary',
    },
});

const alertCancelDanger = Swal.mixin({
    customClass: {
        confirmButton: 'swal2-confirm swal2-styled bg-danger',
    },
});

const alertWarning = Swal.mixin({
    customClass: {
        confirmButton: 'swal2-confirm swal2-styled bg-primary',
    },
});

const typePassword = Swal.mixin({
    customClass: {
        confirmButton: 'swal2-confirm swal2-styled bg-primary',
        cancelButton:  'swal2-cancel swal2-styled bg-secondary',
    },
});

$(document).ready(function() {
    tableList = $("#table").DataTable({
        dom: "<'row options-bar'<'col-md-4'f>l>rtip",
        fixedHeader: true,
        // bSort: false,
        order: [[ 0, "desc" ]]
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

    const url = window.location.pathname;
    const origin = window.location.origin;
    const indexURL = url.indexOf('/', 1);
    const urlPath = url.substr(0, indexURL);

    $("ul.nav-sidebar a").filter(function() {
        return this.href == origin + urlPath;
    }).addClass("active");

    // Botão Cancelar (compra/venda)
    $('#btn-cancel').click(function() {
        alertCancelDanger.fire({
            title: 'Atenção!',
            text: (compra || venda) ?'Os dados referente a este registro serão descartados.' : 'Deseja realmente cancelar este registro?',
            icon: 'error',
            showCloseButton: true,
            confirmButtonText: 'Prosseguir com o cancelamento.',
        }).then((result) => {
            if (result.value) {
                typePassword.fire({
                    input: 'password',
                    title: 'Digite sua senha:',
                    // inputPlaceholder: 'Digite sua senha',
                    inputAttributes: {
                        maxlength: 30,
                        autocapitalize: 'off',
                        autocorrect: 'off',
                        autocomplete: 'off',
                        className: 'form-control',
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Continuar',
                    cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.value && result.isConfirmed) {
                        $("#senha").val(result.value);
                        $('#form-cancel').submit();
                    }
                });
            }
        })
    });

    // Botão Cancelar (voltar tela consulta)
    $('.btn-outline-secondary').click(function(e) {
        if (sofreuAlteracao) {
            e.preventDefault();

            href = $(this).attr('href');

            alertWarning.fire({
                title: 'Atenção!',
                text: 'As alterações feitas serão descartadas.',
                icon: 'warning',
                showCloseButton: true,
                confirmButtonText: 'Continuar mesmo assim.',
            }).then((result) => {
                if (result.value)
                    window.location.href = href;
            });
        }
    });

    // Botão Excluir
    $('#btn-delete').not('.delete').click(function() {
        alertDanger.fire({
            title: 'Você tem certeza?',
            text: 'Esta operação não poderá ser desfeita.',
            icon: 'error',
            showCancelButton: true,
            confirmButtonText: 'Excluir',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.value) {
                $('#form-show').submit();
            }
        });
    });

    // Submit
    // $("button[type=submit]").click(function(e) {
    //     const form = $("form").eq(0);

    //     // const dados = form.serialize();

    //     // console.table(dados);

    //     // return false;

    //     // if (!form.valid()) {
    //         e.preventDefault();
    //     //     console.log('ops');
    //     //     return;
    //     // }

    //     form.submit();
    // });

    // $("button[type=submit]").on("click", function (e) {
    //     var form = $("form")[0];
    //     var isValid = form.checkValidity();
    //     if (!isValid) {
    //         e.preventDefault();
    //         e.stopPropagation();
    //     }
    //     form.classList.add('was-validated');
    //     return false; // For testing only to stay on this page
    // });

    $("#form-compra, #form-venda").submit(function(e) {
        e.preventDefault();

        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "preventDuplicates": true,
        }

        $("#form-errors").hide();
        $('#form-errors .list-unstyled li').remove();

        const routeList = ($(this).attr("id") == "form-compra") ? '/compras' : '/vendas';

        $.post("save", $(this).serialize(), function(data) { })

        .done(function(data) {
            if (data.success)
                window.location.href = routeList;
        })

        .fail(function (request, status, error) {
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

                // Atualiza listagem para exibir item cadastrado
                $(".modal.show").last().find(".btn-search").click();
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

        if (id === idBusca)
            return;

        if (id === 0) {
            $(".btn-search[data-route='produtos']").attr("disabled", false);
            return;
        }

        const route = $(this).data("route");
        const input = $($(this).data("input"));

        let action = '';

        if (route == 'produtos') {
            action = compra ? 'compra' : 'venda';

            if (produtoInserido(id))
                return;
        }

        const routeURL = action ? `/${route}/${id}/findById/${action}` : `/${route}/${id}/findById`;

        $.get(routeURL, function(data) {

            let chave = input.attr("id");

            const dados = data[0];

            if (chave.substr(0, 15) == 'forma_pagamento')
                chave = chave.substr(0, 15);

            (dados) ? input.val(dados[chave]) : input.val("Nenhum registro encontrado.");

            if (route === 'fornecedores' && compra) {
                $('#limite_credito').val(Number(dados.valor_credito));
            } else if (route === 'produtos') {
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
            } else if (route === 'fornecedores') {
                console.table(dados)
            }
        });
    });

    // Seleciona item da modal e coloca os valores nos inputs
    $(document).on("click", ".modal-body tbody tr", function() {
        const source = $(this).parents(".modal").attr("id").replace("modal-", "");

        const data = dt[source].rows({ selected: true }).data()[0];

        const modal = $(this).closest(".modal");

        const field = modal.data("field");

        const id = data[0];
        const descricao = data[1];

        if (field === 'fornecedor' && compra) {
            $('#limite_credito').val(Number(data[4]))
        }
        if (field === "forma_pagamento[]") {
            $(".forma-pagamento-id").eq(fieldIndex).val(id);
            $(".forma-pagamento").eq(fieldIndex).val(descricao);
        }
        else if (field === "produto") {
            if (produtoInserido(id))
                return;

            let detalhesProduto = {
                "id"        : id,
                "descricao" : descricao,
                "unidade"   : $(this).find("td").eq(2).text(),
                "categoria" : $(this).find("td").eq(3).text(),
                // "custoUltimaCompra" : $(this).find("td").eq(5).text(),
                // "estoque" : $(this).find("td").eq(6).text(),
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
            let valoresParcelas = Array();

            parcelas.map(function(parcela, index) {
                const inputData = $("#form-compra").length ? $("#data_emissao") : $("#data_venda");
                const dataEmissao = new Date(inputData.val());

                var prazo = new Date();

                prazo.setDate(dataEmissao.getDate() + parcela.prazo + 1);

                const numParcela  = compra ? `${$("#num_nota").val()}/${parcela.numero}` : parcela.numero;
                const formaPagamento = parcela.forma_pagamento;
                const vencimento = prazo.toLocaleDateString();

                let valParcela = calcularParcela(totalPagar, parcela.porcentagem);

                if (index === parcelas.length - 1) {
                    const totalDuplicatas = valParcela + valoresParcelas.reduce((count, val) => count + val, 0);

                    // Ajustar centavos
                    if (totalPagar != totalDuplicatas)
                        valParcela += totalPagar - totalDuplicatas;
                }

                const valParcelaTexto = formatarReais(valParcela);

                const duplicata = {
                    numParcela,
                    formaPagamento,
                    vencimento,
                    valParcela,
                    valParcelaTexto,
                };

                duplicatas.push(duplicata);
                valoresParcelas.push(valParcela);
            });

            bloquearCampos();
            listarDuplicatas(duplicatas);
        }

        const inputId = $(`input[name='${field}_id']`).eq(0);
        const inputDescricao = $(`input[name='${field}']`).eq(0);

        inputId.val(id).change();
        inputDescricao.val(descricao).change();

        // inputId.removeClass('is-invalid').addClass('is-valid');
        // inputDescricao.removeClass('is-invalid').addClass('is-valid');

        inputId.parents('.form-group').find('.is-invalid').remove();
        inputDescricao.parents('.form-group').find('.is-invalid').remove();

        modal.modal("hide");
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

            $("#cpf_cnpj, #rg_inscricao_estadual").val('');
        } else if (id === "juridica") {
            $("#nome_fantasia").prev().text("Nome Fantasia");

            $("#cpf_cnpj").prev().text("CNPJ");
            $("#cpf_cnpj").addClass("cnpj");
            $("#cpf_cnpj").removeClass("cpf");

            $("#cpf_cnpj").attr("placeholder", "__.___.___/____-__");

            $("#rg_inscricao_estadual").prev().text("Inscrição Estadual");

            $("#cpf_cnpj, #rg_inscricao_estadual").val('');
        }
    });

    $(document).on("click", ".btn-search", function(e) {
        e.preventDefault();

        let route = null;

        if ($("#table").length)
            route = $("#table").data("route");
        else if ($(this).data("route"))
            route = $(this).data("route");
        else {
            route = $(".modal.show").last().not("[id*='create']").attr("id").replace("modal-", "");
        }
        // else if (!$(".modal").hasClass("show"))
        //     route = $(this).data("route");
        // else
        //     route = $(".modal.show").not("[id*='create']").attr("id").replace("modal-", "");

        if (route === 'formas-pagamento')
            fieldIndex = $(this).parents('tr').index();

        const id = Number($($(this).data("input")).val());

        let action = '';

        if (route == 'produtos')
            action = compra ? 'compra' : 'venda';

        if (!id) {
            const routeURL = action ? `/${route}/all/${action}` : `/${route}/all`;

            $.get(routeURL, function(data) {

            })

            .done(function(data) {
                listarItensModal(data, route);
            })

            .fail(function() {
                // alert("Erro na busca!");
            });
        }
        else {
            const routeURL = action ? `/${route}/${id}/findById/${action}` : `/${route}/${id}/findById`;

            $.get(routeURL, function(data) {

            })

            .done(function(data) {
                listarItensModal(data, route);
            })

            .fail(function() {
                // alert("Erro na busca!");
            });
        }
    });

    $("#form-show .form-control, #form-show .btn-search").each(function() {
        $(this).attr("readonly", true);
        $(this).attr("disabled", true);
    });
});

function listarItensModal(result, route) {
    let dados = [];

    if (result && result[0] != null) {
        dados = result.data
            ? result.data.map(obj => Object.values(obj))
            : result.map(obj => Object.values(obj))
    }

    if (!$.fn.DataTable.isDataTable(`#modal-${route} .table`)) {
        dt[route] = $(`#modal-${route} .table`).DataTable({
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
        dt[route].clear().draw();
        dt[route].rows.add(dados).draw();
    }

    $(`#modal-${route} .overlay`).fadeOut();
}

function calcularParcela(num, per)
{
    const totalParcela = (num / 100) * per;
    return toFixed(totalParcela, 2);
}

function ajustarTotalProduto(total = 0) {
    $("#total strong").html(`<span class="mr-2 text-gray">Total:</span>${formatarReais(total)}`);
}

function ajustarTotalGeral(total = 0) {
    const totalTexto = compra ? 'Total da Compra' : 'Total da Venda';
    $(".card-footer strong").html(`<span class="mr-2 text-gray">${totalTexto}:</span>${formatarReais(total)}`);
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
        ajustarTotalProduto(detalhesProduto.total);
        $("#add-item").attr("disabled", false);
    } else {
        $("#add-item").attr("disabled", true);
        $("#quantidade, #valor").val('');
        ajustarTotalProduto();
    }

    if (venda) {
        $("#valor").val(detalhesProduto.preco);
        $("#estoque").val(detalhesProduto.estoque);
    }

    $("#modal-detalhes-produto").modal("show");
}

function produtoInserido(id) {
    if (produtosInseridos.includes(id)) {
        alertDanger.fire({
            title: "Erro!",
            text: "Este produto já foi inserido na lista.",
            icon: "error",
            showCancelButton: false,
            showConfirmButton: false,
            showCloseButton: true,
        });

        $(".btn-search[data-route='produtos']").attr("disabled", true);
        return true;
    }

    $(".btn-search[data-route='produtos']").attr("disabled", false);
    return false;
}

function listarProdutos(dadosProduto) {
    if (listaProdutos) {
        listaProdutos.rows( { selected: true } ).remove().draw(false);
    } else {
        gerarListaProdutos();
    }

    listaProdutos.row.add([
        `<input type='hidden' class='produto_id'  name='produto_id[]'  value='${dadosProduto.id}' data-estoque='${dadosProduto.estoque ?? ''}' /> ${dadosProduto.id}`,
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
                        `<div class="btn-group btn-group-xs">
                            <button class='btn btn-warning' onclick='alterarProduto(this, event)'>
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
            select: {
                style:    'os',
                selector: 'td'
            },
            language: {
                emptyTable: 'Listagem de Produtos'
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
                { title: 'Parcela' },
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
                emptyTable: 'Listagem de Parcelas'
            }
        });
    }

    // $("#descontos").keydown(function(e) {
    //     console.log($(this).val());
    //     if ($(this).val() > $("#total_pagar").val()) {
    //         e.preventDefault();
    //         return;
    //     }
    // });

    // listaDuplicatas.rows.add(duplicatas).draw();
}

function bloquearCampos() {
    $('#form-compra, #forma-venda, #form-cancel, #form-conta').find('.form-group .form-control').not('#condicao_pagamento_id').attr('readonly', true);
    $('#form-compra, #forma-venda, #form-cancel, #form-conta').find('.btn-danger, .btn-warning').not('#btn-cancel').prop('disabled', true);
    $('#form-compra, #forma-venda, #form-cancel, #form-conta').find('.form-group .btn-search').not('#ipt-condicao-pagamento .btn-search').prop('disabled', true);
}

function desbloquearAdicionais() {
    $('#frete, #seguro, #despesas').prop('readonly', true);
}

function desbloquearAdicionais() {
    $('#frete, #seguro, #despesas').prop('readonly', false);
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
        else {
            totalPagar -= calcularDescontos();
        }

        $("#descontos").attr("max", totalProdutos);
        $("#total_produtos").val(totalProdutos.toFixed(2));
        $("#total_pagar, #total_venda").val(totalPagar.toFixed(2));
        ajustarTotalGeral(totalPagar);
    }
}

function formatarReais(valor) {
    return valor.toLocaleString("pt-BR", {
        style: "currency",
        currency: "BRL",
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
}

function toFixed(num, fixed) {
    var re = new RegExp('^-?\\d+(?:\.\\d{0,' + (fixed || -1) + '})?');
    return Number(num.toString().match(re)[0]);
}
