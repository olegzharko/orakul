<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrentTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'card_id',
        'date_time',
    ];

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

    public static function set_current_task($card)
    {
        $current_task = new CurrentTask();
        $current_task->staff_id = auth()->user()->id;
        $current_task->card_id = $card->id;
        $current_task->date_time = new \DateTime();
        $current_task->save();
    }
}
