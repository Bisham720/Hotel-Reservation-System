<?php 
include_once("../includes/a-session.php");
include_once("../includes/dbconnect.php"); 

if(isset($_POST['pay'])){

	$amount=$_POST['amount'];
	$ad_id=$_POST['ad_id'];
	$sql="INSERT INTO tbl_installment(bill_id, amount,date)VALUES('$ad_id','$amount','')";
	$result = executequery($sql);
	header('location:managead.php');
}


$sql = "SELECT * FROM tbl_advertisement WHERE ad_id=".$_GET['ad_id'];
$result = executequery($sql);
$dataad=mysqli_fetch_assoc($result);
$start_date=$dataad['start_date'];
$dt1=explode('-',$start_date);
$day1=$dt1[2];
$month1=$dt1[1];

$end_date=$dataad['end_date'];
$dt2=explode('-',$end_date);
$day2=$dt2[2];
$month2=$dt2[1];

$noofmonths=$month2-$month1;
if($noofmonths==0){
	$noofdays=$day2-$day1;
}else if($noofmonths==1){
	$noofdays=$day1+$day2;
}else{
	$noofdays=$day1+$day2+$noofmonths*30;

}
$noofweeks=ceil($noofdays/7);


$sql = "SELECT * FROM tbl_advertisement_schedule WHERE ad_id=".$_GET['ad_id'];
$result = executequery($sql);
$amount=0;
while($data=mysqli_fetch_assoc($result)){

$program_id=$data['program_id'];
$frequency=$data['frequency'];

$sql1="SELECT * FROM tbl_program as p, tbl_program_days as pd WHERE p.program_id=pd.pid AND p.program_id=".$program_id;
$result1 = executequery($sql1);
$i=1;

while($data1=mysqli_fetch_assoc($result1)){
     $amount+=$data1['rate']*$frequency;
	 $i++;
}

}
$totalamount=$amount*$noofweeks;



?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Media Planning System</title>

<!-- Bootstrap core CSS -->
<link href="assets/css/bootstrap.css" rel="stylesheet">
<!--external css-->
<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

<!-- Custom styles for this template -->
<link href="assets/css/style.css" rel="stylesheet">
<link href="assets/css/style-responsive.css" rel="stylesheet">
<link href="assets/css/table-responsive.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<section id="container" > 
  <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** --> 
  <!--header start-->
  <?php  include("header.php");?>
  <!--header end--> 
  
  <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** --> 
  <!--sidebar start-->
  <?php include("sidebar.php");?>
  <!--sidebar end--> 
  
  <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** --> 
  <!--main content start-->
  <section id="main-content">
    <section class="wrapper">
	
	<?php
	
	$sql="SELECT * FROM tbl_installment WHERE bill_id=".$_GET['ad_id'];
	$result = executequery($sql);
	$amountpaid=0;
	while($dataad=mysqli_fetch_assoc($result)){
		$amountpaid+=$dataad['amount'];
	}
	
	
	?>
	
	
	
	 
        <h4><i class="fa fa-angle-right"></i> Payment Details </h4>
            <section id="unseen">
              <table class="table table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    <th>Remaining Amount: <?php echo $totalamount-$amountpaid;?></th>
					
                   
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><?php //echo $totalamount;?>
					
					<form action="makepayment.php" method="POST">
					<input type="hidden" name="ad_id" value="<?php echo $_GET['ad_id']?>">
					Amount<input type="text" name="amount">
					
					<input type="submit" name="pay" value="Submit">
					
					
					
					</form>
					
					
						<a href="billing.php?amt">
					</td>
                  </tr>
                </tbody>
              </table>
            </section>
          </div>
          <!-- /content-panel --> 
        </div>
        <!-- /col-lg-4 --> 
      </div>
      <!-- /row -->
      
      <?php //}//end of else ?>
    </section>
    <!--wrapper --> 
  </section>
  <!-- /MAIN CONTENT --> 
  
  <!--main content end-->
  <?php include("footer.php");?>
</section>

<!-- js placed at the end of the document so the pages load faster --> 
<script src="assets/js/jquery.js"></script> 
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script> 
<script src="assets/js/jquery.ui.touch-punch.min.js"></script> 
<script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script> 
<script src="assets/js/jquery.scrollTo.min.js"></script> 
<script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script> 

<!--common script for all pages--> 
<script src="assets/js/common-scripts.js"></script> 

<!--script for this page--> 

<script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>
</body>
</html>
