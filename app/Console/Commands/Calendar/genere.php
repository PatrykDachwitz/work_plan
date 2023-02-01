<?php
declare(strict_types=1);
namespace App\Console\Commands\Calendar;

use App\Repository\Eloquent\DayRepository;
use Illuminate\Console\Command;

class genere extends Command
{
    private $holidays;
    private const COUNT_DAY_GENERE = 365;

    private const AVAILABLE_HOLDIAYS_OPTION_API = [
        'Public',
    ];

    private const TRANSLATE_DAY = [
        'Mon' => 'Poniedziałek',
        'Tue' => 'Wtorek',
        'Wed' => 'Środa',
        'Thu' => 'Czwartek',
        'Fri' => 'Piątek',
        'Sat' => 'Sobota',
        'Sun' => 'Niedziela',
    ];

    private const FREE_WORK_DAY = [
        'Sat',
        'Sun',
    ];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calendar:genere';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command generate calendar for 365 days next';

    /**
     * Execute the console command.
     *
     * @return int
     */

    private function verificationHolidays(string $date, int $year) {
        if(isset($this->holidays[$year])) {
            return (bool) in_array($date, $this->holidays[$year]);
        } else {
            $this->holidays[$year] = $this->genereHoldiays($year);
            return (bool) in_array($date, $this->holidays[$year]);
        }
    }

    private function genereHoldiays(int $year) {
        $linkApi = env('API_HOLIDAYS_URL', "https://date.nager.at/api/v3/publicholidays/");
        $countryCode = env('API_HOLIDAYS_COUNTRY_CODE', 'GB');

        $ch = curl_init("{$linkApi}{$year}/{$countryCode}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $result = curl_exec($ch);
        $errors = curl_error($ch);
        $status = (curl_getinfo($ch))['http_code'];
        curl_close($ch);
        if ($status !== 200 | !empty($errors)) Command::FAILURE;

        return $this->convertoToArray(json_decode($result));
    }

    public function convertoToArray(array|Object $result) {
        $holidaysDate = [];
        foreach ($result as $item) {
            foreach ($item->types as $type) {
                if (in_array($type, SELF::AVAILABLE_HOLDIAYS_OPTION_API)) {
                    $holidaysDate[] = $item->date;
                    break;
                } else {
                    continue;
                }
            }
        }

        return $holidaysDate;
    }

    public function getDay(int $nextDay) {
        $nameDay = date("D", strtotime("+{$nextDay} day"));
        $day = date("d", strtotime("+{$nextDay} day"));
        $monthName = date("M", strtotime("+{$nextDay} day"));
        $year = (int) date("Y", strtotime("+{$nextDay} day"));
        $dateUsFormat = date("Y-m-d", strtotime("+{$nextDay} day"));
        $dateName = date("d-m-Y", strtotime("+{$nextDay} day"));

        $freeDay = in_array($nameDay, SELF::FREE_WORK_DAY) ? true : $this->verificationHolidays($dateUsFormat, $year);

        return [
          'date' => $dateUsFormat,
          'day_name' => SELF::TRANSLATE_DAY[$nameDay],
          'free_day' => $freeDay,
          'day' => $day,
          'month' => $monthName
        ];
    }

    public function handle(DayRepository $dayRepository)
    {
        $days = [];

        for ($i = 1; $i <= SELF::COUNT_DAY_GENERE; $i++) {
            $days[] = $this->getDay($i);
        }

        $dayRepository->insert($days);
        return Command::SUCCESS;
    }
}
