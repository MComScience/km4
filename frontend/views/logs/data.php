<?php
use frontend\assets\DataTableAsset;
DataTableAsset::register($this);
$this->title = 'Datatables';
?>
<?php $this->registerCssFile(Yii::getAlias('@web') . '/css/dataTables.checkboxes.css', ['depends' => [yii\bootstrap\BootstrapAsset::className()]]); ?>
<table id="example" class="table table-bordered table-hover" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><label><input name="select_all" value="1" type="checkbox"><span class="text"></span></label></th>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Age</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
</table>
<a id="btncreate" class="btn btn-success">Create</a>
<?php 
$script = <<< JS
$(document).ready(function() {
    var table = $('#example').DataTable({
        ajax: '/km4/logs/data'
    });
    var rows_selected = [];
    var rows_selected2 = [];    
    $('#example tbody').on('click', 'input[type="checkbox"]', function(e){
        var row = $(this).closest('tr');
        // Get row data
        var data = table.row(row).data();
        
        // Get row ID
        var rowId = data[1];
        var rowId2 = data[2];
        
        // Determine whether row ID is in the list of selected row IDs 
        var index = $.inArray(rowId, rows_selected);
        
        // If checkbox is checked and row ID is not in list of selected row IDs
        if(this.checked && index === -1){
           rows_selected.push(rowId);
        
            // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
        } else if (!this.checked && index !== -1){
           rows_selected.splice(index, 1);
        }
        var index2 = $.inArray(rowId2, rows_selected2);
        // If checkbox is checked and row ID is not in list of selected row IDs
        if(this.checked && index2 === -1){
           rows_selected2.push(rowId2);
        
            // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
        } else if (!this.checked && index2 !== -1){
           rows_selected2.splice(index2, 1);
        }
        
        if(this.checked){
            row.addClass('success');
        } else {
            row.removeClass('success');
        }
        
        // Update state of "Select all" control
        //updateDataTableSelectAllCtrl(table);
       
        console.log(JSON.stringify(rows_selected) === JSON.stringify(rows_selected2));
        console.log(rows_selected);
        console.log(rows_selected2);
        e.stopPropagation();
    } );
        /*
        $('#example').on('click', 'tbody td, thead th:first-child', function(e){
          $(this).parent().find('input[type="checkbox"]').trigger('click');
        });
        */
        // Handle click on "Select all" control

        $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
           if(this.checked){
              $('#example tbody input[type="checkbox"]:not(:checked)').trigger('click');
           } else {
              $('#example tbody input[type="checkbox"]:checked').trigger('click');
           }

           // Prevent click event from propagating to parent
           e.stopPropagation();
        });
        
        // Handle table draw event
        table.on('draw', function(){
           // Update state of "Select all" control
           updateDataTableSelectAllCtrl(table);
        });
        
        //Create
        $('#btncreate').click(function (e) {
            var ids = new Array();
            $('input[type=checkbox]').each(function () {
                if ($(this).is(':checked'))
                {
                    ids.push($(this).val());
                }
            });
            if((rows_selected.length <= 1) && (rows_selected2.length <= 1) && (JSON.stringify(rows_selected) === JSON.stringify(rows_selected2)) && (ids.length !== 0)){
                alert('Continue!');
            }else{
                alert('OMG!');
            }
        });
} );
function updateDataTableSelectAllCtrl(table){
   var tables             = table.table().node();
   var chkbox_all        = $('tbody input[type="checkbox"]', tables);
   var chkbox_checked    = $('tbody input[type="checkbox"]:checked', tables);
   var chkbox_select_all  = $('thead input[name="select_all"]', tables).get(0);

   // If none of the checkboxes are checked
   if(chkbox_checked.length === 0){
      chkbox_select_all.checked = false;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If all of the checkboxes are checked
   } else if (chkbox_checked.length === chkbox_all.length){
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = false;
      }

   // If some of the checkboxes are checked
   } else {
      chkbox_select_all.checked = true;
      if('indeterminate' in chkbox_select_all){
         chkbox_select_all.indeterminate = true;
      }
   }
}
JS;
$this->registerJs($script);
?>