<?php
declare(strict_types=1);
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'statuses';
    protected $fillable = [
        'time_start',
        'time_end',
        'status',
        'accepted',
        'accepted_user_id',
        'user_id',
        'day_id',
    ];

    public function relationEvents() {
        return $this->hasMany(Event::class);
    }
}
