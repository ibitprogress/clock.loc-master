<div id="headerMin" class="mb-3">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-4">
                    <a class="" href="/">
                        <img class="mt-1 mb-1" src="/images/logo.png" alt="Clock Shop" title="Clock Shop">
                    </a>
                </div>
                <div class="col-6 col-md-6 col-lg-4 offset-md-2 offset-lg-4 phones">
                    <p class="phones-title d-none d-sm-inline-flex">@lang('localization.infoPhone'):
                    <p class="phones-number"><span class="d-flex d-sm-inline-flex">(093) 577-85-19,</span> (095) 640-01-98<span class="d-flex d-sm-inline-flex"></span></p>
                    <a href="#" class="schedule-link" data-toggle="modal" data-target="#workSchedule">@lang('localization.workSchedule') <i class="far fa-clock"></i></a>
                </div>
            </div>
        </div>
</div>
<cart v-bind:images-path='"{!! url('images/small').'/'!!}"'
      v-bind:checkout-url='"{!! route('checkout').'/'!!}"'
      v-bind:items-data='{!! session()->has("cart") ? json_encode(session()->get("cart")->items) : json_encode([]) !!}'
      v-bind:total-price-data='{!! session()->has("cart")? session()->get("cart")->totalPrice : 0 !!}'
      v-bind:total-qty-data='{!! session()->has("cart")? session()->get("cart")->totalQty : 0 !!}'
></cart>

<div class="modal fade" id="workSchedule" tabindex="-1" role="dialog" aria-labelledby="workSchedule" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title ">@lang('localization.workScheduleInfoCenter')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="work-time">@lang('localization.from') 9:00 до 22:00</p>
                <p class="schedule-note">@lang('localization.scheduleNote')</p>
            </div>
        </div>
    </div>
</div>

