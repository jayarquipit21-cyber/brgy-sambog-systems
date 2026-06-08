<?php

namespace App\Services;

use Carbon\Carbon;

class HolidaysService
{
    /**
     * Return array of holidays for a given year.
     * Each item: ['date' => 'YYYY-MM-DD', 'name' => 'Holiday name']
     */
    public static function forYear(int $year): array
    {
        $holidays = [];

        // Fixed-date holidays
        $fixed = [
            '01-01' => "New Year's Day",
            '04-09' => 'Araw ng Kagitingan',
            '05-01' => 'Labor Day',
            '06-12' => 'Independence Day',
            '08-21' => 'Ninoy Aquino Day',
            '11-30' => 'Bonifacio Day',
            '12-25' => 'Christmas Day',
            '12-30' => 'Rizal Day',
        ];

        foreach ($fixed as $md => $name) {
            $holidays[] = ['date' => "$year-$md", 'name' => $name];
        }

        // Movable: Maundy Thursday & Good Friday (based on Easter Sunday)
        // Compute Easter Sunday using Meeus/Jones algorithm (approx)
        $easter = self::easterSunday($year);
        // Maundy Thursday = easter -3, Good Friday = easter -2
        $maundy = $easter->copy()->subDays(3);
        $goodFriday = $easter->copy()->subDays(2);
        $holidays[] = ['date' => $maundy->toDateString(), 'name' => 'Maundy Thursday'];
        $holidays[] = ['date' => $goodFriday->toDateString(), 'name' => 'Good Friday'];

        // Other common movable holidays
        // National Heroes Day: last Monday of August
        $nhd = Carbon::create($year, 8, 31)->startOfDay();
        while ($nhd->dayOfWeek !== Carbon::MONDAY) {
            $nhd->subDay();
        }
        $holidays[] = ['date' => $nhd->toDateString(), 'name' => 'National Heroes Day'];

        // EDSA Revolution Anniversary (Feb 25)
        $holidays[] = ['date' => "$year-02-25", 'name' => 'EDSA People Power Anniversary'];

        // Christmas Eve / New Year's Eve are not always official holidays; include as observance (optional)
        $holidays[] = ['date' => "$year-12-24", 'name' => 'Christmas Eve (Observed)'];
        $holidays[] = ['date' => "$year-12-31", 'name' => 'New Year\'s Eve (Observed)'];

        return $holidays;
    }

    /**
     * Determine if a given date (string or Carbon) is a holiday. Returns holiday name or false.
     */
    public static function isHoliday($date)
    {
        $carbon = $date instanceof Carbon ? $date->copy()->startOfDay() : Carbon::parse($date)->startOfDay();
        $year = $carbon->year;

        $list = collect(self::forYear($year))->keyBy('date');

        if ($list->has($carbon->toDateString())) {
            return $list->get($carbon->toDateString())['name'];
        }

        return false;
    }

    /**
     * Return upcoming holidays between two dates (inclusive).
     * Dates can be strings or Carbon instances.
     */
    public static function upcomingBetween($start, $end)
    {
        $start = $start instanceof Carbon ? $start->copy()->startOfDay() : Carbon::parse($start)->startOfDay();
        $end = $end instanceof Carbon ? $end->copy()->endOfDay() : Carbon::parse($end)->endOfDay();

        $years = range($start->year, $end->year);
        $all = collect();
        foreach ($years as $y) {
            $all = $all->merge(self::forYear($y));
        }

        return collect($all)
            ->filter(function ($h) use ($start, $end) {
                $d = Carbon::parse($h['date'])->startOfDay();

                return $d->between($start, $end);
            })
            ->sortBy(function ($h) {
                return Carbon::parse($h['date'])->startOfDay()->timestamp;
            })
            ->values()
            ->all();
    }

    /**
     * Compute Easter Sunday date for given year (Gregorian) using algorithm.
     */
    protected static function easterSunday(int $y): Carbon
    {
        $a = $y % 19;
        $b = intdiv($y, 100);
        $c = $y % 100;
        $d = intdiv($b, 4);
        $e = $b % 4;
        $f = intdiv(($b + 8), 25);
        $g = intdiv(($b - $f + 1), 3);
        $h = (19 * $a + $b - $d - $g + 15) % 30;
        $i = intdiv($c, 4);
        $k = $c % 4;
        $l = (32 + 2 * $e + 2 * $i - $h - $k) % 7;
        $m = intdiv($a + 11 * $h + 22 * $l, 451);
        $month = intdiv($h + $l - 7 * $m + 114, 31);
        $day = (($h + $l - 7 * $m + 114) % 31) + 1;

        return Carbon::create($y, $month, $day)->startOfDay();
    }
}
