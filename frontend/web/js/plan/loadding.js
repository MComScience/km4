$(function () {
    $('table.default tbody').on('click', 'tr', function () {
        if ($(this).hasClass('warning')) {
            $(this).removeClass('warning');
        } else {
            $('tr.warning').removeClass('warning');
            $(this).addClass('warning');
        }
    });
});
function LoadingClass() {
    $('.page-content').waitMe({
        effect: 'roundBounce', //roundBounce,ios,progressBar
        text: 'Please wait...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000', //default #000
        maxSize: '',
        source: 'img.svg',
        fontSize: '20px',
        onClose: function () {
        }
    });
}

