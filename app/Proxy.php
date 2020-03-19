<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Institution;

class Proxy extends Model
{
    //
    protected $fillable = [
        'ip', 'inst_id'
    ];
    public function institute()
    {
        return $this->belongsTo(Institution::class);
    }
}
