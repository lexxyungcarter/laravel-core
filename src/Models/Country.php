<?php

namespace AceLords\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = "countries";
    
    protected $fillable = [
        'name', 'slug', 'iso_code', 'country_code'
    ];
    
    public $timestamps = false;
    
    /**
     * Change the route model binding column
     */
    public function getRouteKeyName()
    {
        return "slug";
    }
    
    /**
     * Set the country's slug as you are setting the name
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug($value, "-");
    }

}
