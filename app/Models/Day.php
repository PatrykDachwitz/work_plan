<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;

    //protected $dateFormat = 'd-m-Y';

    protected $fillable = [
        'date',
        'day_name',
        'free_day',
        'day',
        'month',
    ];

    public function relationStatus()
    {
        return $this->hasMany(Status::class, 'date', 'date');
    }
}
