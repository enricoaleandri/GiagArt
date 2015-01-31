<?php


class DBConnection extends mysqli {
	private $Host;
	private $Username;	
	private $Password;	
	private $NameDB;
	private $DBConnect;
	private $Ready;

    function __construct($config)
    {

        $this->Host = $config->getProperty("host");
        $this->Username = $config->getProperty("user");
        $this->Password = $config->getProperty("pass");
        $this->NameDB = $config->getProperty("db_name");
        $this->DBConnect = false;
    }

	function DB_connect()
    {
		//Logger::log(Logger::$INFO,"DB connect : host =".$this->Host."   username = ".$this->Username."   password = ". $this->Password. "    database_name = ".  $this->NameDB);
        parent::__construct( $this->Host, $this->Username, $this->Password,$this->NameDB);


                /*
         * Use this instead of $connect_error if you need to ensure
         * compatibility with PHP versions prior to 5.2.9 and 5.3.0.
         */
        if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') '
                . mysqli_connect_error());
        }

		$this->Ready = true;
	}

    function getReady()
    {
        return $this->Ready;
    }
}
?>