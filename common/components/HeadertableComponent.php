<?php

namespace common\components;

use Yii;
use yii\base\Component;

class Headertablecomponent extends Component {

    public function headertablepcplandetail() {
        return '<h5 class="row-title before-success">รายละเอียดแผนการจัดชื้อ</h5>
            <table class="table table-striped table-bordered dt-responsive norap" width="100%" id="tabledata">
		<thead>
            <tr role="row">
				<th style="text-align:center" width="5%">
					ลำดับ
				</th>
				<th style="text-align:center">
					รหัสยาสามัญ
				</th>
				<th style="text-align:center">
					รายละเอียดยาสามัญ
				</th>
				<th style="text-align:center">
					ราคาต่อหน่วย
				</th>
                               
				<th style="text-align:center">
					จำนวน
				</th>
                                 <th style="text-align:center">
					หน่วย
				</th>
				<th style="text-align:center" width="10%">
					รวมเป็นเงิน
				</th>
			
				<th width="14%" style="text-align:center">
Actions
				</th>
			</tr>
                        </thead>
                        <tbody>';
    }

    public function headertableplandetail() {
        return '<h5 class="row-title before-success">รายละเอียดแผนการจัดชื้อ</h5>
            <table class="table table-striped table-bordered table-hover dt-responsive nowrap" id="tablenondrug1" width="100%">
		<thead>
                        <tr role="row">
                            <th style="text-align:center" width="5%">
                            ลำดับ
                            </th>
                         
                            <th style="text-align:center">
                                รหัสสินค้า
                            </th>
                            <th style="text-align:center">
                                รายละเอียดสินค้า
                            </th>
                            <th style="text-align:center">
                                ราคาต่อหน่วย
                            </th>
                            
                            <th style="text-align:center">
                                จำนวน
                            </th>
                            <th style="text-align:center">
                            หน่วย
                            </th>
                            <th style="text-align:center">
                                รวมเป็นเงิน
                            </th>
                           
                            
                            <th width="14%" style="text-align:center">
                                Actions
                            </th>
                        </tr>
                    </thead>
		<tbody>';
    }

    public function headertableplandrugdetail() {
        return '<h5 class="row-title before-success">รายละเอียดแผนการจัดชื้อ</h5>
        <table class="table table-striped table-bordered dt-responsive norap" width="100%" id="tabledata">
            <thead>
                <tr role="row">
                    <th style="text-align:center" width="5%">
                        ลำดับ
                    </th>
                    <th style="text-align:center">
                       รหัสยาการค้า
                    </th>
                    <th style="text-align:center">
                         รายละเอียดยาการค้า
                    </th>
                    <th style="text-align:center">
                        ราคาต่อหน่วย
                    </th>
                    
                    <th style="text-align:center">
                        จำนวน
                    </th>
                    <th style="text-align:center">
                        หน่วย
                    </th>
                    <th style="text-align:center" width="10%">
                        ราคารวม
                    </th>
                   
                    <th  width="14%" style="text-align:center">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>';
    }

}
