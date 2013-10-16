	<?	
		//genco
		//$username="root";
        //$password="bluepill";
        //$database="controlfinal2";
		//$url="mail2.gencosa.com.ar";
		
		//local
		$username="root";
        $password="";
        $database="controlfinal";
		$url="localhost";

        mysql_connect($url,$username,$password);
        @mysql_select_db($database) or die( "No pude conectarme a la base de datos");
		
	 ?>
	 

	 
	 
