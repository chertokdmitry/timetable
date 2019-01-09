<?php

class Index extends Model
{
    const DATA = [
        'couriers' => ['Курьеры', ['id', 'first', 'last']],
        'regions' => ['Бизнес-центры', ['id', 'name', 'distance']],
        'schedule' => ['Расписание', ['date', 'courier_id', 'region_id', 'interval']]];

    const FORM = ['schedule' =>
        ['Новый маршрут',
          'fields' =>
           [['Курьер', 'linked', ['couriers', ['first', 'last']]],
            ['Регион', 'linked', ['regions', ['name']]],
            ['Дата', 'date', 'date']]],
        'index' =>
        ['Показать расписание',
          'fields' =>
           [['С ', 'date', 'date1'],
            ['по ', 'date', 'date2']]]];
    
    public function view()
    {
        $tr = [];
        $i = 0;
        $rows = \R::findAll(App::gi()->uri->table);

        foreach ($rows as $row) {
            foreach (self::DATA[App::gi()->uri->table][1] as $key => $value) {
                $tr[$i][$key] = $row[$value];
            }
            $i++;
        }
        
        $table = new Table(self::DATA[App::gi()->uri->table][0],
                self::DATA[App::gi()->uri->table][1],
                $tr);
        
        return $table->html;
    }
    
    public function showSchedule($postData)
    {
        $html = '';
        $date1 = $postData['date1'];
        $date2 =  $this->shiftTime($postData['date2'], 24);
        $items = \R::find('schedule', ' date >= ? AND date <= ?', [$date1, $date2]);
        $items = array_merge([], $items);
        
        foreach ($items as $item) {
            $html .= $this->makeScheduleTable($item, $date1);
        }
        return $html;
    }
    
    private function makeScheduleTable($item, $date1)
    {
        $th = [];
        $courier = \R::findOne('couriers', ' id = ?', [$item['courier_id']]);
        $routeQuery = \R::findOne('regions', ' id = ?', [$item['region_id']]);
        $route = $item['region_id'] == 0 ? ' возврат в Мск' : ' Mск - ' . $routeQuery['name'];
        $header = $item['date'] . ' ' . $courier['first'] . ' ' . $courier['last'] . ' ' . $route;
        $table = new Table($header, 
                $th, 
                $this->makeWorkingHours($item['date'], 
                        $item['interval']));
        return $table->html;
    }
    
    private function makeWorkingHours($itemDate, $interval)
    {
        $date = new DateTime($itemDate);
        $hours = $date->format('H');
        $workingHours = [];
        for ($z=0; $z<24; $z++) {
            if ($z >= $hours && $z < ($hours+$interval)) {
                $workingHours[0][$z] = '<span class="badge badge-warning">&nbsp;</span>';
            } else {
                $workingHours[0][$z] =  '<span class="badge badge-light">&nbsp;</span>';
            }
        }
        return $workingHours;
    }
            
    public function showIndexForm()
    {
        $header = '<div><h3>' . self::FORM['index'][0] . '</h3>';
        $formAction = '/index/';
        $tr = new Form($header, $formAction, self::FORM['index']['fields'], 0, false);
        $html = $tr->html;
        $html .= '</div><br><br>';

        return $html;
    }
    
    public function makeForm($action, $id)
    {
        $header = '<h3>' . self::FORM[App::gi()->uri->table][0] . '</h3>';
        $formAction = '/index/' . $action . '/' .  App::gi()->uri->table;
        $tr = new Form(
            $header,
            $formAction,
                self::FORM[App::gi()->uri->table]['fields'],
            $id
        );

        return $tr->html;
    }
    
    public function add($data)
    {
        $data['date'] = $data['date'] . ' ' . $data['time'];
        $schedule = new Schedule($data);
        $toDb = array_merge($schedule->addSchedule(), $schedule->reverse());

        foreach ($toDb as $route) {
            if ($route[0]=='false') {
                $html = '<div class="alert alert-danger" role="alert">
                                Курьер занят!
                            </div>';
                return $html;
            }
        }


        foreach ($toDb as $route) {
            $schedule->addRoute($route[1], $route[2], $route[3]);
        }

        $html = '<div class="alert alert-success" role="alert">
                                Данные записаны!
                            </div>';
        return $html;
    }
    
    protected function shiftTime($date, $shift)
    {
        $shiftTime = new DateTime($date);
        $shiftTime->add(new DateInterval("PT{$shift}H"));
        
        return $shiftTime->format('Y-m-d H:i');
    }
}
