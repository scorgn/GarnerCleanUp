@once
    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js?render=explicit&onload=recaptchaOnLoad" async defer></script>
        <script type="text/plain" id="recaptcha-site-key">@config('recaptcha-site-key')</script>
    @endpush
@endonce

<div {{ $attributes }}></div>
