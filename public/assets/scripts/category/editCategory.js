(function() {

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

    $('#category-code').attr({'readonly': true});

    $('main form').submit(function(evt) {
        evt.preventDefault();
        evt.stopPropagation();

        $.ajax({
            type: 'POST',
            contentType: 'application/json',
            url: '/categories/edit',
            dataType: 'json',
            data: JSON.stringify(formToJson($(this).serializeArray()))
        })
        .done(function(data) {
            if (data.status === 'Exists') {
                alertify.alert('Aviso', 'Já existe uma categoria com o "nome" informado.');
                return;
            }

            location.href = '/categories';
        });
    });

})();