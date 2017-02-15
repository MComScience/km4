$("#formmail").bootstrapValidator();
$(document).ready(function () {
    $(".modal-mail").on('show.bs.modal', function () {
        setTimeout(function () {
        }, 0);
    });
    $('#summernote').summernote({
        height: 150, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: true,
        toolbar: [
            ['headline', ['style']],
            ['style', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
            ['textsize', ['fontsize']],
            ['alignment', ['ul', 'ol', 'paragraph', 'lineheight']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
        hint: {
            words: ['apple', 'orange', 'watermelon', 'lemon'],
            match: /\b(\w{1,})$/,
            search: function (keyword, callback) {
                callback($.grep(this.words, function (item) {
                    return item.indexOf(keyword) === 0;
                }));
            }
        },
    });
});
var edit = function () {
    $('#summernote').summernote({
        height: 100, // set editor height
        minHeight: null, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: true,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']],
            ['misc', ['print']]
        ],
        hint: {
            words: ['apple', 'orange', 'watermelon', 'lemon'],
            match: /\b(\w{1,})$/,
            search: function (keyword, callback) {
                callback($.grep(this.words, function (item) {
                    return item.indexOf(keyword) === 0;
                }));
            }
        }
    });
};


function init_click_handlers() {
    $('.activity-mail-link').click(function (e) {
        $('#formmail').trigger("reset");
        $('#summernote').summernote('reset');
        var fID = $(this).closest('tr').data('key');
        $.ajax({
            url: 'getdetailpotomail',
            type: 'POST',
            data: {id: fID},
            //data: $('#SaveToGeneric').serialize(),
            dataType: 'json',
            success: function (data) {
                $('#POID').val(fID);
                $('#PONum').val(data.PONum);
                $('#VendorID').val(data.VendorID);
                $('#VendorName').val(data.VenderName);
                $('#PODate').val(data.PODate);
                $('#Subject').val(data.Subject);
                $('#Email').val(data.VenderEmail);
                $('#modalsendmail').modal('show');
            },
            error: function (xhr, status, error) {
                swal({
                    title: error,
                    text: "",
                    type: "error",
                    confirmButtonText: "OK"
                });
            },
        });
    });
}
init_click_handlers(); //first run
$('#pjax-approve').on('pjax:success', function () {
    init_click_handlers(); //reactivate links in grid after pjax update
});
function send() {
    var id = $("#POID").val();
    var mail = $("#Email").val();
    if (mail === '') {
        swal("กรุณากรอก E-mail!", "", "warning");
    } else {
        var l = $('.ladda-button').ladda();
        l.ladda('start');
        run_waitMe();
        $.get(
                '/km4/Report/default/po-approve',
                {
                    data: id
                },
                function (result)
                {
                    Sendmail(l, id, result);

                }
        ).fail(function (xhr, status, error) {
            l.ladda('stop');
            $('.modal-body').waitMe('hide');
            swal("Oops...", error, "error");
        });
    }
}
function Sendmail(l, id,result) {
    var makrup = $('#summernote').summernote('code');
    var subject = $("#Subject").val();
    var mail = $("#Email").val();
    var name = $("#VendorName").val();
    $.post(
            'sending',
            {
                subject: subject, makrup: makrup, mail: mail, name: name, id: id,result:result
            },
            function ()
            {
                $('.modal-body').waitMe('hide');
                swal({
                    title: "",
                    text: "ส่งสำเร็จ!",
                    type: "success",
                    showCancelButton: false,
                    closeOnConfirm: true,
                    closeOnCancel: true,
                },
                        function (isConfirm) {
                            if (isConfirm) {
                                l.ladda('stop');
                                $('#formmail').trigger("reset");
                                $('#modalsendmail').modal('hide');
                                $('.modal-body').waitMe('hide');
                            }
                        });
            }
    ).fail(function ()
    {
        console.log('server error');
        $('.modal-body').waitMe('hide');
        l.ladda('stop');
        swal("OOPS !", "เกิดข้อผิดพลาดในการส่ง :)", "error");
    })
}

function run_waitMe(effect) {
    $('.modal-body').waitMe({
        effect: 'progressBar',
        text: 'Sending...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#53a93f',
        onClose: function () {
        }
    });
}

function Clearnote() {
    $('#summernote').summernote('reset');
}