<?php

session_start();

error_reporting(E_ALL & ~E_STRICT & ~E_NOTICE);

ini_set("display_errors",0);

ini_set("session.bug_compat_warn",0);

ini_set("session.bug_compat_42",0);

include("../db/db_connect.php");

include("../enc/urlenc.php");

date_default_timezone_set('Asia/Calcutta');

$dbconnection = new DatabaseConnection;

$dbconnection->connect();



if(isset($_SESSION['datadetail'][0]['sessionid']))

{

	$tablename		=	$_POST['processname']."_tbl";

	$searchvalue	=	$_POST['searchvalue'];

	$supervisor		=	$_POST['supervisor'];

	$hamali			=	$_POST['hamali'];

	$frmdate		=	date('Y\-m\-d',strtotime($_POST['frmdate']));

	$todate			=	date('Y\-m\-d',strtotime($_POST['todate']));

	

	// $query	=	"select a.*,b.firstname,b.lastname from workslip_tbl a left join supervisor_tbl b on b.supervisorid=a.supervisorid where date(a.workslipdate) between '".$frmdate."' and '".$todate."' ";
	// if($searchvalue!='')

	// {

	// 	$query.=	"and (a.groupname like '%$searchvalue%' or a.remark like '%$searchvalue%' or b.firstname like '%$searchvalue%' or b.lastname like '%$searchvalue%') ";

	// }

	// if($supervisor!="")

	// {

	// 	$query.=" and a.supervisorid=".$supervisor."";

	// }

	// if($hamali!="")

	// {

	// 	$query.=" and a.groupnumber=".$hamali."";

	// }
	// $query.=" and a.acceptance_status='1'";

	$query = "SELECT a.*, b.firstname AS supervisor_firstname, b.lastname AS supervisor_lastname, 
          c.firstname AS approver_firstname, c.lastname AS approver_lastname 
          FROM workslip_tbl a 
          LEFT JOIN supervisor_tbl b ON b.supervisorid = a.supervisorid 
          LEFT JOIN sectionincharge_tbl c ON c.sectioninchargeid = a.approved_by 
          WHERE DATE(a.workslipdate) BETWEEN '".$frmdate."' AND '".$todate."' ";

		if ($searchvalue != '') {
			$query .= " AND (a.groupname LIKE '%$searchvalue%' OR a.remark LIKE '%$searchvalue%' 
					OR b.firstname LIKE '%$searchvalue%' OR b.lastname LIKE '%$searchvalue%') ";
		}

		if ($supervisor != "") {
			$query .= " AND a.supervisorid = ".$supervisor."";
		}

		if ($hamali != "") {
			$query .= " AND a.groupnumber = ".$hamali."";
		}

		$query .= " AND a.acceptance_status = '1'";
}

$rs_sel		=	$dbconnection->firequery($query);

$rs_count	=	$dbconnection->firequery("$query");

$counter	=	$dbconnection->num_rows($rs_count);

$pagescount	=	ceil($counter/$pagesize);

$fields		=	$dbconnection->num_rows($rs_count);

$i=$start;

$j=0;

while($row=mysqli_fetch_assoc($rs_sel))

{

$i++;

$j++;

$cols=0;

?>

<tr>

	<td class="center" id="action"><?php echo $i; $cols++;?></td>

	<td><?php echo date('d\-m\-Y h:i A',strtotime($row['workslipdate'])); $cols++;?></td>

	<td><?php echo $row['workslipnumber']; $cols++;?></td>	

	<td><?php echo $row['firstname']; $cols++;?> <?php echo $row['lastname']; $cols++;?></td>		

	<td><?php echo $row['groupnumber']; $cols++;?>-<?php echo $row['groupname']; $cols++;?></td>		

	<td style="text-align:right;"><i class="fa fa-inr"></i> <?php echo number_format($row['workslipamount'],'2','.',''); $cols++;?></td>

	<td style="text-align:center;">

	<?php

	if($row['paymentstatus']==0)

	{

		echo "PENDING";

	}

	else

	{

		echo "PAID";

	}

	?>

	</td>
    <td><?php echo $row['approver_firstname'] . ' ' . $row['approver_lastname']; $cols++;?></td>

	<td style="text-align:center;"><i class="fa fa-eye" onclick="ViewDetail(<?php echo $i;?>,<?php echo $row['workslipid'];?>)"></i></td>

	<td style="text-align:center;"><a href="./printing/printworkslip.php?slipid=<?php echo $row['workslipid'];?>" target="_blank"><i class="fa fa-print"></i></a></td>	

</tr>

<tr id="rec<?php echo $i;?>" style="display:none;" class="bg-ingo text-white wrec"><td id="recd<?php echo $i;?>" colspan="11" style="width:100%;"></td></tr>

<?php

}

if($j==0)

{

?>

<tr>

	<td colspan="10" style="padding:0px; text-align:center;">

		<label style="font-size:13px; font-weight:normal; padding:10px;"><i>--No Record Found In Searching Criteria--</i></label>

	</td>

</tr>

<?php

}

?>

