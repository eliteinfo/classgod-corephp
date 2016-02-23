<?php
include 'lib/module.php';
//error_reporting(E_ALL);
if ($_SESSION['clg_userid'] == '')
{
    $objModule->redirect("./login.php");
}
if (isset($_GET['post_id']) && $_GET['post_id'] == "")
{
    if (isset($_GET['post_uid']) && $_GET['post_uid'] == "")
    {
        $objModule->redirect("./search_jobs.php");
    }
}
$arrExistBid  =    $objModule->getAll("SELECT * FROM tbl_bidding WHERE Uid = '".$_SESSION['clg_userid']."' AND Post_id = '".$_GET['post_id']."' ");
if(empty($arrExistBid))
{
    $objModule->redirect("./tutordashboard.php");
}
if ($_POST['btnBidPost'] != '')
{
    if ($_POST['bid_deliverydate'] != '' && $_POST['bid_amount'] != '' && $_POST['hdnBid']!='')
    {
        $current_date = date('Y-m-d H:i:s');
        $strDelivery = date("Y-m-d", strtotime($_POST['bid_deliverydate']));
        $intBid = $_POST['hdnBid'];
        $strUpdate =    "UPDATE tbl_bidding SET Bid_amt = '".$_POST['bid_amount']."',Description='".$_POST['txtBidDesc']."',delivery_date='".$strDelivery."',status = '1' WHERE Post_id = '".$_POST['hdn_postid']."' AND  Uid = '".$_SESSION['clg_userid']."' ";
        $arrUpdate =    $objModule->getAll($strUpdate); 
        
        
        // Notification inserted
        $insert_not_bidother = "INSERT INTO tbl_notification (Id, post_id, From_userId, To_userId, Ntype, Ndate, Status) VALUES (NULL,'" . $_POST['hdn_postid'] . "','" . $_SESSION['clg_userid'] . "','" . $_POST['hdn_posterid'] . "',3,'" . $current_date . "',0)";
        $db_not_decl = $objModule->getAll($insert_not_bidother);

        // send mail to buyer
        $arrPostUSer = $objModule->getAll("SELECT * FROM tbl_users WHERE Id='" . $_POST['hdn_posterid'] . "'");
        $arrBidUser = $objModule->getAll("SELECT Username FROM tbl_users WHERE Id='" . $_SESSION['clg_userid'] . "'");
        $to = $arrPostUSer[0]['Email'];
        $subject = "Notification for Update Bid of Job ";
        $message = '<div style="width:98%;border:1px solid #ccc;padding:10px;border-radius:5px">';
        $message .= '<strong>Dear ' . ucfirst($arrPostUSer[0]['Username']) . ',</strong><br /><br />';
        $message .= "" . ucfirst($arrBidUser[0]['Username']) . " has update bid on your job";
        $message.= "<br /><br /><strong>Thank You,</strong><br />";
        $message.= "<strong>Classgod Team</strong><br />";
        $message .= '</div>';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
        $headers .= 'From: ' . $objModule->INFO_MAIL;
        if (mail($to, $subject, $message, $headers))
        {
            $objModule->setMessage("Bid update successfully","success");
            $objModule->redirect("./tutordashboard.php");
        }
    }
}
if ($_POST['btnWithdraw'] != '')
{
    if ($_POST['hdnBid']!='' && $_POST['hdn_postid']!='')
    {
        $arrCh = $objModule->getAll("SELECT COUNT(*) AS tchec FROM tbl_bidding WHERE Id = '".$_POST['hdnBid']."' AND Post_id = '".$_POST['hdn_postid']."'");
        if($arrCh[0]['tchec']>0)
        {
            $objData =  new PCGData();
            $objData->setTableDetails("tbl_bidding","Id");
            $objData->setWhere("Id = '".$_POST['hdnBid']."' AND Post_id = '".$_POST['hdn_postid']."'  ");
            $objData->delete();
            unset($objData);
            
            $objData =  new PCGData();
            $objData->setTableDetails("tbl_notification","Id");
            $objData->setWhere("post_id = '".$_POST['hdn_postid']."' AND From_userId = '".$_SESSION['clg_userid']."' AND To_userId = '".$_POST['hdn_posterid']."' AND Ntype IN (1,3) ");
            $objData->delete();
            unset($objData);
            
             $objModule->setMessage("Bid delete successfully","success");
        }
        else
        {
            $objModule->setMessage("No bid found","error");
        }
    }
    $objModule->redirect("./tutordashboard.php");
    
}

//add milestone code
if($_POST['btnAddMilestone']!='')
{
    $intCost = array_sum($_POST['cost']);
    if($intCost>$_POST['hdnAmt'])
    {
        $objModule->setMessage("Milestone cost is greater than bid amount remove <br />some milestone or change the cost","error");
    }
    else
    {
        $arrExisMile = $objModule->getAll("SELECT COUNT(*) AS tcnt FROM tbl_milestone WHERE status = '0' AND post_id = '".$_GET['post_id']."' AND uid = '".$_SESSION['clg_userid']."'  ");
        if($arrExisMile[0]['tcnt']>0)
        {
             $objModule->getAll("DELETE FROM tbl_milestone WHERE status = '0' AND post_id = '".$_GET['post_id']."' AND uid = '".$_SESSION['clg_userid']."'  ");
        }
        
        foreach($_POST['cost'] as $intKey=>$strValue):
        if($strValue!='' && $_POST['hdnStatus'][$intKey]==0)
        {
            $objData =  new PCGData();
            $objData->setTableDetails("tbl_milestone","id");
            $objData->setFieldValues("post_id",$_GET['post_id']);
            $objData->setFieldValues("uid",$_SESSION['clg_userid']);
            $objData->setFieldValues("created_at",date("Y-m-d H:i:s"));
            $objData->setFieldValues("status",'0');
            $objData->setFieldValues("edate",date("Y-m-d", strtotime($_POST['edate'][$intKey])));
            $objData->setFieldValues("cost",$strValue);
            $objData->setFieldValues("title",$_POST['title'][$intKey]);
            $objData->insert();
            unset($objData);
        }
        else{continue;}
        endforeach;
        $objModule->redirect("./detail-bidded.php?post_id=".$_GET['post_id']."&job=act&post_uid=".$_GET['post_uid']);
    }
}
$arrPostDetail = $objModule->getAll("select p.id, p.category_id, p.title, p.uid, p.start_date_time, p.end_date_time, p.description, p.win_date, p.win_uid, p.price, p.win_status, p.created_date, p.zipcode,u.Photo, u.Status, u.User_type, u.Creation_date,c.name from tbl_post p,tbl_users u,tbl_category c WHERE u.id=p.uid AND p.id='" . $_GET['post_id'] . "' AND c.id=p.category_id");
$arrClientPost = $objModule->getAll("SELECT COUNT(*) AS tpcnt FROM tbl_post WHERE uid = '" . $_GET['post_uid'] . "' ");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <title>Class God</title>
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css" />
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="js/jquery.datetimepicker.js"></script>
        <script type="text/javascript" src="js/expand.js"></script>
        <script type="text/javascript" src="js/common.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#datetimepicker3').datetimepicker({
                    timepicker: false,
                    format: 'd-m-Y',
                    minDate: '+1970/01/01',
                });
                $('#datetimepicker3').scrollTop(0);
                $(".linkwatchlist").click(function () {
                    alert('Job post has been added to your watchlist.');
                    $(this).hide();
                    $('.remwatchlist').show();
                    return false;
                });
                $(".option_button1").click(function () {
                    $("#bidform").slideDown(500);
                    $(this).hide();
                    return false;
                });
                $("ul.menu li:has(ul)").addClass("parent");
                $(".menu_link").click(function () {
                    $(this).next("ul").slideToggle(400);
                    return false;
                });
                $(".menu_link").toggle(function () {
                    $(this).addClass("active");
                }, function () {
                    $(this).removeClass("active");
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".custom-select").each(function () {
                    $(this).wrap("<span class='select-wrapper'></span>");
                    $(this).after("<span class='holder'></span>");
                });
                $(".custom-select").change(function () {
                    var selectedOption = $(this).find(":selected").text();
                    $(this).next(".holder").text(selectedOption);
                }).trigger('change');
            })
        </script>
        <script>
            $(document).ready(function () {
                $("#faqs div.expand_title").toggler();
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function () {
                $(".category_top").click(function () {
                    $(".category_box").slideToggle(400);
                    return false;
                });
            });
        </script>
    </head>
    <body>
        <!----Top Start---->
        <?php include('includes/header_top.inc.php'); ?>
        <!----Top End----> 
        <!----header Start---->
        <div class="header">
            <ul class="slides">
                <li>
                    <div class="header_main">
                        <div class="header_img"><img src="images/about_inner.jpg" alt=""></div>
                        <div class="header_textbox">
                            <div class="wrapper">
                                <h1>Bid Details</h1>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <!------Header End----> 
        <!----mid Start---->
        <div class="mid">
            <div class="wrapper"> 
                <!----content Start---->
                <div class="content_part"> 
                    <!----Sidebar Start---->
                    <div class="sidebar">
                        <div class="category_box">
                            <div class="sidebar_box">
                                <div class="bid_box">
                                    <div class="regform" id="bidform" style="display: block;">
                                        
                                        <form action="" id="frmBid" method="post" onsubmit="return frmvalidate(this.id);">
                                                <?php if($_GET['job']=='bid'):?>
                                                <div class="row">
                                                    <div class="one_full"><label>Enter Description:</label>
                                                        <textarea class="required" name="txtBidDesc"><?php echo stripslashes($arrExistBid[0]['Description']);?></textarea></div>
                                                </div>
                                                <div class="row">
                                                    <div class="one_full">
                                                        <label>Bid Amount:</label>
                                                        <input class="onlynumber required" value="<?php echo $arrExistBid[0]['Bid_amt'];?>" name="bid_amount" kl_virtual_keyboard_secure_input="on" type="text" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="one_full">
                                                        <label>Estimate Delivery Date:</label>
                                                        <input class="required" id="datetimepicker3" value="<?php echo date("d-m-Y",  strtotime($arrExistBid[0]['delivery_date']));?>" name="bid_deliverydate"  type="text" />
                                                    </div>
                                                </div>
                                                <?php if($arrPostDetail[0]['win_status']==0):?>
                                                <div class="row sbmt">
                                                    <div class="one_full">
                                                        <input type="hidden" id="hdn_posterid" name="hdn_posterid" value="<?php echo $_GET['post_uid']; ?>" />
                                                        <input type="hidden" id="hdn_postid" name="hdn_postid" value="<?php echo $_GET['post_id']; ?>" />
                                                        <input type="hidden" id="hdnBid" name="hdnBid" value="<?php echo $arrExistBid[0]['Id'];?>" />
                                                        <input value="Update Bid" name="btnBidPost" type="submit" />
                                                        <input value="Withdraw" name="btnWithdraw" type="submit" />
                                                    </div>
                                                </div>
                                            <?php endif;?>
                                            <?php else:?>
                                            <div class="row">
                                                <div class="one_full">
                                                    <label>Bid Amount:</label>
                                                    $ <?php echo $arrExistBid[0]['Bid_amt'];?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="one_full">
                                                    <label>Estimate Delivery Date:</label>
                                                    <?php echo date("d M Y",  strtotime($arrExistBid[0]['delivery_date']));?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="one_full">
                                                    <label>Description:</label>
                                                    <?php echo stripslashes($arrExistBid[0]['Description']);?>
                                                </div>
                                            </div>
                                            
                                             <?php if($arrPostDetail[0]['win_status']!=1):?>
                                            <a href="detail-bidded.php?post_id=<?php echo $_GET['post_id'];?>&job=bid&post_uid=<?php echo $_GET['post_uid'];?>" class="round-btn2">Update Bid</a>
                                            <div class="row sbmt">
                                                    <div class="one_full">
                                                        <input type="hidden" id="hdn_posterid" name="hdn_posterid" value="<?php echo $_GET['post_uid']; ?>" />
                                                        <input type="hidden" id="hdn_postid" name="hdn_postid" value="<?php echo $_GET['post_id']; ?>" />
                                                        <input type="hidden" id="hdnBid" name="hdnBid" value="<?php echo $arrExistBid[0]['Id'];?>" />
                                                        <input value="Withdraw" name="btnWithdraw" type="submit" />
                                                    </div>
                                            </div>
                                            <?php endif;?>
                                            <?php endif;?> 
                                            </form>
                                    </div>   
                                </div>
                            </div>
                            <div class="sidebar_box">
                            	<ul class="icon-list2">
                                  <li>
                                    <div class="icn"><span><i class="fa fa-star"></i></span></div>
                                    <div class="tit"><strong>5.00</strong><img src="images/icon15.png" alt=""></div>
                                  </li>
                                  <li>
                                    <div class="icn"><span><i class="fa fa-edit"></i></span></div>
                                    <div class="tit"><strong><?php echo date("d,  M Y", strtotime($arrPostDetail[0]['created_date'])); ?></strong><br>Posted on</div>
                                  </li>
                                  <li>
                                    <div class="icn"><span><i><img alt="" src="images/icon18.png"></i></span></div>
                                    <div class="tit"><strong><?php echo $arrClientPost[0]['tpcnt']; ?></strong>Job Posted</div>
                                  </li>
                                  <li>
                                    <div class="icn"><span><i class="fa fa-tint"></i></span></div>
                                    <div class="tit"><strong><?php
                                                $strCur = strtotime(date("Y-m-d H:i:s"));
                                                $strEnd = strtotime($arrPostDetail[0]['end_date_time']);
                                                if ($strEnd > $strCur)
                                                {
                                                    $diff = $strEnd - $strCur;
                                                    $intDays = round($diff / 86400);
                                                }
                                                if ($intDays > 0)
                                                {
                                                    echo $intDays;
                                                }
                                                else if ($intDays == 0)
                                                {
                                                    echo 1;
                                                }
                                                else
                                                {
                                                    echo 0;
                                                }
                                                ?></strong>Days Left</div>
                                  </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!----Sidebar end---->
                    <div class="blog_part">
                        <h2><?php echo $arrPostDetail[0]['title']; ?></h2>
                        <div class="post_date"><div class="pm"><strong>Posted on:</strong> <?php echo date("d,  M Y", strtotime($arrPostDetail[0]['created_date'])); ?></div><div class="pm"><strong>Category:</strong> <?php echo $arrPostDetail[0]['name'];?></div>
                            <div class="blog_price">
                                <ul>
                                    <li>Est. Budget</li>
                                    <?php if ($arrPostDetail[0]['price'] != '' && $arrPostDetail[0]['price'] != 0): ?>
                                        <li>$<span class="money">10</span></li>
                                    <?php else: ?>
                                        <li><span class="money">N/A</span></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="pro_detail">
                            <?php echo $arrPostDetail[0]['description']; ?>
                        </div>
                        <div class="regform det-bid">
                        	<ul>
                            	<li class="readonly"><div class="fas"><input class="required" type="text" value="Final assignment" name="title[]" placeholder="Title" readonly=""></div><div class="cn"><input class="required cost onlynumber" type="text" value="10" name="cost[]" onblur="return chkAmnt();" placeholder="Cost" readonly=""></div><div class="dt"><input class="datetimepicker3 required" type="text" value="12-05-2015" name="edate[]" placeholder="Estimate Delivery Date" readonly=""></div><div class="edt"><div class="msg success">Accepted</div><button class="icnbtn accept"><i class="fa fa-thumbs-up"></i></button><button class="icnbtn fail"><i class="fa fa-thumbs-down"></i></button><button class="icnbtn"><i class="fa fa-cc-paypal"></i></button><button class="icnbtn"><i class="fa fa-upload"></i></button></div></li>
                                <li><div class="fas"><input class="required" type="text" value="Final assignment" name="title[]" placeholder="Title" readonly=""></div><div class="cn"><input class="required cost onlynumber" type="text" value="10" name="cost[]" onblur="return chkAmnt();" placeholder="Cost" readonly=""></div><div class="dt"><input class="datetimepicker3 required" type="text" value="12-05-2015" name="edate[]" placeholder="Estimate Delivery Date" readonly=""></div><div class="edt"><div class="msg fail">Rejected</div><button class="icnbtn accept"><i class="fa fa-thumbs-up"></i></button><button class="icnbtn fail"><i class="fa fa-thumbs-down"></i></button><button class="icnbtn"><i class="fa fa-cc-paypal"></i></button><button class="icnbtn"><i class="fa fa-upload"></i></button></div></li>
                                <li><div class="fas"><input class="required" type="text" value="Final assignment" name="title[]" placeholder="Title" readonly=""></div><div class="cn"><input class="required cost onlynumber" type="text" value="10" name="cost[]" onblur="return chkAmnt();" placeholder="Cost" readonly=""></div><div class="dt"><input class="datetimepicker3 required" type="text" value="12-05-2015" name="edate[]" placeholder="Estimate Delivery Date" readonly=""></div><div class="edt"><div class="msg success">Accepted</div><button class="icnbtn accept"><i class="fa fa-thumbs-up"></i></button><button class="icnbtn fail"><i class="fa fa-thumbs-down"></i></button><button class="icnbtn"><i class="fa fa-cc-paypal"></i></button><button class="icnbtn"><i class="fa fa-upload"></i></button></div></li>
                            </ul>
                        
                        <?php echo $objModule->getMessage();?>
                    <?php if($arrPostDetail[0]['win_status']==1 && $arrPostDetail[0]['win_uid']==$_SESSION['clg_userid'] && $_SESSION['clg_usertype']==1){
                            $arrMilestone = $objModule->getAll("SELECT * FROM tbl_milestone WHERE post_id = '".$_GET['post_id']."' and uid = '".$_SESSION['clg_userid']."' ");
                        ?>
                            <?php if(empty($arrMilestone)): ?>
                            <a href="javascript://" onclick="addMilestone();">Create Milestone</a>
                            <form method="POST" name="frmMilestone" id="frmMilestone" onsubmit="return chkAmnt();">
                                <div id="filegroup"></div>
                                <input type='hidden' name='hdnAmt' id='hdnBidAmt' value='<?php echo $arrExistBid[0]['Bid_amt'];?>' />
                                <input type="hidden" id="hdnCnt" name="hdnCnt" value="0" />
                                <input type="submit" name="btnAddMilestone" value="Save" onclick="return frmvalidate(this.id);"/>
                            </form>
                            <?php else:?>
                            <form method="POST" name="frmMilestone" id="frmMilestone" onsubmit="return chkAmnt();">
                                <div id="filegroup">
                                    <?php foreach($arrMilestone as $intKeys=>$strVal): $inthdnCnt = ($intKeys+1); ?>
                                            <div class='files' id='filediv<?php echo  $inthdnCnt;?>'>
                                                <?php if($strVal['status']==0): ?>
                                                    <input type='text' placeholder='Title' name='title[]' class='required' value="<?php echo $strVal['title'];?>"/>
                                                    <input type='text' placeholder='Cost' onblur='return chkAmnt();'  name='cost[]' value='<?php echo $strVal['cost'];?>'  class='required cost onlynumber'/>
                                                    <input type='text' placeholder='Estimate Delivery Date' class='datetimepicker3 required' name='edate[]' value='<?php echo date("d-m-Y",strtotime($strVal['edate']));?>' />
                                                    <input type="hidden" name="hdnStatus[]" value="0" />
                                                    <a href='javascript:;' onclick='addMilestone();' class='add-more'></a>
                                                <?php else:?>
                                                    <input type='text' readonly placeholder='Title' name='title[]' class='required' value="<?php echo $strVal['title'];?>"/>
                                                    <input type='text' readonly placeholder='Cost' onblur='return chkAmnt();'  name='cost[]' value='<?php echo $strVal['cost'];?>'  class='required cost onlynumber'/>
                                                    <input type='text' readonly placeholder='Estimate Delivery Date' class='datetimepicker3 required' name='edate[]' value='<?php echo date("d-m-Y",strtotime($strVal['edate']));?>' />    
                                                    <input type="hidden" name="hdnStatus[]" value="1" />
                                                <?php endif;?>
                                                
                                                <?php if($inthdnCnt!=1 && $strVal['status']==0): ?>
                                                <a href='javascript:;' onclick='removeMilestone(this);' class='remove'></a>
                                                <?php endif;?>
                                            </div>
                                    <?php endforeach;?>
                                </div>
                                <input type='hidden' name='hdnAmt' id='hdnBidAmt' value='<?php echo $arrExistBid[0]['Bid_amt'];?>' />
                                <input type="hidden" id="hdnCnt" name="hdnCnt" value="<?php count($arrMilestone);?>" />
                                <input type="submit" name="btnAddMilestone" value="Update" onclick="return frmvalidate(this.id);"/>
                            </form>
                            <?php endif;?>
                    <?php } ?>
                    </div>
                        
                    </div>
                    
                </div>
                <!----content End----> 
            </div>
        </div>
        <!----mid End----> 
        <!----Footer Start---->
        <?php include('includes/footer.inc.php'); ?> 
    </body>
</html>
<script type="text/javascript">
function addMilestone()
{
      var intCnt = parseInt(jQuery("#hdnCnt").val());
        jQuery.ajax({
            url: 'ajax.php',
            data: {CMD: "ADD_MILESTONE",intCnt:intCnt},
            type: 'POST',
            success: function (data)
            {
                jQuery("#filegroup").append(data);
                jQuery("#hdnCnt").val(intCnt + 1);
                inti();
                
            }
        });
    
    
}
function removeMilestone(strObj)
{
    var intCnt = parseInt(jQuery("#hdnCnt").val());
    jQuery(strObj).parent("div.files").remove();
    jQuery("#hdnCnt").val(intCnt - 1);
}
function inti()
{

    jQuery('.datetimepicker3').datetimepicker({
                        timepicker:false,
                        format:'d-m-Y',
                        minDate:'+1970/01/01'
                });
    jQuery('.datetimepicker3').scrollTop(0); 
    jQuery(".onlynumber").keyup(function(e)
   {
    if (/\D/g.test(this.value))
    {
        // Filter non-digits from input value.
        this.value = this.value.replace(/\D/g, '');
    }
    });
}
function chkAmnt()
{
    var intBidAmt       =   parseFloat(jQuery("#hdnBidAmt").val());
    var intMilstone     =   0; 
    jQuery(".cost").each(function(intKey,strVal){
        intMilstone =  intMilstone + parseFloat(this.value);
    });
    if(intMilstone > intBidAmt)
    {
        alert("Milestone cost is not greater than bid amount \n\
               remove some milestone or change the cost");
        return false;
    }
}
jQuery(document).ready(function(){
   inti(); 
});
</script>    
