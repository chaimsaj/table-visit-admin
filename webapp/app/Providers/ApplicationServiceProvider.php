<?php


namespace App\Providers;

use App\Models\Language;
use App\Repositories\Base\BaseRepository;
use App\Repositories\Base\BaseRepositoryInterface;
use App\Repositories\BookingRepository;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\CityRepository;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\CountryRepository;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\CurrencyRepository;
use App\Repositories\CurrencyRepositoryInterface;
use App\Repositories\LanguageRepository;
use App\Repositories\LanguageRepositoryInterface;
use App\Repositories\LocationRepository;
use App\Repositories\LocationRepositoryInterface;
use App\Repositories\LogRepository;
use App\Repositories\LogRepositoryInterface;
use App\Repositories\MediaFileRepository;
use App\Repositories\MediaFileRepositoryInterface;
use App\Repositories\PaymentRepository;
use App\Repositories\PaymentRepositoryInterface;
use App\Repositories\PlaceDetailRepository;
use App\Repositories\PlaceDetailRepositoryInterface;
use App\Repositories\PlaceRepository;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\RateRepository;
use App\Repositories\RateRepositoryInterface;
use App\Repositories\ServiceRepository;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\StateRepository;
use App\Repositories\StateRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\CityService;
use App\Services\CityServiceInterface;
use App\Services\CountryService;
use App\Services\CountryServiceInterface;
use App\Services\CurrencyService;
use App\Services\CurrencyServiceInterface;
use App\Services\LanguageService;
use App\Services\LanguageServiceInterface;
use App\Services\LogService;
use App\Services\LogServiceInterface;
use App\Services\StateService;
use App\Services\StateServiceInterface;
use App\Services\UserService;
use App\Services\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //Repositories
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);
        $this->app->bind(LanguageRepositoryInterface::class, LanguageRepository::class);
        $this->app->bind(LocationRepositoryInterface::class, LocationRepository::class);
        $this->app->bind(LogRepositoryInterface::class, LogRepository::class);
        $this->app->bind(MediaFileRepositoryInterface::class, MediaFileRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(PlaceDetailRepositoryInterface::class, PlaceDetailRepository::class);
        $this->app->bind(PlaceRepositoryInterface::class, PlaceRepository::class);
        $this->app->bind(RateRepositoryInterface::class, RateRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(StateRepositoryInterface::class, StateRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        //Services
        //$this->app->bind(BookingServiceInterface::class, BookingService::class);
        $this->app->bind(CityServiceInterface::class, CityService::class);
        $this->app->bind(CountryServiceInterface::class, CountryService::class);
        $this->app->bind(CurrencyServiceInterface::class, CurrencyService::class);
        $this->app->bind(LanguageServiceInterface::class, LanguageService::class);

        $this->app->bind(LogServiceInterface::class, LogService::class);
        /*$this->app->bind(LocationServiceInterface::class, LocationService::class);
        $this->app->bind(MediaFileServiceInterface::class, MediaFileService::class);
        $this->app->bind(PaymentServiceInterface::class, PaymentService::class);
        $this->app->bind(PlaceDetailServiceInterface::class, PlaceDetailService::class);
        $this->app->bind(PlaceServiceInterface::class, PlaceService::class);
        $this->app->bind(RateServiceInterface::class, RateService::class);
        $this->app->bind(ServiceServiceInterface::class, ServiceService::class);*/
        $this->app->bind(StateServiceInterface::class, StateService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
