<div>
    <div class="subheader-block d-lg-flex align-items-center border-faded border-right-0 border-top-0 border-bottom-0 ml-3 pl-3">
        <div class="d-inline-flex flex-column justify-content-center mr-3">
            <span class="fw-300 fs-xs d-block opacity-50">
                <small class="text-uppercase">{{ __('messages.my_profits') }}</small>
            </span>
            <span class="fw-500 fs-xl d-block color-danger-500">
                S/. {{ number_format($total, 2, '.', ',') }}
            </span>
        </div>
        <span class="sparklines hidden-lg-down" sparktype="bar" sparkbarcolor="#fe6bb0" sparkheight="32px" sparkbarwidth="5px" values="1,4,3,6,5,3,9,6,5,9,7"><canvas width="85" height="32" style="display: inline-block; width: 85px; height: 32px; vertical-align: top;"></canvas></span>
    </div>
</div>
