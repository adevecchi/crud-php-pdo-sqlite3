(function() {

    function createTableRow(data) {
        var tableRow;

        for (var i = 0, len = data.length; i < len; i++) {
            tableRow  = '<tr class="data-row">';
            tableRow += '  <td class="data-grid-td">';
            tableRow += '    <span class="data-grid-cell-content">' + data[i].nome + '</span>';
            tableRow += '  </td>';
              
            tableRow += '  <td class="data-grid-td">';
            tableRow += '    <span class="data-grid-cell-content">' + data[i].codigo + '</span>';
            tableRow += '  </td>';
              
            tableRow += '  <td class="data-grid-td">';
            tableRow += '    <div class="actions">';
            tableRow += '      <div class="action edit"><span>Edit</span></div>';
            tableRow += '      <div class="action delete"><span>Delete</span></div>';
            tableRow += '    </div>';
            tableRow += '  </td>';
            tableRow += '</tr>';

            $('table.data-grid tbody').append(tableRow);
        }
    }

    $.ajax({
        type: 'GET',
        contentType: 'application/json',
        url: '/categories/list',
        dataType: 'json'
    })
    .done(function(data) {
        createTableRow(data);
    });

    $('table tbody').on('click', '.action.edit>span', function(evt) {
        var $tr = $(this).closest('tr'),
            code = $.trim($tr.find('td:nth-child(2)').text());

        location.href = '/categories/edit/' + code;
    });

    $('table tbody').on('click', '.action.delete>span', function(evt) {
        var $tr = $(this).closest('tr'),
            name = $.trim($tr.find('td:nth-child(1)').text()),
            code = $.trim($tr.find('td:nth-child(2)').text());

        alertify
            .confirm(
                'Excluir', 
                'Deseja excluir categoria "'+name+'" ?', 
                function(){
                    $.ajax({
                        type: 'GET',
                        contentType: 'application/json',
                        url: '/categories/delete/' + code,
                        dataType: 'json'
                    })
                    .done(function(data) {
                        $tr.remove();
                    });
                }, 
                function(){ }
            )
            .setting({
                'labels': {ok:'Sim', cancel:'Não'},
                'defaultFocus': 'cancel'
            });
    });

})();