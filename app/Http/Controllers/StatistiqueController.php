<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Ticket;
use App\Models\Service;
use App\Models\Technicien;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

        // Récupérer les techniciens actifs avec leur nombre de tickets
        $techniciens = Technicien::where(function($query) {
            $query->whereNull('masquer')
                ->orWhere('masquer', 0);
        })
        ->get()
        ->map(function($technicien) use ($request) {
            $ticketsCount = Ticket::where('id_technicien', $technicien->id_technicien)
                ->where('cloture', 1)
                ->whereBetween('closed_at', [
                    $request->date_debut . ' 00:00:00',
                    $request->date_fin . ' 23:59:59'
                ])
                ->count();

            return [
                'technicien' => $technicien,
                'tickets_count' => $ticketsCount
            ];
        })
        ->sortByDesc('tickets_count')
        ->values();

        // Créer un nouveau spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // En-têtes
        $sheet->setCellValue('A1', 'Position');
        $sheet->setCellValue('B1', 'Nom');
        $sheet->setCellValue('C1', 'Prénom');
        $sheet->setCellValue('D1', 'Nombre de tickets clôturés');

        $row = 2;
        foreach ($techniciens as $index => $data) {
            $sheet->setCellValue('A' . $row, $index + 1);
            $sheet->setCellValue('B' . $row, $data['technicien']->nom);
            $sheet->setCellValue('C' . $row, $data['technicien']->prenom);
            $sheet->setCellValue('D' . $row, $data['tickets_count']);
            
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
        
        $sheet->getStyle('A1:D' . ($row-1))->applyFromArray($styleArray);
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        // Ajuster la largeur des colonnes
        foreach(range('A','D') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Créer le fichier Excel
        $writer = new Xlsx($spreadsheet);
        $fileName = 'statistiques_techniciens_' . date('Y-m-d') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }

    public function exportClientsStats(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'type_rapport' => 'required|in:temps_resolution,clients_frequents,tickets_par_service'
        ]);

        switch($request->type_rapport) {
            case 'temps_resolution':
                return $this->exportTempsResolutionParClient($request);
            case 'clients_frequents':
                return $this->exportClientsFrequents($request);
            case 'tickets_par_service':
                return $this->exportTicketsParService($request);
        }
    }

    private function exportTempsResolutionParClient(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID Client');
        $sheet->setCellValue('B1', 'Nom Client');
        $sheet->setCellValue('C1', 'Temps moyen de résolution (heures)');
        $sheet->setCellValue('D1', 'Nombre total de tickets');

        $clients = Ticket::whereBetween('created_at', [
            $request->date_debut . ' 00:00:00',
            $request->date_fin . ' 23:59:59'
        ])
        ->select('id_client')
        ->distinct()
        ->get();

        $row = 2;
        foreach($clients as $clientTicket) {
            $client = DB::connection('sqlsrv2')
                ->table('F_COMPTET')
                ->where('CT_Num', $clientTicket->id_client)
                ->first();

            if ($client) {
                $tempsResolution = Ticket::where('id_client', $client->CT_Num)
                    ->where('cloture', 1)
                    ->whereBetween('created_at', [
                        $request->date_debut . ' 00:00:00',
                        $request->date_fin . ' 23:59:59'
                    ])
                    ->selectRaw('AVG(DATEDIFF(HOUR, created_at, closed_at)) as avg_time')
                    ->first();

                $totalTickets = Ticket::where('id_client', $client->CT_Num)
                    ->whereBetween('created_at', [
                        $request->date_debut . ' 00:00:00',
                        $request->date_fin . ' 23:59:59'
                    ])
                    ->count();

                $sheet->setCellValue('A' . $row, $client->CT_Num);
                $sheet->setCellValue('B' . $row, $client->CT_Intitule);
                $sheet->setCellValue('C' . $row, round($tempsResolution->avg_time ?? 0, 2));
                $sheet->setCellValue('D' . $row, $totalTickets);

                $row++;
            }
        }

        $this->styleExcelSheet($sheet, 'A1:D' . ($row-1));
        return $this->downloadExcel($sheet, 'temps_resolution_clients_');
    }

    private function exportClientsFrequents(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'ID Client');
        $sheet->setCellValue('B1', 'Nom Client');
        $sheet->setCellValue('C1', 'Nombre de tickets');
        $sheet->setCellValue('D1', 'Tickets clôturés');
        $sheet->setCellValue('E1', 'Tickets en cours');

        $clients = Ticket::whereBetween('created_at', [
            $request->date_debut . ' 00:00:00',
            $request->date_fin . ' 23:59:59'
        ])
        ->select('id_client')
        ->selectRaw('COUNT(*) as total_tickets')
        ->selectRaw('SUM(CASE WHEN cloture = 1 THEN 1 ELSE 0 END) as tickets_clotures')
        ->selectRaw('SUM(CASE WHEN cloture = 0 THEN 1 ELSE 0 END) as tickets_en_cours')
        ->groupBy('id_client')
        ->orderBy('total_tickets', 'desc')
        ->get();

        $row = 2;
        foreach($clients as $clientStats) {
            $client = DB::connection('sqlsrv2')
                ->table('F_COMPTET')
                ->where('CT_Num', $clientStats->id_client)
                ->first();

            if ($client) {
                $sheet->setCellValue('A' . $row, $client->CT_Num);
                $sheet->setCellValue('B' . $row, $client->CT_Intitule);
                $sheet->setCellValue('C' . $row, $clientStats->total_tickets);
                $sheet->setCellValue('D' . $row, $clientStats->tickets_clotures);
                $sheet->setCellValue('E' . $row, $clientStats->tickets_en_cours);
                
                $row++;
            }
        }

        $this->styleExcelSheet($sheet, 'A1:E' . ($row-1));
        return $this->downloadExcel($sheet, 'clients_frequents_');
    }

    private function exportTicketsParService(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Service');
        $sheet->setCellValue('B1', 'Nombre total de tickets');
        $sheet->setCellValue('C1', 'Nombre moyen de tickets par client');
        $sheet->setCellValue('D1', 'Temps moyen de résolution (heures)');

        // Modification ici pour filtrer les services non masqués
        $services = Service::where(function($query) {
            $query->whereNull('masquer')
                ->orWhere('masquer', 0);
        })->get();

        $row = 2;
        foreach($services as $service) {
            $stats = Ticket::where('id_service', $service->id_service)
                ->whereBetween('created_at', [
                    $request->date_debut . ' 00:00:00',
                    $request->date_fin . ' 23:59:59'
                ])
                ->selectRaw('COUNT(DISTINCT id_client) as nb_clients')
                ->selectRaw('COUNT(*) as total_tickets')
                ->selectRaw('AVG(DATEDIFF(HOUR, created_at, closed_at)) as avg_resolution_time')
                ->first();

            $moyenneParClient = $stats->nb_clients > 0 ? ($stats->total_tickets / $stats->nb_clients) : 0;

            $sheet->setCellValue('A' . $row, $service->libelle);
            $sheet->setCellValue('B' . $row, $stats->total_tickets);
            $sheet->setCellValue('C' . $row, round($moyenneParClient, 2));
            $sheet->setCellValue('D' . $row, round($stats->avg_resolution_time ?? 0, 2));

            $row++;
        }

        $this->styleExcelSheet($sheet, 'A1:D' . ($row-1));
        return $this->downloadExcel($sheet, 'tickets_par_service_');
    }

    private function styleExcelSheet($sheet, $range)
    {
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FFFFFF',
                ],
            ],
        ];
        
        // Appliquer les bordures à toutes les cellules
        $sheet->getStyle($range)->applyFromArray($styleArray);
        
        // Mettre en gras les en-têtes
        $sheet->getStyle(explode(':', $range)[0])->getFont()->setBold(true);
        
        // Style pour les en-têtes
        $headerStyle = [
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'E3E3E3',
                ],
            ],
        ];
        $sheet->getStyle(explode(':', $range)[0])->applyFromArray($headerStyle);

        // Ajuster la largeur des colonnes automatiquement
        foreach(range('A', $sheet->getHighestColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
    }

    private function downloadExcel($sheet, $prefix)
    {
        $writer = new Xlsx($sheet->getParent());
        $fileName = $prefix . date('Y-m-d') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit();
    }
}
