<?php
use Business\SpecialDay;
use Business\Day;
use Business\Days;
use Business\Business;
use Business\Holidays;
use Business\DateRange;
require_once 'src/Day.php';
require_once 'src/Days.php';
require_once 'src/AbstractDay.php';
require_once 'src/SpecialDay.php';
require_once 'src/Holidays.php';
require_once 'src/DateRange.php';
require_once 'src/Business.php';
// Opening hours for each week day. If not specified, it is considered closed
$days = [
    // Standard days with fixed opening hours
    new Day(Days::MONDAY, [['09:00', '13:00'], ['2pm', '5 PM']]),
    new Day(Days::TUESDAY, [['9 AM', '5 PM']]),
    new Day(Days::WEDNESDAY, [['10:00', '13:00'], ['14:00', '17:00']]),
    new Day(Days::THURSDAY, [['10 AM', '5 PM']]),
    
    // Special day with dynamic opening hours depending on the date
    new SpecialDay(Days::FRIDAY, function (\DateTime $date) {
        if ('2015-05-29' === $date->format('Y-m-d')) {
            return [['9 AM', '12:00']];
        }
        
        return [['9 AM', '5 PM']];
    }),
    ];

// Optional holiday dates
$holidays = new Holidays([
    new \DateTime('2015-01-01'),
    new \DateTime('2015-01-02'),
    new DateRange(new \DateTime('2015-07-08'), new \DateTime('2015-07-11')),
]);

// Optional business timezone
$timezone = new \DateTimeZone('Europe/Berlin');

// Create a new Business instance
$business = new Business($days, $holidays, $timezone);

$bool = $business->within(new \DateTime('2015-02-02 09:00'));
var_dump($bool);
// $start = new \DateTime('2015-05-11 10:00');
// $end = new \DateTime('2015-05-14 10:00');
// $interval = new \DateInterval('P1D');
// echo "<pre>";
// $dates = $business->timeline($start, $end, $interval);
// var_dump($dates);
// After that date (including it)
$nextDate = $business->closest(new \DateTime('2015-05-11 10:00'));

// Before that date (including it)
$lastDate = $business->closest(new \DateTime('2015-05-11 10:00'), Business::CLOSEST_LAST);

var_dump($nextDate);
echo '----------------';
var_dump($lastDate);

