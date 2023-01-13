<?php
declare(strict_types=1);
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class DataBaseTypeWhere implements Rule
{
    private const TYPE_WHERE_DATABASE = [
      '==',
      '>=',
      '<=',
      '!==',
      '>',
      '<',
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
            return (bool) in_array($value, SELF::TYPE_WHERE_DATABASE);
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
