<?php
declare(strict_types=1);
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AvailableStatusDay implements Rule
{
    private const AVAILABLE_STATUS_DAY = [
        'holidayLeave',
        'workDay',
        'leaveOnRequest',
        'occasionalHolidays',
        'delegation',
    ];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!is_null($value)) {
            return (bool) in_array($value, SELF::AVAILABLE_STATUS_DAY);
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
