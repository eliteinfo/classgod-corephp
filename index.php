<?php
include 'lib/module.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<title>Class God</title>
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="css/owl.carousel.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script src="js/owl.carousel.js" type="text/javascript"></script>
<script type="text/javascript" src="js/script.js"></script>

<script type="text/javascript">
$(".menu_link").hide();
$(document).ready(function(){
$("ul.menu li:has(ul)").addClass("parent");
$(".menu_link").click(function(){
$(this).next("ul").slideToggle(400);
return false;
});
$(".menu_link").toggle(function(){
$(this).addClass("active");
}, function(){
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
<body class="home">
<!----Top Start---->
<?php include('includes/header_top.inc.php'); ?>
<!----Top End----> 
<!----header Start---->
<?php include('includes/index.inc.php'); ?>
<!----mid End----> 
<!----Footer Start---->
<?php include('includes/footer.inc.php'); ?>

</body>
</html>
<script>
$(document).ready(function($) {
$('.our-clients').owlCarousel({
		//navigation : true,
        center: true,
        loop:true,
        margin:0,
		responsive:true,
		items : 5, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0
        itemsMobile : false
    });
});
</script>


