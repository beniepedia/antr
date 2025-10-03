<?php

namespace App\Livewire\Tenant;

use Codedge\Fpdf\Fpdf\Fpdf;
use Livewire\Component;

class PrintLabel extends Component
{
    public function mount(Fpdf $fpdf)
    {
        $fpdf->AddPage('P', 'A5');
        $fpdf->SetFont('Arial', 'B', 16);
        $fpdf->Cell(40, 10, 'Hello World!');
        $fpdf->Output();
        exit;
    }
}
