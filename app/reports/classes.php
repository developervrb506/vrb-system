<?php

class website {
    var $id;
    var $name;
    var $url;

    function __construct($pid, $pname, $purl) {
        $this->id = $pid;
        $this->name = $pname;
        $this->url = $purl;
    }
}

class contact {
    var $email;
    var $name;
    var $phone;
    var $cdate;
    var $web;

    function __construct($pemail, $pname, $pphone, $pdate, $pweb) {
        $this->email = $pemail;
        $this->name = $pname;
        $this->phone = $pphone;
        $this->cdate = $pdate;
        $this->web = $pweb;
    }
}

?>