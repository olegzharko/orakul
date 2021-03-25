<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactType extends Model
{
    use HasFactory;

    public static function get_contact_type()
    {
        return ContactType::select('id', 'title')->get();
    }
}
