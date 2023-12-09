<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DiseaseModel;
use App\Models\ReportModel;
use Illuminate\Http\Request;
class InformationModelController extends Controller
{
    public function index()
    {

        $reports = ReportModel::select('id', 'date', 'result_image', 'disease_id')
            ->get();

        $formattedData = $reports->map(function ($report) {
            return [
                'report' => [
                    'id' => $report->id,
                    'date' => $report->date,
                    'image' => $report->image,
                    'disease' => DiseaseModel::select('id', 'name', 'description', 'solution')
                        ->find($report->disease_id)
                ],
            ];
        });

        // Return the formatted data as JSON
        return response()->json(['reports' => $formattedData]);
    }
}
