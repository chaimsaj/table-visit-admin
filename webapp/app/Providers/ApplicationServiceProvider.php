<?php


namespace App\Providers;

use App\Repositories\Base\BaseRepository;
use App\Repositories\Base\BaseRepositoryInterface;
use App\Repositories\BookingRepository;
use App\Repositories\BookingRepositoryInterface;
use App\Repositories\BookingServiceRepository;
use App\Repositories\BookingServiceRepositoryInterface;
use App\Repositories\BookingTableRepository;
use App\Repositories\BookingTableRepositoryInterface;
use App\Repositories\CityRepository;
use App\Repositories\CityRepositoryInterface;
use App\Repositories\ContentPageRepository;
use App\Repositories\ContentPageRepositoryInterface;
use App\Repositories\CountryRepository;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\CurrencyRepository;
use App\Repositories\CurrencyRepositoryInterface;
use App\Repositories\FavoriteRepository;
use App\Repositories\FavoriteRepositoryInterface;
use App\Repositories\GuestRepository;
use App\Repositories\GuestRepositoryInterface;
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
use App\Repositories\PlaceFeatureRepository;
use App\Repositories\PlaceFeatureRepositoryInterface;
use App\Repositories\PlaceMusicRepository;
use App\Repositories\PlaceMusicRepositoryInterface;
use App\Repositories\PlaceRepository;
use App\Repositories\PlaceRepositoryInterface;
use App\Repositories\PlaceToFeatureRepository;
use App\Repositories\PlaceToFeatureRepositoryInterface;
use App\Repositories\PlaceToMusicRepository;
use App\Repositories\PlaceToMusicRepositoryInterface;
use App\Repositories\PlaceToPlaceTypeRepository;
use App\Repositories\PlaceToPlaceTypeRepositoryInterface;
use App\Repositories\PlaceTypeRepository;
use App\Repositories\PlaceTypeRepositoryInterface;
use App\Repositories\PlaceWorkDayRepository;
use App\Repositories\PlaceWorkDayRepositoryInterface;
use App\Repositories\PlaceWorkHourRepository;
use App\Repositories\PlaceWorkHourRepositoryInterface;
use App\Repositories\PolicyRepository;
use App\Repositories\PolicyRepositoryInterface;
use App\Repositories\RatingRepository;
use App\Repositories\RatingRepositoryInterface;
use App\Repositories\ServiceRateRepository;
use App\Repositories\ServiceRateRepositoryInterface;
use App\Repositories\ServiceRepository;
use App\Repositories\ServiceRepositoryInterface;
use App\Repositories\ServiceTypeRepository;
use App\Repositories\ServiceTypeRepositoryInterface;
use App\Repositories\StateRepository;
use App\Repositories\StateRepositoryInterface;
use App\Repositories\SystemConfigurationRepository;
use App\Repositories\SystemConfigurationRepositoryInterface;
use App\Repositories\TableDetailRepository;
use App\Repositories\TableDetailRepositoryInterface;
use App\Repositories\TableRateRepository;
use App\Repositories\TableRateRepositoryInterface;
use App\Repositories\TableRepository;
use App\Repositories\TableRepositoryInterface;
use App\Repositories\TableTypeRepository;
use App\Repositories\TableTypeRepositoryInterface;
use App\Repositories\TransactionRepository;
use App\Repositories\TransactionRepositoryInterface;
use App\Repositories\UserActionRepository;
use App\Repositories\UserActionRepositoryInterface;
use App\Repositories\UserProfileRepository;
use App\Repositories\UserProfileRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Repositories\UserToPlaceRepository;
use App\Repositories\UserToPlaceRepositoryInterface;
use App\Services\LogService;
use App\Services\LogServiceInterface;
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
        $this->app->bind(BookingServiceRepositoryInterface::class, BookingServiceRepository::class);
        $this->app->bind(BookingTableRepositoryInterface::class, BookingTableRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(ContentPageRepositoryInterface::class, ContentPageRepository::class);
        $this->app->bind(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);
        $this->app->bind(FavoriteRepositoryInterface::class, FavoriteRepository::class);
        $this->app->bind(GuestRepositoryInterface::class, GuestRepository::class);
        $this->app->bind(LanguageRepositoryInterface::class, LanguageRepository::class);
        $this->app->bind(LocationRepositoryInterface::class, LocationRepository::class);
        $this->app->bind(LogRepositoryInterface::class, LogRepository::class);
        $this->app->bind(MediaFileRepositoryInterface::class, MediaFileRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(PlaceDetailRepositoryInterface::class, PlaceDetailRepository::class);
        $this->app->bind(PlaceFeatureRepositoryInterface::class, PlaceFeatureRepository::class);
        $this->app->bind(PlaceMusicRepositoryInterface::class, PlaceMusicRepository::class);
        $this->app->bind(PlaceRepositoryInterface::class, PlaceRepository::class);
        $this->app->bind(PlaceToFeatureRepositoryInterface::class, PlaceToFeatureRepository::class);
        $this->app->bind(PlaceToMusicRepositoryInterface::class, PlaceToMusicRepository::class);
        $this->app->bind(PlaceToPlaceTypeRepositoryInterface::class, PlaceToPlaceTypeRepository::class);
        $this->app->bind(PlaceTypeRepositoryInterface::class, PlaceTypeRepository::class);
        $this->app->bind(PlaceWorkDayRepositoryInterface::class, PlaceWorkDayRepository::class);
        $this->app->bind(PlaceWorkHourRepositoryInterface::class, PlaceWorkHourRepository::class);
        $this->app->bind(PolicyRepositoryInterface::class, PolicyRepository::class);
        $this->app->bind(RatingRepositoryInterface::class, RatingRepository::class);
        $this->app->bind(ServiceRateRepositoryInterface::class, ServiceRateRepository::class);
        $this->app->bind(ServiceRepositoryInterface::class, ServiceRepository::class);
        $this->app->bind(ServiceTypeRepositoryInterface::class, ServiceTypeRepository::class);
        $this->app->bind(StateRepositoryInterface::class, StateRepository::class);
        $this->app->bind(SystemConfigurationRepositoryInterface::class, SystemConfigurationRepository::class);
        $this->app->bind(TableDetailRepositoryInterface::class, TableDetailRepository::class);
        $this->app->bind(TableRateRepositoryInterface::class, TableRateRepository::class);
        $this->app->bind(TableRepositoryInterface::class, TableRepository::class);
        $this->app->bind(TableTypeRepositoryInterface::class, TableTypeRepository::class);
        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);
        $this->app->bind(UserActionRepositoryInterface::class, UserActionRepository::class);
        $this->app->bind(UserProfileRepositoryInterface::class, UserProfileRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UserToPlaceRepositoryInterface::class, UserToPlaceRepository::class);

        //Services
        $this->app->bind(LogServiceInterface::class, LogService::class);
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
