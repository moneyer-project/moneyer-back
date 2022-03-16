<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\Request;

class DateTimeHelper
{
    public static function getByRequest(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));
        $day = $request->get('day', date('d'));

        $date = new \DateTime();
        $date->setDate($year, $month, $day);
        $date->setTime(0, 0, 0);

        return $date;
    }
}
