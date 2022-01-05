<?php

class Weather
{

    protected PdoHelper $pdo;

    public function __construct()
    {
        //хранилище
        $this->pdo = PdoHelper::getInstance();
    }

    public function addWeather(string $city, float $temp): ?int
    {
        $city = trim($city);
        if ($city && $temp) {
            $date = (new DateTime('now'))->format('Y-m-d H:i:s');
            $values = [
                'city' => $city,
                'temp' => $temp,
                'created_at' => $date,
                'updated_at' => $date
            ];
            return $this->pdo->insert('day_temp', array_keys($values), $values, 1);;
        }
        return false;
    }

    public function getDayWeather(string $city, DateTime $date)
    {
        $date->setTime(0, 0, 0);

        $date_to = clone $date;
        $date_to->setTime(23, 59, 59);

        return $this->pdo->selectRows('SELECT temp, created_at FROM day_temp 
                                                                    WHERE (city=?) AND (created_at BETWEEN ? AND ?)',
                                [$city, $date->format('Y-m-d H:i:s'), $date_to->format('Y-m-d H:i:s')]);
    }
}