(function() {

    function createSelectOption(data) {
        var option = '';

        for (var i = 0, len = data.length; i < len; i++) {
            option += '<option>' + data[i].nome + '</option>\n';
        }

        $('#category').append(option);
    }

    function formToJson(data) {
        var json = {},
            objs = JSON.parse(JSON.stringify(data));

        for (var i = 0; i < objs.length; i++) {
            for (var prop in objs[i]) {
                if (typeof json[objs[i].name] === 'undefined') {
                    json[objs[i].name] = objs[i].value;
                } else {
                    json[objs[i].name] += '|' + objs[i].value;
                }
                break;
            }
        }

        return json;
    }

    $.ajax({
        type: 'GET',
        contentType: 'application/json',
        url: '/categories/list',
        dataType: 'json'
    })
    .done(function(data) {
        createSelectOption(data);
    });

    $('#price').mask('000.000.000.000.000,00', {reverse: true});

    $('main form').submit(function(evt) {
        evt.preventDefault();
        evt.stopPropagation();

        var self = this,
            jsonData = formToJson($(this).serializeArray());

        jsonData.price = jsonData.price.replace('.', '').replace(',', '.');

        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: '/products/add',
            dataType: 'json',
            data: JSON.stringify(jsonData)
        })
        .done(function(data) {
            if (data.status === 'Exists') {
                alertify.alert('Aviso', 'Já existe um produto com o "código" informado.');
                return;
            }

            $(self)[0].reset();
            alertify.success('Produto adicionado');
        });
    });

})();