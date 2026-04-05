<?
class affiliate {
	public $id;
	public $name;
	public $last_name;
	public $adress;
	public $city;
	public $state;
	public $country;
	public $zip;
	public $email;
	public $phone;
	public $web_name;
	public $web_url;
	public $is_admin;
	public $register_date;
	public $password;
	public $newsletter;
	public $books;
	public $parent_account;
	public $image;
	public function __construct($pid, $pname, $plastname, $padress, $pcity, $pstate, $pcountry, $pzip, $pemail, $pphone, $pweb_name, $pweb_url, $pis_admin, $pregister_date, $ppassword, $pnewsletter, $pbooks, $pparent = 0) {
       $this->id = $pid;
	   $this->name = $pname;
	   $this->last_name = $plastname;
	   $this->adress = $padress;
	   $this->city = $pcity;
	   $this->state = $pstate;
	   $this->country = $pcountry;
	   $this->zip = $pzip;
	   $this->email = $pemail;
	   $this->phone = $pphone;
	   $this->web_name = $pweb_name;
	   $this->web_url = $pweb_url;
	   $this->is_admin = $pis_admin;
	   $this->register_date = $pregister_date;
	   $this->password = $ppassword;
	   $this->newsletter = $pnewsletter;
	   $this->books = $pbooks;
	   $this->parent_account = $pparent; 
   }
   function bronto_update(){
		if(is_null($fields)){
			$fields = array("firstname","lastname","website","url","phone","newsletter");
			$params = array($this->name, $this->last_name, $this->web_name, $this->web_url, $this->phone,$this->newsletter);	
		}
		$url = "http://app.bronto.com/public/?q=direct_add&fn=Public_DirectAddForm&id=bselztbsqtiznzyeygjacvekxtshblc";
		$url .= "&email=".$this->email;
		$i = 1;
		foreach($fields as $field){			
			$value = $params[$i-1];
			if($value == ""){$value = "0";}
			$value = str_replace(" ","%20",$value);
			$url .= "&field$i=$field,set,".$value;
			$i++;
		}
		$url .= "&list2=0bbd03ec000000000000000000000003515f";
		$bronto = file_get_contents($url);	
		return $url;
   }
   function get_fullname(){
	   $full = $this->name;
	   if($this->name != $this->last_name){$full .= " " . $this->last_name;}
		return  $full;   
   }
   function get_wagerweb_active_accounts(){
	   $affiliate_code = get_affiliate_code($this->id, 1);
	   $content = @file_get_contents('http://lb.playblackjack.com/ag_agentcustomerlistvrb.asp?CustomerID='.$affiliate_code);
	   $content = strtolower($content);
	   $total = substr_count($content, '<tr') - 1;
	   $inactive = substr_count($content, '(inactive)');
	   $active = $total - $inactive;
	   if($active < 0){$active = 0;}
	   return $active;
   }
   function get_clicks($from = "", $to = ""){
	   return web_report_count($this->id, "clicks", $from, $to);
   }
   function get_impressions($from = "", $to = "", $book = ""){
	   return web_report_count($this->id, "impressions", $from, $to);
	   
   }
}
class book{
	public $id;
	public $name;
	public $url;
	public $folder;
	public function __construct($pid, $pname, $purl, $pfolder = ""){
		$this->id = $pid;
		$this->name = $pname;
	    $this->url = $purl;
		$this->folder = $pfolder;
	}
}
class campaigne{
	public $id;
	public $name;
	public $desc;
	public $url;
	public $book;
	public $promos;
	public $category;
	public function __construct($pid, $pname, $pdesc, $purl, $ppromos, $pbook, $pcategory = 1){
		$this->id = $pid;
		$this->name = $pname;
		$this->desc = $pdesc;
	    $this->url = $purl;
		$this->book = $pbook;
		$this->promos = $ppromos;
		$this->category = $pcategory;
	}
	function add_promo($promo){
		$promo->id = insert_promo($promo, $this);
		return $promo; 
   } 
}
class custom_campaign{
	public $id;
	public $name;
	public $desc;
	public $affiliate;
	public $deleted;
	public function __construct($pid, $pname, $pdesc, $paid, $pdeleted){
		$this->id = $pid;
		$this->name = $pname;
		$this->desc = $pdesc;
	    $this->affiliate = $paid;
		$this->deleted = $pdeleted;
	}
}
class promo{
	public $id;
	public $name;
	public $type;
	public function __construct($pid, $pname, $ptype){
		$this->id = $pid;
		$this->name = $pname;
	    $this->type = $ptype;
	}
	function update(){
		update_promo($this);
   }
   function get_code($current_affiliate, $folder = "http://localhost:8080/process"){
	  $code= "<!--Affiliate Code Start Here-->";
	  $code.= '<a href="'.$folder.'/redir.php?pid='.$this->id.'&aid='.$current_affiliate->id.'" target="_blank">';
	  if($this->type == "t"){$code.= $this->name;}
	  $code.= '<img border="0" src="http://localhost:8080/process/image.php?pid='.$this->id.'&aid='.$current_affiliate->id.'" />';
	  $code.= '</a>';
	  $code.= "<!--Affiliate Code End Here-->";
	  return $code;
  }
  function get_image_link($current_affiliate, $folder = "http://localhost:8080/process"){
	  $code= $folder.'/redir.php?pid='.$this->id.'&aid='.$current_affiliate->id;
	  return $code;
  }
  function get_image_url($current_affiliate){
	  $code= 'http://localhost:8080/process/image.php?pid='.$this->id.'&aid='.$current_affiliate->id;
	  return $code;
  }
  function get_size(){
	  $size = explode("_",$this->name);
	  return clean_extension($size[1]);	
  }
  function get_campaigne(){
	  return get_campaigne_by_promo($this);
  }
  static function order_by_size($a, $b){
		return sort_DESC(($a->get_size()+0), ($b->get_size()+0));
   }
  static function order_by_id($a, $b){
		return sort_DESC($a->id, $b->id);
   }
}
class report{
	public $id;
	public $ip;
	public $date_time;
	public function __construct($pid, $pip, $pdate_time){
		$this->id = $pid;
		$this->ip = $pip;
		$this->date_time = $pdate_time;
	}
}
class message{
	public $id;
	public $subject;
	public $content;
	public $m_date;
	public function __construct($pid, $psubject, $pcontent, $pm_date){
		$this->id = $pid;
		$this->subject = $psubject;
		$this->content = $pcontent;
		$this->m_date = $pm_date;
	}
}
class category{
	public $id, $name;
	public function __construct($pid, $pname){
		$this->id = $pid;
		$this->name = $pname;
	}
}
class endorsement{
	public $id;
	public $endorsement;
	public function __construct($pid, $pendorsement){
		$this->id = $pid;
		$this->endorsement = $pendorsement;	    
	}
}
//Headlines
class headlines{
	var $vars = array();
	function initial(){}	
}
//Headlines
class news_updates{
	var $vars = array();
	function initial(){}	
}
//Products
class product{
	var $vars = array();
	function initial(){}	
}
?>