<?php
Class Driver
{
    public static $drivers = [];
    public $name = '';
    public $total_time;
    public $total_distance;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->total_time = 0;
        $this->total_distance = 0;
    }

    public function calculate_trip($name, $start_time, $end_time, $miles_driven) {
        foreach (self::$drivers as $driver) {
            if ($name == $driver[$name]) {
                $trip_time = $timediff = date("H",strtotime($end_time) - strtotime($start_time));
                $inner_mph = $miles_driven / $trip_time;
                if ($inner_mph > 5 && $inner_mph < 100){
                    $this->total_time += $trip_time;
                    $this->total_distance += $miles_driven;
                }
            }
        }
        if ($this->total_time == 0) {
            self::$drivers[$name] = "{$this->total_distance} @ 0 mph";
        } else {
            $mph = $this->total_distance / $this->total_time;
            self::$drivers[$name] = "{$this->total_distance} @ {$mph} mph";
        }
    }

    public static function report_drives()
    {
        foreach (self::$drivers as $driver => $trip_info) {
            echo "{$driver}: " . $trip_info . "\n";
        }
    }
}


$stdin = fopen('php://stdin', 'r');

$drivers = [];
while (($line = fgets($stdin)) !== FALSE) {
    $line_array = explode(' ', $line);

    if ($line_array[0] == 'Driver'){
        ${'driver_' . $line_array[1]} = new Driver($line_array[1]);
    }
    elseif ($line_array[0] == 'Trip') {
        ${'driver_' . $line_array[1]}->calculate_trip($line_array[1], $line_array[2], $line_array[3], $line_array[4]);
    }
}
Driver::report_drives();

//${'driver_' . $line_array[1]} = new Driver($line_array[1]);
//var_dump(${'driver_' . $line_array[1]});
