<?php

namespace App\Exports;

use App\Models\ContactMessage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ContactMessagesExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return ContactMessage::latest()->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nom',
            'Email',
            'Message',
            'Adresse IP',
            'Navigateur',
            'Statut',
            'Date de création',
            'Date de lecture'
        ];
    }

    /**
     * @param mixed $message
     *
     * @return array
     */
    public function map($message): array
    {
        return [
            $message->id,
            $message->name,
            $message->email,
            $message->message,
            $message->ip_address,
            $message->user_agent ?? 'Inconnu',
            $message->is_read ? 'Lu' : 'Non lu',
            $message->created_at->format('d/m/Y H:i'),
            $message->read_at ? $message->read_at->format('d/m/Y H:i') : 'Non lu'
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                
                // Style pour l'en-tête
                $sheet->getStyle('A1:I1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '3490dc'],
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);
                
                // Centrer le texte pour les colonnes spécifiques
                $sheet->getStyle('A1:I' . $sheet->getHighestRow())
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setVertical(Alignment::VERTICAL_CENTER);
                
                // Ajuster la hauteur des lignes
                $sheet->getDefaultRowDimension()->setRowHeight(20);
                
                // Ajuster la hauteur de l'en-tête
                $sheet->getRowDimension(1)->setRowHeight(25);
                
                // Ajouter des filtres
                $sheet->setAutoFilter('A1:I1');
                
                // Gérer le retour à la ligne automatique pour la colonne du message
                $sheet->getStyle('D2:D' . $sheet->getHighestRow())
                    ->getAlignment()
                    ->setWrapText(true);
            },
        ];
    }
}
