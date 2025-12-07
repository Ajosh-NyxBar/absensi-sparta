<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendable_type',
        'attendable_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'latitude_in',
        'longitude_in',
        'latitude_out',
        'longitude_out',
        'qr_code',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    /**
     * Get the parent attendable model (Teacher or Student)
     */
    public function attendable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Check if attendance is on time
     */
    public function isOnTime($checkInTime = '07:30:00')
    {
        if (!$this->check_in) return false;
        return $this->check_in->format('H:i:s') <= $checkInTime;
    }

    /**
     * Check if location is within allowed radius
     */
    public function isWithinRadius($schoolLat, $schoolLong, $radiusInMeters = 100)
    {
        if (!$this->latitude_in || !$this->longitude_in) return false;

        $earthRadius = 6371000; // meters

        $latFrom = deg2rad($schoolLat);
        $lonFrom = deg2rad($schoolLong);
        $latTo = deg2rad($this->latitude_in);
        $lonTo = deg2rad($this->longitude_in);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        $distance = $angle * $earthRadius;

        return $distance <= $radiusInMeters;
    }
}
