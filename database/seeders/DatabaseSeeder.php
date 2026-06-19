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
        /*
        |--------------------------------------------------------------------------
        | Modeļi
        |--------------------------------------------------------------------------
        */

        $modeli = [];

        $modeli['toyota_yaris'] = Modelis::updateOrCreate(
            [
                'marka' => 'Toyota',
                'modelis' => 'Yaris',
            ],
            [
                'degvielas_tips' => 'benzins',
                'vietu_skaits' => 5,
                'transmisija' => 'manuala',
            ]
        );

        $modeli['tesla_model_3'] = Modelis::updateOrCreate(
            [
                'marka' => 'Tesla',
                'modelis' => 'Model 3',
            ],
            [
                'degvielas_tips' => 'elektro',
                'vietu_skaits' => 5,
                'transmisija' => 'automata',
            ]
        );

        $modeli['vw_golf'] = Modelis::updateOrCreate(
            [
                'marka' => 'Volkswagen',
                'modelis' => 'Golf',
            ],
            [
                'degvielas_tips' => 'benzins',
                'vietu_skaits' => 5,
                'transmisija' => 'manuala',
            ]
        );

        $modeli['skoda_octavia'] = Modelis::updateOrCreate(
            [
                'marka' => 'Skoda',
                'modelis' => 'Octavia',
            ],
            [
                'degvielas_tips' => 'dizelis',
                'vietu_skaits' => 5,
                'transmisija' => 'automata',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Lokācijas
        |--------------------------------------------------------------------------
        */

        $lokacijas = [];

        $lokacijas['liepaja'] = Lokacija::updateOrCreate(
            [
                'adrese' => 'Lielā iela 5',
                'pilseta' => 'Liepāja',
            ],
            [
                'platuma_gradi' => 56.5047,
                'garuma_gradi' => 21.0108,
            ]
        );

        $lokacijas['daugavpils'] = Lokacija::updateOrCreate(
            [
                'adrese' => 'Rīgas iela 20',
                'pilseta' => 'Daugavpils',
            ],
            [
                'platuma_gradi' => 55.8713,
                'garuma_gradi' => 26.5322,
            ]
        );

        $lokacijas['valmiera'] = Lokacija::updateOrCreate(
            [
                'adrese' => 'Smilšu iela 3',
                'pilseta' => 'Valmiera',
            ],
            [
                'platuma_gradi' => 57.5370,
                'garuma_gradi' => 25.4250,
            ]
        );

        $lokacijas['jelgava'] = Lokacija::updateOrCreate(
            [
                'adrese' => 'Jelgavas iela 8',
                'pilseta' => 'Jelgava',
            ],
            [
                'platuma_gradi' => 56.6688,
                'garuma_gradi' => 23.7711,
            ]
        );

        $lokacijas['jurmala'] = Lokacija::updateOrCreate(
            [
                'adrese' => 'Jūras iela 15',
                'pilseta' => 'Jūrmala',
            ],
            [
                'platuma_gradi' => 56.9711,
                'garuma_gradi' => 23.7219,
            ]
        );

        $lokacijas['ogre'] = Lokacija::updateOrCreate(
            [
                'adrese' => 'Pils iela 4',
                'pilseta' => 'Ogre',
            ],
            [
                'platuma_gradi' => 56.8500,
                'garuma_gradi' => 24.5833,
            ]
        );

        $lokacijas['ventspils'] = Lokacija::updateOrCreate(
            [
                'adrese' => 'Vēstures iela 7',
                'pilseta' => 'Ventspils',
            ],
            [
                'platuma_gradi' => 57.7522,
                'garuma_gradi' => 26.0411,
            ]
        );

        $lokacijas['rezekne'] = Lokacija::updateOrCreate(
            [
                'adrese' => 'Ezera iela 2',
                'pilseta' => 'Rēzekne',
            ],
            [
                'platuma_gradi' => 56.4063,
                'garuma_gradi' => 27.0169,
            ]
        );

        $lokacijas['limbazi'] = Lokacija::updateOrCreate(
            [
                'adrese' => 'Stacijas iela 11',
                'pilseta' => 'Limbaži',
            ],
            [
                'platuma_gradi' => 57.1233,
                'garuma_gradi' => 24.3522,
            ]
        );

        $lokacijas['sigulda'] = Lokacija::updateOrCreate(
            [
                'adrese' => 'Gaujas iela 1',
                'pilseta' => 'Sigulda',
            ],
            [
                'platuma_gradi' => 57.1522,
                'garuma_gradi' => 24.8533,
            ]
        );

        $lokacijas['riga'] = Lokacija::updateOrCreate(
            [
                'adrese' => 'Brīvības iela 1',
                'pilseta' => 'Rīga',
            ],
            [
                'platuma_gradi' => 56.9496,
                'garuma_gradi' => 24.1052,
            ]
        );

        $lokacijas['cesis'] = Lokacija::updateOrCreate(
            [
                'adrese' => 'Rīgas iela 12',
                'pilseta' => 'Cēsis',
            ],
            [
                'platuma_gradi' => 57.3122,
                'garuma_gradi' => 25.2733,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Mašīnas
        |--------------------------------------------------------------------------
        */

        $masinas = [];

        $masinas['AB1234'] = Masina::updateOrCreate(
            ['registracijas_nr' => 'AB1234'],
            [
                'modelis_id' => $modeli['tesla_model_3']->id,
                'gads' => 2022,
                'degvielas_limenis' => null,
                'baterijas_limenis' => 85,
                'statuss' => 'pieejama',
                'lokacija_id' => $lokacijas['jelgava']->id,
                'tehniskas_apskates_termins' => '2026-08-15',
            ]
        );

        $masinas['CD5678'] = Masina::updateOrCreate(
            ['registracijas_nr' => 'CD5678'],
            [
                'modelis_id' => $modeli['toyota_yaris']->id,
                'gads' => 2021,
                'degvielas_limenis' => 70,
                'baterijas_limenis' => null,
                'statuss' => 'pieejama',
                'lokacija_id' => $lokacijas['jurmala']->id,
                'tehniskas_apskates_termins' => '2026-11-20',
            ]
        );

        $masinas['EF9012'] = Masina::updateOrCreate(
            ['registracijas_nr' => 'EF9012'],
            [
                'modelis_id' => $modeli['vw_golf']->id,
                'gads' => 2023,
                'degvielas_limenis' => null,
                'baterijas_limenis' => 60,
                'statuss' => 'pieejama',
                'lokacija_id' => $lokacijas['ogre']->id,
                'tehniskas_apskates_termins' => '2027-03-05',
            ]
        );

        $masinas['GH3456'] = Masina::updateOrCreate(
            ['registracijas_nr' => 'GH3456'],
            [
                'modelis_id' => $modeli['skoda_octavia']->id,
                'gads' => 2020,
                'degvielas_limenis' => 45,
                'baterijas_limenis' => null,
                'statuss' => 'pieejama',
                'lokacija_id' => $lokacijas['ventspils']->id,
                'tehniskas_apskates_termins' => '2026-06-30',
            ]
        );

        $masinas['IJ7890'] = Masina::updateOrCreate(
            ['registracijas_nr' => 'IJ7890'],
            [
                'modelis_id' => $modeli['tesla_model_3']->id,
                'gads' => 2022,
                'degvielas_limenis' => null,
                'baterijas_limenis' => 95,
                'statuss' => 'pieejama',
                'lokacija_id' => $lokacijas['rezekne']->id,
                'tehniskas_apskates_termins' => '2027-01-18',
            ]
        );

        $masinas['KL2345'] = Masina::updateOrCreate(
            ['registracijas_nr' => 'KL2345'],
            [
                'modelis_id' => $modeli['toyota_yaris']->id,
                'gads' => 2021,
                'degvielas_limenis' => 30,
                'baterijas_limenis' => null,
                'statuss' => 'pieejama',
                'lokacija_id' => $lokacijas['limbazi']->id,
                'tehniskas_apskates_termins' => '2026-09-12',
            ]
        );

        $masinas['MN6789'] = Masina::updateOrCreate(
            ['registracijas_nr' => 'MN6789'],
            [
                'modelis_id' => $modeli['vw_golf']->id,
                'gads' => 2023,
                'degvielas_limenis' => null,
                'baterijas_limenis' => 78,
                'statuss' => 'pieejama',
                'lokacija_id' => $lokacijas['sigulda']->id,
                'tehniskas_apskates_termins' => '2027-05-22',
            ]
        );

        $masinas['OP1234'] = Masina::updateOrCreate(
            ['registracijas_nr' => 'OP1234'],
            [
                'modelis_id' => $modeli['skoda_octavia']->id,
                'gads' => 2020,
                'degvielas_limenis' => 55,
                'baterijas_limenis' => null,
                'statuss' => 'pieejama',
                'lokacija_id' => $lokacijas['riga']->id,
                'tehniskas_apskates_termins' => '2026-12-01',
            ]
        );

        $masinas['QR5678'] = Masina::updateOrCreate(
            ['registracijas_nr' => 'QR5678'],
            [
                'modelis_id' => $modeli['toyota_yaris']->id,
                'gads' => 2022,
                'degvielas_limenis' => null,
                'baterijas_limenis' => 42,
                'statuss' => 'pieejama',
                'lokacija_id' => $lokacijas['cesis']->id,
                'tehniskas_apskates_termins' => '2027-02-14',
            ]
        );

        $masinas['AA1234'] = Masina::updateOrCreate(
            ['registracijas_nr' => 'AA1234'],
            [
                'modelis_id' => $modeli['toyota_yaris']->id,
                'gads' => 2020,
                'degvielas_limenis' => 85,
                'baterijas_limenis' => null,
                'statuss' => 'pieejama',
                'lokacija_id' => $lokacijas['liepaja']->id,
                'tehniskas_apskates_termins' => '2026-06-01',
            ]
        );

        $masinas['BB5678'] = Masina::updateOrCreate(
            ['registracijas_nr' => 'BB5678'],
            [
                'modelis_id' => $modeli['tesla_model_3']->id,
                'gads' => 2023,
                'degvielas_limenis' => null,
                'baterijas_limenis' => 92,
                'statuss' => 'pieejama',
                'lokacija_id' => $lokacijas['daugavpils']->id,
                'tehniskas_apskates_termins' => '2027-01-10',
            ]
        );

        $masinas['CC9012'] = Masina::updateOrCreate(
            ['registracijas_nr' => 'CC9012'],
            [
                'modelis_id' => $modeli['vw_golf']->id,
                'gads' => 2021,
                'degvielas_limenis' => 60,
                'baterijas_limenis' => null,
                'statuss' => 'remontā',
                'lokacija_id' => $lokacijas['valmiera']->id,
                'tehniskas_apskates_termins' => '2026-03-15',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Lietotāji
        |--------------------------------------------------------------------------
        */

        $lietotaji = [];

        $lietotaji['admin'] = Lietotajs::updateOrCreate(
            ['epasts' => 'admin@admin.com'],
            [
                'vards' => 'admin',
                'uzvards' => 'admin',
                'pilns_vards' => 'admin admin',
                'telefons' => '+37120000000',
                'paroles_hash' => bcrypt('password'),
                'vaditaja_apliecibas_nr' => 'LV001',
                'vaditaja_apliecibas_statuss' => 'deriga',
                'vaditaja_apliecibas_termins' => '2028-05-01',
                'statuss' => 'aktīvs',
                'izveidots' => now(),
                'loma' => 'admins',
            ]
        );

        $lietotaji['anna'] = Lietotajs::updateOrCreate(
            ['epasts' => 'anna@gmail.com'],
            [
                'vards' => 'Anna',
                'uzvards' => 'Kalniņa',
                'pilns_vards' => 'Anna Kalniņa',
                'telefons' => '+37120000002',
                'paroles_hash' => bcrypt('password'),
                'vaditaja_apliecibas_nr' => 'LV002',
                'vaditaja_apliecibas_statuss' => 'deriga',
                'vaditaja_apliecibas_termins' => '2027-08-15',
                'statuss' => 'aktīvs',
                'izveidots' => now(),
                'loma' => 'moderators',
            ]
        );

        $lietotaji['peteris'] = Lietotajs::updateOrCreate(
            ['epasts' => 'peteris@gmail.com'],
            [
                'vards' => 'Pēteris',
                'uzvards' => 'Ozols',
                'pilns_vards' => 'Pēteris Ozols',
                'telefons' => '+37120000003',
                'paroles_hash' => bcrypt('password'),
                'vaditaja_apliecibas_nr' => 'LV003',
                'vaditaja_apliecibas_statuss' => 'deriga',
                'vaditaja_apliecibas_termins' => '2026-12-01',
                'statuss' => 'aktīvs',
                'izveidots' => now(),
                'loma' => 'lietotajs',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Īres
        |--------------------------------------------------------------------------
        */

        $ires = [];

        $ires['ire_1'] = Ire::updateOrCreate(
            [
                'lietotajs_id' => $lietotaji['admin']->id,
                'masina_id' => $masinas['AA1234']->id,
                'sakuma_laiks' => '2025-01-05 09:00:00',
            ],
            [
                'beigu_laiks' => '2025-01-05 11:30:00',
                'lokacija_id' => $lokacijas['daugavpils']->id,
                'nobrauktais_attalums' => 45.2,
                'statuss' => 'pabeigta',
                'cena' => 18.50,
            ]
        );

        $ires['ire_2'] = Ire::updateOrCreate(
            [
                'lietotajs_id' => $lietotaji['anna']->id,
                'masina_id' => $masinas['BB5678']->id,
                'sakuma_laiks' => '2025-02-01 10:00:00',
            ],
            [
                'beigu_laiks' => '2025-02-01 13:00:00',
                'lokacija_id' => $lokacijas['valmiera']->id,
                'nobrauktais_attalums' => 70.0,
                'statuss' => 'pabeigta',
                'cena' => 30.00,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Maksājumi
        |--------------------------------------------------------------------------
        */

        Maksajums::updateOrCreate(
            ['ire_id' => $ires['ire_1']->id],
            [
                'summa_bez_pvn' => 18.50,
                'summa_ar_pvn' => round(18.50 * 1.21, 2),
                'maksajuma_veids' => 'karte',
                'maksajuma_statuss' => 'veikts',
                'maksajuma_datums' => '2025-01-05 11:35:00',
            ]
        );

        Maksajums::updateOrCreate(
            ['ire_id' => $ires['ire_2']->id],
            [
                'summa_bez_pvn' => 30.00,
                'summa_ar_pvn' => round(30.00 * 1.21, 2),
                'maksajuma_veids' => 'apple_pay',
                'maksajuma_statuss' => 'veikts',
                'maksajuma_datums' => '2025-02-01 13:10:00',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Rezervācijas
        |--------------------------------------------------------------------------
        */

        Rezervacija::updateOrCreate(
            [
                'lietotajs_id' => $lietotaji['admin']->id,
                'masina_id' => $masinas['BB5678']->id,
                'datums' => '2025-03-01 10:00:00',
            ],
            [
                'deriguma_beigas' => '2025-03-01 12:00:00',
                'statuss' => 'izmantota',
            ]
        );

        Rezervacija::updateOrCreate(
            [
                'lietotajs_id' => $lietotaji['anna']->id,
                'masina_id' => $masinas['AA1234']->id,
                'datums' => '2025-03-05 09:00:00',
            ],
            [
                'deriguma_beigas' => '2025-03-05 11:00:00',
                'statuss' => 'aktīva',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Apkopes
        |--------------------------------------------------------------------------
        */

        Apkope::updateOrCreate(
            [
                'masina_id' => $masinas['AA1234']->id,
                'apraksts' => 'Eļļas maiņa',
                'datums' => '2025-04-10 09:00:00',
            ],
            [
                'izmaksas' => 75.00,
                'statuss' => 'pabeigta',
            ]
        );

        Apkope::updateOrCreate(
            [
                'masina_id' => $masinas['CC9012']->id,
                'apraksts' => 'Bremžu pārbaude',
                'datums' => '2025-04-15 11:00:00',
            ],
            [
                'izmaksas' => 120.00,
                'statuss' => 'procesā',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Pārkāpumi
        |--------------------------------------------------------------------------
        */

        Parkapums::updateOrCreate(
            [
                'lietotajs_id' => $lietotaji['admin']->id,
                'ire_id' => $ires['ire_1']->id,
                'tips' => 'smēķēšana',
            ],
            [
                'apraksts' => 'Smēķēšana automašīnā',
                'summa' => 50.00,
                'statuss' => 'samaksats',
            ]
        );

        Parkapums::updateOrCreate(
            [
                'lietotajs_id' => $lietotaji['anna']->id,
                'ire_id' => $ires['ire_2']->id,
                'tips' => 'satiksmes_pārkāpums',
            ],
            [
                'apraksts' => 'Ātruma pārsniegšana',
                'summa' => 80.00,
                'statuss' => 'nesamaksats',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Atsauksmes
        |--------------------------------------------------------------------------
        */

        Atsauksmes::updateOrCreate(
            [
                'lietotajs_id' => $lietotaji['admin']->id,
                'ire_id' => $ires['ire_1']->id,
            ],
            [
                'vertejums' => 5,
                'komentars' => 'Lieliska pieredze!',
                'izveidots' => '2025-01-05 12:00:00',
            ]
        );

        Atsauksmes::updateOrCreate(
            [
                'lietotajs_id' => $lietotaji['anna']->id,
                'ire_id' => $ires['ire_2']->id,
            ],
            [
                'vertejums' => 4,
                'komentars' => 'Labs auto un ērts serviss.',
                'izveidots' => '2025-02-01 14:00:00',
            ]
        );
    }
}