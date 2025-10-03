<?php

namespace App\Livewire\Tenant;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PrintLabel extends Component
{
    public function mount()
    {
        $tenant = Auth::guard('tenant')->user()->tenant;

        $fpdf = new Fpdf();
        $fpdf->SetMargins(10,20);
        $fpdf->AddPage();

        $fpdf->SetFont('Arial', 'B', 20);
        $fpdf->Cell(0, 10, 'ANTRIAN ONLINE', 0, 1, 'C');
        $fpdf->Ln(10);


        // Sub Judul
        $fpdf->SetFont('Arial', '', 16);
        $fpdf->MultiCell(0, 7, "SILAHKAN SCAN QR CODE DIBAWHAH INI UNTUK MENGAMBIL ANTRIAN ONLINE.", 0, 'C');
        // $fpdf->Ln(10);


        // Generate QR Code langsung sebagai string biner PNG
        $qrcodeData = QrCode::format('png')->size(500)->margin(2)->generate(make_url($tenant->url));

        // Simpan ke memori sementara pakai data URI
        $tempImage = 'data://text/plain;base64,' . base64_encode($qrcodeData);
        $pageWidth = $fpdf->GetPageWidth();
        $imageWidth = 100; // lebar QR yang kamu set
        $x = ($pageWidth - $imageWidth) / 2; // posisi X biar center
        $y = 70; // posisi Y bebas, misal 50mm dari atas

        $fpdf->Image($tempImage, $x, $y, $imageWidth, $imageWidth, 'PNG');
        $fpdf->SetFont('Arial', 'B', 18);
        $fpdf->SetY(170);
        $fpdf->Cell(0, 6, 'SCAN QR CODE', 0, 1, 'C');

        $fpdf->Ln(25);
        $fpdf->SetFont('Arial', 'B', 20);
        $fpdf->Cell(0, 10, $tenant->code, 0, 1, 'C');
        $fpdf->SetFont('Arial', 'B', 16);
        $fpdf->Cell(0, 10, strtoupper($tenant->name), 0, 1, 'C');
        $fpdf->SetFont('Arial', '', 16);
        $fpdf->Cell(0, 10, $tenant->address ?? '', 0, 1, 'C');

        $fpdf->Output('', 'qr-code.png');
        exit;
    }
}
