<?php

namespace Api\Controller;

use Api\Common\CommonController;

class JPushController extends CommonController {
	var $runTime_1;
	protected $Config, $ConfigData;

    public function _initialize(){
    	$this->runTime_1 = microtime(true);
        parent::_initialize();
        set_time_limit(0);
        $this->Config = D("Config");
        $ConfigData=F("web_config");
        if(!$ConfigData){
            $ConfigData=$this->Config->order(array('id'=>'desc'))->select();
            F("web_config",$ConfigData);
        }
        $thirdApiconfig=array();
        foreach ($ConfigData as $r) {
            if($r['groupid'] == 5){
                $thirdApiconfig[$r['varname']] = $r['value'];
            }
        }
        $this->ConfigData=$thirdApiconfig;
    }
    
}