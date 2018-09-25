<?php

class Schedule
{
    public $data;
    
    public function __construct($data)
    {
        $this->data = $data;
        $regionQuery= \R::findOne('regions', ' id = ?', [$this->data['regions']]);
        $this->data['interval'] = $regionQuery['distance'];
    }
    
    private function addNightRoute($interval)
    {
        $hours = getHours($this->data['date']);
        $todayInterval = 24 - $hours;
        $tommorrowInterval = $interval - $todayInterval;
        $tomorrow = $this->shiftTime($this->data['date'], $todayInterval);
        $tommorrowDatetime = $tomorrow;
        
        return $this->checkRoute($tommorrowDatetime, $tommorrowInterval, $this->data['regions']);
    }
    
    public function addRoute($date, $interval, $region)
    {
        $item = \R::dispense('schedule');
        $item['date'] = $date;
        $item['courier_id'] =  $this->data['couriers'];
        $item['region_id'] =  $region;
        $item['interval'] =  $interval;
        \R::store($item);
    }
    
    private function checkRoute($date, $interval, $region)
    {
        $query= \R::findOne(
            'schedule',
                  ' courier_id = ? AND date = ?',
            [$this->data['couriers'], $date]
        );
        
        if ($query) {
            $hoursToAdd = getHours($date);
            $hoursFromQuery = getHours($query['date']);
            
            if (($hoursToAdd + $interval) >= $hoursFromQuery) {
                return ['false'];
            } else {
                return ['true', $date, $interval, $region];
            }
        } else {
            return ['true',$date, $interval, $region];
        }
        return ['false'];
    }
    
    public function reverse()
    {
        $this->data['date'] = $this->shiftTime($this->data['date'], $this->data['interval']);
        $this->data['regions'] = 0;
        return $this->add();
    }
    
    public function add()
    {
        $hours = getHours($this->data['date']);
        $toDb = [];
  
        if ($this->data['interval'] > (24 - $hours)) {
            $todayInterval = 24 - $hours;
            $toDb[] = $this->checkRoute($this->data['date'], $todayInterval, $this->data['regions']);
            $toDb[] = $this->addNightRoute($this->data['interval']);
        } else {
            $toDb[] = $this->checkRoute($this->data['date'], $this->data['interval'], $this->data['regions']);
        }
       
        return $toDb;
    }

    private function shiftTime($date, $shift)
    {
        $shiftTime = new DateTime($date);
        $shiftTime->add(new DateInterval("PT{$shift}H"));
        
        return $shiftTime->format('Y-m-d H:i');
    }
}
