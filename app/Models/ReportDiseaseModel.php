<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReportDiseaseModel extends Model
{
    use HasFactory;
    public function report(): BelongsTo
    {
        return $this->belongsTo(ReportDiseaseModel::class);
    }

    public function diseases() : HasMany {
        return $this->HasMany (DiseaseModel::class);
    }
}
