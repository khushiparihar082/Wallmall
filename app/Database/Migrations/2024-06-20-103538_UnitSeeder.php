<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use App\Traits\CommonTraits;
class UnitSeeder extends Migration
{
    use CommonTraits;
    public function up()
    {
        $data = $this->getUnitModel()->first();
        if(empty($data)){
            $mst_unit = array(
                array('unit_name' => 'BAG'),
                array('unit_name' => 'BAL'),
                array('unit_name' => 'BDL'),
                array('unit_name' => 'BKL'),
                array('unit_name' => 'BOU'),
                array('unit_name' => 'BOX'),
                array('unit_name' => 'BTL'),
                array('unit_name' => 'BUN'),
                array('unit_name' => 'CAN'),
                array('unit_name' => 'CBM'),
                array('unit_name' => 'CCM'),
                array('unit_name' => 'CMS'),
                array('unit_name' => 'CTN'),
                array('unit_name' => 'DOZ'),
                array('unit_name' => 'DRM'),
                array('unit_name' => 'GGK'),
                array('unit_name' => 'GMS'),
                array('unit_name' => 'GRS'),
                array('unit_name' => 'GYD'),
                array('unit_name' => 'KGS'),
                array('unit_name' => 'KLR'),
                array('unit_name' => 'KME'),
                array('unit_name' => 'MLT'),
                array('unit_name' => 'MTR'),
                array('unit_name' => 'MTS'),
                array('unit_name' => 'NOS'),
                array('unit_name' => 'PAC'),
                array('unit_name' => 'PCS'),
                array('unit_name' => 'PRS'),
                array('unit_name' => 'QTL'),
                array('unit_name' => 'ROL'),
                array('unit_name' => 'SET'),
                array('unit_name' => 'SQF'),
                array('unit_name' => 'SQM'),
                array('unit_name' => 'SQY'),
                array('unit_name' => 'TBS'),
                array('unit_name' => 'TGM'),
                array('unit_name' => 'THD'),
                array('unit_name' => 'TON'),
                array('unit_name' => 'TUB'),
                array('unit_name' => 'UGS'),
                array('unit_name' => 'UNT'),
                array('unit_name' => 'YDS'),
                array('unit_name' => 'OTH')
              );
            foreach ($mst_unit as $key => $unit) {
                $this->getUnitModel()->insert($unit);
            }
            
        }
    }

    public function down()
    {
        //
    }
}
