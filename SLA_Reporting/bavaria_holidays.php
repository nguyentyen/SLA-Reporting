<?php
require_once 'Holiday/Calculator.php';
require_once 'Holiday/Holiday.php';
require_once 'Holiday/Germany.php';
require_once 'Holiday/Bavaria.php';
require_once 'test/Holiday/BavariaTest.php';
require_once 'business-master/src/Holidays.php';
use Holiday\Bavaria;

class Bavaria_Holidays extends Bavaria
{
/**
 * 
 * @param string $year
 * @return []
 */
    public function get_holidays_bavaria($year)
    {
        // $b = new Bavaria();
        $d = $this->getHolidays($year);
        $res = [];
        $holidays = [
            'Neujahrstag',
            'Heilige Drei Könige',
            'Karfreitag',
            'Ostermontag',
            'Tag der Arbeit',
            'Christi Himmelfahrt',
            'Pfingstmontag',
            'Fronleichnam',
            'Mariä Himmelfahrt',
            'Tag der deutschen Einheit',
            'Allerheiligen',
            '1. Weihnachtsfeiertag',
            '2. Weihnachtsfeiertag'
        ];
        foreach ($holidays as $holiday){
                foreach($d as $value) {
                    if(utf8_encode($holiday) == $value->name) {
                        $res[] = $value;
                    }
                }
        }
        return $res;
    }
    
    public function get_holidays_array($year) {
        $y= $this->get_holidays_bavaria($year);
        $res = [];
        for($i = 0; $i < count($y); $i++) {
            $arr = get_object_vars($y[$i]);
            $res[$i]['date'] = $arr["date"];
            $res[$i]['name'] = $arr["name"];
        }
        return $res;
    }
}

