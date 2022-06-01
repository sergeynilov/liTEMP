@component('mail::message')
    Вы зарегистрировались на {{ $site_mame }}

    Вы ввели {{ $user->email }} е-мейл,

    Ваш код подтверждения : {{ $confirmation_code }}
    Введите его чтобы завершить регистрацию.


    С наилучшими пожеланиями,
    {{ config('app.name') }}
@endcomponent

