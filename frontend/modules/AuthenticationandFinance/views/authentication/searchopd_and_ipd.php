
<script>
    $(function () {
        $("#pt").keyup(function (event) {
            if (event.which == 13) {
                $.ajax({
                    url: 'index.php?r=Inventory/sa-list/getnd',
                    type: 'POST',
                    success: function (data) {
                        alert(data);
                    }
                });
            }
        });
    });
</script>

