
<?php
require_once("config.php");
require_once("includes/classService.php");
require_once("includes/siteService.php");

function generate_class_url($classid,$date,$studio_id=null,$programme_id){
	$date=new Datetime($date);
	$date_class=$date->format("m/d/Y");
	
	return "https://clients.mindbodyonline.com/ws.asp?sDate=$date_class&&classid=$classid&&studioid=$studio_id&&TG=$programme_id&&sType=-7";

}


// initialize default credentials
$creds = new SourceCredentials(SOURCE_NAME, KEY, array(SIDE_ID));

$classService = new MBClassService();
$classService->SetDefaultCredentials($creds);
function get_session_ids($creds){
	
	
	
	$siteService= new MBSiteservice();
$siteService->SetDefaultCredentials($creds);
$tt=FALSE;
$session_types=$siteService->GetSessionTypesRequest(array(),false, $creds);
$session_types_array=$session_types->GetSessionTypesResult->SessionTypes->SessionType;
	return $session_types_array;
	
}
?>
	<?php include("tem/header.html");?>
	

	<div id="page-wrapper">

	<br/>
<div class="container">
    <div class="row"> 
	<form action='getclasses.php' method='get'>	
        <div class="col-xs-8 col-xs-offset-2">
		    <div class="input-group">
                <div class="input-group-btn search-panel">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    	<span id="search_concept">Filter by</span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#si">Staff ID</a></li>
                      <li><a href="#ci">Class ID</a></li>
                      <li><a id='classtypes' href="#ct">Class Type</a></li>
                    
                      <li><a  id='alla'href="#all">All</a></li>
                    </ul>
                </div>
			
                <input type="hidden" name="t" value="all" id="search_param">     
			<select id='classtypelists' style='width:24%;float:left;display:none; height:34px;' name='classtype'>
			
			<?php
			$class_types_array=get_session_ids($creds);
			
			
			for($i=0;$i<count($class_types_array);$i++){
				
			$session_name=$class_types_array[$i]->Name;
            $session_id=$class_types_array[$i]->ID;

?>
<option name='sessionid' value='<?php echo $session_id; ?>' ><?php  echo $session_name;?></option>


<?php			
				
				
				
			}
			?>
			
			</select>
                <input type="text"  id='searchtext' class="form-control" name="x" placeholder="Search term...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                </span>
				
				
            </div>
        </div>
	
	</div>
</div>
<br/>
<div class="row">

  <div class="col-md-6 col-md-offset-3 ">	
  
  

 <?php
 
 
 $default_start_date=new Datetime();
 
 
 
 
 
 ?>

	<input class="form-control  pul-left"   value='<?php echo $default_start_date->format("d/m/Y")." 00:00:00 ";?>'style='width:24%;float:left; ' id='startdate'type="text" name="startdate"   placeholder='Select Start Date' />
<label class='pull-left ' style='margin-left:5%;float:left; line-height:35px;'><small>Or</small></label>
  
  	<input class="form-control  pul-left" value='<?php echo $default_start_date->format("d/m/Y")." 11:59:59";?>'  style='width:24%;float:left; margin-left:5%; ' id='enddate'type="text" name="enddate"   placeholder='Select End Date' /><button type="submit" style='margin-left:10%;' class="btn btn-primary">Search</button>
  
  
  
  
  
  
  
	


  </div>
  
  </form>
</div>

<br/><br/>
<?php 







$class_id=array();
$staff_id=array();
$startdate=null;
$enddate=null;
$session_types=array();



function verifyDate($date)
{
    return (DateTime::createFromFormat('m/d/Y H:i', $date) !== false);
}





if(isset($_GET['startdate']) AND $_GET['startdate']!==""){
	
		$d=urldecode($_GET['startdate']);

if(verifyDate($d)){
	$startdate=new Datetime($d);

}	
	
}


if(isset($_GET['enddate']) AND $_GET['enddate']!==""){
	$d=urldecode($_GET['enddate']);
	
if(verifyDate($d)){
		$enddate=new Datetime($d);

}	
	
}


if((isset($_GET['classtype'])) AND ($_GET['classtype']!=="")){
$session_types=array((int)urldecode($_GET['classtype']));	
}

if((isset($_GET['t']) AND isset($_GET['x'])) AND($_GET['t']=="ci" AND $_GET['x']!=="")){
$class_id=array(10,
8,
38,
138,
139,
79,
44,
6,
91,
7,
104,
136,
15,
14,
66,
11);	
}
if((isset($_GET['t']) AND isset($_GET['x'])) AND($_GET['t']=="si" AND $_GET['x']!=="")){
$staff_id=array((int)urldecode($_GET['x']));	
}
if(isset($_GET['t']) AND $_GET['t']=="all"){
$staff_id=array();
$class_id=array();
}
$date=new Datetime("2016-02-10 00:00:00");
$tt=toArray($classService->GetClassDescriptions(array(10,
8,
38,
138,
139,
79,
44,
6,
91,
7,
104,
136,
15,
14,
66,
11),array(),array(),null,null,null,null,XMLDetail::Bare,array("ClassDescriptions.ID","ClassDescriptions.SessionType.Name"),$creds));
//$tt=toArray($classService->GetClasses(array(),$class_id,$staff_id,$startdate,$enddate,null,null, null, XMLDetail::Full, NULL, $creds,$session_types));
echo "<pre>";
print_r($tt);


echo "</pre>";

exit;
if($tt[0]->GetClassesResult->ResultCount>0){
display_results($tt);
}
else{
	?>
	
	
	
	
	<div class="alert alert-danger" role="alert">No Results Found</div>
	
	
	<?php
	
	
}



function display_results($tt){
	
	$classes=(array)$tt[0]->GetClassesResult->Classes->Class;


echo "<br/><br/><div class='alert alert-success' role='alert'>Displaying ".count($classes)." Classes</div><br/>
<table class='table table-bordered'>

 <thead> 
 <tr><th></th> <th>ID</th>
 <th>Class Name</th>
  <th>Class Description</th>
 <th>Location Name</th>
 <th>Location Address</th>
 <th>City</th> 
  <th>Start Datetime</th> 
    <th>End Datetime</th> 
	 <th>View </th>
 </tr> </thead><tbody>
";
for($i=0;$i<count($classes);$i++){
	if(is_array($classes) AND count($classes)>0){
	$id=$classes[$i]->ID;
	$description_id=$classes[$i]->ClassDescription->ID;
	$programme_id=$classes[$i]->ClassDescription->Program->ID;
	$site_id=$classes[$i]->Location->SiteID;
	$schdule_id=$classes[$i]->ClassScheduleID;
	$location_name=$classes[$i]->Location->Name;
	$location_address1=$classes[$i]->Location->Address;
	$location_city=$classes[$i]->Location->City;
	$start_datetime=$classes[$i]->StartDateTime;
	$end_datetime=$classes[$i]->EndDateTime;
	$description=substr($classes[$i]->ClassDescription->Description,0,100);
	$url=generate_class_url($schdule_id,$start_datetime,$site_id,$programme_id);
	
	
	if(isset($classes[$i]->ClassDescription->ImageURL)){
	$class_description_img=$classes[$i]->ClassDescription->ImageURL;
	}
	else{
		$class_description_img="http://collegemix.ca/img/placeholder.png";
		
	}
	$class_description_name=$classes[$i]->ClassDescription->Name;
	}
	else{
		
		$description_id=$classes[$i]->ClassDescription->ID;
			$schdule_id=$classes[$i]->ClassScheduleID;
		
			$id=$classes->ID;
				$programme_id=$classes[$i]->ClassDescription->Program->ID;
	$site_id=$classes[$i]->Location->SiteID;
	$location_name=$classes->Location->Name;
	$location_address1=$classes->Location->Address;
	$location_city=$classes->Location->City;
	$start_datetime=$classes->StartDateTime;
	$end_datetime=$classes->EndDateTime;
	$description=substr($classes->ClassDescription->Description,0,100);
		$url=generate_class_url($schdule_id,$start_datetime,$site_id,$programme_id);
	if(isset($classes->ClassDescription->ImageURL)){
	$class_description_img=$classes->ClassDescription->ImageURL;
	}
	else{
		$class_description_img="http://collegemix.ca/img/placeholder.png";
		
	}
	$class_description_name=$classes->ClassDescription->Name;
		
		
		
	}
	
	$new_dd=new DateTime($start_datetime);
	$dd=$new_dd->format("D, M d, Y h:i a");

	$heal_code_url="https://widgets.healcode.com/mb/sites/".HEAL_CODE_SITE_ID."/cart/add_item?item[name]=$class_description_name&item[mbo_id]=$id&item[mbo_location_id]=1&item[type]=Class&item[info]=$dd";
	echo " 
 <tr> 
<td><img width='200' height='108'src='{$class_description_img}' /> </td> 
 <td>$id</td> 
 <td><a  class='class_registration' href='{$heal_code_url}' data-width='700' data-height='500' target='_blank'>$class_description_name </a></td><td>$description</td>
 <td>$location_name</td>
  <td>$location_address1</td>
   <td>$location_city</td>
    <td>$start_datetime</td>
	 <td>$end_datetime</td>
	  <td><a href='viewclass.php?id={$id}' class='btn btn-primary'>View </a></td>
 </tr>

";


}
echo " </tbody>
 </table>";
	
	
	
	
	
	
	
	
}


?>
</div>

	<?php include("tem/footer.html");?>
	
	
	

<script>
$(function () {
    var iframe = $('<iframe frameborder="0" marginwidth="0" marginheight="0" allowfullscreen></iframe>');
    var dialog = $("<div ></div>").append(iframe).appendTo("body").dialog({
        autoOpen: false,
        modal: true,
        resizable: false,
        width: "auto",
        height: "auto",
        close: function () {
            iframe.attr("src", "");
        }
    });
    $(".class_registration").on("click", function (e) {
        e.preventDefault();
        var src =  $(this).attr("href");
        var title = $(this).attr("data-title");
        var width = $(this).attr("data-width");
        var height = $(this).attr("data-height");
        iframe.attr({
            width: +width,
            height: +height,
            src: src
        });
        dialog.dialog("option", "title", title).dialog("open");
    });
});

</script>	
	
	
	
	
	
	
	
	
	
	
	
	
	
	<script>


$(document).ready(function(e){
    $('.search-panel .dropdown-menu').find('a').click(function(e) {
		e.preventDefault();
		var param = $(this).attr("href").replace("#","");
		var concept = $(this).text();
		$('.search-panel span#search_concept').text(concept);
		$('.input-group #search_param').val(param);
	});
	
	$("#alla").click(function(){
		
		$("#searchtext").fadeOut();
		$(".input-group-btn").css("width","0%");
		
		
	});
		$("#classtypes").click(function(){
		
		$("#searchtext").fadeOut();
		$("#classtypelists").fadeIn();
		$("#classtypelists").css("width","40%");
			$("#classtypelists").css("margin-left","10%");
		$(".input-group-btn").css("width","0%");
		
		
	});
	$("#sda").click(function(){
	$("#searchtext").attr("id","basic_example_1")
	
	
		
	});


	
});






</script>
