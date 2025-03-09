<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentCardController extends Controller
{
    public function previewCard()
    {
        $css = File::get(public_path('css/app.css'));

        $bgPath = public_path('images/bg-card.png');
        $bgData = base64_encode(file_get_contents($bgPath));
        $bgSrc = 'data:image/png;base64,' . $bgData;

        $imagePath = public_path('images/logo-school.png');
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/png;base64,' . $imageData;

        $photoPath = public_path('images/avatar.png');
        $photoData = base64_encode(file_get_contents($photoPath));
        $photoSrc = 'data:image/png;base64,' . $photoData;

        $qrPath = public_path('images/qr.png');
        $qrData = base64_encode(file_get_contents($qrPath));
        $qrSrc = 'data:image/png;base64,' . $qrData;

        $data = [
            'css' => $css,
            'bgSrc' => $bgSrc,
            'imageSrc' => $imageSrc,
            'student' => [
                'photo' => $photoSrc,
                'qr' => $qrSrc,
                'name' => 'Mawaddah Jannah',
                'student_id' => '2918237214',
                'card_id' => '1092982218721122',
                'school' => 'Sekolah ABC',
                'url' => 'www.sekolahabc.sch.id',
            ]
        ];

        $pdf = PDF::loadView('pdf.student-card', $data)
            ->setPaper([0, 0, 1615.75, 2561.18], 'portrait')
            ->setWarnings(false)
            ->setOptions([
                'dpi' => 72,
                'defaultFont' => 'Arial',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        return $pdf->stream('kartu_pelajar.pdf');
    }
}