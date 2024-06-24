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
}
