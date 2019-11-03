<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

class SeedRank extends Model
{
    use Uuids;

    /** 
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seed_ranks';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array $hidden
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
