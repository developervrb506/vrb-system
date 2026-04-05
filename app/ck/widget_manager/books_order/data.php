<? include(ROOT_PATH . "/ck/process/security.php"); ?>
<?


$action = param('action');

switch ($action) {
	case 'order':
		$data = $_POST['data'];
 		$booksorder = json_decode($data,true);
		foreach ($booksorder as $book) {
			update_book_order($book['id'],$book['order']);
		}
		break;

	case 'status': 

	        
	        $id = param('id');
	        $status = $_POST['status'];
	        $val = 0; 
	        if($status == 'true'){ $val = 1;}
            
             update_book_status($id,$val) ;
            
	       break;
		
	
	  default:
		# code...
		break;
}






?>