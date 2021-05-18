# Introduction
- Login project for interview.<br>
- Users are divided into managers and general employees.<br>
- After logging in, direct to different pages based on different identities.<br>

# Update
- Add OTP Verification after login.

# Development Technology
- Frontend : HTML, CSS, Javascript, jQuery, bootstrap.<br>
- Backend : PHP, Laravel.<br>
- Database : MySQL.<br>

# OTP Verification
## Introduction
1. A one-time password (OTP), is a password that is valid for only one login session or transaction, on a computer system or other digital device.
2. OTP Verification verifies Email Address/Mobile Number of users by sending OTP verification code during registration and login.
3. In this project we use javascript library otplib to implement.

## Custome .js File
### Introduction
1. In this file we implement the Email OTP Verification.
2. Users can import and use this function to their own pages.
### Tutorial
1. Create an div element with id otp_div in your own page.
` <div id="otp_div"></div>'

## Reference
- [OneTimePasswordDemo](https://github.com/wellwind/OneTimePasswordDemo)
- [一次性密碼演算法](https://wellwind.idv.tw/blog/2017/09/07/one-time-pass-introduce-with-hotp-totp-google-authenticator/)
- [JS-OTP](https://github.com/jiangts/JS-OTP)
- [otplib](https://www.npmjs.com/package/otplib)
- [otplib](https://github.com/yeojz/otplib)
- [otplib](https://otplib.yeojz.dev/)

# Laravel File Navigation
[Laravel Directory Structure](https://laravel.tw/docs/5.3/structure)

## Model
1. The central component of the pattern.  The application's dynamic data structure, independent of the user interface. It directly manages the data, logic and rules of the application.<br>
2. File location:
    * ./.env => ***Set up the database.***
    * ./app/Entity => ***Set up table name, primary key, etc.***
## View
1. Any representation of information such as a chart, diagram or table. Multiple views of the same information are possible, such as a bar chart for management and a tabular view for accountants.
2. File location:
    * ./resources/views/layouts => ***Web page rendering blade.***
## Controller
1. Accepts input and converts it to commands for the model or view.
2. File location:
    * ./app/Http/Controllers => ***Handle the HTTP request and execute the corresponding action.***
    * ./app/Http/Middleware/EmployeeHasAuth, ./app/Http/Middleware/ManagerHasAuth, ./app/Http/Middleware/UserHasAuth => ***Handle browsing permission control.***
    * ./app\Http/Kernel.php => ***Set up middleware.***
    * ./routes/web.php => ***Define all routes for the application.***

## Website Public Resources
File location: <br>
    * ./public/css <br>
    * ./public/js <br>
    * ./public/images <br>

<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[British Software Development](https://www.britishsoftware.co)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- [UserInsights](https://userinsights.com)
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)
- [Invoice Ninja](https://www.invoiceninja.com)
- [iMi digital](https://www.imi-digital.de/)
- [Earthlink](https://www.earthlink.ro/)
- [Steadfast Collective](https://steadfastcollective.com/)
- [We Are The Robots Inc.](https://watr.mx/)
- [Understand.io](https://www.understand.io/)
- [Abdel Elrafa](https://abdelelrafa.com)
- [Hyper Host](https://hyper.host)
- [Appoly](https://www.appoly.co.uk)
- [OP.GG](https://op.gg)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
