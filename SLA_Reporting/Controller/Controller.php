<?php
require_once __DIR__.'/../Model/ticket_model.php';
require_once __DIR__.'/../Model/project_model.php';

class Controller
{

    private $client_obj;
    private $tickets_data_from_youtrack;
    private $edited_tickets_array;//edited array
    
    private $project_name;
    private $from_date;
    private $to_date;
    
    private $from_timestamp;
    private $to_timestamp;
       
    private $project_model_object;
    private $ticket_model_object;
    
    function __construct($client_obj)
    {
        $this->client_obj = $client_obj;
        $this->project_model_object = new Project_Model();
    }

    function get_tickets($projectinfo)
    {
        $this->project_name = $projectinfo['report'];
        $this->from_date = $projectinfo['fromdate'];
        $this->to_date = $projectinfo['todate'];
        
        $response = $this->client_obj->get('/issue/byproject/'.$this->project_name);
        
        /**
         * Key: int 
         * Ticket: array: 
         * 
         */
        $this->tickets_data_from_youtrack = $response->toArray();
        //alle ticket_models des Projects
        $this->project_model_object->set_ticket_array($this->client_obj, $this->tickets_data_from_youtrack);
        //alle tickets in array des Projects
        $this->edited_tickets_array = $this->project_model_object->get_tickets_array_by_date($this->from_date, $this->to_date);
       
        return $this->edited_tickets_array;
    }

    function get_projects()
    {
        // https://tracker.ixenso.com/rest/admin/project
        $response = $this->client_obj->get('/admin/project');
        $projects = $response->toArray();
        foreach ($projects as $project) {
            $res[] = $project['id'];
        }
        return $res;
    }
    
    function tickets_sort($array, $on, $order=SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();
        
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }
            
            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }
            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }
        return $new_array;
    }
}