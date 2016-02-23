<?php
include 'lib/module.php';
if (isset($_POST['CMD']) && $_POST['CMD'] != ''):
    $strCmd = $_POST['CMD'];
    switch ($strCmd) {
        case "CHECK_EMAIL":
            $strEmail = $_POST['strEmail'];
            if($strEmail!='')
            {
                $arrExist = $objModule->getAll("SELECT COUNT(*) as tcount FROM tbl_users WHERE Email = '".$strEmail."' ");
                $arrReturn = 0;
                if($arrExist[0]['tcount']==0)
                {
                    $arrReturn = 1;
                }
            }
            break;
        case "CHECK_USERNAME":
            $strUsername= $_POST['strUsername'];
            if($strUsername!='')
            {
                $arrExist = $objModule->getAll("SELECT COUNT(*) as tcount FROM tbl_users WHERE Username = '".$strUsername."' ");
                $arrReturn = 0;
                if($arrExist[0]['tcount']==0)
                {
                    $arrReturn = 1;
                }
            }
            break;
        case "GET_SUBCATEGORY":
            $intCatId   =   $_POST['intCat'];
            $intSelect  =   $_POST['intSelect'];
            $strSk      =   $_POST['strSkill'];
            if($strSk!='')
            {
                $arrEdiSk = @explode(',', $strSk);
            }
            $arrSki = '';
			$arrSki1 = '';
            if($intCatId!='')
            {
                $arrSubcat = $objModule->getAll("SELECT * FROM tbl_subcategory WHERE cat_id = '".$intCatId."' ");
                $arrSkills = $objModule->getAll("SELECT * FROM tbl_skills WHERE cat_id = '".$intCatId."' ");
				$arrSkills1 = $objModule->getAll("SELECT * FROM tbl_skills WHERE cat_id = '".$intCatId."' ");
                $arrS ='<select class="required" name="cmbSubCategory"><option value="">-Select Subcategory-</option>';
                if(!empty($arrSubcat))
                {
                    foreach($arrSubcat as $intKey=>$strValue):
                        if($intSelect==$strValue['sid']):
                            $arrS .='<option selected value="'.$strValue['sid'].'">'.$strValue['sname'].'</option>';
                        else:
                            $arrS .='<option value="'.$strValue['sid'].'">'.$strValue['sname'].'</option>';
                        endif;
                    endforeach;
                }
                $arrS .='</select>';
                if(!empty($arrSkills)):
                    foreach($arrSkills as $intKey=>$strValue):
                        if(in_array($strValue['sk_id'], $arrEdiSk))
                        {
                            $arrSki .='<option selected value="'.$strValue['sk_id'].'">'.ucfirst($strValue['sk_name']).'</option>';
                        }
                        else
                        {
                            $arrSki .='<option value="'.$strValue['sk_id'].'">'.ucfirst($strValue['sk_name']).'</option>';
                        }
                    endforeach;
                endif;
				if(!empty($arrSkills1)):
                           $arrSki1 .='<label>Choose Skills</label><div class="skill_option"><ul class="skil more1">';
                          foreach($arrSkills1 as $intKey=>$strValue1): 
                                 $arrSki1 .='<li class="cat_'.$strValue1['cat_id'].' listskill"><label>';
									if(in_array($strValue1['sk_id'], $arrEdiSk))
									{
										$arrSki1 .='<input type="checkbox" name="cmbSkills[]" class="chk_sk" checked value="'.$strValue1['sk_id'].'">';
									}
									else
									{
										$arrSki1 .='<input type="checkbox" name="cmbSkills[]" class="chk_sk" value="'.$strValue1['sk_id'].'">';
									}
                                     
                                      $arrSki1.=ucfirst($strValue1['sk_name']);
                                                        
                                  $arrSki1 .='</label></li>'; 
                             endforeach;
							 $arrSki1 .='</ul></div>';
                endif;
				
                $arrReturn = $arrS.'~~~~~'.$arrSki.'~~~~~'.$arrSki1;
            }
            break;
        case "GET_SUBCAT":
            $intCatId = $_POST['intCat'];
            $arrS ='<option value="">-Select Subcategory-</option>';
            if($intCatId!='')
            {
                $arrSubcat = $objModule->getAll("SELECT * FROM tbl_subcategory WHERE cat_id = '".$intCatId."' ");
                if(!empty($arrSubcat))
                {
                    foreach($arrSubcat as $intKey=>$strValue):
                        if($_POST['intSelect']==$strValue['sid'])
                        {
                            $arrS .='<option selected value="'.$strValue['sid'].'">'.$strValue['sname'].'</option>';
                        }
                        else
                        {
                            $arrS .='<option value="'.$strValue['sid'].'">'.$strValue['sname'].'</option>';
                        }
                    endforeach;
                }
            }
            $arrReturn = $arrS;
            break;
        case "GET_SUBCATSEARCHJOB":
            $intCatId = $_POST['intCat'];
            $arrS ='<option value="">-Select Subcategory-</option>';
            $arrSki = '<option value="">-Select Skill-</option>';
            if($intCatId!='')
            {
                $arrSubcat = $objModule->getAll("SELECT * FROM tbl_subcategory WHERE cat_id = '".$intCatId."' ");
                $arrSkills = $objModule->getAll("SELECT * FROM tbl_skills WHERE cat_id = '".$intCatId."' ");
                if(!empty($arrSubcat))
                {
                    foreach($arrSubcat as $intKey=>$strValue):
                        if($_POST['intSelect']==$strValue['sid'])
                        {
                            $arrS .='<option selected value="'.$strValue['sid'].'">'.$strValue['sname'].'</option>';
                        }
                        else
                        {
                            $arrS .='<option value="'.$strValue['sid'].'">'.$strValue['sname'].'</option>';
                        }
                    endforeach;
                }
                if(!empty($arrSkills)):
                    foreach($arrSkills as $intKey=>$strValue):
                        if($strValue['sk_id']==$_POST['intSkill'])
                        {
                            $arrSki .='<option selected value="'.$strValue['sk_id'].'">'.ucfirst($strValue['sk_name']).'</option>';
                        }
                        else
                        {
                            $arrSki .='<option value="'.$strValue['sk_id'].'">'.ucfirst($strValue['sk_name']).'</option>';
                        }
                    endforeach;
                endif;
            }
            $arrReturn = $arrS.'~~~~~'.$arrSki;
            break;
        case "GET_SKILLS":
            $intCatId = $_POST['intCat'];
            $arrSki = '<option value="">-Select Skill-</option>';
            if($intCatId!='')
            {
                $arrSkills = $objModule->getAll("SELECT * FROM tbl_skills WHERE cat_id = '".$intCatId."' ");
                if(!empty($arrSkills)):
                    foreach($arrSkills as $intKey=>$strValue):
                        if($strValue['sk_id']==$_POST['intSkill'])
                        {
                            $arrSki .='<option selected value="'.$strValue['sk_id'].'">'.ucfirst($strValue['sk_name']).'</option>';
                        }
                        else
                        {
                            $arrSki .='<option value="'.$strValue['sk_id'].'">'.ucfirst($strValue['sk_name']).'</option>';
                        }
                    endforeach;
                endif;
            }
            $arrReturn = $arrSki;
            break;
        case "ADD_FILE":
            $arrReturn = '<div class="files"><input type="file" name="files[]" onchange="checkFile(this);"   />'
                . '<a href="javascript:;" class="remove" onclick="removeFile(this);" ></a><a href="javascript:;" class="add-more" onclick="addFile();"></a>'
                . '</div>';
            break;
        case "ADD_FILE_ADMIN":
            $arrReturn = '<div class="files"><input type="file" name="files[]"  />'
                . '<a href="javascript:;"  onclick="addFile();"><img src="'.$objModule->SITEURL.'admin/images/add-more.png" /></a><a href="javascript:;" onclick="removeFile(this);" ><img src="'.$objModule->SITEURL.'admin/images/remove1.png" /></a>'
                . '</div>';
            break;
        case "DEL_ATTCH":
            $intPostId   =  $_POST['intPostId'];
            $intAttId    =  $_POST['intAtId'];
            if($intAttId!='' && $intPostId!='')
            {
                $arrAttch = $objModule->getAll("SELECT * FROM tbl_post_attach WHERE att_id = '".$intAttId."' AND post_id = '".$intPostId."' ");
                if(!empty($arrAttch))
                {
                    $objData =  new PCGData();
                    $objData->setTableDetails("tbl_post_attach","att_id");
                    $objData->setWhere("att_id = '".$intAttId."' AND post_id = '".$intPostId."'");
                    $objData->delete();
                    unset($objData);
                    $strDel = "upload/attachment/".$arrAttch[0]['post_id']."/".$arrAttch[0]['filename'];
                    unlink($strDel);
                    $arrReturn =  1;
                }
                else
                {
                    $arrReturn =  0;
                }
            }
            else
            {
                $arrReturn =  0;
            }
            break;
        case "GET_BIDCONTENT":
            $intBid     =   $_POST['bid_id'];
            $arrContent =   $objModule->getAll("SELECT * FROM tbl_bidding WHERE Id = '".$intBid."' ");
            $arrReturn  =   '<div class="popup-cont">'.$arrContent[0]['Description'].'</div>';
            break;
        case "ADD_MILESTONE":
            $intCnt = ($_POST['intCnt']+1);
            //if($intCnt>1)
            //{
                $strA = "<a href='javascript:;' onclick='removeMilestone(this);' class='icnbtn'><i class='fa fa-minus-circle'></i></a>";
            //}
            $arrReturn ="<li class='files' id='filediv".$intCnt."'>
                                <div class='fas'><input class='required' type='text'  name='title[]' placeholder='Title' ></div>
                                <div class='cn'><input class='required cost onlynumber' type='text' value='0' name='cost[]' onblur='return chkAmnt();' placeholder='Cost' ></div>
                                <div class='dt'><input class='datetimepicker3 required' type='text' value='".date("d-m-Y")."' name='edate[]' placeholder='Estimate Delivery Date' >
                               
                                </div>
                                <div class='edt'> ".$strA."
                                </div>    
                            </li>";
            break;
            case "UPDATE_NOTIFY":
                $arrUpdate = $objModule->getAll("UPDATE tbl_notification SET Status = '1' WHERE To_userId = '".$_SESSION['clg_userid']."' ");
                $arrReturn = 1;
            break;
    }
    print_r($arrReturn);exit;
endif;
?>