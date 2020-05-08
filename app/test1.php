<?php

include_once('app_code/events_stages_current.php');

		$obj = new EventsStagesCurrent();
		$obj->openConnection();
		$obj->setTHREADID(1);
		echo $query = $obj->preparedExecuteNoneQuery(Common::$insert);
		//$check = $obj->executeReader($query);
			


?>