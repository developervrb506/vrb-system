<?
final class EnumServices{
	const GUID = 'c9d4bc902ae9414cbdb6d9f1ee9bf464';
	const JASPER_SERVICE = 'http://vrbservices.wagerweb.ag/reports.svc?wsdl';
}

abstract class FactoryManager{
	public abstract function create_manager($classManager);
	
	public function send_action_to_manager($classManager,$params=null){
		$manager = $this->create_manager($classManager);
		return $manager->action($params);
	}
	
	public function send_session_to_manager($classManager,$params=null){
		$manager = $this->create_manager($classManager);
		return $manager->set_affiliate_session($params);
	}			
}

class JasperHelper
{
	private $service;
	
	public function JasperHelper(){
		$this->service = new JasperService();
	}

	public function getsession($params= null)
	{
		if(empty($params))return '';
		return $this->service->getsession($params['affiliateID'],$params['password']);	
	}
	
	public function commissions($params= null)
	{
		if(empty($params))return '';
		return $this->service->commissions($params['sessionID']);	
	}
	
	public function dailyfigures($params= null)
	{
		if(empty($params))return '';
		return $this->service->dailyfigures($params['sessionID'],$params['thisWeek']);
	}
	
	public function players($params= null)
	{
		if(empty($params))return '';
		return $this->service->players($params['sessionID']);	
	}
	
	public function payouts($params= null)
	{
		if(empty($params))return '';
		return $this->service->payouts($params['sessionID'],$params['flag']);
	}
	
	public function transactions($params= null)
	{
		if(empty($params))return '';
		return $this->service->transactions($params['sessionID'],$params['from'],$params['customerID']);
	}
	
	public function tracking($params= null)
	{
		if(empty($params))return '';
		return $this->service->tracking($params['sessionID'],$params['from'],$params['to']);
	}
	
	public function openwagers($params= null)
	{
		if(empty($params))return '';
		return $this->service->openwagers($params['sessionID'],$params['customerID']);
	}
	
	public function wagerdetailsbydate($params= null)
	{
		if(empty($params))return '';
		return $this->service->wagerdetailsbydate($params['sessionID'],$params['customerID'],$params['date']);
	}
	
	public function wagerdetails($params= null)
	{
		if(empty($params))return '';
		return $this->service->wagerdetails($params['sessionID'],$params['customerID'],$params['ticketNumber'],$params['gradeNumber']);
	}	
	
	public function totalsignupsbydate($params= null)
	{
		if(empty($params))return '';
		return $this->service->totalsignupsbydate($params['sessionID'],$params['from'],$params['to']);
	}
	
	public function getaffiliatestatus($params= null)
	{		
		if(empty($params))return '';
		return $this->service->getaffiliatestatus($params['sessionID']);
	}
	
	public function getaffiliateupdatebydate($params= null)
	{
		if(empty($params))return '';
		return $this->service->getaffiliateupdatebydate($params['sessionID'],$params['from'],$params['to']);
	}				
}

interface IManager{
	public function action($params = null);
}

class JasperManager implements IManager
{	
	private static $jasperHelper;
	private static $loginHelper;
	
	public function JasperManager()
	{
		$this->instance_jasper_helper();
	}
	
	public function action($params = null)
	{
		if(isset($params)){
			
			session_start();
			
			$report = $params['report'];
			unset($params['report']);
			$params['sessionID'] = $_SESSION['session_id'];
			$function_to_call = $report;
			return call_user_func(array(JasperManager::$jasperHelper, $function_to_call), $params);
		}
		return null;
	}	
	
	public function set_affiliate_session($params = null)
	{
		if(isset($params)){		
		
		    session_start();		
			
			$function_to_call = 'GetSession';																
			
			$result = call_user_func(array(JasperManager::$jasperHelper, $function_to_call), $params);			
			
            $_SESSION['session_id'] = $result;						
		}
	}	
	
	private function instance_jasper_helper()
	{
		if(!is_object(JasperManager::$jasperHelper))
		{
			JasperManager::$jasperHelper = new JasperHelper();		
		}
	}	
}

class FactoryManagerImpl extends FactoryManager
{
	private $manager;
	public function create_manager($classManager)
	{		
		if(!is_object($this->manager))
		{
			$this->manager = new JasperManager();
		}
		return $this->manager;
	}
}

abstract class Service {

	private $service;
	public function get_service() {
		return $this -> service;
	}

	public function set_service($service) {
		$this -> service = $service;
	}
}

class JasperService extends Service
{
	public function JasperService()
	{
		try{
			$webservice_url = EnumServices::JASPER_SERVICE;
			$this->set_service(new SoapClient($webservice_url));	
		}catch(Exception $e){}
	}
	
	public function getsession($affiliateID=null,$password=null)
	{
		return @$this->get_service()->GetSession(array('affiliateID'=>$affiliateID, 'password'=>$password, 'guid'=>EnumServices::GUID))->GetSessionResult;
	}

	public function commissions($sessionID=null)
	{
		return $this->get_service()->Commission(array('sessionID'=>$sessionID, 'guid'=>EnumServices::GUID))->CommissionResult;
	}
	
	public function dailyfigures($sessionID=null,$thisWeek=null)
	{
		return $this->get_service()->DailyFigures(array('sessionID'=>$sessionID, 'thisWeek'=>$thisWeek, 'guid'=>EnumServices::GUID))->DailyFiguresResult;
	}
	
	public function players($sessionID=null)
	{
		return $this->get_service()->CustomerList(array('sessionID'=>$sessionID, 'flag'=>'All', 'guid'=>EnumServices::GUID))->CustomerListResult;
	}
	
	public function payouts($sessionID=null,$period=null)
	{
		return $this->get_service()->Payouts(array('sessionID'=>$sessionID, 'flag'=>$period, 'guid'=>EnumServices::GUID))->PayoutsResult;
	}
	
	public function transactions($sessionID=null,$period=null,$customerID=null)
	{
		return $this->get_service()->Transactions(array('sessionID'=>$sessionID, 'from'=>$period, 'customerID'=>$customerID, 'guid'=>EnumServices::GUID))->TransactionsResult;
	}
	
	public function tracking($sessionID=null,$from=null,$to=null)
	{
		return $this->get_service()->Tracking(array('sessionID'=>$sessionID, 'from'=>$from, 'to'=>$to, 'guid'=>EnumServices::GUID))->TrackingResult;
	}
	
	public function openwagers($sessionID=null,$customerID=null)
	{
		return $this->get_service()->OpenWagers(array('sessionID'=>$sessionID, 'customerID'=>$customerID, 'guid'=>EnumServices::GUID))->OpenWagersResult;
	}
	
	public function wagerdetailsbydate($sessionID=null,$customerID=null,$date=null)
	{
		return $this->get_service()->WagerDetailsByDateAff(array('sessionID'=>$sessionID, 'customerID'=>$customerID, 'date'=>$date, 'guid'=>EnumServices::GUID))->WagerDetailsByDateAffResult;
	}
	
	public function wagerdetails($sessionID=null,$customerID=null,$ticketNumber=null,$gradeNumber=null)
	{
		return $this->get_service()->WagerDetailsAff(array('sessionID'=>$sessionID, 'customerID'=>$customerID, 'ticketNumber'=>$ticketNumber, 'gradeNumber'=>$gradeNumber, 'guid'=>EnumServices::GUID))->WagerDetailsAffResult;
	}	
		
	public function totalsignupsbydate($sessionID=null,$from=null,$to=null)
	{
		return $this->get_service()->TotalSignupsByDate(array('sessionID'=>$sessionID, 'from'=>$from, 'to'=>$to, 'guid'=>EnumServices::GUID))->TotalSignupsByDateResult;
	}
	
	public function getaffiliatestatus($sessionID=null)
	{
		return $this->get_service()->GetAffiliateStatus(array('sessionID'=>$sessionID, 'guid'=>EnumServices::GUID))->GetAffiliateStatusResult;
	}
	
	public function getaffiliateupdatebydate($sessionID=null,$from=null,$to=null)
	{
		return $this->get_service()->GetAffiliateUpdateByDate(array('sessionID'=>$sessionID, 'from'=>$from, 'to'=>$to, 'guid'=>EnumServices::GUID))->GetAffiliateUpdateByDateResult;
	}		
}
?>