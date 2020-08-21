$(document).ready(function() {

    var url = window.location;

    var element = $('ul.nav-sidebar a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active');

    // console.log(element)

    // if (element.is('a')) {
    //     element.parents('li.nav-item.has-treeview').click()
    // }

    var table, listaProdutos, listaContasPagar = null;

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
        dom: "<'row options-bar'<'col-md-4'f>l>rtip",
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

        // console.table(data)

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
        else if (field === 'condicao_pagamento' && $("#total_pagar").length) { // Inserir na lista de contas à pagar
            const totalPagar = Number($("#total_pagar").val());

            // console.table(data)
            const parcelas = data[6];

            let duplicatas = [];

            parcelas.map(function(parcela) {
                const dataEmissao = new Date($("#data_emissao").val());

                var prazo = new Date();

                prazo.setDate(dataEmissao.getDate() + parcela.prazo + 2);

                const numParcela = `${$("#numero").val()}/${parcela.numero}`;
                const vencimento = prazo.toLocaleDateString();
                const valParcela = getPercentual(totalPagar, parcela.porcentagem);

                const duplicata = {
                    0: numParcela,
                    1: vencimento,
                    2: `R$ ${valParcela}`,
                };

                duplicatas.push(duplicata);
            });

            listarDuplicatas(duplicatas);
        }
        // else {
            $(`input[name='${field}_id']`).eq(0).val(id);
            $(`input[name='${field}']`).eq(0).val(descricao);
        // }

        modal.modal('hide');
    });

    function mostrarDetalhesProduto(detalhesProduto, alterar = false) {
        $("#produto_cod").val(detalhesProduto.id);
        $("#descricao").val(detalhesProduto.descricao);
        $("#unidade").val(detalhesProduto.unidade);
        // $("#categoria").val(detalhesProduto.categoria);

        if (alterar) {
            $("#quantidade").val(detalhesProduto.quantidade);
            $("#valor").val(detalhesProduto.valor);
            $("#total").val(detalhesProduto.total);
        } else {
            $("#quantidade, #valor, #total").val('');
        }

        $("#modal-detalhes-produto").modal("show");
    }

    function calcularAdicionais() {
        return adicionais.frete + adicionais.seguro + adicionais.despesas;
    }

    function calcularTotal(total = 0) {
        if (listaProdutos) {

            let totalPagar    = 0;
            let totalProdutos = 0;

            const itens = listaProdutos.rows().data();

            itens.map(function(item) {
                totalProdutos += Number(item[4].replace("R$ ", "")) * item[3];
                totalPagar += Number(item[5].replace("R$ ", ""));
            });

            $("#total_produtos").val(totalProdutos.toFixed(2));
            $("#total_pagar").val((totalPagar + calcularAdicionais()).toFixed(2));
        } else {
            $("#total_produtos").val(total.toFixed(2));
        }
    }

    function getPercentual(num, per)
    {
        return ((num / 100) * per).toFixed(2);
    }

    function listarProdutos(dadosProduto) {
        if (listaProdutos) {
            listaProdutos.rows( { selected: true } ).remove().draw(false);
        } else {
            listaProdutos = $('#produtos-table').DataTable({
                dom: '<"row"<"col-md-4">>rt',
                columns: [
                    { title: 'Cód.' },
                    { title: 'Produto' },
                    { title: 'Und.' },
                    { title: 'Qtd.' },
                    { title: 'Valor' },
                    { title: 'Valor Total' },
                    {
                        title: 'Ações',
                        className: 'text-center',
                        render: data =>
                            `<div class="btn-group btn-group-sm">
                                <i class="fa fa-edit py-0 btn text-warning alterar"></i>
                                <i class="fa fa-trash-alt py-0 btn text-danger remover"></i>
                             </div>`
                    }
                ],
                columnDefs: [
                    {
                        targets: 0,
                            //"className": "select-checkbox",
                        checkboxes: {
                            "selectRow": true
                        }
                    }
                ],
                select: {
                    style: "multi"
                },
                bSort: false,
            });
        }

        listaProdutos.row.add(dadosProduto).draw();
    }

    function listarDuplicatas(duplicatas) {
        if (listaContasPagar)
            listaContasPagar.clear().draw();
        else {
            listaContasPagar = $('#contas-pagar-table').DataTable({
                "dom": '<"row"<"col-md-4">>rt',
                columns: [
                    { title: 'Duplicata' },
                    { title: 'Vencimento' },
                    { title: 'Valor da Parcela' },
                ],
                bSort: false,
            });
        }

        listaContasPagar.rows.add(duplicatas).draw();

        if ($("#card-contas-pagar").hasClass("collapsed-card"))
            $("#card-contas-pagar .card-tools .btn").click();
    }

    function desbloquearAdicionais() {
        if ($("#frete").is(":disabled") && $("#seguro").is(":disabled") && $("#despesas").is(":disabled"))
            $("#frete, #seguro, #despesas").attr("disabled", false);
    }

    $("#modelo, #serie, #numero, #data_emissao, #data_chegada").change(function() {
        let vazio = $("#modelo, #serie, #numero, #data_emissao, #data_chegada").filter(function(index, item) {
            return $(item).val() === "";
        });

        if (vazio.length === 0) {
            $("#produto_id, .btn-search[data-input='#produto_id']").attr("disabled", false);
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

    var adicionais = {
        "frete"    : 0,
        "seguro"   : 0,
        "despesas" : 0,
    }

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
            "id"         : row.find("td").eq(0).text(),
            "descricao"  : row.find("td").eq(1).text(),
            "unidade"    : row.find("td").eq(2).text(),
            "quantidade" : row.find("td").eq(3).text(),
            "valor"      : Number(row.find("td").eq(4).text().replace("R$ ", "")).toFixed(2),
            "total"      : Number(row.find("td").eq(5).text().replace("R$ ", "")).toFixed(2),
        };

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
        ]

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

        if (!$(".modal").hasClass("show"))
            route = $(this).data("route");

        if (route === "formas-pagamento")
            fieldIndex = $(this).parents("tr").index();

        const val = Number($($(this).data("input")).val());

        if (!val) {
            $.get(`/${route}/all`, function(data) {
                fillDataTable(data, route);
            });
        } else {
            $.get(`/${route}/${val}/findById`, function(data) {
                fillDataTable(data, route);
            });
        }
    });

    function fillDataTable(result, route) {
        const dados = result.data
            ? result.data.map(obj => Object.values(obj))
            : result.map(obj => Object.values(obj))

        console.table(dados)

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

    $("#form-delete .form-control, #form-delete .btn-search").each(function() {
        $(this).attr("readonly", true)
        $(this).attr("disabled", true)
    });
})
