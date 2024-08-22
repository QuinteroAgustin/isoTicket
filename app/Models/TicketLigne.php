<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketLigne extends Model
{
    use HasFactory;
    protected $table = 'ticket_lignes';
    protected $primaryKey = 'id_ligne';
    public $timestamps = false;

    public function technicien()
    {
        return $this->hasOne(Technicien::class, 'id_technicien', 'id_technicien');
    }

    public function contact()
    {
        return $this->hasOne(Client::class, 'CT_Num', 'id_client');
    }
    public function contactCbmarq()
    {
        return $this->belongsTo(Contact::class, 'id_contact', 'cbMarq');
    }

    public function contact_ctnom()
    {
        return $this->hasOne(Client::class, 'CT_Nom', 'ct_nom');
    }

    public function contact_ctprenom()
    {
        return $this->hasOne(Client::class, 'CT_Prenom', 'ct_prenom');
    }

    public function contact_ctnum()
    {
        return $this->hasOne(Client::class, 'CT_Num', 'ct_num');
    }

    public function categorie()
    {
        return $this->hasOne(Categorie::class, 'id_categorie', 'id_categorie');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'id_ticket', 'id_ticket');
    }

    /**
     * Accessoire pour retourner la durée formatée en hh:mm.
     *
     * @return string
     */
    public function getFormattedDureeAttribute()
    {
        // Assure que la durée est formatée avec deux chiffres après la virgule
        $dureeFormatted = number_format($this->duree, 2);

        // Sépare les heures et les minutes
        list($hours, $minutes) = explode('.', $dureeFormatted);

        // Formate les heures et les minutes sur deux chiffres
        $formattedHours = str_pad($hours, 2, '0', STR_PAD_LEFT);
        $formattedMinutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);

        // Retourne le résultat sous la forme hh:mm
        return $formattedHours . ':' . $formattedMinutes;
    }
}
