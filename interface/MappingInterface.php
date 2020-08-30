<?php

interface MappingInterface {
    public function distanceMapping();
    public function addGarageAreaDistance($garage_distance);
    public function totalSpentTime();
}