<?php




require_once("mbApi.php");

class MBStaffservice extends MBAPIService
{	
	function __construct($debug = false)
	{
		$endpointUrl = "https://" . GetApiHostname() . "/0_5/StaffService.asmx";
		$wsdlUrl = $endpointUrl . "?wsdl";
	
		$this->debug = $debug;
		$option = array();
		if ($debug)
		{
			$option = array('trace'=>1);
		}
		$this->client = new soapclient($wsdlUrl, $option);
		$this->client->__setLocation($endpointUrl);
		
		
	}
	
function get_staff( $XMLDetail = XMLDetail::Full,  SourceCredentials $credentials = null,$currentpage=null,$pagesize=null, $sessiontypeids=null,$fields=null,$locationid=null,$datetime=null){
	
	
	
	$additions = array();
		if (isset($sessiontypeids))
		{
			$additions['SessionTypeID'] =(int)$sessiontypeids;
		}
			if (isset($locationid))
		{
		$additions['LocationID'] =(int)$locationid;
		}
		
			if (isset($datetime))
		{
			$additions['StartDateTime'] =$datetime->format(DateTime::ATOM);
		}
		
	
		
	$params = $this->GetMindbodyParams($additions, $this->GetCredentials($credentials), $XMLDetail, $pagesize, $currentpage,$fields);
			

			
				try
		{
		$result = $this->client->GetStaff($params);
		}
		catch (SoapFault $fault)
		{
			DebugResponse($result);
			echo '</xmp><br/><br/> Error Message : <br/>', $fault->getMessage(); 
		}
		
		return $result;
	
}
	

}
