<?php ?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
<?php echo $Gridview ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#table_protocol').DataTable(
                {
                    "dom": '<"pull-left"f><"pull-right"Tl>t<"pull-left"i>p',
                    "pageLength": 10,
                    responsive: true,
                    //"bSortable": false,
                    "ordering": false,
                    "language": {
                        "lengthMenu": " _MENU_ ",
                        "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                        "search": '_INPUT_',
                    },
                    "aLengthMenu": [
                        [10, 15, 20, 100, -1],
                        [10, 15, 20, 100, "All"]
                    ]
                }
        );
    });
    
    function SelctProtocol(e){
        var paycode = (e.getAttribute("paycode"));
        $('#tbcpoe-pt_trp_regimen_paycode').val(paycode);
        $('#ajaxCrudModal').modal('hide');
    }
</script>
