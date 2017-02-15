$(document).ready(function ($) {
    $("li.tab_A").click(function (e) {
        window.location.replace("/pr/default/index");
    });
    $("li.tab_B").click(function (e) {
        window.location.replace("/pr/default/waiting-verify");
    });
    $("li.tab_C").click(function (e) {
        window.location.replace("/pr/default/reject-verify");
    });
    $("li.tab_D").click(function (e) {
        window.location.replace("/pr/default/waiting-approve");
    });
    $("li.tab_E").click(function (e) {
        window.location.replace("/pr/default/reject-approve");
    });
    $("li.tab_F").click(function (e) {
        window.location.replace("/pr/default/approve");
    });
});
