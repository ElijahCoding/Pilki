@extends('users.layouts.app')

@section('scripts')
    <script>
        $('#sendSMSCode').click(function () {
            $(this).attr('disabled', 'disabled');
            axios.post(laroute.route('api.phone.confirm'), {
                phone: $('#phone').val()
            }).then(function () {
                $('#sendSMSCode').addClass('d-none');
                $('#phone_code').removeClass('d-none');
            });
        })
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Fill the form') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('users.auth.social.fill_form.save') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="phone"
                                       class="col-sm-3 col-form-label text-md-right">{{ __('Phone') }}</label>

                                <div class="col-md-4">
                                    <input id="phone" type="tel"
                                           class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                           name="phone" value="{{ old('phone') }}" required autofocus>

                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="col-md-4">
                                    <button type="button" class="btn btn-secondary btn-block{{ $errors->has('phone_code') ? ' d-none' : '' }}"
                                            id="sendSMSCode">{{ __('Send code') }}</button>

                                    <input id="phone_code"
                                           class="form-control{{ $errors->has('phone_code') ? ' is-invalid' : ' d-none' }}"
                                           name="phone_code" value="{{ old('phone_code') }}" required>

                                    @if ($errors->has('phone_code'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('phone_code') }}</strong>
                                        </span>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="email"
                                       class="col-sm-3 col-form-label text-md-right">{{ __('E-mail') }}</label>

                                <div class="col-md-8">
                                    <input id="email" type="email"
                                           class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0 justify-content-center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Finish') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection