
<?php
require_once("config.php");
require_once("includes/StaffClass.php");
require_once("includes/siteService.php");


$creds = new SourceCredentials(SOURCE_NAME, KEY, array(SIDE_ID));
	$siteService= new MBSiteservice();
$siteService->SetDefaultCredentials($creds);

//get_location_ids(	$creds,$siteService);



function get_location_ids(	$creds,$siteService){
   $fields=array("Locations.Name","Locations.ID");
	$session_types=$siteService->GetSessionTypesRequest(array(),false, $creds);
	
	$locations=$siteService->get_locations($creds,XMLDetail::Bare,null,null, $fields);
if($locations){
	return $locations;
}
else{
	return false;
}
	
}




function get_session_ids($creds,$siteService){
	
$fields=array("SessionType.Name","SessionType.ID");
$tt=FALSE;
$session_types=$siteService->GetSessionTypesRequest(array(),false, $creds,XMLDetail::Bare,null,null,$fields);
$session_types_array=$session_types->GetSessionTypesResult->SessionTypes->SessionType;
	return $session_types_array;
	
}
?>
	<?php include("tem/header.html");?>
	
		<div id="page-wrapper">

		<br/>
		<div class="container">
    <div class="row"> 
	<form action='staffinfo.php' method='get'>	
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
			
			
			  <div  id='selectlocation'class="form-group">
    <label for="locationid">Location ID</label>
    <select  name='locationid' class="form-control" id="locationid" >
	<?php
	
	$location=get_location_ids($creds,$siteService);
	

	$location_list=$location->GetLocationsResult->Locations->Location;
	if(is_array($location_list)){
		
		for($i=0;$i<count($location_list);$i++){
			
		$location_name=$location_list[$i]->Name;
        $location_id=$location_list[$i]->ID;		
			?>
			
			<option name='locationid' value='<?php echo    $location_id; ?>' ><?php  echo $location_name;?></option>
			
			<?php
			
		}
		
		
		
		
	}
	
	
	
	?>
	
	</select>
  </div>
			
			
			  <div id='selectdatetime' class="form-group">
    <label for="availableDatetime">Available DateTime</label>
    <input type="text" class="form-control" id="availableDatetime" name='availabledatetime'>
  </div>
			
			
                
              <button id='searchbutton' type="submit" class="btn btn-primary">Search</button>
				
				
            </div>
        </div>
	
	</div>
</div>
		
		
		
		<center><h3>Staff Information</h3></center>
		<br/>
<?php
$currentpage=0;
$sessiontypeid=null;
$locationid=null;
$availabledatetime=null;
if(isset($_GET['classtype']) AND $_GET['classtype']!==""){
	
	$sessiontypeid=(int)$_GET['classtype'];
}


if(isset($_GET['locationid']) AND $_GET['locationid']!==""){
	
	$locationid=(int)$_GET['locationid'];
}

if(isset($_GET['availabledatetime']) AND $_GET['availabledatetime']!==""){
	
	$availabledatetime=urldecode($_GET['availabledatetime']);
}







if(isset($_GET['p']) AND is_int((int)$_GET['p'])){
$currentpage=(int)$_GET['p'];	
}

$fields=array("Staff.ID","Staff.Name","Staff.Address","Staff.Bio","Staff.MobilePhone","Staff.HomePhone","Staff.ImageURL");

$staffclass= new  StaffInfo($currentpage,10,XMLDetail::Bare,$fields);


$staffclass-> get_staff_info("html",$sessiontypeid,$locationid,$availabledatetime);















?>
	</div>
		<?php include("tem/footer.html");?>
		
		
		<script>
		$(document).ready(function(){
			$selected_val=$("#classtypelists").val();
			if($selected_val==0){
						$("#searchbutton").fadeOut();	
			$("#selectdatetime").fadeOut();	
			$("#selectlocation").fadeOut();	
				
			}
			$("#classtypelists").change(function(){
				
			$("#searchbutton").fadeIn();	
			$("#selectdatetime").fadeIn();	
			$("#selectlocation").fadeIn();	
				
			});
			
			
			
			
		});
		
		
		
		
		
		
		
		
		
		</script>