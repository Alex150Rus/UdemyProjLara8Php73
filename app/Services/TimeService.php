<?php

namespace App\Services;

class TimeService
{
    public function timeDiffCheck() {
        $dateTime = new \DateTime('01.02.2022');
        $dateTimeDateOfAdd = new \DateTime('10.11.2021');
        dd(($dateTime->diff($dateTimeDateOfAdd)->y > 0) || ($dateTime->diff($dateTimeDateOfAdd)->m * 100 + $dateTime->diff($dateTimeDateOfAdd)->d) > 216);
    }
}
