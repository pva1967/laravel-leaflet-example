@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('auth.Reset') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('auth.Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                            <a href="#" name="generate" id="generate">Сгененировать надежный пароль</a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('auth.Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('auth.Reset Password') }}
                            </button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')


<script>
    String.prototype.pick = function(min, max) {
        var n, chars = '';

        if (typeof max === 'undefined') {
            n = min;
        } else {
            n = min + Math.floor(Math.random() * (max - min + 1));
        }

        for (var i = 0; i < n; i++) {
            chars += this.charAt(Math.floor(Math.random() * this.length));
        }

        return chars;
    };


    // Credit to @Christoph: http://stackoverflow.com/a/962890/464744
    String.prototype.shuffle = function() {
        var array = this.split('');
        var tmp, current, top = array.length;

        if (top) while (--top) {
            current = Math.floor(Math.random() * (top + 1));
            tmp = array[current];
            array[current] = array[top];
            array[top] = tmp;
        }

        return array.join('');
    };
    $('#generate').on('click', function (){
        //var specials = '!@#$%^&*()_+{}:"<>?\|[];\',./`~';
        var lowercase = 'abcdefghijklmnopqrstuvwxyz';
        var uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var numbers = '0123456789';

        var all = lowercase + uppercase + numbers;

        var password = '';
        password += numbers.pick(1);
        password += lowercase.pick(1);
        password += uppercase.pick(1);
        password += all.pick(5, 5);
        password = password.shuffle();
        console.log('password:', password);
        $('#password').val(password);
    }
    );

    $(document).ready(function () {
        // Initialize the show/hide toggle (so non-JS users don't see it)
        (function($) {
            $('#password').each(function(val) {
                var input = $(this);
                var show = $("<a>").text("Показать пароль").addClass("show-plain").attr({
                    title: "Show your password in plain text",
                    href: "#"
                }).insertAfter(input);
                ;
                $("<a>").text("Скрыть пароль").addClass("show-hidden").css("display", "none").attr({
                    title: "Спрятать пароль",
                    href: "#"
                }).insertAfter(show);
            });
        })(jQuery);
        $(".show-plain").on("click", function() {
            //cache selector
            var input = $("#password");
            //create new text input
            $("<input>").attr({
                id: input.attr("id"),
                type: "text",
                name: input.attr("name")
            }).val(input.val())
                .addClass(input.attr("class"))
                .insertAfter(input);
            //    .insertAfter(input.prev());
             input.remove();
            //change link text and attributes
           /* $(this).text("Hide password").removeClass("show-plain")
                .addClass("show-hidden").attr({
                title: "Hide your password"
            });*/

           $(".show-hidden").css("display", "block");
           $(".show-plain").css("display", "none");
            //stop link being followed
            return false;
        });
        $(".show-hidden").on("click", function() {
            //cache selector

            var input = $("#password");

            //create new password input
           $("<input>").attr({
                id: input.attr("id"),
                type: "password",
                name: input.attr("name")
            }).val(input.val())
                .addClass(input.attr("class"))
                .insertAfter(input);
            input.remove();
            //change link text and attributes
            $(".show-hidden").css("display", "none");
            $(".show-plain").css("display", "block");
            //stop link being followed
            return false;
        });
    });

</script>
<style>
    .show-plain, .show-hidden {
        display: block;
        padding: 4px 0 4px 26px;
        background-position: center left;
        background-repeat: no-repeat;
    }
    .show-plain { background-image: url("{{ asset('storage/img/' . "show.png") }}"); }
    .show-hidden { background-image: url("{{ asset('storage/img/' . "hide.png") }}"); }
</style>
@endpush
