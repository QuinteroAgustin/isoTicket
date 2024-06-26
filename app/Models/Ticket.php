<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $primaryKey = 'id_ticket';
    public $timestamps = false;

    public function forfait()
    {
        return $this->belongsTo(Forfait::class, 'id_forfait', 'id_forfait');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'CT_Num', 'id_client');
    }

    public function technicien()
    {
        return $this->hasOne(Technicien::class, 'id_technicien', 'id_technicien');
    }

    public function categorie()
    {
        return $this->hasOne(Categorie::class, 'id_categorie', 'id_categorie');
    }

    public function fonction()
    {
        return $this->hasOne(Fonction::class, 'id_fonction', 'id_fonction');
    }

    public function statut()
    {
        return $this->hasOne(Status::class, 'id_statut', 'id_statut');
    }

    public function impact()
    {
        return $this->hasOne(Impact::class, 'id_impact', 'id_impact');
    }

    public function priorite()
    {
        return $this->hasOne(priorite::class, 'id_priorite', 'id_priorite');
    }

    public function service()
    {
        return $this->hasOne(service::class, 'id_service', 'id_service');
    }

    public function lignes()
    {
        return $this->hasMany(TicketLigne::class, 'id_ticket', 'id_ticket')->orderBy('created_at', 'desc');;
    }

}
