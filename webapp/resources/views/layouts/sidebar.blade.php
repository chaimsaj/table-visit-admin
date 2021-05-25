<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-apps">@lang('translation.TableVisit')</li>



                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-user-circle"></i>
                        <span key="t-users">@lang('translation.Users')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="users" key="t-users">@lang('translation.Users')</a></li>
                    </ul>
                </li>

                {{--<li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-store"></i>
                        <span key="t-ecommerce">@lang('translation.Ecommerce')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="#" key="t-products">@lang('translation.Products')</a></li>
                        <li><a href="#"
                               key="t-product-detail">@lang('translation.Product_Detail')</a></li>
                        <li><a href="#" key="t-orders">@lang('translation.Orders')</a></li>
                        <li><a href="#" key="t-customers">@lang('translation.Customers')</a></li>
                        <li><a href="#" key="t-cart">@lang('translation.Cart')</a></li>
                        <li><a href="#" key="t-checkout">@lang('translation.Checkout')</a></li>
                        <li><a href="#" key="t-shops">@lang('translation.Shops')</a></li>
                        <li><a href="#" key="t-add-product">@lang('translation.Add_Product')</a>
                        </li>
                    </ul>
                </li>--}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="bx bx-map-pin"></i>
                        <span key="t-locations">@lang('translation.Locations')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="countries" key="t-countries">@lang('translation.Countries')</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        {{--<span class="badge rounded-pill bg-success float-end"
                              key="t-new">@lang('translation.New')</span>--}}
                        <i class="bx bx-lock-alt"></i>
                        <span key="t-authentication">@lang('translation.Authentication')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">

                        <li><a href="#" key="t-login">@lang('translation.Login')</a></li>
                        <li><a href="#" key="t-register">@lang('translation.Register')</a></li>
                        <li><a href="#" key="t-recover-password">@lang('translation.Recover_Password')</a>
                        </li>
                        <li><a href="#" key="t-lock-screen">@lang('translation.Lock_Screen')</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
