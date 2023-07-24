<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Login</title>

    @include('admin.layout.style')

</head>

<body class="animsition">
<div class="page-wrapper">
    <div class="page-content--bge5">
        <div class="container">
            <div class="login-wrap">
                <div class="login-content">
                    <div class="login-logo">
                        <a href="#">
                            <img src="theme/images/icon/logo.png" alt="CoolAdmin">
                        </a>
                    </div>
                    <div class="login-form">
                        <form action="login" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Username</label>
                                <input class="au-input au-input--full" type="text" name="username" value="{{ old('username') }}" placeholder="Enter your username" required>
                                @if ($errors->has('username'))
                                    <span class="help-block text-danger">
                                        <p>{{ $errors->first('username') }}</p>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="au-input au-input--full" type="password" name="password" placeholder="Enter your password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block text-danger">
                                        <p>{{ $errors->first('password') }}</p>
                                    </span>
                                @endif
                            </div>
                            <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('admin.layout.script')

</body>

</html>
<!-- end document-->
