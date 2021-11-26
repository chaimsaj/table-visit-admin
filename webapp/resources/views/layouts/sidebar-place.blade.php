<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-apps">@lang('translation.Administration')</li>

                <li>
                    <a href="{{route("root")}}" class="waves-effect">
                        <i class="bx bxs-dashboard"></i>
                        <span key="t-dashboard">@lang('translation.Dashboard')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect nav-item">
                        <i class="bx bx-user-circle"></i>
                        <span key="t-users">@lang('translation.Users')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a class="load" href="{{route("users")}}" key="t-users">@lang('translation.Users')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-building-house"></i>
                        <span key="t-venues">@lang('translation.Venues')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route("places")}}" key="t-places">@lang('translation.Places')</a></li>
                        <li class="menu-title-divider" key="t-places-divider">
                            @lang('translation.TypesAndFeatures')
                        </li>
                        <li><a href="{{route("place-types")}}" key="t-place-types">@lang('translation.Types')</a></li>
                        <li><a href="{{route("place-features")}}"
                               key="t-place-features">@lang('translation.Features')</a></li>
                        <li><a href="{{route("place-music-list")}}"
                               key="t-place-music-list">@lang('translation.Music')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-drink"></i>
                        <span key="t-table-services">@lang('translation.TablesAndBottles')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li class="menu-title-divider" key="t-tables-divider">
                            @lang('translation.Tables')
                        </li>
                        <li><a href="{{route("tables")}}" key="t-tables">@lang('translation.Tables')</a></li>
                        <li><a href="{{route("table-types")}}" key="t-table-types">@lang('translation.TableTypes')</a>
                        </li>
                        <li class="menu-title-divider" key="t-services-divider">
                            @lang('translation.BottlesAndDrinks')
                        </li>
                        <li><a href="{{route("services")}}" key="t-services">@lang('translation.Bottles')</a></li>
                        <li><a href="{{route("service-rates")}}"
                               key="t-service-rates">@lang('translation.BottleRates')</a>
                        </li>
                        <li><a href="{{route("service-types")}}"
                               key="t-service-types">@lang('translation.DrinkTypes')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-purchase-tag-alt"></i>
                        <span key="t-reservations">@lang('translation.Reservations')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route("bookings")}}" key="t-bookings">@lang('translation.Bookings')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-chart"></i>
                        <span key="t-reports">@lang('translation.Reports')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route("table-spends")}}"
                               key="t-table-spends">@lang('translation.Spends')</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
