(function() {

    function createSelectOption(data) {
        var option = '';

        for (var i = 0, len = data.length; i < len; i++) {
            option += '<option>' + data[i].nome + '</option>\n';
        }

        $('#category').append(option);
    }

    function formToJson(datas) {
        var json = {},
            objs = JSON.parse(JSON.stringify(datas));

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
        $("#category").val(categoria.split('|'));
    });

    $('#sku').attr({'readonly': true});
    $('#price').mask('000.000.000.000.000,00', {reverse: true});

    $('main form').submit(function(evt) {
        evt.preventDefault();
        evt.stopPropagation();

        var jsonData = formToJson($(this).serializeArray());

        jsonData.price = jsonData.price.replace('.', '').replace(',', '.');

        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: '/products/edit',
            dataType: 'json',
            data: JSON.stringify(jsonData)
        })
        .done(function(data) {
            location.href = '/products';
        });
    });

})();