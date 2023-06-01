<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .alert{
            z-index: 999;
        }
        @charset "UTF-8";
        body {
            background: #e9e9e9;
            color: #666666;
            font-family: "RobotoDraft", "Roboto", sans-serif;
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Pen Title */
        .pen-title {
            padding: 50px 0;
            text-align: center;
            letter-spacing: 2px;
        }
        .pen-title h1 {
            margin: 0 0 20px;
            font-size: 48px;
            font-weight: 300;
        }
        .pen-title span {
            font-size: 12px;
        }
        .pen-title span .fa {
            color: #4723D9;
        }
        .pen-title span a {
            color: #4723D9;
            font-weight: 600;
            text-decoration: none;
        }

        /* Rerun */
        .rerun {
            margin: 0 0 30px;
            text-align: center;
        }
        .rerun a {
            cursor: pointer;
            display: inline-block;
            background: #4723D9;
            border-radius: 3px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            padding: 10px 20px;
            color: #ffffff;
            text-decoration: none;
            transition: 0.3s ease;
        }
        .rerun a:hover {
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
        }

        /* Scroll To Bottom */
        #codepen, #portfolio {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #363636;
            width: 56px;
            height: 56px;
            border-radius: 100%;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            transition: 0.3s ease;
            color: #ffffff;
            text-align: center;
        }
        #codepen i, #portfolio i {
            line-height: 56px;
        }
        #codepen:hover, #portfolio:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
        }

        /* CodePen */
        #portfolio {
            bottom: 96px;
            right: 36px;
            background: #4723D9;
            width: 44px;
            height: 44px;
            -webkit-animation: buttonFadeInUp 1s ease;
            animation: buttonFadeInUp 1s ease;
        }
        #portfolio i {
            line-height: 44px;
        }

        /* Container */
        .container {
            position: relative;
            max-width: 460px;
            width: 100%;
            margin: 0 auto 100px;
        }
        .container.active .card:first-child {
            background: #f2f2f2;
            margin: 0 15px;
        }
        .container.active .card:nth-child(2) {
            background: #fafafa;
            margin: 0 10px;
        }
        .container.active .card.alt {
            top: 20px;
            right: 0;
            width: 100%;
            min-width: 100%;
            height: auto;
            border-radius: 5px;
            padding: 60px 0 40px;
            overflow: hidden;
        }
        .container.active .card.alt .toggle {
            position: absolute;
            top: 40px;
            right: -70px;
            box-shadow: none;
            transform: scale(10);
            transition: transform 0.3s ease;
        }
        .container.active .card.alt .toggle:before {
            content: "";
        }
        .container.active .card.alt .title,
        .container.active .card.alt .input-container,
        .container.active .card.alt .button-container {
            left: 0;
            opacity: 1;
            visibility: visible;
            transition: 0.3s ease;
        }
        .container.active .card.alt .title {
            transition-delay: 0.3s;
        }
        .container.active .card.alt .input-container {
            transition-delay: 0.4s;
        }
        .container.active .card.alt .input-container:nth-child(2) {
            transition-delay: 0.5s;
        }
        .container.active .card.alt .input-container:nth-child(3) {
            transition-delay: 0.6s;
        }
        .container.active .card.alt .button-container {
            transition-delay: 0.7s;
        }

        /* Card */
        .card {
            position: relative;
            background: #ffffff;
            border-radius: 5px;
            padding: 60px 0 40px 0;
            box-sizing: border-box;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            transition: 0.3s ease;
            /* Title */
            /* Inputs */
            /* Button */
            /* Footer */
            /* Alt Card */
        }
        .card:first-child {
            background: #fafafa;
            height: 10px;
            border-radius: 5px 5px 0 0;
            margin: 0 10px;
            padding: 0;
        }
        .card .title {
            position: relative;
            z-index: 1;
            border-left: 5px solid #4723D9;
            margin: 0 0 35px;
            padding: 10px 0 10px 50px;
            color: #4723D9;
            font-size: 32px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .card .input-container {
            position: relative;
            margin: 0 60px 50px;
        }
        .card .input-container input {
            outline: none;
            z-index: 1;
            position: relative;
            background: none;
            width: 100%;
            height: 60px;
            border: 0;
            color: #212121;
            font-size: 24px;
            font-weight: 400;
        }
        .card .input-container input:focus ~ label {
            color: #9d9d9d;
            transform: translate(-12%, -50%) scale(0.75);
        }
        .card .input-container input:focus ~ .bar:before, .card .input-container input:focus ~ .bar:after {
            width: 50%;
        }
        .card .input-container input:valid ~ label {
            color: #9d9d9d;
            transform: translate(-12%, -50%) scale(0.75);
        }
        .card .input-container label {
            position: absolute;
            top: 0;
            left: 0;
            color: #757575;
            font-size: 24px;
            font-weight: 300;
            line-height: 60px;
            transition: 0.2s ease;
        }
        .card .input-container .bar {
            position: absolute;
            left: 0;
            bottom: 0;
            background: #757575;
            width: 100%;
            height: 1px;
        }
        .card .input-container .bar:before, .card .input-container .bar:after {
            content: "";
            position: absolute;
            background: #4723D9;
            width: 0;
            height: 2px;
            transition: 0.2s ease;
        }
        .card .input-container .bar:before {
            left: 50%;
        }
        .card .input-container .bar:after {
            right: 50%;
        }
        .card .button-container {
            margin: 0 60px;
            text-align: center;
        }
        .card .button-container button {
            outline: 0;
            cursor: pointer;
            position: relative;
            display: inline-block;
            background: 0;
            width: 240px;
            border: 2px solid #e3e3e3;
            padding: 20px 0;
            font-size: 24px;
            font-weight: 600;
            line-height: 1;
            text-transform: uppercase;
            overflow: hidden;
            transition: 0.3s ease;
        }
        .card .button-container button span {
            position: relative;
            z-index: 1;
            color: #ddd;
            transition: 0.3s ease;
        }
        .card .button-container button:before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            display: block;
            background: #4723D9;
            width: 30px;
            height: 30px;
            border-radius: 100%;
            margin: -15px 0 0 -15px;
            opacity: 0;
            transition: 0.3s ease;
        }
        .card .button-container button:hover, .card .button-container button:active, .card .button-container button:focus {
            border-color: #4723D9;
        }
        .card .button-container button:hover span, .card .button-container button:active span, .card .button-container button:focus span {
            color: #4723D9;
        }
        .card .button-container button:active span, .card .button-container button:focus span {
            color: #ffffff;
        }
        .card .button-container button:active:before, .card .button-container button:focus:before {
            opacity: 1;
            transform: scale(10);
        }
        .card .footer {
            margin: 40px 0 0;
            color: #d3d3d3;
            font-size: 24px;
            font-weight: 300;
            text-align: center;
        }
        .card .footer a {
            color: inherit;
            text-decoration: none;
            transition: 0.3s ease;
        }
        .card .footer a:hover {
            color: #bababa;
        }
        .card.alt {
            position: absolute;
            top: 40px;
            right: -70px;
            z-index: 10;
            width: 140px;
            height: 140px;
            background: none;
            border-radius: 100%;
            box-shadow: none;
            padding: 0;
            transition: 0.3s ease;
            /* Toggle */
            /* Title */
            /* Input */
            /* Button */
        }
        .card.alt .toggle {
            position: relative;
            background: #4723D9;
            width: 140px;
            height: 140px;
            border-radius: 100%;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
            color: #ffffff;
            font-size: 58px;
            line-height: 140px;
            text-align: center;
            cursor: pointer;
        }
        .card.alt .toggle:before {
            content: "";
            display: inline-block;
            font: normal normal normal 14px/1 FontAwesome;
            font-size: inherit;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            transform: translate(0, 0);
        }
        .card.alt .title,
        .card.alt .input-container,
        .card.alt .button-container {
            left: 100px;
            opacity: 0;
            visibility: hidden;
        }
        .card.alt .title {
            position: relative;
            border-color: #ffffff;
            color: #ffffff;
        }
        .card.alt .title .close {
            cursor: pointer;
            position: absolute;
            top: 0;
            right: 60px;
            display: inline;
            color: #ffffff;
            font-size: 58px;
            font-weight: 400;
        }
        .card.alt .title .close:before {
            content: "×";
        }
        .card.alt .input-container input {
            color: #ffffff;
        }
        .card.alt .input-container input:focus ~ label {
            color: #ffffff;
        }
        .card.alt .input-container input:focus ~ .bar:before, .card.alt .input-container input:focus ~ .bar:after {
            background: #ffffff;
        }
        .card.alt .input-container input:valid ~ label {
            color: #ffffff;
        }
        .card.alt .input-container label {
            color: rgba(255, 255, 255, 0.8);
        }
        .card.alt .input-container .bar {
            background: rgba(255, 255, 255, 0.8);
        }
        .card.alt .button-container button {
            width: 100%;
            background: #ffffff;
            border-color: #ffffff;
        }
        .card.alt .button-container button span {
            color: #4723D9;
        }
        .card.alt .button-container button:hover {
            background: rgba(255, 255, 255, 0.9);
        }
        .card.alt .button-container button:active:before, .card.alt .button-container button:focus:before {
            display: none;
        }

        /* Keyframes */
        @-webkit-keyframes buttonFadeInUp {
            0% {
                bottom: 30px;
                opacity: 0;
            }
        }
        @keyframes buttonFadeInUp {
            0% {
                bottom: 30px;
                opacity: 0;
            }
        }
    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900|RobotoDraft:400,100,300,500,700,900">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(document).on('click','.toggle',function(){
            $('.container').stop().addClass('active');
        });

        $(document).on('click','.close',function(){
            $('.container').stop().removeClass('active');
        });
    </script>
</head>
<body>


<!-- Mixins-->
<!-- Pen Title-->
<div class="pen-title">
    <h1>Course Recommendation System</h1><span> <i class='fa fa-code'></i> by <a href='#'>CODE BREWERS</a></span>
</div>

<div class="container {{(Session::has('registration_error') ?'active' :'')}}" style="">

    <div class="card"></div>
    <div class="card">
        <h1 class="title">Login</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="input-container">
                {{--                <input type="#{type}" id="#{label}" required="required"/>--}}
                <x-input placeholder="" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <label for="email">Username</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <x-input  placeholder="" class="block mt-1 w-full"
                         type="password"
                         name="password"
                         required autocomplete="current-password" />
                <label for="#{label}">Password</label>
                <div class="bar"></div>
            </div>
            <div class="button-container">
                <button><span>Log In</span></button>
            </div>
            {{--            <div class="footer"><a href="#">Forgot your password?</a></div>--}}
        </form>
    </div>
    <div class="card alt">
        @include('layouts.flash-message')
        <div class="toggle"></div>
        <h1 class="title">Register
            <div class="close"></div>
        </h1>
        <form method="POST" action="{{ route('register_user') }}">
            @csrf
            <div class="input-container">
                <input type="text" id="name" name="name" required="required"/>
                <label for="name">Name</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input type="email" id="email" name="email" required="required"/>
                <label for="email">Email</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input type="password" id="password" name="password" required="required"/>
                <label for="#password">Password</label>
                <div class="bar"></div>
            </div>
            <div class="input-container">
                <input type="password" id="password_confirmation" name="password_confirmation" required="required"/>
                <label for="password_confirmation">Repeat Password</label>
                <div class="bar"></div>
            </div>
            <div class="button-container">
                <button type="submit"><span>Sign Up</span></button>
            </div>
        </form>
    </div>
</div>
</body>

</html>
