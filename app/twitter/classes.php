<?
class tweet {
	public $id;
	public $text;
	public $source;
	public $t_date;
	public $user_id;
	public $user_image;
	public function __construct($pid, $ptext, $psource, $pdate, $puser, $pimage) {
       $this->id = $pid;
	   $this->text = $ptext;
	   $this->source = $psource;
	   $this->t_date = $pdate;
	   $this->user_id = $puser;
	   $this->user_image = $pimage;
   }	
}
class twitter_list {
    public $id;
	public $name;
	public $description;
	public $url;
	public function __construct($pid, $pname, $pdesc, $purl) {
       $this->id = $pid;
	   $this->name = $pname;
	   $this->description = $pdesc;
	   $this->url = $purl;
   }
}
class twitter_user{
	public $id;
	public $name;
	public $screen_name;
	public $team;
	public $sport;
	public $position;
    public function __construct($pid, $pname, $pscreen, $pteam = "", $psport = "", $pposition = "") {
       $this->id = $pid;
	   $this->name = $pname;
	   $this->screen_name = $pscreen;
	   $this->team = $pteam;
	   $this->sport = $psport;
	   $this->position = $pposition;
   }
}
?>