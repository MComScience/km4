
function waitMe_Running_show(type) {
    if (type == '1') {
        var idnaclass = '.modal-content';
    } else if (type == '2') {
        var idnaclass = '.main-container';
    }
    $(idnaclass).waitMe({
        effect: 'ios',
        text: 'Please wait...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000',
        maxSize: '',
        source: 'img.svg',
        onClose: function () {
        }
    });
}
function waitMe_Running_hide(type) {
    if (type == '1') {
        $('.modal-content').removeClass('waitMe_container');
        $('.waitMe').html('');
    } else if (type == '2') {
        $('.main-container').removeClass('waitMe_container');
        $('.waitMe').html('');
    }
}
