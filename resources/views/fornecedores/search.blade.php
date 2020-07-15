<table class="table table-hover" id="table">
    <thead>
        <tr>
            <th>Cód.</th>
            <th>Fornecedor</th>
            <th>WhatsApp</th>
        </tr>
    </thead>
    <tbody>
    @forelse ($fornecedores as $fornecedor)
        <tr>
            <td>{{ $fornecedor->getId() }}</td>
            <td>{{ $fornecedor->getRazaoSocial() }}</td>
            <td>{{ $fornecedor->getWhatsapp() }}</td>
        </tr>
    @empty
    @endforelse
    </tbody>
</table>
