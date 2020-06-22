<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Typeetats extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'typeetats_id','libelleE'
    ];
       /**
     * Get the biens that owns the comment.
     */
    public function comptes()
    {
        return $this->belongsTo('App\Comptes', 'foreign_key');
    }

       /**
     * Get the biens that owns the comment.
     */
    public function biens()
    {
        return $this->belongsTo('App\Biens', 'foreign_key');
    }
}
