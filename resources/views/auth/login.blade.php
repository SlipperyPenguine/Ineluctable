@extends('appoption')

@section('content')

        <!--Reg Block-->
<div class="reg-block">
    <div class="reg-block-header">
        <h2>Sign In</h2>
        <p>Don't Have Account? Click <a class="color-green" href="{{URL::asset('auth/register')}}">Sign Up</a> to registration.</p>
    </div>

    <form method="POST">
        {!! csrf_field() !!}

    <div class="input-group margin-bottom-20">
        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
        <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>
    <div class="input-group margin-bottom-20">
        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="remember">
            <p>Always stay signed in</p>
        </label>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <button type="submit" class="btn btn-block btn-primary">Log In</button>
        </div>
    </div>

        </form>
</div>
<!--End Reg Block-->




@endsection