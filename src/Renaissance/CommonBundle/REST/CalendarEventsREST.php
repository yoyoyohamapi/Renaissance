<?php
namespace Renaissance\CommonBundle\REST;
use Renaissance\CommonBundle\REST\REST_Base;

class CalendarEventsREST extends BaseREST{
	public function getAllCalEvents(){
		$this->api = "calendar_events?all_events=true";
        		$events = $this->execute();
        		return $events;
	}

	public function getCalEventsOfCurrentUser(){
		$this->api = "calendar_events";
        		$events = $this->execute();
        		return $events;
	}

	public function getCalEventsOfCourse($course_id){
		$this->api = "calendar_events?context_codes[]=course_".$course_id;
		$events = $this->execute();
		return $events;
	}

	public function getCalUndatedEvents(){
		$this->api = "calendar_events?undated=true";
		$events = $this->execute();
		return $events;
	}

	public function getCalEventById($event_id){
		$this->api = "calendar_events/".$event_id;
		$event = $this->execute();
		return $event;
	}

	public function getCalAssignmentById($assignment_id){
		$this->api = "calendar_events/".$assignment_id;
		$assignment = $this->execute();
		return $assignment;
	} 

	public function deleteCalEvent($event_id, $reason){
		$this->api = "calendar_events/".$event_id;
		$cancel_reason = $reason;
		$this->data_field = array(
			"cancel_reason"=>$cancel_reason,
		);
		$this->execute('DELETE');
	}
}