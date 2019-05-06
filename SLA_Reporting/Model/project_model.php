<?php
class Project_Model {
    private $project_name;
    private $creator;
    private $created_time;
    private $ticket_array;
    
    private $tickets_data_from_youtrack;
    
    public function __construck() {
        
    }
    
    function get_project_data() {
        $res['project_name'] = $this->project_name;
        $res['creator'] = $this->creator;
        $res['created_time'] = $this->created_time;
        $res['tickets'] = $this->ticket_array;
        
        return $res;
    }
    
    public function set_ticket_array($client_obj, $ticket_array) {
//         echo "<pre>";var_dump($ticket_array);die;
        $this->tickets_data_from_youtrack = $ticket_array;
        for($i = 0; $i < count($ticket_array); $i++) {
            $this->ticket_model = new Ticket_Model($client_obj);
            
            $this->ticket_model->set_ticket_data_from_id($this->tickets_data_from_youtrack[$i]['id']);
           
            $this->ticket_array[] = $this->ticket_model;
        }
        
    }
    
    function get_tickets_array_by_date($fromdate, $todate) {
        $res = [];
        foreach($this->ticket_array as $value) {
            $created_date = explode(' ', $value->created_datetime);
            if($fromdate <= $created_date[0] && $todate >= $created_date[0]) {
                $res[] = Ticket_Model::get_ticket_data($value);
            }
        }
        return $res;
    }
    
    function milisecond_to_time($time) {
        //         $time = gmdate("H:i:s", $time / 1000);
        $hours = gmdate("H", $time / 1000);
        $mins = gmdate("i", $time / 1000);
        $seconds = gmdate("s", $time / 1000);
        if($hours > 24) {
            $tags = Math.floor($hours/24);
            $hours = $hours % 24;
        }
        $res = "$hours:$mins:$seconds";
        return $res;
    }
    
    function get_ticket_models_from_project() {
        return $this->ticket_array;
    }
    
    
}