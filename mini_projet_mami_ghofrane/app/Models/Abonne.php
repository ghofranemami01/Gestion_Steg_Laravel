<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Abonne extends Model
{
    use HasFactory;

    protected $table = 'abonnes';

    protected $fillable = [
        'reference',
        'num_cin',
        'nom',
        'prenom',
        'date_abonnement',
        'num_compteur_elec',
        'num_compteur_gaz',
        'adresse',
        'tel',
        'email'
    ];

    protected $casts = [
        'date_abonnement' => 'date',
    ];

    /**
     * Get the full name attribute
     */
    protected function nom(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                return strtoupper($value);
            },
        );
    }

    protected function prenom(): Attribute
    {
        return Attribute::make(
            set: function ($value) {
                return ucwords(strtolower($value));
            },
        );
    }

    /**
     * Get the full name attribute
     */
    public function getFullNameAttribute()
    {
        return $this->nom . ' ' . $this->prenom;
    }

    /**
     * Scope pour la recherche
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('nom', 'like', "%{$search}%")
              ->orWhere('prenom', 'like', "%{$search}%")
              ->orWhere('reference', 'like', "%{$search}%")
              ->orWhere('num_cin', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }
}
