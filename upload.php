<?php
include 'lib/module.php';
include 'lib/unplagapi.class.php';
define('API_KEY', 'XqM1dBpDN8rYPEtu');
define('API_SECRET', 'I7QpcjZeomzMVwERfAWK58tsb2LPvGxr');
$un_api = new UnApi(API_KEY, API_SECRET);
$arrData = $objModule->getAll("SELECT * FROM tbl_assignment WHERE cstatus = '0' AND file_id !='' AND check_id !='' ");
if(!empty($arrData))
{
    foreach($arrData as $intKey=>$strValue)
    {
        $result = $un_api->GetResults($strValue['check_id']);
        if($result['checks_results'][0][0]['progress']==100)
        {
            if($result['checks_results'][0][0]['similarity']<41)
            {
                $objData = new PCGData();
                $objData->setTableDetails("tbl_assignment", "id");
                $objData->setFieldValues("cstatus",'1');
                $objData->setWhere("mid = '".$strValue['mid']."' AND post_id = '".$strValue['post_id']."' AND check_id = '".$strValue['check_id']."' ");
                $objData->update();
                unset($objData);
            }
            else
            {
                $objData =  new PCGData();
                $objData->setTableDetails("tbl_notification","Id");
                $objData->setFieldValues("post_id",$strValue['mid']);
                $objData->setFieldValues("From_userId",0);
                $objData->setFieldValues("To_userId",$strValue['uid']);
                $objData->setFieldValues("Ntype",'11');
                $objData->setFieldValues("Ndate",date("Y-m-d H:i:s"));
                $objData->setFieldValues("Status",0);
                $objData->insert();
                unset($objData);
                //echo "<pre>";print_r(353);die;
                $objData = new PCGData();
                $objData->setTableDetails("tbl_assignment", "id");
                $objData->setWhere("mid = '".$strValue['mid']."' AND post_id = '".$strValue['post_id']."' AND check_id = '".$strValue['check_id']."' ");
                $objData->delete();
                unset($objData);
            }
        }
    }
}
?>