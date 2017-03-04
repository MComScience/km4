$(function () {
    $('.image-uploader form').on('submit', (function (e) {
        e.preventDefault();

        if (typeof window.isAvatarLoading !== 'undefined' && window.isAvatarLoading === true) {
            return;
        }

        window.isAvatarLoading = true;
        var uploader = $(this).parent();
        var action = $(this).attr('action');

        $(uploader).find('.image-submit i').removeClass('fa-save').addClass('fa-spin fa-repeat');

        $.ajax({
            url: action,
            type: 'POST',
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            complete: function () {
                $(uploader).find('.image-submit i').removeClass('fa-spin fa-repeat').addClass('fa-save');
                window.isAvatarLoading = false;
            },
            error: function (data) {
                swal("กรุณาเลือกไฟล์ภาพเพื่ออัพโหลด!");
                //$(uploader).find('.upload-status').html(data.responseText);
            },
            success: function (data) {
                $(uploader).find('.image-preview img').attr('src', data.large);
                $('.avatar img').attr('src', data.large);
                $('.avatar-area img').attr('src', data.large);
                $(uploader).find("input[name='image']").val('');
                swal("Upload avatar completed!");
            }
        });
    }));

    $('.image-input').change(function () {
        var uploader = $(this).closest('.image-uploader');
        $(uploader).find('.upload-status').empty();

        var file = this.files[0];
        var fileType = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];

        if ((fileType === match[0]) || (fileType === match[1]) || (fileType === match[2])) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(uploader).find('.image-preview img').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    $('.image-remove').click(function () {
        var imageRemove = $(this);
        var action = $(this).data('action');
        var uploader = $(this).closest('.image-uploader');

        swal({
            title: "Are you sure?",
            text: "you want to delete your profile picture!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Confirm",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: true
        },
                function (isConfirm) {
                    if (isConfirm) {
                        $(uploader).find('.upload-status').empty();
                        $(imageRemove).find('i').removeClass('fa-remove').addClass('fa-spin fa-repeat');

                        $.ajax({
                            url: action,
                            type: 'POST',
                            dataType: "json",
                            contentType: false,
                            cache: false,
                            processData: false,
                            complete: function () {
                                $(imageRemove).find('i').removeClass('fa-spin fa-repeat').addClass('fa-remove');
                            },
                            error: function (data) {
                                $(uploader).find('.upload-status').html(data.responseText);
                            },
                            success: function (data) {
                                $(uploader).find('.image-preview img').attr('src', data);
                                $('.avatar img').attr('src', data);
                                $('.avatar-area img').attr('src', data);
                                $(uploader).find('.upload-status').empty();
                            }
                        });
                        swal("Deleted!", "Your imaginary file has been deleted.", "success");
                    } else {
                        //swal("Cancelled", "Your imaginary file is safe :)", "error");
                    }
                });
        /*
         if (confirm(confRemovingAvatarMessage)) {
         $(uploader).find('.upload-status').empty();
         $(imageRemove).find('i').removeClass('fa-remove').addClass('fa-spin fa-repeat');
         
         $.ajax({
         url: action,
         type: 'POST',
         dataType: "json",
         contentType: false,
         cache: false,
         processData: false,
         complete: function () {
         $(imageRemove).find('i').removeClass('fa-spin fa-repeat').addClass('fa-remove');
         },
         error: function (data) {
         $(uploader).find('.upload-status').html(data.responseText);
         },
         success: function (data) {
         $(uploader).find('.image-preview img').attr('src', data);
         $(uploader).find('.upload-status').empty();
         }
         });
         }*/
    });

    $('.oauth-authorized-services .auth-client a').on('click', function () {
        return confirm(confRemovingAuthMessage);
    });
});