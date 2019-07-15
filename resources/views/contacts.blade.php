@extends('layouts.app')

@section('content')
    @include('layouts.header')
    <div id="contacts" class="container">
        <h1>@lang('localization.contacts')</h1>
        <div class="row">
            <div class="col-12 col-md-6">
                <h5>@lang('localization.contactsPhones'):</h5>
                <div class="phones">
                    <div class="lifecell">
                        (093) 577-85-19
                    </div>
                    <div class="vodafone">
                        (095) 640-01-98
                    </div>
                </div>

                <p class="mt-3"><strong class="mr-2">e-mail:</strong> clockshop@ukr.net</p>

            </div>
            <div class="col-12 col-md-6">
                <h5>@lang('localization.workScheduleInfoCenter'):</h5>
                <p class="work-time">@lang('localization.everyDay'): <strong class="ml-5">9:00 - 22:00</strong></p>
                <p class="schedule-note">@lang('localization.scheduleNote')</p>

            </div>
        </div>
    </div>


@endsection

@section('scripts')

@endsection