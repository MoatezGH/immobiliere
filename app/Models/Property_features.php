<?php

namespace App\Models;

use App\Models\Property;
use App\Models\PromoteurProperty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property_features extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id',
        'type__',
        
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'id');

        
 
    }

    public function propertypromoteur()
    {
        // return $this->belongsTo(Property::class, 'property_id', 'id');
        return $this->belongsTo(PromoteurProperty::class, 'property_id', 'id');

        
 
    }


    public function classified()
    {
        // return $this->belongsTo(Property::class, 'property_id', 'id');
        return $this->belongsTo(Classified::class, 'property_id', 'id');

        
 
    }


    public function service()
    {
        // return $this->belongsTo(Property::class, 'property_id', 'id');
        return $this->belongsTo(Service::class, 'property_id', 'id');

        
 
    }
}
