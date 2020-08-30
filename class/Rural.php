<?php

include_once 'interface/MappingInterface.php';
include_once 'Comman.php';

class Rural implements MappingInterface {
  
    CONST FUEL_LIMIT = 200;
    CONST SPEED_LIMIT = 70;

    public $distance_covered = 0;
    public $fuel_range = self::FUEL_LIMIT;
    public $drop_range_percentage = 0;
    public $gain_speed_limit = 15;
    public $garage_distance = 50;
    public $refuel_count = 0;
    public $detour_distance = 10;
    public $refule_time = 30;
    public $to_fuel;
    public $from_fuel = 0;
    public $total_distance;
    private $road_length;
    
    public function __construct($road_length) {
        $this->road_length = $road_length;
        $this->total_distance = ($this->road_length + ($this->garage_distance*2));
        $this->to_fuel = $this->detour_distance/2;
    }
    
    public function distanceMapping() {
        $this->addGarageAreaDistance($this->garage_distance);

        while ($this->distance_covered < $this->total_distance) {
            $remaining_distance = $this->total_distance - $this->distance_covered;

            $this->fuel_range = $this->fuel_range - $this->from_fuel;

            if ($this->fuel_range < $remaining_distance) {
                $this->from_fuel = $this->detour_distance/2;
                if(($remaining_distance - $this->fuel_range) >= $this->garage_distance){
                    $this->distance_covered += ($this->fuel_range-$this->to_fuel);
                }else{
                    $this->distance_covered += ($this->fuel_range < ($remaining_distance - $this->garage_distance) + $this->to_fuel) ? ($remaining_distance - $this->garage_distance) - $this->to_fuel:$remaining_distance - $this->garage_distance;
                }
                $this->refuel_count++;
                $this->fuel_range = self::FUEL_LIMIT;
            }else{
                $this->distance_covered += $remaining_distance;
            }
        }

        $this->totalSpentTime();
        Comman::refuelCount($this->refuel_count);
        Comman::totalDistanceTravelled($this->total_distance, $this->refuel_count, $this->detour_distance);       
    }

    public function addGarageAreaDistance($garage_distance){
        $this->fuel_range = $this->fuel_range - $garage_distance;
        $this->distance_covered = $this->distance_covered + $garage_distance;
    }

    public function totalSpentTime(){
        $urban_speed_limit = self::SPEED_LIMIT + (self::SPEED_LIMIT * ($this->gain_speed_limit/100));
        $urban_distance_covered = $this->road_length + ($this->refuel_count*$this->detour_distance);
        $total_urban_time = number_format((float)($urban_distance_covered/$urban_speed_limit), 2, '.', '');
        $total_garage_time = number_format((float)(($this->garage_distance*2)/self::SPEED_LIMIT), 2, '.', '');
        $total_refuel_time = number_format((float)(($this->refuel_count*30)/60), 2, '.', '');
        $total_spent_time = $total_urban_time+$total_garage_time+$total_refuel_time;
        $total_spent_time = Comman::convertTime($total_spent_time);

        echo "Total time spent on mapping task:$total_spent_time Hours". PHP_EOL;
    }
}