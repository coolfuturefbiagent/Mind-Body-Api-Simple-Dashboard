
<?php
require_once("config.php");
require_once("includes/ViewSchedule.php");
require_once("includes/siteService.php");



// initialize default credentials
$creds = new SourceCredentials(SOURCE_NAME, KEY, array(SIDE_ID));

$classService = new MBClassService();
$classService->SetDefaultCredentials($creds);
$sessiontypeids=array();
if(isset($_GET['classtype']) AND $_GET['classtype']!==""){
	$sessiontypeids[]=urldecode($_GET['classtype']);
	
}
$fields=array("ClassSchedules.DaySunday",


"ClassSchedules.ID",
"ClassSchedules.DayMonday",
"ClassSchedules.DayTuesday",
"ClassSchedules.DayWednesday",
"ClassSchedules.DayThursday",
"ClassSchedules.DayFriday",
"ClassSchedules.DaySaturday",
"ClassSchedules.StartTime",
"ClassSchedules.EndTime",
"ClassSchedules.StartDate",
"ClassSchedules.EndDate",

"ClassSchedules.ClassDescription.Name"





);
$schedule=new Schedule(null,null,XMLDetail::Bare,$fields);
function get_session_ids($creds){
	
	
	
	$siteService= new MBSiteservice();
$siteService->SetDefaultCredentials($creds);
$tt=FALSE;
$session_types=$siteService->GetSessionTypesRequest(array(),false, $creds);
$session_types_array=$session_types->GetSessionTypesResult->SessionTypes->SessionType;
	return $session_types_array;
	
}

function get_class_schdulles($creds,$classService,$sessiontypeid){
	
	$result=$classService->GetClassSchedulesRequest($sessiontypeid, NULL,NULL, XMLDetail::Full, NULL,$creds);
	echo "<pre>";
	print_r($result);
	echo "</pre>";
}
?>
	<?php include("tem/header.html");?>
		<div id="page-wrapper">

	<br/>
<div class="container">
    <div class="row"> 
	
	
	
	
		<form action='schedule.php' method='get'>	
        <div class="col-xs-8 col-xs-offset-2">
		
	
		    <div class="form-group">
                <label for="classtypelists">Class Type</label>
			<select id='classtypelists'  class='form-control'style='' name='classtype'>
			  <option value='0' selected> Select Class Type</option>
			<?php
			$class_types_array=get_session_ids($creds,	$siteService);
		
			for($i=0;$i<count($class_types_array);$i++){
				
			$session_name=$class_types_array[$i]->Name;
            $session_id=$class_types_array[$i]->ID;

?>
<option name='sessionid' value='<?php echo $session_id; ?>' ><?php  echo $session_name;?></option>


<?php			
				
				
				
			}
			?>
			
			</select>
			
			

			
<br/>
			
                
              <button id='searchbuttons' type="submit" class="btn btn-primary">Search</button>
				
				
            </div>
        </div>
	
	</div>
	
	
	</form>
	
	
	
	
	
	
	
	
	
	
	
	
	<?php //get_class_schdulles($creds,$classService,$sessiontypeids); ?>
	
	<?php
	
	
	
	 $schedule->get_schedules("html", $sessiontypeids);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	?>
	
	
	
	


	
	

</div>
</div>
	<?php include("tem/footer.html");?>