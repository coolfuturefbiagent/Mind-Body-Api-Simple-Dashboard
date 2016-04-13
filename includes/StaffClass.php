<?php
require_once("classService.php");
require_once("staffService.php");


class  StaffInfo {
	
private $currentpage;
private $pagesize;	
private $creds;
private $xmldetail;
private $classService;
private $fields;
function __construct($currentpage,$pagesize,$xmldetail=XMLDetail::Full,$fields=null){
	$this->currentpage=$currentpage;
	$this->pagesize=$pagesize;
	$this->xmldetail=$xmldetail;
	$this->classService = new MBClassService();
    
	$this->creds= new SourceCredentials(SOURCE_NAME, KEY, array(SIDE_ID));
	$this->classService->SetDefaultCredentials($this->creds);
	
	
	if(isset($fields) ANd is_array($fields)){
		
		$this->fields=$fields;
	}
}	
	
	function get_class_descriptions_bystaffid($startdate,$enddate,$id){
		
		
		$tt=$this->classService->GetClassDescriptions(array(),array($id),array(), $startdate, $enddate,null, null, XMLDetail::Basic, null,$this->creds);
		return $tt;
		
		
		
	}
	function generate_pagination($total_pages,$total_results,$currentpage){
		
		$url=strtok($_SERVER["REQUEST_URI"],'?');
		echo "<center><nav>
  <ul class='pagination'>
   ";
	for($i=0;$i<$total_pages;$i++){
		$active="";
		
		if($currentpage==$i){
			$active="active";
		}
 echo "   <li class='{$active}'><a href='{$url}?p={$i}'>$i</a></li>";
	
	
	}
   echo "
  </ul>
</nav></center>";
		
		
		
		
	}
function get_staff_info($output="array", $sessiontypeids,$locationid,$datetime){
$staff= new MBStaffservice();	
$staff->SetDefaultCredentials($this->creds);
$datetime=new DateTime($datetime);	
$all_staff=$staff->get_staff($this->xmldetail, $this->creds,$this->currentpage,$this->pagesize,$sessiontypeids,$this->fields,$locationid,$datetime);	
	if($output=="array"){
		return $all_staff;
	}
	elseif($output=="html"){
		$this->output_staff_info_html($all_staff);
	}
	
}
function output_staff_info_html($all_staff){	


	
	$result_count=$all_staff->GetStaffResult->ResultCount;

	if($result_count>0){
		$staff_members=$all_staff->GetStaffResult->StaffMembers->Staff;	
	 echo "
	<table class='table table-bordered'>
    <thead> 
    <tr>
    <th></th>
    <th>ID</th>
    <th>Name</th>
    <th>Address</th>
    <th>Bio</th>
    <th>Mobile Phone </th>
    <th>Home Phone</th> 
    <th>Classes taught</th> 	 
    </tr> </thead><tbody>
	";	
	for($i=0;$i<count($staff_members);$i++){
		$image_url="";
		$id=0;
		$name="";
		$address="";
		$bio="";
		$mobile="";
		$home="";
		if(isset($staff_members[$i]->ImageURL)){
		$image_url=	$staff_members[$i]->ImageURL;
		}
		else{			
			$image_url=NO_IMAGE;
		}
		if(isset($staff_members[$i]->ID)){
		$id=$staff_members[$i]->ID;
		}
		if(isset($staff_members[$i]->Name)){
			$name=$staff_members[$i]->Name;
		}
		if(isset($staff_members[$i]->Address)){
			$address=$staff_members[$i]->Address;
		}
		if(isset($staff_members[$i]->Bio)){
			$bio=substr($staff_members[$i]->Bio,0,100);
		}
		if(isset($staff_members[$i]->MobilePhone)){
			$mobile=$staff_members[$i]->MobilePhone;
		}
		if(isset($staff_members[$i]->HomePhone)){
			$home=$staff_members[$i]->HomePhone;
		}		
		$startdate=new DateTime("monday this week");
		$enddate=new DateTime("sunday this week");	
		$tt=  $this->get_class_descriptions_bystaffid($startdate,$enddate,$id);
	//echo $id;
		//echo "<pre>";
		//print_r($tt);
//	echo "</pre>";
	

		echo "
	<tr> 
<td><img width='100' height='100'src='$image_url' /> </td> 
 <td>$id</td> 
 <td>$name</td><td>$address</td>
 <td style=' width:50px; word-wrap:break-word;'>$bio</td>
  <td>$mobile</td>
   <td>$home</td>
    <td>";	
		if(isset($tt->GetClassDescriptionsResult->ClassDescriptions->ClassDescription)){
		$classes_descriptions_list=$tt->GetClassDescriptionsResult->ClassDescriptions->ClassDescription;
		if(is_array($classes_descriptions_list)){
			for($j=0;$j<count($classes_descriptions_list);$j++){
				$class_name=$classes_descriptions_list[$j]->Name;
				echo "<li>$class_name</li>";
			}
		}
		else{
			$class_name=$classes_descriptions_list->ID;
				echo "<li>$class_name</li>";
			
		}
		}	
	echo "</td>

	   
 </tr>
	";
	}
	
	echo "
	 </tbody>
 </table>
	";
	}
	else{
		
	echo "<center><h2>No Results </h2></center>";	
		
		
	}
	
		
$number_of_results=$all_staff->GetStaffResult->ResultCount;
$current_page=$all_staff->GetStaffResult->CurrentPageIndex;
$total_page_count=$all_staff->GetStaffResult->TotalPageCount;
	
	$this->generate_pagination($total_page_count,	$number_of_results,$current_page);
	
}	
	
	
}
















?>