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
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-building-house"></i>
                        <span key="t-venues">@lang('translation.Venues')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route("places")}}" key="t-places">@lang('translation.Places')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bxs-drink"></i>
                        <span key="t-table-services">@lang('translation.TableServices')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route("services")}}" key="t-services">@lang('translation.Services')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-purchase-tag-alt"></i>
                        <span key="t-reservations">@lang('translation.Reservations')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route("bookings")}}" key="t-bookings">@lang('translation.Bookings')</a></li>
                        <li><a href="{{route("payments")}}" key="t-payments">@lang('translation.Payments')</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
