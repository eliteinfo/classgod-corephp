<?php 
include_once 'lib/module.php';
$select_post = $objModule->getAll("SELECT * FROM tbl_post WHERE uid = '".$_SESSION['clg_userid']."'");
foreach($select_post as $data){
 $delete_asign = $objModule->getAll("DELETE FROM tbl_assignment WHERE post_id = '".$data['id']."'");
 $delete_bids = $objModule->getAll("DELETE FROM tbl_bidding WHERE Post_id = '".$data['id']."'");
 $delete_miles = $objModule->getAll("DELETE FROM tbl_milestone WHERE post_id = '".$data['id']."'");
 $delete_miles_pay = $objModule->getAll("DELETE FROM tbl_milestone_payment WHERE post_id = '".$data['id']."'");
 $delete_rates = $objModule->getAll("DELETE FROM tbl_ratings WHERE post_id = '".$data['id']."'");
 $delete_reviews = $objModule->getAll("DELETE FROM tbl_reviews WHERE review_post = '".$data['id']."'");
 $delete_tmp_pay = $objModule->getAll("DELETE FROM tbl_temp_payment WHERE post_id = '".$data['id']."'");
 $delete_tmp_tutor = $objModule->getAll("DELETE FROM tbl_temp_tutor WHERE post_id = '".$data['id']."'");
 $delete_ttr_pay = $objModule->getAll("DELETE FROM tbl_tutor_pay WHERE post_id = '".$data['id']."'");
 $delete_post_attach = $objModule->getAll("DELETE FROM tbl_post_attach WHERE post_id = '".$data['id']."'");
}
$delete_user = $objModule->getAll("DELETE FROM tbl_users WHERE Id = '".$_SESSION['clg_userid']."'");
$delete_assign = $objModule->getAll("DELETE FROM tbl_assignment WHERE uid = '".$_SESSION['clg_userid']."'");
$delete_bid = $objModule->getAll("DELETE FROM tbl_bidding WHERE Uid = '".$_SESSION['clg_userid']."'");
$delete_msg = $objModule->getAll("DELETE FROM tbl_messages WHERE From_user = '".$_SESSION['clg_userid']."' OR To_user = '".$_SESSION['clg_userid']."'");
$delete_milestone = $objModule->getAll("DELETE FROM tbl_milestone WHERE uid = '".$_SESSION['clg_userid']."'");
$delete_milestone_pay = $objModule->getAll("DELETE FROM tbl_milestone_payment WHERE uid = '".$_SESSION['clg_userid']."'");
$delete_noti = $objModule->getAll("DELETE FROM tbl_notification WHERE From_userId = '".$_SESSION['clg_userid']."' OR To_userId = '".$_SESSION['clg_userid']."'");
$delete_post = $objModule->getAll("DELETE FROM tbl_post WHERE uid = '".$_SESSION['clg_userid']."'");
$delete_rate = $objModule->getAll("DELETE FROM tbl_ratings WHERE from_uid = '".$_SESSION['clg_userid']."' OR to_uid = '".$_SESSION['clg_userid']."'");
$delete_review = $objModule->getAll("DELETE FROM tbl_reviews WHERE review_from = '".$_SESSION['clg_userid']."' OR review_to = '".$_SESSION['clg_userid']."'");
$delete_temp_payment = $objModule->getAll("DELETE FROM tbl_temp_payment WHERE uid = '".$_SESSION['clg_userid']."'");
$delete_temp_tutor = $objModule->getAll("DELETE FROM tbl_temp_tutor WHERE uid = '".$_SESSION['clg_userid']."'");
$delete_tutor_pay = $objModule->getAll("DELETE FROM tbl_tutor_pay WHERE uid = '".$_SESSION['clg_userid']."'");
$delete_skills = $objModule->getAll("DELETE FROM tmp_skills WHERE uid = '".$_SESSION['clg_userid']."'");

session_destroy();
$objModule->redirect("./login.php");
?>