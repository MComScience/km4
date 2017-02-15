$(document).ready(function () {
    if ($('ul.sidebar-menu >li').hasClass('active')) {
        $('ul.sidebar-menu >li.active').addClass("open");
    }
    if ($('ul.sidebar-menu >li.active>ul.submenu>li').hasClass('active') && $('ul.sidebar-menu >li.active>ul.submenu>li.active>a').hasClass('menu-dropdown')) {
        $('ul.sidebar-menu >li.active>ul.submenu>li.active').addClass("open");
    }
    if ($('ul.sidebar-menu >li.active>ul.submenu>li.active>ul.submenu>li.active>a').hasClass('menu-dropdown')) {
        $('ul.sidebar-menu >li.active>ul.submenu>li.active>ul.submenu>li.active').addClass("open");
    }

    $("a.dashboardpr").click(function (e) {
        $('.page-content').waitMe({
            effect: 'ios', //roundBounce
            text: 'Please wait...',
            bg: 'rgba(255,255,255,0.7)',
            color: '#000',
            maxSize: '',
            source: 'img.svg',
            onClose: function () {
            }
        });
    });
});
$(document).ready(function () {
    // Set idle time
    $(document).idleTimer(60000*180);

});

$(document).on("idle.idleTimer", function (event, elem, obj) {
    swal({
        title: "Session Expired",
        text: "Please login again!",
        type: "warning",
        showCancelButton: false,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    },
            function (isConfirm) {
                if (isConfirm) {
                    location.reload();
                }
            });
});
/*
 $(document).on("active.idleTimer", function (event, elem, obj, triggerevent) {
 swal.close();
 });
 */
(function () {
    var monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var dayNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"]

    // Create a newDate() object
    var newDate = new Date();

    // Extract the current date from Date object
    newDate.setDate(newDate.getDate());

    // Output the day, date, month and year
    $('#date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

    setInterval(function () {

        // Create a newDate() object and extract the seconds of the current time on the visitor's
        var seconds = new Date().getSeconds();

        // Add a leading zero to seconds value
        $("#sec").html((seconds < 10 ? "0" : "") + seconds);
    }, 1000);

    setInterval(function () {

        // Create a newDate() object and extract the minutes of the current time on the visitor's
        var minutes = new Date().getMinutes();

        // Add a leading zero to the minutes value
        $("#min").html((minutes < 10 ? "0" : "") + minutes);
    }, 1000);

    setInterval(function () {

        // Create a newDate() object and extract the hours of the current time on the visitor's
        var hours = new Date().getHours();

        // Add a leading zero to the hours value
        $("#hours").html((hours < 10 ? "0" : "") + hours);
    }, 1000);
})();