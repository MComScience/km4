
<a href="javascript:call1()">xxx</a>
<a href="javascript:call2()">xxx</a>
<script>
 function call1() {
        $.ajax({
            url: "index.php?r=Purchasing/tbpcplan/call1",
            type: "post",
            dataType: 'json',
            success: function (r) {
               alert();
            }
        });
    }
     function call2() {
        $.ajax({
            url: "index.php?r=Purchasing/tbpcplan/callpro",
            type: "post",
            dataType: 'json',
            success: function (r) {
               alert(r);
            }
        });
    }
</script>

<?php


  