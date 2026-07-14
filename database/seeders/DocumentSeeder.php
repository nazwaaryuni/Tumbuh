<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        Document::create([
            'title' => 'Surat Keputusan Kepengurusan 2026',
            'type' => 'Surat Keluar',
            'file_url' => 'documents/sk_kepengurusan_2026.pdf',
        ]);

        Document::create([
            'title' => 'Proposal Kegiatan Tahunan',
            'type' => 'Proposal',
            'file_url' => 'documents/proposal_kegiatan.pdf',
        ]);
        
        Document::create([
            'title' => 'Undangan Rapat Organisasi Eksternal',
            'type' => 'Surat Masuk',
            'file_url' => 'documents/undangan_rapat.pdf',
        ]);
    }
}
