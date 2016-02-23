<?php 
include 'lib/module.php';
if($_REQUEST['h']!='' && $_REQUEST['u']!='')
{
    $strCode = base64_decode($_REQUEST['h']);
    $intUser = $_REQUEST['u'];
    $arrCheck = $objModule->getAll("SELECT * FROM tbl_users WHERE Id = '".$intUser."'  ");
    if($arrCheck[0]['Status']==1)
    {
        $_SESSION['clg_userid'] = $arrCheck[0]['Id'];
        $_SESSION['clg_usertype'] = $arrCheck[0]['User_type'];
        $_SESSION['classgod_User']=$arrCheck;
        $objModule->setMessage("Your account is already activated link is expired","error");
        $objModule->redirect("./addjob.php");
    }
    if(!empty($arrCheck) && $arrCheck[0]['verify_code']==$strCode)
    {
        
        $objData = new PCGData();
        $objData->setTableDetails("tbl_users","Id");
        $objData->setFieldValues("Status",'1');
        $objData->setFieldValues("verify_code","");
        $objData->setWhere("Id = '".$intUser."' ");
        $objData->update();
        $arrCheck1 = $objModule->getAll("SELECT * FROM tbl_users WHERE Id = '".$intUser."'  ");
        $_SESSION['clg_userid'] = $arrCheck1[0]['Id'];
        $_SESSION['clg_usertype'] = $arrCheck1[0]['User_type'];
        $_SESSION['classgod_User']=$arrCheck1;
        
        
        if($arrCheck[0]['scrtyq']=='1')
        {
            if($arrCheck[0]['User_type']==0)
            {
                /*for buyer*/
                $objModule->redirect("./addjob.php");
            }
            else
            {
                /* for tutor*/
                $objModule->redirect("./edit_tutor_profile.php");
            }
        }
        else
        {
            $objModule->redirect("./security.php");
        }
    }
}
?>