<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Modelis;
use App\Models\Lokacija;
use App\Models\Masina;
use App\Models\Lietotajs;
use App\Models\Ire;
use App\Models\Maksajums;
use App\Models\Rezervacija;
use App\Models\Apkope;
use App\Models\Parkapums;
use App\Models\Atsauksmes;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        Modelis::create([
            'marka' => 'Toyota',
            'modelis' => 'Yaris',
            'degvielas_tips' => 'benzins',
            'vietu_skaits' => 5,
            'transmisija' => 'manuala'
        ]);

        Modelis::create([
            'marka' => 'Tesla',
            'modelis' => 'Model 3',
            'degvielas_tips' => 'elektro',
            'vietu_skaits' => 5,
            'transmisija' => 'automata'
        ]);

        Modelis::create([
            'marka' => 'Volkswagen',
            'modelis' => 'Golf',
            'degvielas_tips' => 'benzins',
            'vietu_skaits' => 5,
            'transmisija' => 'manuala'
        ]);

        Modelis::create([
            'marka' => 'Skoda',
            'modelis' => 'Octavia',
            'degvielas_tips' => 'dizelis',
            'vietu_skaits' => 5,
            'transmisija' => 'automata'
        ]);

        Lokacija::create([
            'platuma_gradi' => 57.1522,
            'garuma_gradi' => 24.8533,
            'adrese' => 'Gaujas iela 1',
            'pilseta' => 'Sigulda'
        ]);

        Lokacija::create([
            'platuma_gradi' => 56.9496,
            'garuma_gradi' => 24.1052,
            'adrese' => 'Brīvības iela 1',
            'pilseta' => 'Rīga'
        ]);

        Lokacija::create([
            'platuma_gradi' => 57.3122,
            'garuma_gradi' => 25.2733,
            'adrese' => 'Rīgas iela 12',
            'pilseta' => 'Cēsis'
        ]);

        Masina::create([
            'modelis_id' => 1,
            'registracijas_nr' => 'AA1234',
            'gads' => 2020,
            'degvielas_limenis' => 85,
            'baterijas_limenis' => null,
            'statuss' => 'pieejama',
            'lokacija_id' => 1,
            'tehniskas_apskates_termins' => '2026-06-01'
        ]);

        Masina::create([
            'modelis_id' => 2,
            'registracijas_nr' => 'BB5678',
            'gads' => 2023,
            'degvielas_limenis' => null,
            'baterijas_limenis' => 92,
            'statuss' => 'pieejama',
            'lokacija_id' => 2,
            'tehniskas_apskates_termins' => '2027-01-10'
        ]);

        Masina::create([
            'modelis_id' => 3,
            'registracijas_nr' => 'CC9012',
            'gads' => 2021,
            'degvielas_limenis' => 60,
            'baterijas_limenis' => null,
            'statuss' => 'remontā',
            'lokacija_id' => 3,
            'tehniskas_apskates_termins' => '2026-03-15'
        ]);

        Lietotajs::create([
            'vards' => 'Jānis',
            'uzvards' => 'Bērziņš',
            'pilns_vards' => 'Jānis Bērziņš',
            'epasts' => 'janis@gmail.com',
            'telefons' => '+37120000001',
            'paroles_hash' => bcrypt('password'),
            'vaditaja_apliecibas_nr' => 'LV001',
            'vaditaja_apliecibas_statuss' => 'deriga',
            'vaditaja_apliecibas_termins' => '2028-05-01',
            'statuss' => 'aktīvs',
            'izveidots' => now(),
            'loma' => 'lietotajs'

        ]);

        Lietotajs::create([
            'vards' => 'Anna',
            'uzvards' => 'Kalniņa',
            'pilns_vards' => 'Anna Kalniņa',
            'epasts' => 'anna@gmail.com',
            'telefons' => '+37120000002',
            'paroles_hash' => bcrypt('password'),
            'vaditaja_apliecibas_nr' => 'LV002',
            'vaditaja_apliecibas_statuss' => 'deriga',
            'vaditaja_apliecibas_termins' => '2027-08-15',
            'statuss' => 'aktīvs',
            'izveidots' => now(),
            'loma' => 'moderators'
        ]);

        Lietotajs::create([
            'vards' => 'Pēteris',
            'uzvards' => 'Ozols',
            'pilns_vards' => 'Pēteris Ozols',
            'epasts' => 'peteris@gmail.com',
            'telefons' => '+37120000003',
            'paroles_hash' => bcrypt('password'),
            'vaditaja_apliecibas_nr' => 'LV003',
            'vaditaja_apliecibas_statuss' => 'deriga',
            'vaditaja_apliecibas_termins' => '2026-12-01',
            'statuss' => 'aktīvs',
            'izveidots' => now(),
            'loma' => 'lietotajs'
        ]);

        Ire::create([
            'lietotajs_id' => 1,
            'masina_id' => 1,
            'sakuma_laiks' => '2025-01-05 09:00',
            'beigu_laiks' => '2025-01-05 11:30',
            'lokacija_id' => 1,
            'lokacija_id' => 2,
            'nobrauktais_attalums' => 45.2,
            'statuss' => 'pabeigta',
            'cena' => 18.50
        ]);

        Ire::create([
            'lietotajs_id' => 2,
            'masina_id' => 2,
            'sakuma_laiks' => '2025-02-01 10:00',
            'beigu_laiks' => '2025-02-01 13:00',
            'lokacija_id' => 2,
            'lokacija_id' => 3,
            'nobrauktais_attalums' => 70.0,
            'statuss' => 'pabeigta',
            'cena' => 30.00
        ]);

        Maksajums::create([
            'ire_id' => 1,
            'summa_bez_pvn' => 18.50,
            'summa_ar_pvn' => 18.5 * 1.21,
            'maksajuma_veids' => 'karte',
            'maksajuma_statuss' => 'veikts',
            'maksajuma_datums' => '2025-01-05 11:35'
        ]);

        Maksajums::create([
            'ire_id' => 2,
            'summa_bez_pvn' => 30.00,
            'summa_ar_pvn' => 30 * 1.21,
            'maksajuma_veids' => 'apple_pay',
            'maksajuma_statuss' => 'veikts',
            'maksajuma_datums' => '2025-02-01 13:10'
        ]);

        Rezervacija::create([
            'lietotajs_id' => 1,
            'masina_id' => 2,
            'datums' => '2025-03-01 10:00',
            'deriguma_beigas' => '2025-03-01 12:00',
            'statuss' => 'izmantota'
        ]);

        Rezervacija::create([
            'lietotajs_id' => 2,
            'masina_id' => 1,
            'datums' => '2025-03-05 09:00',
            'deriguma_beigas' => '2025-03-05 11:00',
            'statuss' => 'aktīva'
        ]);

        Apkope::create([
            'masina_id' => 1,
            'apraksts' => 'Eļļas maiņa',
            'datums' => '2025-04-10 09:00',
            'izmaksas' => 75.00,
            'statuss' => 'pabeigta'
        ]);

        Apkope::create([
            'masina_id' => 3,
            'apraksts' => 'Bremžu pārbaude',
            'datums' => '2025-04-15 11:00',
            'izmaksas' => 120.00,
            'statuss' => 'procesā'
        ]);

        Parkapums::create([
            'lietotajs_id' => 1,
            'ire_id' => 1,
            'apraksts' => 'Smēķēšana automašīnā',
            'summa' => 50.00,
            'tips' => 'smēķēšana',
            'statuss' => 'samaksats'
        ]);

        Parkapums::create([
            'lietotajs_id' => 2,
            'ire_id' => 2,
            'apraksts' => 'Ātruma pārsniegšana',
            'summa' => 80.00,
            'tips' => 'satiksmes_pārkāpums',
            'statuss' => 'nesamaksats'
        ]);

        Atsauksmes::create([
            'lietotajs_id' => 1,
            'ire_id' => 1,
            'vertejums' => 5,
            'komentars' => 'Lieliska pieredze!',
            'izveidots' => '2025-01-05 12:00'
        ]);

        Atsauksmes::create([
            'lietotajs_id' => 2,
            'ire_id' => 2,
            'vertejums' => 4,
            'komentars' => 'Labs auto un ērts serviss.',
            'izveidots' => '2025-02-01 14:00'
        ]);
    }
}