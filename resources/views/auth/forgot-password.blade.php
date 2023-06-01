<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <style type="text/css">
        img{
            width: 100%;
        }
        .login {
            height: 1000px;
            width: 100%;
            backgrounbuid: radial-gradient(#171530, #171530);
            position: relative;

        }
        .login_box {
            width: 1050px;
            height: 600px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            background: #fff;
            border-radius: 10px;
            box-shadow: 1px 4px 22px -8px #0004;
            display: flex;
            overflow: hidden;
        }
        .login_box .left{
            width: 41%;
            height: 100%;
            padding: 10px 25px;

        }
        .signin-label {
            padding-top: 20px;
            margin: auto;
            margin-top: 20px;
            font-weight: 400;
            align-items: center;
            justify-content: center;
            align-self: center;
            font-size: 40px;

        }
        .login_box .right{
            width: 59%;
            height: 100%
        }
        .left .top_link a {
            color: #452A5A;
            font-weight: 400;
            margin: auto;
        }
        .left .top_link{
            height: 20px
        }
        .left .contact{
            display: flex;
            align-items: center;
            justify-content: center;
            align-self: center;
            height: 80%;
            width: 73%;
            margin: auto;
        }
        .left h3{
            text-align: center;
            margin-bottom: 40px;
        }
        .left input {
            border: none;
            width: 80%;
            margin: 20px 2px;
            border-bottom: 1px solid #4f30677d;
            padding: 7px 9px;
            width: 100%;
            overflow: hidden;
            background: transparent;
            font-weight: 600;
            font-size: 14px;
        }
        .left{
            background: linear-gradient(-45deg, #dcd7e0, #fff);
        }
        .submit {
            border: none;
            padding: 15px 50px;
            width: 55%;
            border-radius: 5px;
            display: block;
            margin: auto;
            margin-top: 20px;
            background: #583672;
            color: #fff;
            font-weight: bold;
            -webkit-box-shadow: 0px 9px 15px -11px rgba(88,54,114,1);
            -moz-box-shadow: 0px 9px 15px -11px rgba(88,54,114,1);
            box-shadow: 0px 9px 15px -11px rgba(88,54,114,1);
        }

        .right {
            background: linear-gradient(212.38deg, rgba(242, 57, 127, 0.7) 0%, rgba(175, 70, 189, 0.71) 100%),url(https://static.seattletimes.com/wp-content/uploads/2019/01/web-typing-ergonomics-1020x680.jpg);
            color: #fff;
            position: relative;
        }

        .right .right-text{
            height: 100%;
            position: relative;
            transform: translate(0%, 45%);
        }
        .right-text h2{
            display: block;
            width: 100%;
            text-align: center;
            font-size: 50px;
            font-weight: 500;
        }
        .right-text h5{
            display: block;
            width: 100%;
            text-align: center;
            font-size: 19px;
            font-weight: 400;
        }

        .right .right-inductor{
            position: absolute;
            width: 70px;
            height: 7px;
            background: #fff0;
            left: 50%;
            bottom: 70px;
            transform: translate(-50%, 0%);
        }
        .top_link img {
            width: 28px;
            padding-right: 7px;
            margin-top: -3px;
        }

    </style>
</head>
<body>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<body>
<section class="login">
    <div class="login_box">
        <div class="left">
            <div class="text-center">
                <h1 class="signin-label"> Sign In</h1>
            </div>
            <div class="contact">
                <!-- <form action="">
                    <h3>SIGN IN</h3>
                    <input type="text" placeholder="USERNAME">
                    <input type="text" placeholder="PASSWORD">
                    <button class="submit">LET'S GO</button>
                </form> -->
                <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->

                    <x-input id="email" placeholder="Email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />


                    <!-- Password -->


                    <x-input id="password" placeholder="Password" class="block mt-1 w-full"
                             type="password"
                             name="password"
                             required autocomplete="current-password" />


                    <!-- Remember Me -->


                    <div class="flex items-center justify-end mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif


                    </div>
                    <button class="submit">Login</button>
                </form>

            </div>
        </div>
        <div class="right">
            <div class="right-text">
                <h2>Bicol University</h2>
                <h5>A WEB-BASED COURSE RECOMMENDATION SYSTEM</h5>
            </div>
            <div class="right-inductor"><img src="https://lh3.googleusercontent.com/fife/ABSRlIoGiXn2r0SBm7bjFHea6iCUOyY0N2SrvhNUT-orJfyGNRSMO2vfqar3R-xs5Z4xbeqYwrEMq2FXKGXm-l_H6QAlwCBk9uceKBfG-FjacfftM0WM_aoUC_oxRSXXYspQE3tCMHGvMBlb2K1NAdU6qWv3VAQAPdCo8VwTgdnyWv08CmeZ8hX_6Ty8FzetXYKnfXb0CTEFQOVF4p3R58LksVUd73FU6564OsrJt918LPEwqIPAPQ4dMgiH73sgLXnDndUDCdLSDHMSirr4uUaqbiWQq-X1SNdkh-3jzjhW4keeNt1TgQHSrzW3maYO3ryueQzYoMEhts8MP8HH5gs2NkCar9cr_guunglU7Zqaede4cLFhsCZWBLVHY4cKHgk8SzfH_0Rn3St2AQen9MaiT38L5QXsaq6zFMuGiT8M2Md50eS0JdRTdlWLJApbgAUqI3zltUXce-MaCrDtp_UiI6x3IR4fEZiCo0XDyoAesFjXZg9cIuSsLTiKkSAGzzledJU3crgSHjAIycQN2PH2_dBIa3ibAJLphqq6zLh0qiQn_dHh83ru2y7MgxRU85ithgjdIk3PgplREbW9_PLv5j9juYc1WXFNW9ML80UlTaC9D2rP3i80zESJJY56faKsA5GVCIFiUtc3EewSM_C0bkJSMiobIWiXFz7pMcadgZlweUdjBcjvaepHBe8wou0ZtDM9TKom0hs_nx_AKy0dnXGNWI1qftTjAg=w1920-h979-ft" alt=""></div>
        </div>
    </div>
</section>
</body>
</html>
</html>

