<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReportModel extends Model
{
    use HasFactory;

    public function reportDisease(): HasMany
    {
        return $this->hasMany(ReportDiseaseModel::class);
    }
}
