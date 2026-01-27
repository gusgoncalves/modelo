function openCreate() {
    $('#crudForm')[0].reset();
    $('#crud-id').val('');
    $('#crudModal').modal('show');
}

function openEdit(id) {
    $.get(endpoint + '/edit/' + id, function (data) {
        for (let campo in data) {
            $('[name="'+campo+'"]').val(data[campo]);
        }
        $('#crud-id').val(id);
        $('#crudModal').modal('show');
    });
}

$('#crudForm').on('submit', function (e) {
    e.preventDefault();

    $.post(endpoint + '/save', $(this).serialize(), function () {
        $('#crudModal').modal('hide');
        $('#datatable').DataTable().ajax.reload(null, false);
    });
});
function remover(id) {
    if (!confirm('Deseja realmente excluir este registro?')) return;

    $.post(endpoint + '/delete/' + id, function (resp) {
        if (resp.success) {
            $('#datatable').DataTable().ajax.reload(null, false);
        } else {
            alert(resp.message ?? 'Erro ao remover');
        }
    }).fail(function () {
        alert('Erro ao comunicar com o servidor');
    });
}
