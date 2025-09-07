<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileView extends Model
{
    protected $fillable = [
        'file_type',
        'file_path',
        'filename'
    ];

    // Pas de timestamps car c'est un modèle virtuel pour les statistiques
    public $timestamps = false;
    
    // Pas de table physique
    protected $table = 'virtual_file_views';

    /**
     * Créer un modèle virtuel pour un fichier
     */
    public static function createVirtual(string $type, string $filename): self
    {
        $model = new self();
        $model->id = md5($type . '/' . $filename);
        $model->file_type = $type;
        $model->filename = $filename;
        $model->file_path = $type . '/' . $filename;
        
        return $model;
    }
}