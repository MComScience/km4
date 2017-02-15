$(document).ready(function ($) {
    $("li.tab_A").click(function (e) {
        window.location.replace("/km4/po/default/index");
    });
    $("li.tab_B").click(function (e) {
        window.location.replace("/km4/po/default/draft");
    });
    $("li.tab_C").click(function (e) {
        window.location.replace("/km4/po/default/waiting-verify");
    });
    $("li.tab_D").click(function (e) {
        window.location.replace("/km4/po/default/reject-verify");
    });
    $("li.tab_E").click(function (e) {
        window.location.replace("/km4/po/default/waiting-approve");
    });
    $("li.tab_F").click(function (e) {
        window.location.replace("/km4/po/default/reject-approve");
    });
    $("li.tab_G").click(function (e) {
        window.location.replace("/km4/po/default/approve");
    });
});

