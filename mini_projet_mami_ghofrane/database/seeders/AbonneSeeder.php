<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Abonne;

class AbonneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $abonnes = [
            [
                'reference' => 'STEG-001',
                'num_cin' => '12345678',
                'nom' => 'BEN ALI',
                'prenom' => 'mohamed',
                'date_abonnement' => '2024-01-15',
                'num_compteur_elec' => 'ELEC-001',
                'num_compteur_gaz' => 'GAZ-001',
                'adresse' => '123 Rue de la République, Tunis',
                'tel' => '71234567',
                'email' => 'mohamed.benali@email.com'
            ],
            [
                'reference' => 'STEG-002',
                'num_cin' => '23456789',
                'nom' => 'TRABELSI',
                'prenom' => 'fatma',
                'date_abonnement' => '2024-02-20',
                'num_compteur_elec' => 'ELEC-002',
                'num_compteur_gaz' => 'GAZ-002',
                'adresse' => '45 Avenue Habib Bourguiba, Sfax',
                'tel' => '72345678',
                'email' => 'fatma.trabelsi@email.com'
            ],
            [
                'reference' => 'STEG-003',
                'num_cin' => '34567890',
                'nom' => 'SASSI',
                'prenom' => 'ahmed',
                'date_abonnement' => '2024-03-10',
                'num_compteur_elec' => 'ELEC-003',
                'num_compteur_gaz' => 'GAZ-003',
                'adresse' => '78 Rue de la Liberté, Sousse',
                'tel' => '73456789',
                'email' => 'ahmed.sassi@email.com'
            ],
            [
                'reference' => 'STEG-004',
                'num_cin' => '45678901',
                'nom' => 'BOUZAYENE',
                'prenom' => 'amel',
                'date_abonnement' => '2024-04-05',
                'num_compteur_elec' => 'ELEC-004',
                'num_compteur_gaz' => 'GAZ-004',
                'adresse' => '12 Rue du Lac, Bizerte',
                'tel' => '74567890',
                'email' => 'amel.bouzayene@email.com'
            ],
            [
                'reference' => 'STEG-005',
                'num_cin' => '56789012',
                'nom' => 'CHAIEB',
                'prenom' => 'karim',
                'date_abonnement' => '2024-05-12',
                'num_compteur_elec' => 'ELEC-005',
                'num_compteur_gaz' => 'GAZ-005',
                'adresse' => '89 Boulevard 7 Novembre, Gabès',
                'tel' => '75678901',
                'email' => 'karim.chaieb@email.com'
            ],
            [
                'reference' => 'STEG-006',
                'num_cin' => '67890123',
                'nom' => 'KACEM',
                'prenom' => 'sarra',
                'date_abonnement' => '2024-06-18',
                'num_compteur_elec' => 'ELEC-006',
                'num_compteur_gaz' => 'GAZ-006',
                'adresse' => '56 Rue de la Medina, Kairouan',
                'tel' => '76789012',
                'email' => 'sarra.kacem@email.com'
            ],
            [
                'reference' => 'STEG-007',
                'num_cin' => '78901234',
                'nom' => 'HAMDI',
                'prenom' => 'youssef',
                'date_abonnement' => '2024-07-25',
                'num_compteur_elec' => 'ELEC-007',
                'num_compteur_gaz' => 'GAZ-007',
                'adresse' => '34 Rue des Palmiers, Djerba',
                'tel' => '77890123',
                'email' => 'youssef.hamdi@email.com'
            ],
            [
                'reference' => 'STEG-008',
                'num_cin' => '89012345',
                'nom' => 'ZITOUNI',
                'prenom' => 'leila',
                'date_abonnement' => '2024-08-30',
                'num_compteur_elec' => 'ELEC-008',
                'num_compteur_gaz' => 'GAZ-008',
                'adresse' => '67 Avenue de la République, Monastir',
                'tel' => '78901234',
                'email' => 'leila.zitouni@email.com'
            ],
            [
                'reference' => 'STEG-009',
                'num_cin' => '90123456',
                'nom' => 'MAATOUG',
                'prenom' => 'riadh',
                'date_abonnement' => '2024-09-15',
                'num_compteur_elec' => 'ELEC-009',
                'num_compteur_gaz' => 'GAZ-009',
                'adresse' => '23 Rue du Port, La Manouba',
                'tel' => '79012345',
                'email' => 'riadh.maatoug@email.com'
            ],
            [
                'reference' => 'STEG-010',
                'num_cin' => '01234567',
                'nom' => 'BEN HASSEN',
                'prenom' => 'nadia',
                'date_abonnement' => '2024-10-20',
                'num_compteur_elec' => 'ELEC-010',
                'num_compteur_gaz' => 'GAZ-010',
                'adresse' => '91 Rue de la Paix, Ariana',
                'tel' => '70123456',
                'email' => 'nadia.benhassen@email.com'
            ]
        ];

        foreach ($abonnes as $abonne) {
            Abonne::create($abonne);
        }
    }
}
