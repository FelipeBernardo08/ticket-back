<?php

namespace App\Models;

use App\Http\Controllers\AtractionController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'name',
        'id_atraction',
        'date',
        'hour',
        'description'
    ];

    public function atraction()
    {
        return $this->belongsTo(Atraction::class, 'id_atraction');
    }
}
