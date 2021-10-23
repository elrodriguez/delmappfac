<div>
<nav class="shortcut-menu d-none d-sm-block">
    <input type="checkbox" class="menu-open" name="menu-open" id="menu_open" />
    <label for="menu_open" class="menu-open-button ">
        <span class="app-shortcut-icon d-block"></span>
    </label>
    <a href="#" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Scroll Top">
        <i class="fal fa-arrow-up"></i>
    </a>
    <a href="{{ route('logout') }}" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="@lang('messages.logout')" onclick="event.preventDefault(); document.getElementById('logout-form-shortcut-menu').submit();">
        <i class="fal fa-sign-out"></i>
    </a>
    <a href="#" class="menu-item btn" data-action="app-fullscreen" data-toggle="tooltip" data-placement="left" title="Full Screen">
        <i class="fal fa-expand"></i>
    </a>
    <a href="#" class="menu-item btn" data-action="app-print" data-toggle="tooltip" data-placement="left" title="Print page">
        <i class="fal fa-print"></i>
    </a>
    <a href="#" class="menu-item btn" data-action="app-voice" data-toggle="tooltip" data-placement="left" title="Voice command">
        <i class="fal fa-microphone"></i>
    </a>
    <form id="logout-form-shortcut-menu" method="POST" action="{{ route('logout') }}" style="display:none">@csrf</form>
</nav>
<!-- END Quick Menu -->
<!-- BEGIN Page Settings -->
<div class="modal fade js-modal-settings modal-backdrop-transparent" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-right modal-md">
        <div class="modal-content">
            <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center w-100">
                <h4 class="m-0 text-center color-white">
                    @lang('messages.layout_settings')
                    <small class="mb-0 opacity-80">@lang('messages.user_interface_settings')</small>
                </h4>
                <button type="button" class="close text-white position-absolute pos-top pos-right p-2 m-1 mr-2" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="settings-panel">
                    <div class="mt-4 d-table w-100 px-5">
                        <div class="d-table-cell align-middle">
                            <h5 class="p-0">
                                @lang('messages.app_layout')
                            </h5>
                        </div>
                    </div>
                    <div class="list" id="fh">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="header-function-fixed"></a>
                        <span class="onoffswitch-title">@lang('messages.fixed_header')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.header_is_in_a_fixed_at_all_times')</span>
                    </div>
                    <div class="list" id="nff">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-function-fixed"></a>
                        <span class="onoffswitch-title">@lang('messages.fixed_navigation')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.left_panel_is_fixed')</span>
                    </div>
                    <div class="list" id="nfm">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-function-minify"></a>
                        <span class="onoffswitch-title">@lang('messages.minify_navigation')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.skew_nav_to_maximize_space')</span>
                    </div>
                    <div class="list" id="nfh">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-function-hidden"></a>
                        <span class="onoffswitch-title">@lang('messages.hide_navigation')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.roll_mouse_on_edge_to_reveal')</span>
                    </div>
                    <div class="list" id="nft">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-function-top"></a>
                        <span class="onoffswitch-title">@lang('messages.top_navigation')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.relocate_left_pane_to_top')</span>
                    </div>
                    <div class="list" id="fff">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="footer-function-fixed"></a>
                        <span class="onoffswitch-title">@lang('messages.fixed_footer')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.page_footer_is_fixed')</span>
                    </div>
                    <div class="list" id="mmb">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-main-boxed"></a>
                        <span class="onoffswitch-title">@lang('messages.boxed_layout')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.encapsulates_to_a_container')</span>
                    </div>
                    <div class="expanded">
                        <ul class="mb-3 mt-1">
                            <li>
                                <div class="bg-fusion-50" data-action="toggle" data-class="mod-bg-1"></div>
                            </li>
                            <li>
                                <div class="bg-warning-200" data-action="toggle" data-class="mod-bg-2"></div>
                            </li>
                            <li>
                                <div class="bg-primary-200" data-action="toggle" data-class="mod-bg-3"></div>
                            </li>
                            <li>
                                <div class="bg-success-300" data-action="toggle" data-class="mod-bg-4"></div>
                            </li>
                            <li>
                                <div class="bg-white border" data-action="toggle" data-class="mod-bg-none"></div>
                            </li>
                        </ul>
                        <div class="list" id="mbgf">
                            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-fixed-bg"></a>
                            <span class="onoffswitch-title">@lang('messages.fixed_background')</span>
                        </div>
                    </div>
                    <div class="mt-4 d-table w-100 px-5">
                        <div class="d-table-cell align-middle">
                            <h5 class="p-0">@lang('messages.mobile_menu')</h5>
                        </div>
                    </div>
                    <div class="list" id="nmp">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-mobile-push"></a>
                        <span class="onoffswitch-title">@lang('messages.push_content')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.content_pushed_on_menu_reveal')</span>
                    </div>
                    <div class="list" id="nmno">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-mobile-no-overlay"></a>
                        <span class="onoffswitch-title">@lang('messages.removes_mesh_on_menu_reveal')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.removes_mesh_on_menu_reveal')</span>
                    </div>
                    <div class="list" id="sldo">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-mobile-slide-out"></a>
                        <span class="onoffswitch-title">@lang('messages.off_canvas')<sup>(@lang('messages.beta'))</sup></span>
                        <span class="onoffswitch-title-desc">@lang('messages.content_overlaps_menu')</span>
                    </div>
                    <div class="mt-4 d-table w-100 px-5">
                        <div class="d-table-cell align-middle">
                            <h5 class="p-0">@lang('messages.accessibility')</h5>
                        </div>
                    </div>
                    <div class="list" id="mbf">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-bigger-font"></a>
                        <span class="onoffswitch-title">@lang('messages.bigger_content_font')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.content_fonts_are_bigger_for_readability')</span>
                    </div>
                    <div class="list" id="mhc">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-high-contrast"></a>
                        <span class="onoffswitch-title">@lang('messages.high_contrast_text') (WCAG 2 AA)</span>
                        <span class="onoffswitch-title-desc">4.5:1 @lang('messages.text_contrast_ratio')</span>
                    </div>
                    <div class="list" id="mcb">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-color-blind"></a>
                        <span class="onoffswitch-title">@lang('messages.daltonism') <sup>(@lang('messages.beta'))</sup> </span>
                        <span class="onoffswitch-title-desc">@lang('messages.color_vision_deficiency')</span>
                    </div>
                    <div class="list" id="mpc">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-pace-custom"></a>
                        <span class="onoffswitch-title">@lang('messages.preloader_inside')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.preloader_will_be_inside_content')</span>
                    </div>
                    <div class="list" id="mpi">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-panel-icon"></a>
                        <span class="onoffswitch-title">@lang('messages.system_icons') (@lang('messages.not_panels'))</span>
                        <span class="onoffswitch-title-desc">@lang('messages.buttons_will_appear_as_icons')</span>
                    </div>
                    <div class="mt-4 d-table w-100 px-5">
                        <div class="d-table-cell align-middle">
                            <h5 class="p-0">@lang('messages.global_modifications')</h5>
                        </div>
                    </div>
                    <div class="list" id="mcbg">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-clean-page-bg"></a>
                        <span class="onoffswitch-title">@lang('messages.clean_page_background')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.adds_more_whitespace')</span>
                    </div>
                    <div class="list" id="mhni">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-hide-nav-icons"></a>
                        <span class="onoffswitch-title">@lang('messages.hide_navigation_icons')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.invisible_navigation_icons')</span>
                    </div>
                    <div class="list" id="dan">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-disable-animation"></a>
                        <span class="onoffswitch-title">@lang('messages.disable_css_animation')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.disables_css_based_animations')</span>
                    </div>
                    <div class="list" id="mhic">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-hide-info-card"></a>
                        <span class="onoffswitch-title">@lang('messages.hide_info_card')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.hides_info_card_from_left_panel')</span>
                    </div>
                    <div class="list" id="mlph">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-lean-subheader"></a>
                        <span class="onoffswitch-title">@lang('messages.lean_subheader')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.distinguished_page_header')</span>
                    </div>
                    <div class="list" id="mnl">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-nav-link"></a>
                        <span class="onoffswitch-title">@lang('messages.hierarchical_avigation')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.clear_breakdown_of_nav_links')</span>
                    </div>
                    <div class="list" id="mdn">
                        <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-nav-dark"></a>
                        <span class="onoffswitch-title">@lang('messages.dark_navigation')</span>
                        <span class="onoffswitch-title-desc">@lang('messages.navigation_background_is_darkend')</span>
                    </div>
                    <hr class="mb-0 mt-4">
                    <div class="mt-4 d-table w-100 pl-5 pr-3">
                        <div class="d-table-cell align-middle">
                            <h5 class="p-0">@lang('messages.global_font_size')</h5>
                        </div>
                    </div>
                    <div class="list mt-1">
                        <div class="btn-group btn-group-sm btn-group-toggle my-2" data-toggle="buttons">
                            <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text-sm" data-target="html">
                                <input type="radio" name="changeFrontSize"> SM
                            </label>
                            <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text" data-target="html">
                                <input type="radio" name="changeFrontSize" checked=""> MD
                            </label>
                            <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text-lg" data-target="html">
                                <input type="radio" name="changeFrontSize"> LG
                            </label>
                            <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text-xl" data-target="html">
                                <input type="radio" name="changeFrontSize"> XL
                            </label>
                        </div>
                        <span class="onoffswitch-title-desc d-block mb-0">@lang('messages.change') <strong>@lang('messages.root')</strong> @lang('messages.font_size_to_effect_rem')
                            @lang('messages.values') (@lang('messages.resets_on_page_refresh'))</span>
                    </div>
                    <hr class="mb-0 mt-4">
                    <div class="mt-4 d-table w-100 pl-5 pr-3">
                        <div class="d-table-cell align-middle">
                            <h5 class="p-0 pr-2 d-flex">
                                @lang('messages.theme_colors')
                                <a href="#" class="ml-auto fw-400 fs-xs" data-toggle="popover" data-trigger="focus" data-placement="top" title="" data-html="true" data-content="@lang('messages.msg_info')" data-original-title="<span class='text-primary'><i class='fal fa-exclamation-triangle mr-1'></i> @lang('messages.heads_up')</span>" data-template="<div class=&quot;popover bg-white border-white&quot; role=&quot;tooltip&quot;><div class=&quot;arrow&quot;></div><h3 class=&quot;popover-header bg-transparent&quot;></h3><div class=&quot;popover-body fs-xs&quot;></div></div>"><i class="fal fa-info-circle mr-1"></i> @lang('messages.more_info')</a>
                            </h5>
                        </div>
                    </div>
                    <div class="expanded theme-colors pl-5 pr-3">
                        <ul class="m-0">
                            <li>
                                <a href="#" id="myapp-0" data-action="theme-update" data-themesave data-theme="" data-toggle="tooltip" data-placement="top" title="Wisteria (base css)" data-original-title="Wisteria (base css)"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-1" data-action="theme-update" data-themesave data-theme="{{ asset('theme/css/themes/cust-theme-1.css') }}" data-toggle="tooltip" data-placement="top" title="Tapestry" data-original-title="Tapestry"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-2" data-action="theme-update" data-themesave data-theme="{{ asset('theme/css/themes/cust-theme-2.css') }}" data-toggle="tooltip" data-placement="top" title="Atlantis" data-original-title="Atlantis"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-3" data-action="theme-update" data-themesave data-theme="{{ asset('theme/css/themes/cust-theme-3.css') }}" data-toggle="tooltip" data-placement="top" title="Indigo" data-original-title="Indigo"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-4" data-action="theme-update" data-themesave data-theme="{{ asset('theme/css/themes/cust-theme-4.css') }}" data-toggle="tooltip" data-placement="top" title="Dodger Blue" data-original-title="Dodger Blue"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-5" data-action="theme-update" data-themesave data-theme="{{ asset('theme/css/themes/cust-theme-5.css') }}" data-toggle="tooltip" data-placement="top" title="Tradewind" data-original-title="Tradewind"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-6" data-action="theme-update" data-themesave data-theme="{{ asset('theme/css/themes/cust-theme-6.css') }}" data-toggle="tooltip" data-placement="top" title="Cranberry" data-original-title="Cranberry"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-7" data-action="theme-update" data-themesave data-theme="{{ asset('theme/css/themes/cust-theme-7.css') }}" data-toggle="tooltip" data-placement="top" title="Oslo Gray" data-original-title="Oslo Gray"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-8" data-action="theme-update" data-themesave data-theme="{{ asset('theme/css/themes/cust-theme-8.css') }}" data-toggle="tooltip" data-placement="top" title="Chetwode Blue" data-original-title="Chetwode Blue"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-9" data-action="theme-update" data-themesave data-theme="{{ asset('theme/css/themes/cust-theme-9.css') }}" data-toggle="tooltip" data-placement="top" title="Apricot" data-original-title="Apricot"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-10" data-action="theme-update" data-themesave data-theme="{{ asset('theme/css/themes/cust-theme-10.css') }}" data-toggle="tooltip" data-placement="top" title="Blue Smoke" data-original-title="Blue Smoke"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-11" data-action="theme-update" data-themesave data-theme="{{ asset('theme/css/themes/cust-theme-11.css') }}" data-toggle="tooltip" data-placement="top" title="Green Smoke" data-original-title="Green Smoke"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-12" data-action="theme-update" data-themesave data-theme="{{ asset('theme/css/themes/cust-theme-12.css') }}" data-toggle="tooltip" data-placement="top" title="Wild Blue Yonder" data-original-title="Wild Blue Yonder"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-13" data-action="theme-update" data-themesave data-theme="{{ asset('theme/css/themes/cust-theme-13.css') }}" data-toggle="tooltip" data-placement="top" title="Emerald" data-original-title="Emerald"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-14" data-action="theme-update" data-themesave data-theme="{{ asset('theme/css/themes/cust-theme-14.css') }}" data-toggle="tooltip" data-placement="top" title="Supernova" data-original-title="Supernova"></a>
                            </li>
                            <li>
                                <a href="#" id="myapp-15" data-action="theme-update" data-themesave data-theme="{{ asset('theme/css/themes/cust-theme-15.css') }}" data-toggle="tooltip" data-placement="top" title="Hoki" data-original-title="Hoki"></a>
                            </li>
                        </ul>
                    </div>
                    <hr class="mb-0 mt-4">
                    <div class="mt-4 d-table w-100 pl-5 pr-3">
                        <div class="d-table-cell align-middle">
                            <h5 class="p-0 pr-2 d-flex">
                                @lang('messages.theme_modes') (@lang('messages.beta'))
                                <a href="#" class="ml-auto fw-400 fs-xs" data-toggle="popover" data-trigger="focus" data-placement="top" title="" data-html="true" data-content="@lang('messages.msg_beta')" data-original-title="<span class='text-primary'><i class='fal fa-question-circle mr-1'></i> @lang('messages.why_beta')</span>" data-template="<div class=&quot;popover bg-white border-white&quot; role=&quot;tooltip&quot;><div class=&quot;arrow&quot;></div><h3 class=&quot;popover-header bg-transparent&quot;></h3><div class=&quot;popover-body fs-xs&quot;></div></div>"><i class="fal fa-question-circle mr-1"></i> @lang('messages.why_beta')</a>
                            </h5>
                        </div>
                    </div>
                    <div class="pl-5 pr-3 py-3">
                        <div class="ie-only alert alert-warning d-none">
                            <h6>@lang('messages.internet_explorer_issue')</h6>
                            @lang('messages.msg_explorer')
                        </div>
                        <div class="row no-gutters">
                            <div class="col-4 pr-2 text-center">
                                <div id="skin-default" data-action="toggle-replace" data-replaceclass="mod-skin-light mod-skin-dark" data-class="" data-toggle="tooltip" data-placement="top" title="" class="d-flex bg-white border border-primary rounded overflow-hidden text-success js-waves-on" data-original-title="Default Mode" style="height: 80px">
                                    <div class="bg-primary-600 bg-primary-gradient px-2 pt-0 border-right border-primary"></div>
                                    <div class="d-flex flex-column flex-1">
                                        <div class="bg-white border-bottom border-primary py-1"></div>
                                        <div class="bg-faded flex-1 pt-3 pb-3 px-2">
                                            <div class="py-3" style="background:url('{{ asset('theme/img/demo/s-1.png') }}') top left no-repeat;background-size: 100%;"></div>
                                        </div>
                                    </div>
                                </div>
                                @lang('messages.default')
                            </div>
                            <div class="col-4 px-1 text-center">
                                <div id="skin-light" data-action="toggle-replace" data-replaceclass="mod-skin-dark" data-class="mod-skin-light" data-toggle="tooltip" data-placement="top" title="" class="d-flex bg-white border border-secondary rounded overflow-hidden text-success js-waves-on" data-original-title="Light Mode" style="height: 80px">
                                    <div class="bg-white px-2 pt-0 border-right border-"></div>
                                    <div class="d-flex flex-column flex-1">
                                        <div class="bg-white border-bottom border- py-1"></div>
                                        <div class="bg-white flex-1 pt-3 pb-3 px-2">
                                            <div class="py-3" style="background:url('{{ asset('theme/img/demo/s-1.png') }}') top left no-repeat;background-size: 100%;"></div>
                                        </div>
                                    </div>
                                </div>
                                @lang('messages.light')
                            </div>
                            <div class="col-4 pl-2 text-center">
                                <div id="skin-dark" data-action="toggle-replace" data-replaceclass="mod-skin-light" data-class="mod-skin-dark" data-toggle="tooltip" data-placement="top" title="" class="d-flex bg-white border border-dark rounded overflow-hidden text-success js-waves-on" data-original-title="Dark Mode" style="height: 80px">
                                    <div class="bg-fusion-500 px-2 pt-0 border-right"></div>
                                    <div class="d-flex flex-column flex-1">
                                        <div class="bg-fusion-600 border-bottom py-1"></div>
                                        <div class="bg-fusion-300 flex-1 pt-3 pb-3 px-2">
                                            <div class="py-3 opacity-30" style="background:url('{{ asset('theme/img/demo/s-1.png') }}') top left no-repeat;background-size: 100%;"></div>
                                        </div>
                                    </div>
                                </div>
                                @lang('messages.dark')
                            </div>
                        </div>
                    </div>
                    <hr class="mb-0 mt-4">
                    <div class="pl-5 pr-3 py-3 bg-faded">
                        <div class="row no-gutters">
                            <div class="col-6 pr-1">
                                <a href="#" class="btn btn-outline-danger fw-500 btn-block" data-action="app-reset">@lang('messages.reset_settings')</a>
                            </div>
                            <div class="col-6 pl-1">
                                <a href="#" class="btn btn-danger fw-500 btn-block" data-action="factory-reset">@lang('messages.factory_reset')</a>
                            </div>
                        </div>
                    </div>
                </div> <span id="saving"></span>
            </div>
        </div>
    </div>
</div>
</div>
