<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Terminal extends Model
{
    protected $fillable = ['business_name', 'rfc', 'name', 'status', 'postcode', 'kind_road', 'name_road', 'n_outsice', 'n_inside', 'settlement', 'location', 'town', 'state'];

    public function fits()
    {
        return $this->hasMany(Fee::class);
    }

    public function fit()
    {
        return $this->belongsTo('App\Fit', 'id', 'terminal_id');
    }

    public function competitions()
    {
        return $this->hasMany('App\Competition');
    }

    public function policons()
    {
        return $this->hasMany('App\Policon');
    }

    public function impulsas()
    {
        return $this->hasMany('App\Impulsa');
    }

    public function valeros()
    {
        return $this->hasMany('App\Valero');
    }

    public function hamses()
    {
        return $this->hasMany('App\Hamse');
    }

    public function potestas()
    {
        return $this->hasMany('App\Potesta');
    }

    public function energos()
    {
        return $this->hasMany('App\Energo');
    }
}
