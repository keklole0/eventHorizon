<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'city', 'street', 'house_number', 'latitude', 'longitude'];
    public function events(){
        return $this->hasMany(Event::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($address) {
            if (empty($address->latitude) || empty($address->longitude)) {
                $addressString = $address->city . ', ' . $address->street . ', ' . $address->house_number;
                $apiKey = '41ace702-81a2-48c5-8e3f-35fbb11e5cde';
                $url = "https://geocode-maps.yandex.ru/1.x/?apikey=$apiKey&format=json&geocode=" . urlencode($addressString);
                $response = @file_get_contents($url);
                if ($response) {
                    $data = json_decode($response, true);
                    if (!empty($data['response']['GeoObjectCollection']['featureMember'])) {
                        $pos = $data['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
                        list($longitude, $latitude) = explode(' ', $pos);
                        $address->latitude = $latitude;
                        $address->longitude = $longitude;
                    }
                }
            }
        });
    }
}
