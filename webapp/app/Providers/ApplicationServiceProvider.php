<?php


namespace App\Providers;

use App\Repositories\Base\BaseRepository;
use App\Repositories\Base\BaseRepositoryInterface;
use App\Repositories\CityRepository;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\CountryRepository;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\CurrencyRepository;
use App\Repositories\CurrencyRepositoryInterface;
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
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);
        $this->app->bind(StateRepositoryInterface::class, StateRepository::class);

        //Services
        $this->app->bind(CountryServiceInterface::class, CountryService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(CityServiceInterface::class, CityService::class);
        $this->app->bind(CurrencyServiceInterface::class, CurrencyService::class);
        $this->app->bind(StateServiceInterface::class, StateService::class);
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
