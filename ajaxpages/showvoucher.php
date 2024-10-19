<?php
$t=1;
@session_start();
$t=1;
error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);
ini_set("display_errors",0);
ini_set("session.bug_compat_warn",0);
ini_set("session.bug_compat_42",0);
$sessionid	=	$_SESSION['datadetail'][0]['sessionid'];
if(!isset($_SESSION['datadetail'][0]['sessionid']))
{
	echo '<script>document.location.href="./vnr_supervisor";</script>';
}
require("../validation/validation.php");
include("../enc/urlenc.php");
require('../db/db_connect.php');
date_default_timezone_set('Asia/Calcutta');
$dbconnection = new DatabaseConnection;
$dbconnection->connect();

?>
<html>
<title>PRINT ADVANCE PAYMENT VOUCHER</title>
<head>
<style>
td{
padding:3px;
}
</style>
</head>
<body>
<div id="printdiv">
<?php
$query	=	$dbconnection->firequery("select * from advance_tbl where advanceid=".$_POST['advanceid']."");
while($row=mysqli_fetch_assoc($query))
{
?>	
<table style="width:100%; border:1px solid #CCCCCC; border-collapse:collapse;" border="1">
<tr style="line-height:100px; vertical-align:middle;">
	<td colspan="2" align="center"><img src="./images/vnr.png" style="float:left;" /><b style="font-size:30px;">VNR SEEDS PVT. LTD.</b></td>
</tr>
<tr><td colspan="2" align="center"><b>ADVANCE PAYMENT ENTRY FOR <?php echo $dbconnection->getField("location_tbl","locationname","locationid=".$row['location']."");?></b></td></tr>
<tr>
	<td width="50%;" align="left">Voucher Number : <b><?php echo $row['slipnumber'];?></b></td>
	<td align="left">Payment Date : <b><?php echo date('d\-m\-Y',strtotime($row['advancedate']));?></b></td>
</tr>
<tr>
	<td align="left">Department Name : <b><?php echo $dbconnection->getField("department_tbl","departmentname","departmentid=".$row['department']."");?></b></td>
	<td align="left">Hamali Group Name : <b><?php echo $dbconnection->getField("hamaligroup_tbl","groupname","hgid=".$row['groupname']."");?></b></td>
</tr>
<tr>
	<td align="left">Amount : <b><i class="fa fa-inr"></i> <?php echo $row['amount'];?></b></td>
	<td align="left">Payment Mode : <b><?php echo $row['paymentmode'];?></b></td>
</tr>
<tr>
	<td align="left">Cheque/DD Number : <?php echo $row['cdno'];?></td>
	<td align="left">
		Remark : <?php echo $row['remark'];?>
	</td>
</tr>
<tr style="line-height:100px;">
	<td align="center" style="font-size:14px; font-weight:bold; border:none;" colspan="2">
		<label style="float:left;"><b>PREPARE BY</b></label>
		<label style="margin:0 auto;"><b>RECEIVED BY</b></label>
		<label style="float:right;"><b>AUTHORISED SIGNATORY</b></label>
	</td>
</tr>

</table>
</div>
<br>
<button type="button" class="btn" onclick="printDiv()">Print</button>
<button type="button" class="btn" onclick="Cls()">Close</button>

<?php
}
?>
</form>
</body>
</html>
