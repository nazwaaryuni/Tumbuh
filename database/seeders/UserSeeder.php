<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Division;
use App\Models\Position;
use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Division
        $divHumas = Division::firstOrCreate(['name' => 'Humas'], ['description' => 'Hubungan Masyarakat']);
        $divPSDM = Division::firstOrCreate(['name' => 'PSDM'], ['description' => 'Pengembangan SDM']);

        // 2. Buat Position
        $posKetua = Position::firstOrCreate(['name' => 'Ketua'], ['level' => 'Inti']);
        $posSekretaris = Position::firstOrCreate(['name' => 'Sekretaris'], ['level' => 'Inti']);
        $posBendahara = Position::firstOrCreate(['name' => 'Bendahara'], ['level' => 'Inti']);
        $posKoord = Position::firstOrCreate(['name' => 'Koordinator Divisi'], ['level' => 'Kadiv']);
        $posPengurus = Position::firstOrCreate(['name' => 'Pengurus'], ['level' => 'Staf']);
        $posAnggota = Position::firstOrCreate(['name' => 'Anggota'], ['level' => 'Member']);

        // 3. Definisikan array usersData
        $usersData = [
            // Admin (Inti & Koordinator)
            ['name' => 'Ketua Umum', 'email' => 'ketua@gmail.com', 'role' => 'Admin', 'pos' => $posKetua->id, 'div' => null],
            ['name' => 'Sekretaris Umum', 'email' => 'sekretaris@gmail.com', 'role' => 'Admin', 'pos' => $posSekretaris->id, 'div' => null],
            ['name' => 'Bendahara Umum', 'email' => 'bendahara@gmail.com', 'role' => 'Admin', 'pos' => $posBendahara->id, 'div' => null],
            ['name' => 'Koord Humas', 'email' => 'koord.humas@gmail.com', 'role' => 'Admin', 'pos' => $posKoord->id, 'div' => $divHumas->id],
            ['name' => 'Koord PSDM', 'email' => 'koord.psdm@gmail.com', 'role' => 'Admin', 'pos' => $posKoord->id, 'div' => $divPSDM->id],

            // Pengurus
            ['name' => 'Pengurus Humas 1', 'email' => 'pengurus1@gmail.com', 'role' => 'Pengurus', 'pos' => $posPengurus->id, 'div' => $divHumas->id],
            ['name' => 'Pengurus Humas 2', 'email' => 'pengurus2@gmail.com', 'role' => 'Pengurus', 'pos' => $posPengurus->id, 'div' => $divHumas->id],
            ['name' => 'Pengurus PSDM 1', 'email' => 'pengurus3@gmail.com', 'role' => 'Pengurus', 'pos' => $posPengurus->id, 'div' => $divPSDM->id],

            // Anggota
            ['name' => 'Anggota 1', 'email' => 'anggota1@gmail.com', 'role' => 'Anggota', 'pos' => $posAnggota->id, 'div' => null],
            ['name' => 'Anggota 2', 'email' => 'anggota2@gmail.com', 'role' => 'Anggota', 'pos' => $posAnggota->id, 'div' => null],
            ['name' => 'Anggota 3', 'email' => 'anggota3@gmail.com', 'role' => 'Anggota', 'pos' => $posAnggota->id, 'div' => null],
            ['name' => 'Anggota 4', 'email' => 'anggota4@gmail.com', 'role' => 'Anggota', 'pos' => $posAnggota->id, 'div' => null],
            ['name' => 'Anggota 5', 'email' => 'anggota5@gmail.com', 'role' => 'Anggota', 'pos' => $posAnggota->id, 'div' => null],
        ];

        // 4. Loop usersData
        foreach ($usersData as $data) {
            // 5. firstOrCreate User
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => bcrypt('password'),
                    'role' => $data['role'],
                ]
            );

            // 6. firstOrCreate Member
            Member::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'division_id' => $data['div'],
                    'position_id' => $data['pos'],
                    'full_name' => $data['name'],
                    'join_date' => now(),
                    'status' => 'Aktif',
                ]
            );
        }
    }
}
