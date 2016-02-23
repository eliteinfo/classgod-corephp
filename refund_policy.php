<?php include 'lib/module.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<title>Class God</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("ul.menu li:has(ul)").addClass("parent");
$(".menu_link").click(function(){
$(this).next("ul").slideToggle(400);
return false;
});
$(".menu_link").toggle(function(){
$(this).addClass("active");
}, function () {
$(this).removeClass("active");
});
});
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".custom-select").each(function(){
            $(this).wrap("<span class='select-wrapper'></span>");
            $(this).after("<span class='holder'></span>");
        });
        $(".custom-select").change(function(){
            var selectedOption = $(this).find(":selected").text();
            $(this).next(".holder").text(selectedOption);
        }).trigger('change');
    })
</script>
</head>
<body>
<!----Top Start---->
<?php include('includes/header_top.inc.php'); ?>
<!----Top End----> 
<!----header Start---->
<?php include('includes/refund_policy.inc.php'); ?>
<!----mid End----> 
<!----Footer Start---->
<?php include('includes/footer.inc.php'); ?>
</body>
</html>
