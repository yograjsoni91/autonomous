<?php

class Comman {
  
    public static function refuelCount($refuel_count){
        echo "Number of times refulled:$refuel_count". PHP_EOL;
    }

    public function totalDistanceTravelled($total_distance, $refuel_count, $detour_distance){
        $total_distance_travelled = $total_distance + ($refuel_count*$detour_distance);

        echo "Total distance travelled:$total_distance_travelled KM". PHP_EOL;
    }

    public static function convertTime($dec)
    {
        $seconds = ($dec * 3600);
        $hours = floor($dec);
        $seconds -= $hours * 3600;
        $minutes = floor($seconds / 60);
        $seconds -= $minutes * 60;

        return self::lz($hours) .":". self::lz($minutes) .":". self::lz($seconds);
    }

    // lz = leading zero
    public static function lz($num)
    {

        return (strlen($num) < 2) ? "0{$num}" : $num;
    }

}