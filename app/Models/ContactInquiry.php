<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    public const STATUSES = ['new', 'read', 'in_progress', 'resolved'];

    public const MAIL_STATUSES = ['pending', 'sent', 'logged', 'failed'];

    public const DIRECTIONS = [
        'to_aqaba' => 'Jordan to Aqaba Port',
        'from_aqaba' => 'Aqaba Port to Jordan',
        'round_trip' => 'Both directions / Round trip',
        'general' => 'General enquiry',
    ];

    protected $fillable = [
        'name',
        'company',
        'email',
        'phone',
        'direction',
        'message',
        'locale',
        'status',
        'mail_status',
        'mail_error',
        'admin_notes',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'read_at' => 'datetime',
        ];
    }

    public function directionLabel(): string
    {
        return self::DIRECTIONS[$this->direction] ?? $this->direction;
    }
}
