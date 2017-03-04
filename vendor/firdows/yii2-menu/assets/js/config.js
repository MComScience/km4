$(document).ready(function () {
    toastr.options = {
        "debug": false,
        "newestOnTop": false,
        "positionClass": "toast-top-center",
        "closeButton": true,
        "toastClass": "animated fadeInDown",
    };

    var updateOutput = function (e) {
        var list = e.length ? e : $(e.target), output = list.data('output');

        $.ajax({
            method: "POST",
            url: "index.php?r=menu/default/saveondrag",
            data: {
                list: list.nestable('serialize')
            },
            success: function (data) {
                toastr.info('The changes have been Saved!');
            },
        }).fail(function (jqXHR, textStatus, errorThrown) {
            alert("Unable to save new list order: " + errorThrown);
        });
    };

    $('.dd').nestable({
        group: 1,
        maxDepth: 4,
    }).on('change', updateOutput);
});
