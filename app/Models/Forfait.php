<?php

namespace App\Models;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Forfait extends Model
{
    use HasFactory;
    protected $table = 'forfaits';
    protected $primaryKey = 'id_forfait';
    protected $fillable = ['created_at', 'valid_to', 'credit', 'id_type', 'masquer'];
    public $timestamps = false;

    public function type()
    {
        return $this->hasOne(TypeForfait::class, 'id_type', 'id_type');
    }

    // Define the relationship with the Ticket model
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'id_forfait');
    }

    // Méthode pour calculer le crédit restant
    public function restant()
    {
        // Calculer le total des crédits utilisés en additionnant la durée des tickets
        $totalCreditsUsed = $this->tickets->where('cri', 1)->where('cloture', 1)->sum(function ($ticket) {
            return $this->convertDureeToMinutes($ticket->duree);
        });

        // Retourner le crédit restant
        return $this->credit - $totalCreditsUsed;
    }

    // Convertir HH,MM en minutes totales
    private function convertDureeToMinutes($duree)
    {
        list($hours, $minutes) = explode('.', $duree);
        $totalMinutes = ((int) $hours * 60) + (int) $minutes; // Convertir en entiers avant de faire l'addition
        return $totalMinutes;
    }
}
