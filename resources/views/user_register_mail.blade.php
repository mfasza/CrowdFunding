<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

    <style>
        * {
            padding: 0;
            margin: 0;
        }
        .text-center {
            text-align: center !important;
        }
        .bg-dark {
            background-color: #343a40 !important;
        }
        .p-3 {
            padding: 1rem !important;
        }
        .text-light {
            color: #f8f9fa !important;
        }
        .btn {
            display: inline-block;
            font-weight: 400;
            color: #212529;
            text-align: center;
            text-decoration: none;
            vertical-align: middle;
            -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                    user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
            line-height: 1.6;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .btn:hover {
            color: #212529;
            text-decoration: none;
        }
        .btn-primary {
            color: #fff;
            background-color: #3490dc;
            border-color: #3490dc;
        }

        .btn-primary:hover {
            color: #fff;
            background-color: #227dc7;
            border-color: #2176bd;
        }
    </style>

</head>
<body>
    <h4 class="text-center bg-dark text-light p-3">Verifikasi Email</h4>
    <p class="p-3">
        Selamat Datang <strong>{{$name}}</strong>, <br>
        Anda telah terdaftar pada aplikasi CrowdFunding dengan informasi sebagai berikut: <br>
        Alamat email: <strong>{{$email}}</strong> <br>
        kode OTP: <strong>{{$otp_code}}</strong> <br>
        Silakan lakukan verifikasi email Anda dengan menggunakan kode OTP di atas.
    </p>
    <div class="text-center p-3">
        <a href="" class="btn btn-primary">Verifikasi Email</a>
    </div>
    <p class="p-3">
        <small><em>*Kode OTP hanya berlaku selama 5 menit setelah pendaftaran. Anda perlu meregenerate ulang kode OTP bila telah kadaluarsa.</em></small>
    </p>

</body>
</html>
