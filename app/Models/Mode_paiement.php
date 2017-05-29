<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mode_paiement extends Model
{
    protected $table = 'mode_paiements';
    protected $primaryKey = 'id_mode_paiement';

    protected $fillable = [
      'id_mode_paiement', 'libelle',
    ];
}
