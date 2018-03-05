<?php
	
	class CGIAccess
	{
	private $db;
	
	public function __construct($database)
	{
		$this->db = new mysqli("localhost","root","creative",$database);   //creativegamesinc
		if ($this->db->connect_errno != 0)
		{
			echo "error connecting to databse: ".$this->db->connect_error.PHP_EOL;
			exit();
		}
	}
	
	public function __destruct()
	{
		if (isset($this->db))
		{
			$this->db->close();
		}
	}
	
	public function getEventSchedule()
	{
		$query = "select e.eventid, e.eventname, v.venue, e.eventdate from event e, venue v;";
	
		$queryResponse = $this->db->query($query);
		$response = array();
		while($row = $queryResponse->fetch_assoc())
		{
			$response[] = $row;
		}
		return $response;
	}
	
	public function addEvent($eventname,$eventvenue,$eventdate)
	{
		$en = $this->db->real_escape_string($eventname);
		$ev = $this->db->real_escape_string($eventvenue);
		$ed = $this->db->real_escape_string($eventdate);
		
		$query = "insert into event(eventname, eventid, eventdate) VALUES ('$en','$ev','$ed');";
	
		echo "executing SQL statement:\n".$query."\n";
		if (!$this->db->query($query))
		{
			echo "failed to insert record for $eventname".PHP_EOL;
		}
	}
	
	public function validateUser($username,$password)
	{
		$un = $this->db->real_escape_string($username);
		$pw = $this->db->real_escape_string($password);
	
		$query = "select * from users where username = '$un';";
		$result = $this->db->query($query);
	
		while ($row = $result->fetch_assoc())
		{
			if ($row["password"] == $pw)
			{
				// I have a match
				return true;
			}
		}
		return false;
	}
	
	}
	?>
	

