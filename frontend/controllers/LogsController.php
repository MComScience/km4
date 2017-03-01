<?php

namespace frontend\controllers;

use Yii;
use dektrium\user\models\log\LoginForm;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use chrmorandi\jasper\Jasper;

class LogsController extends \yii\web\Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['Admin', 'SuperAdmin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $data = new ActiveDataProvider([
            'query' => LoginForm::find(),
            'sort' => ['defaultOrder' => ['log_id' => SORT_DESC]],
        ]);

        return $this->render('index', [
                    'data' => $data
        ]);
    }

    public function actionReport() {
        // Set alias for sample directory
        Yii::setAlias('example', '@web/report');

        /* @var $jasper Jasper */
        $jasper = new \chrmorandi\jasper\Jasper();

        // Compile a JRXML to Jasper
        $jasper->compile(Yii::getAlias('@example') . '/hello_world.jrxml')->execute();

        // Process a Jasper file to PDF and RTF (you can use directly the .jrxml)
        $jasper->process(Yii::getAlias('@example') . '/hello_world.jasper', [
            'php_version' => '7.0'
                ], [
            'pdf',
                // 'rtf'
                ], false, false)->execute();

        // List the parameters from a Jasper file.
        $array = $jasper->listParameters(Yii::getAlias('@example') . '/hello_world.jasper')->execute();

        // return pdf file
        Yii::$app->response->sendFile(Yii::getAlias('@example') . '/hello_world.pdf');
    }

    public function actionDatatables() {
        return $this->render('data', [
        ]);
    }

    public function actionData() {
        $data['data'] = [
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                'System Architect',
                'System Architect',
                'Edinburgh',
                '61',
                '2011/04/25',
                '$320,800'
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tiger Nixon",
                "System Architect",
                "Edinburgh",
                "5421",
                "2011/04/25",
                "$320,800"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Garrett Winters",
                "Accountant",
                "Tokyo",
                "8422",
                "2011/07/25",
                "$170,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Ashton Cox",
                "Junior Technical Author",
                "San Francisco",
                "1562",
                "2009/01/12",
                "$86,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Cedric Kelly",
                "Senior Javascript Developer",
                "Edinburgh",
                "6224",
                "2012/03/29",
                "$433,060"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Airi Satou",
                "Accountant",
                "Tokyo",
                "5407",
                "2008/11/28",
                "$162,700"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Brielle Williamson",
                "Integration Specialist",
                "New York",
                "4804",
                "2012/12/02",
                "$372,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Herrod Chandler",
                "Sales Assistant",
                "San Francisco",
                "9608",
                "2012/08/06",
                "$137,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Rhona Davidson",
                "Integration Specialist",
                "Tokyo",
                "6200",
                "2010/10/14",
                "$327,900"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Colleen Hurst",
                "Javascript Developer",
                "San Francisco",
                "2360",
                "2009/09/15",
                "$205,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Sonya Frost",
                "Software Engineer",
                "Edinburgh",
                "1667",
                "2008/12/13",
                "$103,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jena Gaines",
                "Office Manager",
                "London",
                "3814",
                "2008/12/19",
                "$90,560"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Quinn Flynn",
                "Support Lead",
                "Edinburgh",
                "9497",
                "2013/03/03",
                "$342,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Charde Marshall",
                "Regional Director",
                "San Francisco",
                "6741",
                "2008/10/16",
                "$470,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Haley Kennedy",
                "Senior Marketing Designer",
                "London",
                "3597",
                "2012/12/18",
                "$313,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tatyana Fitzpatrick",
                "Regional Director",
                "London",
                "1965",
                "2010/03/17",
                "$385,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Michael Silva",
                "Marketing Designer",
                "London",
                "1581",
                "2012/11/27",
                "$198,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Paul Byrd",
                "Chief Financial Officer (CFO)",
                "New York",
                "3059",
                "2010/06/09",
                "$725,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gloria Little",
                "Systems Administrator",
                "New York",
                "1721",
                "2009/04/10",
                "$237,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Bradley Greer",
                "Software Engineer",
                "London",
                "2558",
                "2012/10/13",
                "$132,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Dai Rios",
                "Personnel Lead",
                "Edinburgh",
                "2290",
                "2012/09/26",
                "$217,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jenette Caldwell",
                "Development Lead",
                "New York",
                "1937",
                "2011/09/03",
                "$345,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Yuri Berry",
                "Chief Marketing Officer (CMO)",
                "New York",
                "6154",
                "2009/06/25",
                "$675,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Caesar Vance",
                "Pre-Sales Support",
                "New York",
                "8330",
                "2011/12/12",
                "$106,450"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Doris Wilder",
                "Sales Assistant",
                "Sidney",
                "3023",
                "2010/09/20",
                "$85,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Angelica Ramos",
                "Chief Executive Officer (CEO)",
                "London",
                "5797",
                "2009/10/09",
                "$1,200,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gavin Joyce",
                "Developer",
                "Edinburgh",
                "8822",
                "2010/12/22",
                "$92,575"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jennifer Chang",
                "Regional Director",
                "Singapore",
                "9239",
                "2010/11/14",
                "$357,650"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tiger Nixon",
                "System Architect",
                "Edinburgh",
                "5421",
                "2011/04/25",
                "$320,800"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Garrett Winters",
                "Accountant",
                "Tokyo",
                "8422",
                "2011/07/25",
                "$170,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Ashton Cox",
                "Junior Technical Author",
                "San Francisco",
                "1562",
                "2009/01/12",
                "$86,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Cedric Kelly",
                "Senior Javascript Developer",
                "Edinburgh",
                "6224",
                "2012/03/29",
                "$433,060"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Airi Satou",
                "Accountant",
                "Tokyo",
                "5407",
                "2008/11/28",
                "$162,700"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Brielle Williamson",
                "Integration Specialist",
                "New York",
                "4804",
                "2012/12/02",
                "$372,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Herrod Chandler",
                "Sales Assistant",
                "San Francisco",
                "9608",
                "2012/08/06",
                "$137,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Rhona Davidson",
                "Integration Specialist",
                "Tokyo",
                "6200",
                "2010/10/14",
                "$327,900"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Colleen Hurst",
                "Javascript Developer",
                "San Francisco",
                "2360",
                "2009/09/15",
                "$205,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Sonya Frost",
                "Software Engineer",
                "Edinburgh",
                "1667",
                "2008/12/13",
                "$103,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jena Gaines",
                "Office Manager",
                "London",
                "3814",
                "2008/12/19",
                "$90,560"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Quinn Flynn",
                "Support Lead",
                "Edinburgh",
                "9497",
                "2013/03/03",
                "$342,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Charde Marshall",
                "Regional Director",
                "San Francisco",
                "6741",
                "2008/10/16",
                "$470,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Haley Kennedy",
                "Senior Marketing Designer",
                "London",
                "3597",
                "2012/12/18",
                "$313,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tatyana Fitzpatrick",
                "Regional Director",
                "London",
                "1965",
                "2010/03/17",
                "$385,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Michael Silva",
                "Marketing Designer",
                "London",
                "1581",
                "2012/11/27",
                "$198,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Paul Byrd",
                "Chief Financial Officer (CFO)",
                "New York",
                "3059",
                "2010/06/09",
                "$725,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gloria Little",
                "Systems Administrator",
                "New York",
                "1721",
                "2009/04/10",
                "$237,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Bradley Greer",
                "Software Engineer",
                "London",
                "2558",
                "2012/10/13",
                "$132,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Dai Rios",
                "Personnel Lead",
                "Edinburgh",
                "2290",
                "2012/09/26",
                "$217,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jenette Caldwell",
                "Development Lead",
                "New York",
                "1937",
                "2011/09/03",
                "$345,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Yuri Berry",
                "Chief Marketing Officer (CMO)",
                "New York",
                "6154",
                "2009/06/25",
                "$675,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Caesar Vance",
                "Pre-Sales Support",
                "New York",
                "8330",
                "2011/12/12",
                "$106,450"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Doris Wilder",
                "Sales Assistant",
                "Sidney",
                "3023",
                "2010/09/20",
                "$85,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Angelica Ramos",
                "Chief Executive Officer (CEO)",
                "London",
                "5797",
                "2009/10/09",
                "$1,200,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gavin Joyce",
                "Developer",
                "Edinburgh",
                "8822",
                "2010/12/22",
                "$92,575"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jennifer Chang",
                "Regional Director",
                "Singapore",
                "9239",
                "2010/11/14",
                "$357,650"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tiger Nixon",
                "System Architect",
                "Edinburgh",
                "5421",
                "2011/04/25",
                "$320,800"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Garrett Winters",
                "Accountant",
                "Tokyo",
                "8422",
                "2011/07/25",
                "$170,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Ashton Cox",
                "Junior Technical Author",
                "San Francisco",
                "1562",
                "2009/01/12",
                "$86,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Cedric Kelly",
                "Senior Javascript Developer",
                "Edinburgh",
                "6224",
                "2012/03/29",
                "$433,060"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Airi Satou",
                "Accountant",
                "Tokyo",
                "5407",
                "2008/11/28",
                "$162,700"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Brielle Williamson",
                "Integration Specialist",
                "New York",
                "4804",
                "2012/12/02",
                "$372,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Herrod Chandler",
                "Sales Assistant",
                "San Francisco",
                "9608",
                "2012/08/06",
                "$137,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Rhona Davidson",
                "Integration Specialist",
                "Tokyo",
                "6200",
                "2010/10/14",
                "$327,900"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Colleen Hurst",
                "Javascript Developer",
                "San Francisco",
                "2360",
                "2009/09/15",
                "$205,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Sonya Frost",
                "Software Engineer",
                "Edinburgh",
                "1667",
                "2008/12/13",
                "$103,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jena Gaines",
                "Office Manager",
                "London",
                "3814",
                "2008/12/19",
                "$90,560"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Quinn Flynn",
                "Support Lead",
                "Edinburgh",
                "9497",
                "2013/03/03",
                "$342,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Charde Marshall",
                "Regional Director",
                "San Francisco",
                "6741",
                "2008/10/16",
                "$470,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Haley Kennedy",
                "Senior Marketing Designer",
                "London",
                "3597",
                "2012/12/18",
                "$313,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tatyana Fitzpatrick",
                "Regional Director",
                "London",
                "1965",
                "2010/03/17",
                "$385,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Michael Silva",
                "Marketing Designer",
                "London",
                "1581",
                "2012/11/27",
                "$198,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Paul Byrd",
                "Chief Financial Officer (CFO)",
                "New York",
                "3059",
                "2010/06/09",
                "$725,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gloria Little",
                "Systems Administrator",
                "New York",
                "1721",
                "2009/04/10",
                "$237,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Bradley Greer",
                "Software Engineer",
                "London",
                "2558",
                "2012/10/13",
                "$132,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Dai Rios",
                "Personnel Lead",
                "Edinburgh",
                "2290",
                "2012/09/26",
                "$217,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jenette Caldwell",
                "Development Lead",
                "New York",
                "1937",
                "2011/09/03",
                "$345,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Yuri Berry",
                "Chief Marketing Officer (CMO)",
                "New York",
                "6154",
                "2009/06/25",
                "$675,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Caesar Vance",
                "Pre-Sales Support",
                "New York",
                "8330",
                "2011/12/12",
                "$106,450"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Doris Wilder",
                "Sales Assistant",
                "Sidney",
                "3023",
                "2010/09/20",
                "$85,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Angelica Ramos",
                "Chief Executive Officer (CEO)",
                "London",
                "5797",
                "2009/10/09",
                "$1,200,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gavin Joyce",
                "Developer",
                "Edinburgh",
                "8822",
                "2010/12/22",
                "$92,575"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jennifer Chang",
                "Regional Director",
                "Singapore",
                "9239",
                "2010/11/14",
                "$357,650"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tiger Nixon",
                "System Architect",
                "Edinburgh",
                "5421",
                "2011/04/25",
                "$320,800"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Garrett Winters",
                "Accountant",
                "Tokyo",
                "8422",
                "2011/07/25",
                "$170,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Ashton Cox",
                "Junior Technical Author",
                "San Francisco",
                "1562",
                "2009/01/12",
                "$86,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Cedric Kelly",
                "Senior Javascript Developer",
                "Edinburgh",
                "6224",
                "2012/03/29",
                "$433,060"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Airi Satou",
                "Accountant",
                "Tokyo",
                "5407",
                "2008/11/28",
                "$162,700"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Brielle Williamson",
                "Integration Specialist",
                "New York",
                "4804",
                "2012/12/02",
                "$372,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Herrod Chandler",
                "Sales Assistant",
                "San Francisco",
                "9608",
                "2012/08/06",
                "$137,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Rhona Davidson",
                "Integration Specialist",
                "Tokyo",
                "6200",
                "2010/10/14",
                "$327,900"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Colleen Hurst",
                "Javascript Developer",
                "San Francisco",
                "2360",
                "2009/09/15",
                "$205,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Sonya Frost",
                "Software Engineer",
                "Edinburgh",
                "1667",
                "2008/12/13",
                "$103,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jena Gaines",
                "Office Manager",
                "London",
                "3814",
                "2008/12/19",
                "$90,560"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Quinn Flynn",
                "Support Lead",
                "Edinburgh",
                "9497",
                "2013/03/03",
                "$342,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Charde Marshall",
                "Regional Director",
                "San Francisco",
                "6741",
                "2008/10/16",
                "$470,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Haley Kennedy",
                "Senior Marketing Designer",
                "London",
                "3597",
                "2012/12/18",
                "$313,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tatyana Fitzpatrick",
                "Regional Director",
                "London",
                "1965",
                "2010/03/17",
                "$385,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Michael Silva",
                "Marketing Designer",
                "London",
                "1581",
                "2012/11/27",
                "$198,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Paul Byrd",
                "Chief Financial Officer (CFO)",
                "New York",
                "3059",
                "2010/06/09",
                "$725,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gloria Little",
                "Systems Administrator",
                "New York",
                "1721",
                "2009/04/10",
                "$237,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Bradley Greer",
                "Software Engineer",
                "London",
                "2558",
                "2012/10/13",
                "$132,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Dai Rios",
                "Personnel Lead",
                "Edinburgh",
                "2290",
                "2012/09/26",
                "$217,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jenette Caldwell",
                "Development Lead",
                "New York",
                "1937",
                "2011/09/03",
                "$345,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Yuri Berry",
                "Chief Marketing Officer (CMO)",
                "New York",
                "6154",
                "2009/06/25",
                "$675,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Caesar Vance",
                "Pre-Sales Support",
                "New York",
                "8330",
                "2011/12/12",
                "$106,450"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Doris Wilder",
                "Sales Assistant",
                "Sidney",
                "3023",
                "2010/09/20",
                "$85,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Angelica Ramos",
                "Chief Executive Officer (CEO)",
                "London",
                "5797",
                "2009/10/09",
                "$1,200,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gavin Joyce",
                "Developer",
                "Edinburgh",
                "8822",
                "2010/12/22",
                "$92,575"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jennifer Chang",
                "Regional Director",
                "Singapore",
                "9239",
                "2010/11/14",
                "$357,650"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tiger Nixon",
                "System Architect",
                "Edinburgh",
                "5421",
                "2011/04/25",
                "$320,800"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Garrett Winters",
                "Accountant",
                "Tokyo",
                "8422",
                "2011/07/25",
                "$170,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Ashton Cox",
                "Junior Technical Author",
                "San Francisco",
                "1562",
                "2009/01/12",
                "$86,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Cedric Kelly",
                "Senior Javascript Developer",
                "Edinburgh",
                "6224",
                "2012/03/29",
                "$433,060"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Airi Satou",
                "Accountant",
                "Tokyo",
                "5407",
                "2008/11/28",
                "$162,700"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Brielle Williamson",
                "Integration Specialist",
                "New York",
                "4804",
                "2012/12/02",
                "$372,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Herrod Chandler",
                "Sales Assistant",
                "San Francisco",
                "9608",
                "2012/08/06",
                "$137,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Rhona Davidson",
                "Integration Specialist",
                "Tokyo",
                "6200",
                "2010/10/14",
                "$327,900"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Colleen Hurst",
                "Javascript Developer",
                "San Francisco",
                "2360",
                "2009/09/15",
                "$205,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Sonya Frost",
                "Software Engineer",
                "Edinburgh",
                "1667",
                "2008/12/13",
                "$103,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jena Gaines",
                "Office Manager",
                "London",
                "3814",
                "2008/12/19",
                "$90,560"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Quinn Flynn",
                "Support Lead",
                "Edinburgh",
                "9497",
                "2013/03/03",
                "$342,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Charde Marshall",
                "Regional Director",
                "San Francisco",
                "6741",
                "2008/10/16",
                "$470,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Haley Kennedy",
                "Senior Marketing Designer",
                "London",
                "3597",
                "2012/12/18",
                "$313,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tatyana Fitzpatrick",
                "Regional Director",
                "London",
                "1965",
                "2010/03/17",
                "$385,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Michael Silva",
                "Marketing Designer",
                "London",
                "1581",
                "2012/11/27",
                "$198,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Paul Byrd",
                "Chief Financial Officer (CFO)",
                "New York",
                "3059",
                "2010/06/09",
                "$725,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gloria Little",
                "Systems Administrator",
                "New York",
                "1721",
                "2009/04/10",
                "$237,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Bradley Greer",
                "Software Engineer",
                "London",
                "2558",
                "2012/10/13",
                "$132,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Dai Rios",
                "Personnel Lead",
                "Edinburgh",
                "2290",
                "2012/09/26",
                "$217,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jenette Caldwell",
                "Development Lead",
                "New York",
                "1937",
                "2011/09/03",
                "$345,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Yuri Berry",
                "Chief Marketing Officer (CMO)",
                "New York",
                "6154",
                "2009/06/25",
                "$675,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Caesar Vance",
                "Pre-Sales Support",
                "New York",
                "8330",
                "2011/12/12",
                "$106,450"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Doris Wilder",
                "Sales Assistant",
                "Sidney",
                "3023",
                "2010/09/20",
                "$85,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Angelica Ramos",
                "Chief Executive Officer (CEO)",
                "London",
                "5797",
                "2009/10/09",
                "$1,200,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gavin Joyce",
                "Developer",
                "Edinburgh",
                "8822",
                "2010/12/22",
                "$92,575"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jennifer Chang",
                "Regional Director",
                "Singapore",
                "9239",
                "2010/11/14",
                "$357,650"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tiger Nixon",
                "System Architect",
                "Edinburgh",
                "5421",
                "2011/04/25",
                "$320,800"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Garrett Winters",
                "Accountant",
                "Tokyo",
                "8422",
                "2011/07/25",
                "$170,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Ashton Cox",
                "Junior Technical Author",
                "San Francisco",
                "1562",
                "2009/01/12",
                "$86,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Cedric Kelly",
                "Senior Javascript Developer",
                "Edinburgh",
                "6224",
                "2012/03/29",
                "$433,060"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Airi Satou",
                "Accountant",
                "Tokyo",
                "5407",
                "2008/11/28",
                "$162,700"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Brielle Williamson",
                "Integration Specialist",
                "New York",
                "4804",
                "2012/12/02",
                "$372,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Herrod Chandler",
                "Sales Assistant",
                "San Francisco",
                "9608",
                "2012/08/06",
                "$137,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Rhona Davidson",
                "Integration Specialist",
                "Tokyo",
                "6200",
                "2010/10/14",
                "$327,900"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Colleen Hurst",
                "Javascript Developer",
                "San Francisco",
                "2360",
                "2009/09/15",
                "$205,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Sonya Frost",
                "Software Engineer",
                "Edinburgh",
                "1667",
                "2008/12/13",
                "$103,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jena Gaines",
                "Office Manager",
                "London",
                "3814",
                "2008/12/19",
                "$90,560"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Quinn Flynn",
                "Support Lead",
                "Edinburgh",
                "9497",
                "2013/03/03",
                "$342,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Charde Marshall",
                "Regional Director",
                "San Francisco",
                "6741",
                "2008/10/16",
                "$470,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Haley Kennedy",
                "Senior Marketing Designer",
                "London",
                "3597",
                "2012/12/18",
                "$313,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tatyana Fitzpatrick",
                "Regional Director",
                "London",
                "1965",
                "2010/03/17",
                "$385,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Michael Silva",
                "Marketing Designer",
                "London",
                "1581",
                "2012/11/27",
                "$198,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Paul Byrd",
                "Chief Financial Officer (CFO)",
                "New York",
                "3059",
                "2010/06/09",
                "$725,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gloria Little",
                "Systems Administrator",
                "New York",
                "1721",
                "2009/04/10",
                "$237,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Bradley Greer",
                "Software Engineer",
                "London",
                "2558",
                "2012/10/13",
                "$132,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Dai Rios",
                "Personnel Lead",
                "Edinburgh",
                "2290",
                "2012/09/26",
                "$217,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jenette Caldwell",
                "Development Lead",
                "New York",
                "1937",
                "2011/09/03",
                "$345,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Yuri Berry",
                "Chief Marketing Officer (CMO)",
                "New York",
                "6154",
                "2009/06/25",
                "$675,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Caesar Vance",
                "Pre-Sales Support",
                "New York",
                "8330",
                "2011/12/12",
                "$106,450"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Doris Wilder",
                "Sales Assistant",
                "Sidney",
                "3023",
                "2010/09/20",
                "$85,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Angelica Ramos",
                "Chief Executive Officer (CEO)",
                "London",
                "5797",
                "2009/10/09",
                "$1,200,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gavin Joyce",
                "Developer",
                "Edinburgh",
                "8822",
                "2010/12/22",
                "$92,575"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jennifer Chang",
                "Regional Director",
                "Singapore",
                "9239",
                "2010/11/14",
                "$357,650"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tiger Nixon",
                "System Architect",
                "Edinburgh",
                "5421",
                "2011/04/25",
                "$320,800"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Garrett Winters",
                "Accountant",
                "Tokyo",
                "8422",
                "2011/07/25",
                "$170,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Ashton Cox",
                "Junior Technical Author",
                "San Francisco",
                "1562",
                "2009/01/12",
                "$86,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Cedric Kelly",
                "Senior Javascript Developer",
                "Edinburgh",
                "6224",
                "2012/03/29",
                "$433,060"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Airi Satou",
                "Accountant",
                "Tokyo",
                "5407",
                "2008/11/28",
                "$162,700"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Brielle Williamson",
                "Integration Specialist",
                "New York",
                "4804",
                "2012/12/02",
                "$372,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Herrod Chandler",
                "Sales Assistant",
                "San Francisco",
                "9608",
                "2012/08/06",
                "$137,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Rhona Davidson",
                "Integration Specialist",
                "Tokyo",
                "6200",
                "2010/10/14",
                "$327,900"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Colleen Hurst",
                "Javascript Developer",
                "San Francisco",
                "2360",
                "2009/09/15",
                "$205,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Sonya Frost",
                "Software Engineer",
                "Edinburgh",
                "1667",
                "2008/12/13",
                "$103,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jena Gaines",
                "Office Manager",
                "London",
                "3814",
                "2008/12/19",
                "$90,560"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Quinn Flynn",
                "Support Lead",
                "Edinburgh",
                "9497",
                "2013/03/03",
                "$342,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Charde Marshall",
                "Regional Director",
                "San Francisco",
                "6741",
                "2008/10/16",
                "$470,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Haley Kennedy",
                "Senior Marketing Designer",
                "London",
                "3597",
                "2012/12/18",
                "$313,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tatyana Fitzpatrick",
                "Regional Director",
                "London",
                "1965",
                "2010/03/17",
                "$385,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Michael Silva",
                "Marketing Designer",
                "London",
                "1581",
                "2012/11/27",
                "$198,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Paul Byrd",
                "Chief Financial Officer (CFO)",
                "New York",
                "3059",
                "2010/06/09",
                "$725,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gloria Little",
                "Systems Administrator",
                "New York",
                "1721",
                "2009/04/10",
                "$237,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Bradley Greer",
                "Software Engineer",
                "London",
                "2558",
                "2012/10/13",
                "$132,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Dai Rios",
                "Personnel Lead",
                "Edinburgh",
                "2290",
                "2012/09/26",
                "$217,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jenette Caldwell",
                "Development Lead",
                "New York",
                "1937",
                "2011/09/03",
                "$345,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Yuri Berry",
                "Chief Marketing Officer (CMO)",
                "New York",
                "6154",
                "2009/06/25",
                "$675,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Caesar Vance",
                "Pre-Sales Support",
                "New York",
                "8330",
                "2011/12/12",
                "$106,450"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Doris Wilder",
                "Sales Assistant",
                "Sidney",
                "3023",
                "2010/09/20",
                "$85,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Angelica Ramos",
                "Chief Executive Officer (CEO)",
                "London",
                "5797",
                "2009/10/09",
                "$1,200,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gavin Joyce",
                "Developer",
                "Edinburgh",
                "8822",
                "2010/12/22",
                "$92,575"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jennifer Chang",
                "Regional Director",
                "Singapore",
                "9239",
                "2010/11/14",
                "$357,650"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tiger Nixon",
                "System Architect",
                "Edinburgh",
                "5421",
                "2011/04/25",
                "$320,800"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Garrett Winters",
                "Accountant",
                "Tokyo",
                "8422",
                "2011/07/25",
                "$170,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Ashton Cox",
                "Junior Technical Author",
                "San Francisco",
                "1562",
                "2009/01/12",
                "$86,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Cedric Kelly",
                "Senior Javascript Developer",
                "Edinburgh",
                "6224",
                "2012/03/29",
                "$433,060"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Airi Satou",
                "Accountant",
                "Tokyo",
                "5407",
                "2008/11/28",
                "$162,700"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Brielle Williamson",
                "Integration Specialist",
                "New York",
                "4804",
                "2012/12/02",
                "$372,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Herrod Chandler",
                "Sales Assistant",
                "San Francisco",
                "9608",
                "2012/08/06",
                "$137,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Rhona Davidson",
                "Integration Specialist",
                "Tokyo",
                "6200",
                "2010/10/14",
                "$327,900"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Colleen Hurst",
                "Javascript Developer",
                "San Francisco",
                "2360",
                "2009/09/15",
                "$205,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Sonya Frost",
                "Software Engineer",
                "Edinburgh",
                "1667",
                "2008/12/13",
                "$103,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jena Gaines",
                "Office Manager",
                "London",
                "3814",
                "2008/12/19",
                "$90,560"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Quinn Flynn",
                "Support Lead",
                "Edinburgh",
                "9497",
                "2013/03/03",
                "$342,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Charde Marshall",
                "Regional Director",
                "San Francisco",
                "6741",
                "2008/10/16",
                "$470,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Haley Kennedy",
                "Senior Marketing Designer",
                "London",
                "3597",
                "2012/12/18",
                "$313,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tatyana Fitzpatrick",
                "Regional Director",
                "London",
                "1965",
                "2010/03/17",
                "$385,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Michael Silva",
                "Marketing Designer",
                "London",
                "1581",
                "2012/11/27",
                "$198,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Paul Byrd",
                "Chief Financial Officer (CFO)",
                "New York",
                "3059",
                "2010/06/09",
                "$725,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gloria Little",
                "Systems Administrator",
                "New York",
                "1721",
                "2009/04/10",
                "$237,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Bradley Greer",
                "Software Engineer",
                "London",
                "2558",
                "2012/10/13",
                "$132,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Dai Rios",
                "Personnel Lead",
                "Edinburgh",
                "2290",
                "2012/09/26",
                "$217,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jenette Caldwell",
                "Development Lead",
                "New York",
                "1937",
                "2011/09/03",
                "$345,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Yuri Berry",
                "Chief Marketing Officer (CMO)",
                "New York",
                "6154",
                "2009/06/25",
                "$675,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Caesar Vance",
                "Pre-Sales Support",
                "New York",
                "8330",
                "2011/12/12",
                "$106,450"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Doris Wilder",
                "Sales Assistant",
                "Sidney",
                "3023",
                "2010/09/20",
                "$85,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Angelica Ramos",
                "Chief Executive Officer (CEO)",
                "London",
                "5797",
                "2009/10/09",
                "$1,200,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gavin Joyce",
                "Developer",
                "Edinburgh",
                "8822",
                "2010/12/22",
                "$92,575"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jennifer Chang",
                "Regional Director",
                "Singapore",
                "9239",
                "2010/11/14",
                "$357,650"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tiger Nixon",
                "System Architect",
                "Edinburgh",
                "5421",
                "2011/04/25",
                "$320,800"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Garrett Winters",
                "Accountant",
                "Tokyo",
                "8422",
                "2011/07/25",
                "$170,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Ashton Cox",
                "Junior Technical Author",
                "San Francisco",
                "1562",
                "2009/01/12",
                "$86,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Cedric Kelly",
                "Senior Javascript Developer",
                "Edinburgh",
                "6224",
                "2012/03/29",
                "$433,060"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Airi Satou",
                "Accountant",
                "Tokyo",
                "5407",
                "2008/11/28",
                "$162,700"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Brielle Williamson",
                "Integration Specialist",
                "New York",
                "4804",
                "2012/12/02",
                "$372,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Herrod Chandler",
                "Sales Assistant",
                "San Francisco",
                "9608",
                "2012/08/06",
                "$137,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Rhona Davidson",
                "Integration Specialist",
                "Tokyo",
                "6200",
                "2010/10/14",
                "$327,900"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Colleen Hurst",
                "Javascript Developer",
                "San Francisco",
                "2360",
                "2009/09/15",
                "$205,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Sonya Frost",
                "Software Engineer",
                "Edinburgh",
                "1667",
                "2008/12/13",
                "$103,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jena Gaines",
                "Office Manager",
                "London",
                "3814",
                "2008/12/19",
                "$90,560"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Quinn Flynn",
                "Support Lead",
                "Edinburgh",
                "9497",
                "2013/03/03",
                "$342,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Charde Marshall",
                "Regional Director",
                "San Francisco",
                "6741",
                "2008/10/16",
                "$470,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Haley Kennedy",
                "Senior Marketing Designer",
                "London",
                "3597",
                "2012/12/18",
                "$313,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tatyana Fitzpatrick",
                "Regional Director",
                "London",
                "1965",
                "2010/03/17",
                "$385,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Michael Silva",
                "Marketing Designer",
                "London",
                "1581",
                "2012/11/27",
                "$198,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Paul Byrd",
                "Chief Financial Officer (CFO)",
                "New York",
                "3059",
                "2010/06/09",
                "$725,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gloria Little",
                "Systems Administrator",
                "New York",
                "1721",
                "2009/04/10",
                "$237,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Bradley Greer",
                "Software Engineer",
                "London",
                "2558",
                "2012/10/13",
                "$132,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Dai Rios",
                "Personnel Lead",
                "Edinburgh",
                "2290",
                "2012/09/26",
                "$217,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jenette Caldwell",
                "Development Lead",
                "New York",
                "1937",
                "2011/09/03",
                "$345,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Yuri Berry",
                "Chief Marketing Officer (CMO)",
                "New York",
                "6154",
                "2009/06/25",
                "$675,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Caesar Vance",
                "Pre-Sales Support",
                "New York",
                "8330",
                "2011/12/12",
                "$106,450"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Doris Wilder",
                "Sales Assistant",
                "Sidney",
                "3023",
                "2010/09/20",
                "$85,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Angelica Ramos",
                "Chief Executive Officer (CEO)",
                "London",
                "5797",
                "2009/10/09",
                "$1,200,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gavin Joyce",
                "Developer",
                "Edinburgh",
                "8822",
                "2010/12/22",
                "$92,575"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jennifer Chang",
                "Regional Director",
                "Singapore",
                "9239",
                "2010/11/14",
                "$357,650"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tiger Nixon",
                "System Architect",
                "Edinburgh",
                "5421",
                "2011/04/25",
                "$320,800"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Garrett Winters",
                "Accountant",
                "Tokyo",
                "8422",
                "2011/07/25",
                "$170,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Ashton Cox",
                "Junior Technical Author",
                "San Francisco",
                "1562",
                "2009/01/12",
                "$86,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Cedric Kelly",
                "Senior Javascript Developer",
                "Edinburgh",
                "6224",
                "2012/03/29",
                "$433,060"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Airi Satou",
                "Accountant",
                "Tokyo",
                "5407",
                "2008/11/28",
                "$162,700"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Brielle Williamson",
                "Integration Specialist",
                "New York",
                "4804",
                "2012/12/02",
                "$372,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Herrod Chandler",
                "Sales Assistant",
                "San Francisco",
                "9608",
                "2012/08/06",
                "$137,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Rhona Davidson",
                "Integration Specialist",
                "Tokyo",
                "6200",
                "2010/10/14",
                "$327,900"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Colleen Hurst",
                "Javascript Developer",
                "San Francisco",
                "2360",
                "2009/09/15",
                "$205,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Sonya Frost",
                "Software Engineer",
                "Edinburgh",
                "1667",
                "2008/12/13",
                "$103,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jena Gaines",
                "Office Manager",
                "London",
                "3814",
                "2008/12/19",
                "$90,560"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Quinn Flynn",
                "Support Lead",
                "Edinburgh",
                "9497",
                "2013/03/03",
                "$342,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Charde Marshall",
                "Regional Director",
                "San Francisco",
                "6741",
                "2008/10/16",
                "$470,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Haley Kennedy",
                "Senior Marketing Designer",
                "London",
                "3597",
                "2012/12/18",
                "$313,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tatyana Fitzpatrick",
                "Regional Director",
                "London",
                "1965",
                "2010/03/17",
                "$385,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Michael Silva",
                "Marketing Designer",
                "London",
                "1581",
                "2012/11/27",
                "$198,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Paul Byrd",
                "Chief Financial Officer (CFO)",
                "New York",
                "3059",
                "2010/06/09",
                "$725,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gloria Little",
                "Systems Administrator",
                "New York",
                "1721",
                "2009/04/10",
                "$237,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Bradley Greer",
                "Software Engineer",
                "London",
                "2558",
                "2012/10/13",
                "$132,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Dai Rios",
                "Personnel Lead",
                "Edinburgh",
                "2290",
                "2012/09/26",
                "$217,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jenette Caldwell",
                "Development Lead",
                "New York",
                "1937",
                "2011/09/03",
                "$345,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Yuri Berry",
                "Chief Marketing Officer (CMO)",
                "New York",
                "6154",
                "2009/06/25",
                "$675,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Caesar Vance",
                "Pre-Sales Support",
                "New York",
                "8330",
                "2011/12/12",
                "$106,450"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Doris Wilder",
                "Sales Assistant",
                "Sidney",
                "3023",
                "2010/09/20",
                "$85,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Angelica Ramos",
                "Chief Executive Officer (CEO)",
                "London",
                "5797",
                "2009/10/09",
                "$1,200,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gavin Joyce",
                "Developer",
                "Edinburgh",
                "8822",
                "2010/12/22",
                "$92,575"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jennifer Chang",
                "Regional Director",
                "Singapore",
                "9239",
                "2010/11/14",
                "$357,650"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tiger Nixon",
                "System Architect",
                "Edinburgh",
                "5421",
                "2011/04/25",
                "$320,800"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Garrett Winters",
                "Accountant",
                "Tokyo",
                "8422",
                "2011/07/25",
                "$170,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Ashton Cox",
                "Junior Technical Author",
                "San Francisco",
                "1562",
                "2009/01/12",
                "$86,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Cedric Kelly",
                "Senior Javascript Developer",
                "Edinburgh",
                "6224",
                "2012/03/29",
                "$433,060"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Airi Satou",
                "Accountant",
                "Tokyo",
                "5407",
                "2008/11/28",
                "$162,700"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Brielle Williamson",
                "Integration Specialist",
                "New York",
                "4804",
                "2012/12/02",
                "$372,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Herrod Chandler",
                "Sales Assistant",
                "San Francisco",
                "9608",
                "2012/08/06",
                "$137,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Rhona Davidson",
                "Integration Specialist",
                "Tokyo",
                "6200",
                "2010/10/14",
                "$327,900"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Colleen Hurst",
                "Javascript Developer",
                "San Francisco",
                "2360",
                "2009/09/15",
                "$205,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Sonya Frost",
                "Software Engineer",
                "Edinburgh",
                "1667",
                "2008/12/13",
                "$103,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jena Gaines",
                "Office Manager",
                "London",
                "3814",
                "2008/12/19",
                "$90,560"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Quinn Flynn",
                "Support Lead",
                "Edinburgh",
                "9497",
                "2013/03/03",
                "$342,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Charde Marshall",
                "Regional Director",
                "San Francisco",
                "6741",
                "2008/10/16",
                "$470,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Haley Kennedy",
                "Senior Marketing Designer",
                "London",
                "3597",
                "2012/12/18",
                "$313,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Tatyana Fitzpatrick",
                "Regional Director",
                "London",
                "1965",
                "2010/03/17",
                "$385,750"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Michael Silva",
                "Marketing Designer",
                "London",
                "1581",
                "2012/11/27",
                "$198,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Paul Byrd",
                "Chief Financial Officer (CFO)",
                "New York",
                "3059",
                "2010/06/09",
                "$725,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gloria Little",
                "Systems Administrator",
                "New York",
                "1721",
                "2009/04/10",
                "$237,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Bradley Greer",
                "Software Engineer",
                "London",
                "2558",
                "2012/10/13",
                "$132,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Dai Rios",
                "Personnel Lead",
                "Edinburgh",
                "2290",
                "2012/09/26",
                "$217,500"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jenette Caldwell",
                "Development Lead",
                "New York",
                "1937",
                "2011/09/03",
                "$345,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Yuri Berry",
                "Chief Marketing Officer (CMO)",
                "New York",
                "6154",
                "2009/06/25",
                "$675,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Caesar Vance",
                "Pre-Sales Support",
                "New York",
                "8330",
                "2011/12/12",
                "$106,450"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Doris Wilder",
                "Sales Assistant",
                "Sidney",
                "3023",
                "2010/09/20",
                "$85,600"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Angelica Ramos",
                "Chief Executive Officer (CEO)",
                "London",
                "5797",
                "2009/10/09",
                "$1,200,000"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Gavin Joyce",
                "Developer",
                "Edinburgh",
                "8822",
                "2010/12/22",
                "$92,575"
            ],
            [
                '<label><input name="select" value="2" type="checkbox"><span class="text"></span></label>',
                "Jennifer Chang",
                "Regional Director",
                "Singapore",
                "9239",
                "2010/11/14",
                "$357,650"
            ],
        ];
        return json_encode($data);
    }

}
