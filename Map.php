<?php

include ("interface/MappingInterface.php");
include ("class/Urban.php");
include ("class/Rural.php");

class Map {

    private $road_type;
    private $road_length;

    function __construct($road_type, $road_length) {
        $this->road_type = $road_type;
        $this->road_length = $road_length;
    }
    
    public function mapArea() {
        try {
            if('urban' == $this->road_type){
                $areaInstance = new Urban($this->road_length);
                $areaInstance->distanceMapping();
            }else if('rural' == $this->road_type){
                $areaInstance = new Rural($this->road_length);
                $areaInstance->distanceMapping();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

$input_params = getopt(null, ["road_type:", "road_length:"]);
$map = new Map($input_params['road_type'], $input_params['road_length']);
$map->mapArea();
