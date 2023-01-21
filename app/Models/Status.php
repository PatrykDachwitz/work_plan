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
        'status',
        'accepted',
        'accepted_user_id',
        'user_id',
        'day_id',
        'hour_start',
        'hour_end',
        'date',
    ];

    public function relationEvents() {
        return $this->hasMany(Event::class);
    }

    public function relationDay() {
        return $this->belongsTo(Day::class, 'day_id', 'id');
    }

    public function scopeGetTime(int $idUser, string $searchStatus = 'workDay', string $startTime = null, string $endTime = null) {
        $query = $this->newQuery();
        $query->where('status', $searchStatus);
        $query->where('user_id', $idUser);
        $query->where('accepted', true);
        if (!is_null($startTime)) $query->where('date', ">=",  $startTime);
        if (!is_null($endTime)) $query->where('date', "<=",  $endTime);

        return $query->sum('complety_time');
    }
}
