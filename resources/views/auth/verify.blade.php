@extends('layouts.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background-color: rgba(128, 128, 128, 0.8); border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
                <div class="card-header" style="background-color: rgba(0, 0, 0, 0.6); color: #fff;">
                    {{ __('Verify Your Email Address') }}
                </div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    <p style="color: #fff;">{{ __('Before proceeding, please check your email for a verification link.') }}</p>
                    <p style="color: #fff;">{{ __('If you did not receive the email') }},</p>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline" style="color: #00f;">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
