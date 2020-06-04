$(document).ready(function() {

    var table = null;

    $(".table").DataTable({
        "dom": '<"row justify-content-md-between"<"col-md-4"f>l>rtip',
    });

    $(document).on( 'click', '.modal-body tbody tr', function() {
        let dados = table.rows( { selected: true } ).data()[0];
        console.log(dados[1])

        let field = $('.modal.show').data('field');

        $('.modal.show').modal('hide');

        $(`input[name='${field}_id']`).val(dados[0]);
        $(`input[name='${field}']`).val(dados[1]);
    });

    $('.custom-control-input').click(function() {
        let id = $(this).attr('id');

        if (id === 'fisica') {
            $('#nome_fantasia').prev().text('Apelido');
            $('#cpf_cnpj').prev().text('CPF *');
            $('#inscricao_estadual').prev().text('RG');
        } else if (id === 'juridica') {
            $('#nome_fantasia').prev().text('Nome Fantasia');
            $('#cpf_cnpj').prev().text('CNPJ *');
            $('#inscricao_estadual').prev().text('Inscrição Estadual');
        }
    });

    // $(document).on("click", ".modal .btn-search", function(e) {
    //     e.preventDefault();
    // });

    var route = null;

    $(document).on("click", ".btn-search", function(e) {
        e.preventDefault();

        let val = $(this).parent().prev().val();

        if (!$('.modal').hasClass('show'))
            route = $(this).data("route");

        // console.log(val, route)

        $.get(`/${route}/search`, `q=${val}`, function(data) {
            $(`#modal-${route} .table-responsive`).html(data);
            // console.log(data)
            table = $(`#modal-${route} .table`).DataTable({
                "dom": '<"row justify-content-md-between"<"col-md-6"f>l>rtip',
                select: true,
            })
        })
    });
})
