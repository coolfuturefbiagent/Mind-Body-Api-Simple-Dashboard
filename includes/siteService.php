<?php

require_once("mbApi.php");


class MBSiteservice extends MBAPIService
{



	function __construct($debug = false)
	{
		$endpointUrl = "https://" . GetApiHostname() . "/0_5/SiteService.asmx";
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
	
	function get_locations(SourceCredentials $credentials = null, $XMLDetail = XMLDetail::Basic, $PageSize=null, $CurrentPage=null, $Fields = NULL){
		
			$additions = array();

		$params = $this->GetMindbodyParams($additions, $this->GetCredentials($credentials),  $XMLDetail, $PageSize, $CurrentPage, $Fields);
				
				
						try
		{
			$result = $this->client->GetLocations($params);
		}
				
				catch (SoapFault $fault)
		{
			DebugResponse($this->client);
			// <xmp> tag displays xml output in html
			echo '</xmp><br/><br/> Error Message : <br/>', $fault->getMessage(); 
		}
		
		if ($this->debug)
		{
			DebugRequest($this->client);
			DebugResponse($this->client, $result);
		}
		
		return $result;
	}



function GetSessionTypesRequest(array $ProgramIDs,$OnlineOnly=false,  SourceCredentials $credentials = null, $XMLDetail = XMLDetail::Basic, $PageSize=null, $CurrentPage=null, $Fields = NULL){
	
	$additions = array();
	if (isset($ProgramIDs))
		{
			$additions['ProgramIDs'] = $ProgramIDs;
		}
		if (isset($OnlineOnly))
		{
			$additions['OnlineOnly'] =$OnlineOnly;
		}
	$params = $this->GetMindbodyParams($additions, $this->GetCredentials($credentials),  $XMLDetail, $PageSize, $CurrentPage, $Fields);
	
		
			try
		{
			$result = $this->client->GetSessionTypes($params);
		}
		
		catch (SoapFault $fault)
		{
			DebugResponse($this->client);
			// <xmp> tag displays xml output in html
			echo '</xmp><br/><br/> Error Message : <br/>', $fault->getMessage(); 
		}
		
		if ($this->debug)
		{
			DebugRequest($this->client);
			DebugResponse($this->client, $result);
		}
		
		return $result;
	
}
}	




?>