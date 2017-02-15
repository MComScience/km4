function Print(PRID) {
    var myWindow = window.open("/km4/Report/report-purchasing/pr-approve?data=" + PRID, "", "top=100,left=auto,width=" + screen.width + ",height=550");
    myWindow.window.print();
}
