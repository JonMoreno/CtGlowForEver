<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->app->bind(
            'App\Repositories\Contracts\ClientRepositoryInterface',
            'App\Repositories\ClientRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\MedicalRepositoryInterface',
            'App\Repositories\MedicalRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\StressLevelRepositoryInterface',
            'App\Repositories\StressLevelRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\SkinProductRepositoryInterface',
            'App\Repositories\SkinProductRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\MedicationRepositoryInterface',
            'App\Repositories\MedicationRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\AllergieRepositoryInterface',
            'App\Repositories\AllergieRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\SurgeryRepositoryInterface',
            'App\Repositories\SurgeryRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\SurgeryRepositoryInterface',
            'App\Repositories\SurgeryRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\IllnessRepositoryInterface',
            'App\Repositories\IllnessRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\MedicalRecordRepositoryInterface',
            'App\Repositories\MedicalRecordRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\BasicInfoRepositoryInterface',
            'App\Repositories\BasicInfoRepository'
        );
        $this->app->bind(
            'App\Repositories\Composites\MedicalRecordComposite'
        );
        $this->app->bind(
            'App\Repositories\Contracts\ProductRepositoryInterface',
            'App\Repositories\ProductRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\TreatmentRepositoryInterface',
            'App\Repositories\TreatmentRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\DiscountRepositoryInterface',
            'App\Repositories\DiscountRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\ConsultationRepositoryInterface',
            'App\Repositories\ConsultationRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\InvoiceRepositoryInterface',
            'App\Repositories\InvoiceRepository'
        );

        $this->app->bind(
            'App\Repositories\Contracts\PurchaseProductRepositoryInterface',
            'App\Repositories\PurchaseProductRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\PurchaseTreatmentRepositoryInterface',
            'App\Repositories\PurchaseTreatmentRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\PurchaseDiscountRepositoryInterface',
            'App\Repositories\PurchaseDiscountRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\CalendarRepositoryInterface',
            'App\Repositories\CalendarRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\ConsultationEventRepositoryInterface',
            'App\Repositories\ConsultationEventRepository'
        );
        $this->app->bind(
            'App\Repositories\Contracts\CustomEventRepositoryInterface',
            'App\Repositories\CustomEventRepository'
        );
        
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
