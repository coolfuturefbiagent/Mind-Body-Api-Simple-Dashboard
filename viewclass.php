
<?php

if(!isset($_GET['id']) OR $_GET['id']=="" OR !is_int((int)$_GET['id'])){
	header("location:getclasses.php");
}
else{
	
	$classDescriptionid=(int)urldecode($_GET['id']);
}
require_once("config.php");
require_once("includes/classService.php");


// initialize default credentials
$creds = new SourceCredentials(SOURCE_NAME, KEY, array(SIDE_ID));

$classService = new MBClassService();
$classService->SetDefaultCredentials($creds);

?>
	<?php include("tem/header.html");?>
	
<?php


function generate_class_url($classid,$date,$studio_id=null,$programme_id){
	$date=new Datetime($date);
	$date_class=$date->format("m/d/Y");
	
	return "https://clients.mindbodyonline.com/ws.asp?sDate=$date_class&&classid=$classid&&studioid=$studio_id&&TG=$programme_id&&sType=-7";

}



function get_class_details($classService,$id,$creds){
	
	
	$result=$classService-> GetClasses(array(),array($id),array(),null,null,null,null,null,XMLDetail::Full, NULL,$creds,array());
return $result;
}







?>
	<div id="page-wrapper">

	<br/>
<div class="container">
    <div class="row"> 
	<legend>View Class Details </legend>
<br/><br/>
	
<?php

$result=get_class_details($classService,$classDescriptionid,$creds);
$classes=$result->GetClassesResult->Classes->Class;


$description_id=$classes->ClassDescription->ID;
			$schdule_id=$classes->ClassScheduleID;
		
			$id=$classes->ID;
				$programme_id=$classes->ClassDescription->Program->ID;
	$site_id=$classes->Location->SiteID;
	$phone=$classes->Location->Phone;

	$location_name=$classes->Location->Name;
	$location_address1=$classes->Location->Address;
	$location_address2=$classes->Location->Address2;
	$location_city=$classes->Location->City;
	$start_datetime=$classes->StartDateTime;
	$end_datetime=$classes->EndDateTime;
	$description=$classes->ClassDescription->Description;
		$url=generate_class_url($schdule_id,$start_datetime,$site_id,$programme_id);
	if(isset($classes->ClassDescription->ImageURL)){
	$class_description_img=$classes->ClassDescription->ImageURL;
	}
	else{
		$class_description_img="";
		
	}
	$class_description_name=$classes->ClassDescription->Name;


$postal_code=$classes->Location->PostalCode;
$class_type=$classes->ClassDescription->SessionType->Name;


echo "<legend>$class_description_name</legend>";


echo "<p style='width:80%;display:flex;'>         "; if($class_description_img!==""){echo "<img  style='margin-right:15px;vertical-align:middle'src='{$class_description_img}' />";} echo "$description</p>";

echo "<br/>";
echo "<p><b>Location Name</b>  &nbsp: &nbsp $location_name</p>";
echo "<p><b>Location Address 1</b>  &nbsp:  &nbsp$location_address1</p>";
echo "<p><b>Location Address 2</b>  &nbsp:  &nbsp$location_address2</p>";
echo "<p><b>City</b>  &nbsp:  &nbsp $location_city</p>";
echo "<p><b>Phone Number</b>  &nbsp:  &nbsp $phone</p>";
echo "<p><b>Postal Code</b>  &nbsp:  &nbsp $postal_code</p>";

echo "<p><b>Start Date Time</b>  &nbsp:  &nbsp $start_datetime</p>";
echo "<p><b>End Date Time</b>  &nbsp:  &nbsp $end_datetime</p>";
echo "<p><b>Class Type :</b>  &nbsp:  &nbsp $class_type</p>";
?>
<br/><br/>







<?php


$staff_name=$classes->Staff->Name;

$staff_state=$classes->Staff->State;
$staff_gender="Male";
if($classes->Staff->isMale){
	$staff_gender="Male";
}
else{
	$staff_gender="Female";
}


$IndependentContractor="Yes";
if($classes->Staff->IndependentContractor){
	$IndependentContractor="Yes";
}
else{
$IndependentContractor="No";
}

$staffif=$classes->Staff->ID;

$always_allow_double_booking="no";

if($classes->Staff->AlwaysAllowDoubleBooking){
	$always_allow_double_booking="Yes";
}
else{
	$always_allow_double_booking="No";
}

$staff_pic="";

if(isset($classes->Staff->ImageURL) AND $classes->Staff->ImageURL!==""){
	$staff_pic=$classes->Staff->ImageURL;
	
}
else{
	$staff_pic="http://collegemix.ca/img/placeholder.png";
}
?>


<div class="container">
      <div class="row">
  
        <div class="toppad"  style='width:85%;'>
   
   
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title"><?php echo $staff_name;?></h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="<?php echo $staff_pic;?>" class="img-circle img-responsive"> </div>
                
                <!--<div class="col-xs-10 col-sm-10 hidden-md hidden-lg"> <br>
                  <dl>
                    <dt>DEPARTMENT:</dt>
                    <dd>Administrator</dd>
                    <dt>HIRE DATE</dt>
                    <dd>11/12/2013</dd>
                    <dt>DATE OF BIRTH</dt>
                       <dd>11/12/2013</dd>
                    <dt>GENDER</dt>
                    <dd>Male</dd>
                  </dl>
                </div>-->
                <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>State:</td>
                        <td><?php echo $staff_state;?></td>
                      </tr>
                      <tr>
                        <td>Gender:</td>
                        <td><?php echo $staff_gender;?></td>
                      </tr>
                      <tr>
                        <td>Independent Contractor :</td>
                        <td><?php echo $IndependentContractor="Yes";?></td>
                      </tr>
                   
                       
                        <tr>
                        <td>ID</td>
                        <td><?php echo $staffif;?></td>
                      </tr>
                      <tr>
                        <td>Always Allow Double Booking :</td>
                        <td><?php echo $always_allow_double_booking;?></td>
                      </tr>
                    
                           
                      </tr>
                     
                    </tbody>
                  </table>
                  
                </div>
              </div>
            </div>
                 <div class="panel-footer">
                       
                    </div>
            
          </div>
        </div>
      </div>
    </div>




<?php
	
	$new_dd=new DateTime($start_datetime);
	$dd=$new_dd->format("D, M d, Y h:i a");

	$heal_code_url="https://widgets.healcode.com/mb/sites/".HEAL_CODE_SITE_ID."/cart/add_item?item[name]=$class_description_name&item[mbo_id]=$id&item[mbo_location_id]=1&item[type]=Class&item[info]=$dd";
echo "<a  data-width='700' data-height='500' target='_blank' class='class_registration btn btn-primary' href='{$heal_code_url}' class='' > SignUp </a>";
?>








</div>
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

	
	
	
	
	
	
	
	
	
	
	
	

