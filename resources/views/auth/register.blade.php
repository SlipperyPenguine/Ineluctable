@extends('appoption')

@section('content')

    <!--Reg Block-->
    <div class="reg-block">
        <div class="reg-block-header">
            <h2>Sign Up</h2>

            <p>Already Signed Up? Click <a class="color-green" href="{{URL::asset('auth/login')}}">Sign In</a> to login your account.</p>
        </div>

        <form method="POST">
            {!! csrf_field() !!}

        <div class="input-group margin-bottom-20">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Username" required>
        </div>
        <div class="input-group margin-bottom-20">
            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
            <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required>
        </div>
        <div class="input-group margin-bottom-20">
            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="input-group margin-bottom-30">
            <span class="input-group-addon"><i class="fa fa-key"></i></span>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <button type="submit" class="btn btn-block btn-primary">Register</button>
            </div>
        </div>

        </form>
    </div>
    <!--End Reg Block-->


@endsection