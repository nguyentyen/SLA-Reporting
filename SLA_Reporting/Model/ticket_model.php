<?php
require_once __DIR__.'/../Business_datetime.php';
class Ticket_Model
{

    public $ticket_name;

    public $creator;

    public $created_timestamp;

    public $created_datetime;

    public $time_to_respond;
    public $respond_timestamp;

    public $time_to_resolved;
    public $resolved_timestamp;

    public $state;

    public $comment;

    public $client_obj;
    public $business;

    private $ticket_changes;

    private $first_comment_time = "0";

    private $change_data;

    private $first_state_change = "0";

    function __construct($client_obj)
    {
        $this->client_obj = $client_obj;
        
        $this->ticket_name = "";
        $this->creator = "";
        $this->created_datetime = "";
        $this->time_to_respond = "";
        $this->time_to_resolved = "";
        $this->state = "";
    }

    public function get_ticket()
    {
        // $this->set_ticket_data($ticket_model);
        $res['ticket_name'] = $this->ticket_name;
        $res['creator'] = $this->creator;
        $res['created_time'] = $this->created_datetime;
        $res['respond'] = miliseconds_to_datetime($this->respond_timestamp);
        $res['time_to_respond'] = $this->time_to_respond;
        $res['resolved'] = miliseconds_to_datetime($this->resolved_timestamp);
        $res['time_to_resolved'] = $this->time_to_resolved;
        $res['state'] = $this->state;
        
        return $res;
    }

    static function get_ticket_data(Ticket_Model $ticket_model)
    {
        // $this->set_ticket_data($ticket_model);
        $res['ticket_name'] = $ticket_model->ticket_name;
        $res['creator'] = $ticket_model->creator;
        $res['created_time'] = $ticket_model->created_datetime;
        $res['time_to_respond'] = $ticket_model->time_to_respond;
        $res['time_to_resolved'] = $ticket_model->time_to_resolved;
        $res['state'] = $ticket_model->state;
        
        return $res;
    }

    public function set_ticket_data_from_id($ticket_id)
    {
        $ticket_id = "IXBY-9";
        $this->ticket_name = $ticket_id;
        $this->get_ticket_data_from_changes($ticket_id);
        echo "<pre>";var_dump($this->get_ticket());die;
        return true;
    }

    private function get_ticket_data_from_changes($ticket_id)
    {
        $changes = $this->client_obj->get('/issue/' . $ticket_id . '/changes');
        $this->ticket_changes = $changes->toArray();
        foreach ($this->ticket_changes['issue']['field'] as $issue_field) {
            if ($issue_field['name'] == "created") {
                $this->created_timestamp = $issue_field['value'];
            }
            if ($issue_field['name'] == "reporterFullName") {
                $this->creator = $issue_field['value'];
            }
            if ($issue_field['name'] == "State") {
                $this->state = $issue_field['value']['0'];
            }
        }
        // get first_comment_time for time_to_respond caculation
        // is the first comment from comments in issue from ticket changes
        if (array_key_exists('comment', $this->ticket_changes['issue'])) {
            if (count($this->ticket_changes['issue']['comment']) > 0) {
                $this->first_comment_time = $this->ticket_changes['issue']['comment']['0']['created'];
            }
        }
        
        // get first_state_change for time_to_respond caculation
        // is the first time when state was changed
        $this->last_resolved_time = $this->created_timestamp;
        if (is_array($this->ticket_changes['change'])) {
            $cl = 0;
            $ve = 0;
            foreach ($this->ticket_changes['change'] as $change_value) {
                
                foreach ($change_value['field'] as $field_value) {
                    $c[$field_value['name']] = $field_value;
                }
                
                if (array_key_exists('State', $c)) {
                    if (array_key_exists('newValue', $c['State'])) {
                        if ($this->first_state_change == "0") {
                            $this->first_state_change = (int) $c['updated']['value'];
                        }
                        if ($c['State']['newValue']['0'] == 'Closed') {
                            $cl = (int) $c['updated']['value'];
                        }
                        if ($c['State']['newValue']['0'] == 'Verified') {
                            $ve = (int) $c['updated']['value'];
                        }
                    }
                }
            }
            if ($cl < $ve) {
                $this->last_resolved_time = $cl;
            } else {
                $this->last_resolved_time = $cl;
            }
        }
        $this->created_datetime = miliseconds_to_datetime($this->created_timestamp);
        
        $this->caculate_time_to_respond();
        $this->caculate_time_to_resolved();
        return;
    }

    private function set_ticket_data(Ticket_Model $ticket_model)
    {
        $this->ticket_name = $ticket_model->ticket_name;
        $this->creator = $ticket_model->creator;
        $this->created_timestamp = $ticket_model->created_timestamp;
        $this->time_to_respond = $ticket_model->time_to_respond;
        $this->time_to_resolved = $ticket_model->time_to_resolved;
        $this->state = $ticket_model->state;
    }

    function caculate_time_to_respond()
    {
        $this->time_to_respond = "";
        $this->business = new Business_Datetime();
        // echo $this->first_state_change.", $this->first_comment_time"; die;
        if ($this->first_state_change !== "0" || $this->first_comment_time !== "0") {
            if ((int) $this->first_state_change < $this->first_comment_time) {
                $this->respond_timestamp = $this->first_state_change;
            } else {
                $this->respond_timestamp = $this->first_comment_time;
            }
            $respon_date = miliseconds_to_datetime($this->respond_timestamp, 'm/d/Y');
            $respon_datetime = miliseconds_to_datetime($this->respond_timestamp);
            $created_date = miliseconds_to_datetime($this->created_timestamp, 'm/d/Y');
            $from = miliseconds_to_datetime($this->respond_timestamp, 'm/d/Y H:i');
            $to = miliseconds_to_datetime($this->created_timestamp, 'm/d/Y H:i');
            $from = '10/18/2018 13:14';
            $to = '10/22/2018 13:15';
            $this->time_to_respond = $this->business->get_business_time_duration($from, $to);
//             $this->time_to_respond = $this->milisecond_to_time($this->respond_timestamp, $this->created_timestamp);
        }
        return;
    }

    private function caculate_time_to_resolved()
    {
        $this->time_to_resolved = "";
        // echo "<pre>";
        // var_dump(timestamp_to_datetime($this->last_resolved_time));
        // die;
        if ($this->state == "Closed" || $this->state == "Verified") {
            $this->resolved_timestamp = $this->last_resolved_time;
            $this->time_to_resolved = $this->milisecond_to_time($this->resolved_timestamp, $this->created_timestamp);
        } else {
            $this->time_to_resolved = "00:00:00";
        }
        return;
    }

    function milisecond_to_time($time)
    {
        // $time = gmdate("H:i:s", $time / 1000);
        $hours = gmdate("H", $time / 1000);
        $mins = gmdate("i", $time / 1000);
        $seconds = gmdate("s", $time / 1000);
        if ($hours > 24) {
            $tags = Math . floor($hours / 24);
            $hours = $hours % 24;
        }
        $res = "$hours:$mins:$seconds";
        return $res;
    }
}