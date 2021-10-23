<div>
    <div class="subheader-block d-lg-flex align-items-center" >
        <div class="d-inline-flex flex-column justify-content-center mr-3">
            <span class="fw-300 fs-xs d-block opacity-50">
                <small class="text-uppercase">Monto total comprobantes</small>
            </span>
            <span class="fw-500 fs-xl d-block color-primary-500">
                S/. {{ number_format($total_document, 2, '.', '') }}
            </span>
        </div>
        <span class="sparklines hidden-lg-down" sparktype="bar" sparkbarcolor="#886ab5" sparkheight="32px" sparkbarwidth="5px" values="3,4,3,6,7,3,3,6,2,6,4"><canvas width="85" height="32" style="display: inline-block; width: 85px; height: 32px; vertical-align: top;"></canvas></span>
    </div>
</div>
