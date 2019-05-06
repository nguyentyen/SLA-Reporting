<?php
use Business\SpecialDay;
use Business\Day;
use Business\Days;
use Business\Business;
use Business\Holidays;
use Business\DateRange;
require_once 'business-master/src/Day.php';
require_once 'business-master/src/Days.php';
require_once 'business-master/src/AbstractDay.php';
require_once 'business-master/src/SpecialDay.php';
require_once 'business-master/src/Holidays.php';
require_once 'business-master/src/DateRange.php';
require_once 'business-master/src/Business.php';
class Business_Datetime
{
    public $business_day;
    public $holiday;
    public $holiday_name;
    public $typ;
    public $datetime;//"m/d/Y 00:00"
    
    public $fromdate; 
    public $todate;
    
    private $days;
    private $timezone;
    /**
     * 
     * @var m/d/Y 00:00
     */
    public $date; //"m/d/Y"
    public $time; //"00:00"
    
    public $business_time = [
        'beginning' => '08:00', 
        'lunch beginning' => '12:00', 
        'lunch ending' => '13:00',
        'ending' => '17:00'
    ];
    
    function __construct() {
        $this->timezone = new \DateTimeZone('Europe/Berlin');
        $this->days = [
            // Standard days with fixed opening hours
            new Day(Days::MONDAY, [['08:00', '12:00'], ['13:00', '17:00']]),
            new Day(Days::TUESDAY, [['08:00', '12:00'], ['13:00', '17:00']]),
            new Day(Days::WEDNESDAY, [['08:00', '12:00'], ['13:00', '17:00']]),
            new Day(Days::THURSDAY, [['08:00', '12:00'], ['13:00', '17:00']]),
            new Day(Days::FRIDAY, [['08:00', '12:00'], ['13:00', '17:00']]),
            // Special day with dynamic opening hours depending on the date
//             new SpecialDay(Days::FRIDAY, function (\DateTime $date) {
//                 if ('2015-05-29' === $date->format('Y-m-d')) {
//                     return [['9 AM', '12:00']];
//                 }
                
//                 return [['9 AM', '5 PM']];
//             }),
            ];
    }
    
    /**
     * 
     * @param string $fromdatetime
     * @param string $todatetime
     * @return string
     */
    function get_business_time_duration($fromdatetime, $todatetime) {        
        $b = new Bavaria_Holidays();
        $holidays = $this->get_holidays_obj($b->get_holidays_array(get_year($fromdatetime)));
        
        $fromdate_business = new Business($this->days, $holidays, $this->timezone);
        
        $holidays = $this->get_holidays_obj($b->get_holidays_array(get_year($todatetime)));
        $todate_business = new Business($this->days, $holidays, $this->timezone);
        
        if($fromdate_business->within(new \DateTime($fromdatetime))) {
            $res = 1;
        } else {
            $this->get_time_type($fromdatetime);
            $nextDate = $fromdate_business->closest(new \DateTime($fromdatetime));
            
        }
        
        //         $todate_business = new Business($this->days, $holidays, $timezone);
//         $bool = $business->within(new \DateTime('2015-02-02 09:00'));
        var_dump($bool);
        $start = new \DateTime('2015-05-11 10:00');
        $end = new \DateTime('2015-05-14 10:00');
        $interval = new \DateInterval('P1D');
        echo "<pre>";
        $dates = $business->timeline($start, $end, $interval);
        var_dump($dates);
        // After that date (including it)
        $nextDate = $business->closest(new \DateTime('2015-05-11 10:00'));
        
        // Before that date (including it)
        $lastDate = $business->closest(new \DateTime('2015-05-11 10:00'), Business::CLOSEST_LAST);
        
        var_dump($nextDate);
        echo '----------------';
        var_dump($lastDate);
        
        echo "from date: $fromdatetime bis to date: $todatetime";
        $this->fromdate = substr($fromdatetime, 0, -5);
        $this->todate = substr($todatetime, 0, -5);
        $res = $this->get_time_difference_business($fromdatetime, $todatetime);
        //         echo "<pre>";var_dump($res);die;
        return $res;
    }
    
    /**
     * 
     * @param [] $array
     */
    function get_holidays_obj($array) {
        foreach($array as $value) {
            $holidays_array[] = new \DateTime(substr($value['date'], 10));
        }
        $holidays = new Holidays($holidays_array);
        return $holidays;
    }
    
    /**
     * 
     * @param string $time m/d/Y H:i
     * @return boolean
     */
    function is_business_time($time) {
//         $time = "01/01/2018 13:30";
        
        $datetime = explode(' ', $time);
        $this->date = $datetime[0];
        $this->time = $datetime[1];
        
//         $this->date = "01/01/2018 13:30";
        $dayOfWeek = date("l", strtotime($this->date));
        $res['business_day'] = true;
        $d_i = explode('/', $this->date);
        
        $b = new Bavaria_Holidays();
        $holidays = $b->get_holidays_bavaria($d_i[2]);
//         var_dump($d_i[2]);die;
        $this->business_day = true;
        $day_for_test_holiday = $this->date." 00:00:00.000000";
//         var_dump($holidays);die;
        foreach($holidays as $holiday) {
            $h = get_object_vars($holiday);
            $hd = $h['date'];
//             echo "<pre>qq";var_dump(get_date_format($hd,'m/d/Y'));echo "<pre>ww";var_dump($day_for_test_holiday);
//             if($hd == '2018-01-01 00:00:00.000000') {
//                 var_dump($day_for_test_holiday);
//                 var_dump($hd);
//                 var_dump(get_holiday_format($hd));
//                 echo "<pre>aaa";var_dump($this->is_the_same_date(get_holiday_format($hd,'m/d/Y'), $day_for_test_holiday));
                
//             }
//             echo "<pre>aaa";var_dump($this->is_the_same_date(get_date_format($hd,'m/d/Y'), $day_for_test_holiday));
            $same_date = $this->is_the_same_date(get_holiday_format($hd,'m/d/Y'), $day_for_test_holiday);
            if($same_date == true) {
                $this->business_day = false;
                $this->holiday = true;
                $this->holiday_name = $h['name'];
            }
        }
        
        if($dayOfWeek == 'Saturday' || $dayOfWeek == 'Sunday') {
            $res['business_day'] = false;
        } else {
            if($this->business_time['beginning'] > $this->time) {
                $this->business_day = false;
                $this->typ = 'night';
            }
            if($this->business_time['lunch beginning'] < $this->time && $this->business_time['lunch ending'] > $this->time) {
                $this->business_day = false;
                $this->typ = 'midday break';
            }
            if($this->business_time['ending'] < $this->time) {
                $this->business_day = false;
                $this->typ = 'night';
            }
        }
        return $this->business_day;
    }
    
    /**
     * 
     * @param string $fromdatetime m/d/Y H:i
     * @param string $todatetime m/d/Y H:i
     * @return string
     */
    
    
    function get_time_difference_business($fromdatetime, $todatetime) {
//         $fromdate = substr($fromdatetime, 0, 10);
//         $fromtime = substr($fromdatetime, 10);
//         $todate = substr($fromdatetime, 0, 10);
//         $totime = substr($fromdatetime, 10);
        
//         if(!$this->is_business_time($fromdatetime)) {
//             $this->get_next_business_beginning();
//         } else {
//             if($this->is_the_same_date($this->fromdate, $this->todate)) {
//                 $time_diff = get_time_difference($fromdatetime, $todatetime);
//                 if($time_diff['hours'] !== 0) {
//                     $res = $time_diff['hours'].' hours ';
//                 }
//                 if($time_diff['minutes'] !== 0) {
//                     $res .= $time_diff['minutes'].' minutes';
//                 }
//             } else {
//                 if($this->is_business_time($todatetime)) {
//                     $res = $this->get_time_difference_business($fromdatetime, $todatetime);
//                 }
//             }
//         }
// //         echo $fromdate;

//         //first day
//         if($fromtime < $this->business_time['lunch beginning']) {
// //             echo get_time_difference($fromdatetime, $fromdate.' '.$this->business_time['lunch beginning']);die;
//             $d = get_time_difference($fromdatetime, $fromdate.' '.$this->business_time['lunch beginning']);
            
//         } else {
//             $d = get_time_difference($fromdatetime, $fromdate.' '.$this->business_time['ending']);
//         }
//         $duration += $d[''];
        
//         $diff_day = get_time_difference($this->get_the_next_day($fromdate), $todatetime);
// //         print_r($diff_day);
//         //more days between them
//         if($diff_day['days'] > 1) {
//             $last_day = date('m/d/Y', strtotime('+'.($diff_day['days']+1).' day', strtotime($fromdatetime)));
//             if($totime < $this->business_time['lunch beginning']) {
//                 $duration += get_time_difference($last_day.' '.$this->business_time['beginning'], $todatetime);
//             } else  {
//                 $duration += get_time_difference($last_day.' '.$this->business_time['lunch ending'], $todatetime) + 4;
//             }
//             $businessday_count= $this->count_business_day($fromdatetime, $todatetime);
// //             if() {
                
// //             }
//             $duration += 0;
            
//             $duration += get_time_difference($this->business_time['beginning'].$last_day, $this->business_time['lunch beginning']);
//         }
//         echo $fromtime;
//         $end_day = "";
//         echo get_time_difference($fromdatetime, $end_day);

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
    }  
    
    function count_business_day($fromdatetime, $todatetime) {
        
    }
    
    function get_next_business_beginning() {
        $res = "";
        if($this->typ == 'midday break') {
            $res = $this->date.$this->business_time['lunch ending'];
        }
        if($this->holiday == true) {
            $res = $this->get_the_next_day($this->date.$this->business_time['beginning']);
        }
        if($this->typ == 'night') {
            $res = $this->get_the_next_day($this->date.$this->business_time['beginning']);
        }
        return $res;
    }
    
    function get_time_type($datetime) {
        $time = substr($datetime, -5);
        if($time < $this->business_time['beginning'] || $time > $this->business_time['ending']) {
            $result = 'night';
        }
        if($time > $this->business_time['lunch beginning'] && $time < $this->business_time['lunch ending']) {
            $result = 'lunch break';
        }
        return $result;
    }
    
    /**
     * 
     * @param string $date YYYY-mm-dd
     */
    function get_the_next_day($date) {
        $res = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        return $res;
    }
    
    function is_the_same_date($date1, $date2) {
        if($date1 < $date2) {
            return false;
        }
        if($date1 > $date2) {
            return false;
        }
        return true;
    }
}

