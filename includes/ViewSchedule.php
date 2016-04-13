<?php

require_once("classService.php");





class Schedule{
	
	
	
	
private $currentpage;
private $pagesize;	
private $creds;
private $xmldetail;
private $classService;
private $fields;

public $schedules=array();	
	
	
	
	
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

function get_schedules($output="array", $sessiontypeids){
	
	
	$result=$this->classService->GetClassSchedulesRequest($sessiontypeids,$this->pagesize,$this->currentpage,$this->xmldetail,$this->fields,$this->creds);
	//echo "<pre>";
//	print_r($result);
	//echo "</pre>";
	if($result){
	if($output=="html"){
		
		$this->output_html($result);
	}
	else{
		return $result;
	}
	
	
}
else{
	
	return false;
}
}

	function output_html($result){
		
		try{
		$result_count=$result->GetClassSchedulesResult->ResultCount;
		
		if($result_count>0){
		$schedules=$result->GetClassSchedulesResult->ClassSchedules->ClassSchedule;
		
		
		
		echo "	
	<div class='container'>


    <hr />

    <div class='agenda'>
        <div class='table-responsive'>
            <table class='table table-condensed table-bordered'>
                <thead>
                    <tr>
                        <th>StartDate</th>
						 <th>EndDate</th>
                        <th> Start Time</th>
						<th>End Time</th>
						    <th>Days</th>
                        <th>Event</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Single event in a single day -->";
		
		
		
		
		
		
		
		
		
		
		
		
		
		$sch=array();
		
		
		
		
		
		
		
		for($i=0;$i<count($schedules);$i++){
			
			
			$id=$schedules[$i]->ID;
			$name=$schedules[$i]->ClassDescription->Name;
			
			
			
			$startdate=new DateTime($schedules[$i]->StartDate);
			$enddate=new DateTime($schedules[$i]->EndDate);
			$starttime= new DateTime($schedules[$i]->StartTime);
			$endtime=new DateTime($schedules[$i]->EndTime);
			
			
			
			$sunday=$schedules[$i]->DaySunday;
			$monday=$schedules[$i]->DayMonday;
			$tuesday=$schedules[$i]->DayTuesday;
			$wednesday=$schedules[$i]->DayWednesday;
			$thursday=$schedules[$i]->DayThursday;
			$friday=$schedules[$i]->DayFriday;
			$saturday=$schedules[$i]->DayFriday;
			/*
			
			$days_different= $enddate->diff($startdate)->format("%a");
			
			
			$sch[strtotime($startdate->format(DateTime::ATOM))]=array("startdate"=>$startdate->format(DateTime::ATOM),
			
			"enddate"=>$enddate->format(DateTime::ATOM),
			"starttime"=>$starttime->format(DateTime::ATOM),
			"endtime"=>$endtime->format(DateTime::ATOM),
			
			"sunday"=>$sunday,
			"monday"=>$monday,
			"tuesday"=>$tuesday,
			"wednesday"=>$wednesday,
			"thursday"=>$thursday,
			"friday"=>$friday,
			"saturday"=>$saturday,
			"name"=>$name,
			"id"=>$id
			
			);
			*/
			
			
			
			?>
			
			
	
                    <tr>
                        <td class="agenda-date" class="active" rowspan="1">
                            <div class="dayofmonth"><?php echo $startdate->format("d");?></div>
                            <div class="dayofweek"><?php echo $startdate->format("D");?></div>
                            <div class="shortdate text-muted"><?php echo $startdate->format("M , Y");?></div>
                        </td>
						
						   <td class="agenda-date" class="active" rowspan="1">
                            <div class="dayofmonth"><?php echo $enddate->format("d");?></div>
                            <div class="dayofweek"><?php echo $enddate->format("D");?></div>
                            <div class="shortdate text-muted"><?php echo $enddate->format("M , Y");?></div>
                        </td>
                        <td class="agenda-time">
                           <?php echo $starttime->format("h:i A");?>
                        </td>
						    <td class="agenda-time">
                             <?php echo $endtime->format("h:i A");?>
                        </td>
						       <td class="agenda-events">
                            <div class="agenda-event">
                                <i class="glyphicon  text-muted" title="Repeating event"></i> 
                           <?php if($sunday){ echo "<li>Sunday</li>";}
						   if($monday){ echo "<li>Monday</li>";}
						   if($tuesday){ echo "<li>Tuesday</li>";}
						   if($wednesday){ echo "<li>Wednesday</li>";}
						   if($thursday){ echo "<li>Thursday</li>";}
						   if($friday){ echo "<li>Friday</li>";}
						   if($saturday){ echo "<li>Saturday</li>";}
						   ?>
                            </div>
                        </td>
                        <td class="agenda-events">
                            <div class="agenda-event">
                                <i class="glyphicon  text-muted" title="Repeating event"></i> 
                             <?php echo $name;?>
                            </div>
                        </td>
                    </tr>
                    
	
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			
			<?php
			
			
			
			
			
			
			
			
			
		}
		
		echo "              
            
         
                </tbody>
            </table>
        </div>
    </div>
</div>
		";
		
		
		
		}else{
			
			echo "<center><h2>No Results</h2></center>";
		}
		
		
		
	}
	
	
	catch (Exception $e){
			
			
			
			
		}
	}
	
	
	
	
	

	
}












?>