<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Technicien;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;

class StatistiqueController extends Controller
{
    public function index()
    {
        return view('statistiques.index');
    }

    public function exportTechnicienStats(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut'
        ]);

        // Récupérer les techniciens actifs
        $techniciens = Technicien::where(function($query) {
            $query->whereNull('masquer')
                  ->orWhere('masquer', 0);
        })->orderBy('nom')
        ->orderBy('prenom')
        ->get();

        // Créer un nouveau spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // En-têtes
        $sheet->setCellValue('A1', 'Nom');
        $sheet->setCellValue('B1', 'Prénom');
        $sheet->setCellValue('C1', 'Nombre de tickets clôturés');

        $row = 2;
        foreach ($techniciens as $technicien) {
            $ticketsCount = Ticket::where('id_technicien', $technicien->id_technicien)
                ->where('cloture', 1)
                ->whereBetween('closed_at', [
                    $request->date_debut . ' 00:00:00',
                    $request->date_fin . ' 23:59:59'
                ])
                ->count();

            $sheet->setCellValue('A' . $row, $technicien->nom);
            $sheet->setCellValue('B' . $row, $technicien->prenom);
            $sheet->setCellValue('C' . $row, $ticketsCount);
            
            $row++;
        }

        // Style du tableau
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        
        $sheet->getStyle('A1:C' . ($row-1))->applyFromArray($styleArray);
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);

        // Ajuster la largeur des colonnes
        foreach(range('A','C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Créer le fichier Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'statistiques_techniciens_' . date('Y-m-d') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}
