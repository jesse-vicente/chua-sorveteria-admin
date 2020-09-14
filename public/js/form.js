var table, listaProdutos, listaDuplicatas = null;

var fieldIndex = 0;

var adicionais = {
    "frete"    : Number($("#frete").val()),
    "seguro"   : Number($("#seguro").val()),
    "despesas" : Number($("#despesas").val()),
}

var sofreuAlteracao = false;

$(document).ready(function() {

    tableList = $("#table").DataTable({
        dom: "<'row options-bar'<'col-md-4'f>l>rtip",
        fixedHeader: true,
        bSort: false,
    });

    $(".form-control").change(function() {
        sofreuAlteracao = true;
    });

    // //Creamos una fila en el head de la tabla y lo clonamos para cada columna
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

    if ($('form').length) {
        $(".content-wrapper .container-fluid").attr('class', 'd-flex justify-content-center')
    }

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
            cancelButton:  'btn btn-secondary'
        },
        buttonsStyling: false
    });

    const confirmCancel = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary',
        },
        buttonsStyling: false
    });

    // Cancelar
    $(".btn-outline-secondary").click(function(e) {
        if (sofreuAlteracao) {
            e.preventDefault();

            href = $(this).attr('href');

            confirmCancel.fire({
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

    // Excluir
    $("#delete-entry").not(".delete").click(function() {
        confirmDelete.fire({
            title: "Aviso!",
            text: "Esta operação não poderá ser revertida.",
            icon: "warning",
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

    $("#form-compra").submit(function(e) {
        e.preventDefault();

        $("#form-errors").hide();
        $('#form-errors .list-unstyled li').remove();

        $.post("save", $(this).serialize(), function(data) {
            console.log(data)
        })

        .done(function(data) {
            console.table(data);
            // window.location.href = '/compras';
        })

        .fail(function (request, status, error) {
            $("html, body").animate({scrollTop: "0px"}, 300);

            $.each(request.responseJSON.errors, function(key,value) {
                console.log(key + ' - ' + value)
                $(`#form-errors .list-unstyled`).append(`<li><i class='fa fa-info-circle'></i> ${value}</li>`);
            });

            $("#form-errors").slideDown();
        });
    });

    $("#form-compra-cancel").submit(function(e) {
        e.preventDefault();

        $('.invalid-feedback').hide();

        $.post(`${$(this).attr('key')}/update`, $(this).serialize(), function(data) {
            console.table(data)
        })

        .done(function(data) {
            // window.location.href = '/compras';
        })

        .fail(function (request, status, error) {
            // $('[name="mandapName"]').next('span').html(request.responseJSON.errors.mandapName);
            //.......
            // console.table(request.responseJSON.errors)
            $.each(request.responseJSON.errors, function(key,value) {
                console.log(key + ' - ' + value)
                $(`.invalid-feedback[ref='${key}']`).html(`<strong>${value}</strong>`).show();
            });
        });
    });

    // $(".modal form").attr("action", "#");
    // $(".modal form").attr("onsubmit", "return false");

    $(".modal form").submit(function(e) {

    })

    $(".btn-save-modal").click(function() {
        const form = $(this).parents(".modal").find("form");
        const route = form.data("route");

        // // console.log(route)
        // const data = form.serialize();

        console.log(data)

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

    var idAtual = 0;

    $(document).on("focusin" ,".form-control[id*='_id']", function() {
        idAtual = Number($(this).val());
    });

    // Atualiza o campo ao mudar valor
    $(document).on("focusout", ".form-control[id*='_id'], .form-control[id*='_id[]']", function() {
        const id = Number($(this).val());

        if (id === idAtual || id === 0)
            return;

        const route = $(this).data("route");

        const input = $($(this).data("input"));

        $.get(`/${route}/${id}/findById`, function(data) {

            const chave = input.attr("id");

            const dados = data[0];

            if (dados)
                input.val(dados[chave])
            else
                input.val("Nenhum registro encontrado.");

            if (route === 'produtos') {
                const detalhesProduto = {
                    'id'        : dados['id'],
                    'descricao' : dados['produto'],
                    'categoria' : dados['categoria'],
                    'unidade'   : dados['unidade'],
                };

                mostrarDetalhesProduto(detalhesProduto)
            } else if (route === 'condicoes-pagamento') {
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
            $(`input[name='forma_pagamento_id[]']`).eq(fieldIndex).val(id);
            $(`input[name='forma_pagamento[]']`).eq(fieldIndex).val(descricao);
        }
        else if (field === 'produto') {
            const detalhesProduto = {
                'id'        : id,
                'descricao' : descricao,
                'unidade'   : $(this).find("td").eq(2).text(),
                // 'categoria' : $(this).find("td").eq(3).text(),
            };

            mostrarDetalhesProduto(detalhesProduto);
        }
        // Inserir na lista de contas à pagar
        else if (field === 'condicao_pagamento' && $("#total_pagar").length) {
            const totalPagar = Number($("#total_pagar").val());

            const parcelas = data[6];

            let duplicatas = Array();

            parcelas.map(function(parcela) {
                const dataEmissao = new Date($("#data_emissao").val());

                var prazo = new Date();

                prazo.setDate(dataEmissao.getDate() + parcela.prazo + 1);

                const numParcela  = `${$("#num_nota").val()}/${parcela.numero}`;
                const vencimento = prazo.toLocaleDateString();
                const valParcela = 'R$ ' + getPercentual(totalPagar, parcela.porcentagem);

                const duplicata = [
                    numParcela,
                    vencimento,
                    valParcela,
                ];

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

    var route = null;

    $(document).on("click", ".btn-search", function(e) {
        e.preventDefault();

        if ($("#table").length)
            route = $("#table").data("route");
        else if (!$(".modal").hasClass("show"))
            route = $(this).data("route");

        if (route === "formas-pagamento")
            fieldIndex = $(this).parents("tr").index();

        const val = Number($($(this).data("input")).val());

        if (!val) {
            $.get(`/${route}/all`, function(data) {

             })

            .done(function(data) {
                fillDataTable(data, route);
            })

            .fail(function() {
                alert("Erro na busca!");
            });
        } else {
            $.get(`/${route}/${val}/findById`, function(data) {

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
    return ((num / 100) * per).toFixed(2);
}

// COMPRA E VENDA
function mostrarDetalhesProduto(detalhesProduto, alterar = false) {
    $("#produto_cod").val(detalhesProduto.id);
    $("#descricao").val(detalhesProduto.descricao);
    $("#unidade").val(detalhesProduto.unidade);
    // $("#categoria").val(detalhesProduto.categoria);

    if (alterar) {
        $("#quantidade").val(detalhesProduto.quantidade);
        $("#valor").val(detalhesProduto.valor);
        $("#total").val(detalhesProduto.total);
        $("#add-item").attr("disabled", false);
    } else {
        $("#add-item").attr("disabled", true);
        $("#quantidade, #valor, #total").val('');
    }

    $("#modal-detalhes-produto").modal("show");
}

function listarProdutos(dadosProduto) {
    if (listaProdutos) {
        listaProdutos.rows( { selected: true } ).remove().draw(false);
    } else {
        // listaProdutos = gerarListaProdutos();
        gerarListaProdutos();
    }

    // listaProdutos.row.add(dadosProduto).draw();
    // console.table(dadosProduto)

    listaProdutos.row.add([
        `<input type='hidden' class='produto_id'  name='produto_id[]'  value='${dadosProduto[0]}' /> ${dadosProduto[0]}`,
        `<input type='hidden' class='produto'     name='produto[]'     value='${dadosProduto[1]}' /> ${dadosProduto[1]}`,
        `<input type='hidden' class='produto_und' name='produto_und[]' value='${dadosProduto[2]}' /> ${dadosProduto[2]}`,
        `<input type='hidden' class='produto_qtd' name='produto_qtd[]' value='${dadosProduto[3]}' /> ${dadosProduto[3]}`,
        `<input type='hidden' class='produto_val' name='produto_val[]' value='${dadosProduto[4]}' /> ${dadosProduto[4]}`,
        `<input type='hidden' class='produto_tot' name='produto_tot[]' value='${dadosProduto[5]}' /> ${dadosProduto[5]}`,
    ]).draw(false);
}

function gerarListaProdutos() {
    if (!$.fn.DataTable.isDataTable('#produtos-table')) {
        listaProdutos = $('#produtos-table').DataTable({
            dom: '<"row"<"col-md-4">>rt',
            columns: [
                { title: 'Cód.', width: '5%', className: 'text-center' },
                { title: 'Produto', width: '35%' },
                { title: 'Und.', width: '5%', className: 'text-center' },
                { title: 'Qtd.', width: '5%', className: 'text-center' },
                { title: 'Valor', width: '15%', className: 'text-right' },
                { title: 'Valor Total', width: '20%', className: 'text-right' },
                {
                    title: 'Ações',
                    width: '20%',
                    className: 'text-center',
                    render: data =>
                        `<div class="btn-group btn-group-sm">
                            <button class='btn btn-warning alterar'>
                                <i class="fa fa-edit text-white"></i>
                            </button>
                            <button class='btn btn-danger remover'>
                                <i class="fa fa-trash-alt text-white"></i>
                            </button>
                         </div>`
                }
            ],
            columnDefs: [
                {
                    targets: 0,
                        "className": "select-checkbox",
                    checkboxes: {
                        "selectRow": true
                    }
                }
            ],
            select: {
                style: "multi"
            },
            bSort: false,
            language: {
              emptyTable: "Nenhum produto selecionado."
            }
        });
    }

    $("#produtos-table .dataTables_empty").addClass("bg-warning");
}

function listarDuplicatas(duplicatas) {
    !listaDuplicatas ? gerarListaDuplicatas() : listaDuplicatas.rows().remove().draw(false);

    duplicatas.map(function(duplicata) {
        listaDuplicatas.row.add([
            `<input type='hidden' class='parcela'       name='parcela[]'       value='${duplicata[0]}' /> ${duplicata[0]}`,
            `<input type='hidden' class='vencimento'    name='vencimento[]'    value='${duplicata[1]}' /> ${duplicata[1]}`,
            `<input type='hidden' class='valor_parcela' name='valor_parcela[]' value='${duplicata[2]}' /> ${duplicata[2]}`,
        ]).draw(false);
    });
}

function gerarListaDuplicatas() {
    if (!$.fn.DataTable.isDataTable('#duplicatas-table')) {
        listaDuplicatas = $('#duplicatas-table').DataTable({
            dom: '<"row"<"col-md-4">>rt',
            columns: [
                { title: 'Duplicata' },
                { title: 'Vencimento' },
                { title: 'Valor da Parcela' },
            ],
            bSort: false,
            language: {
                emptyTable: "Condição de Pagamento não informada."
            }
        });
    }

    // listaDuplicatas.rows.add(duplicatas).draw();

    if ($("#card-duplicatas").hasClass("collapsed-card"))
        $("#card-duplicatas .card-tools .btn").click();

    $("#duplicatas-table .dataTables_empty").addClass("bg-warning");
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

function calcularTotal(total = 0) {
    if (listaProdutos) {

        let totalPagar    = 0;
        let totalProdutos = 0;

        const itens = listaProdutos.$('tbody tr');

        itens.map(function(i, item) {

            const qtd   = Number($(item).find(".produto_qtd").val());
            const val   = parseFloat(Number($(item).find(".produto_val").val().replace("R$ ", "")));
            const total = parseFloat(Number($(item).find(".produto_tot").val().replace("R$ ", "")));

            totalProdutos += val * qtd;
            totalPagar += total;
        });

        totalPagar += calcularAdicionais();

        console.log(totalProdutos);
        console.log(totalPagar);

        $("#total_produtos").val(totalProdutos.toFixed(2));
        $("#total_pagar").val(totalPagar.toFixed(2));
        $("#card-produtos strong").html(`<span class="mr-2 text-gray">Total à Pagar: </span>R$ ${totalPagar.toFixed(2)}`);
    }
}

