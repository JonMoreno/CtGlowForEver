<?php

use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        
        $this->call([
            
            ClientsTableSeeder::class,

            MedicalsTableSeeder::class,
            AllergiesTableSeeder::class,
            IllnessesTableSeeder::class,
            StressLevelsTableSeeder::class,
            SkinProductsTableSeeder::class,
            MedicationsTableSeeder::class,
            SurgeriesTableSeeder::class,

            TreatmentTableSeeder::class,
            ProductTableSeeder::class,
            DiscountTableSeeder::class,

            // InvoiceTableSeeder::class,
            // ConsultationTableSeeder::class,
            // PurchaseTreatmentTableSeeder::class,
            // PurchaseProductTableSeeder::class,
            // PurchaseDiscountTableSeeder::class,
            
            ConsultationEventTableSeeder::class,
            CustomEventTableSeeder::class
        ]);
    }
}
