<x-app>
    <header class="text-center flex min-h-screen relative">
        <div class="header-contents flex py-14 min-h-600 w-full relative">
            <div class="bg-gradient-to-b header-overlay overlay absolute left-0 top-0 w-full h-full">
                <div class="noisy overlay absolute left-0 top-0 w-full h-full"></div>
            </div>
            <div class="z-10 relative text-white inner-header align-middle w-full flex flex-col max-w-540px xl:max-w-620px mx-auto">
                <div class="px-5">
                    <img src="images/logo.png" alt="Clean up garner logo with trash can" height="420" width="367" class="logo mx-auto h-auto max-w-72px">
                    <h1 class="text-4xl font-bold mt-4 text-white">Clean Up Garner</h1>
                    <h2 class="text-xl font-semibold text-gray-300 mt-2">Community Trash Pickup Events</h2>
                    <h3 class="subtext my-6 py-3 text-xl my-8 font-secondary font-primary-deep border-b-3 border-t-3 border-primary-deep text-primary-deep">Subscribe To Our Events</h3>
                </div>
                <div id="subscribeFormContainer" class="relative">
                    <div class="subscribe-inner-container">
                        <form class="p-5 bg-gray-200 bg-opacity-50 flex relative" id="subscribeForm" method="POST" action="/subscribe">
                            <div class="relative z-10 flex w-full">
                                <label class="sr-only" for="subscribeEmail">Email Address</label>
                                <input id="subscribeEmail" name="email" type="email" placeholder="your@email.com" class="p-3 flex-grow translate text-black">
                                <input type="hidden" name="redirect" value="true">
                                <x-captcha id="g-recaptcha-subscribe"></x-captcha>
                                <input type="submit" class="submit-subscribe py-3 px-4 ml-3 border border-transparent font-semibold bg-primary-light text-white hover:bg-primary-semi-light transition-colors cursor-pointer outline-none">
                            </div>
                        </form>
                        <span class="text-xs text-gray-400 mt-3 inline-block">By submitting the form above you agree to our <a href="{{ url('privacy-policy') }}" class="underline">Privacy Policy</a></span>
                    </div>
                    @push('scripts')
                        <style>#subscribeFormContainer .success { opacity: 0; }</style>
                    @endpush
                    <div class="success absolute top-0 left-0 w-full h-full flex items-center justify-center font-lg">
                        <span>Thank you for subscribing! We look forward to seeing you in the future.</span>
                    </div>
                </div>
                <div id="contact" class="mt-16 text-sm text-gray-400 flex-grow flex flex-col justify-end text-primary-dark">
                    <a href="tel:@config('phone-href')" class="block py-1 px-5"><i class="fas fa-phone px-2 align-middle"></i>@config('phone')</a>
                    <a href="mailto:@config('email')" class="block py-1 px-5"><i class="fas fa-envelope px-2 align-middle"></i>@config('email')</a>
                </div>
            </div>
        </div>
    </header>
    <main class="events px-3 py-10 bg-blue-50 xl:pb-24 xl:pt-20">
        <div class="max-w-420px lg:max-w-540px mx-auto xl:max-w-1200px xl:mb-3">
            <h2 class="text-3xl text-gray-900 mb-3 font-semibold">Next Event</h2>
            @ifGetterNotEmpty($events, 'getItems')
                @foreachGetter ($events, 'getItems', 'item')
                    <x-event :event="$item"></x-event>
                    @breakGetter
                @endforeachGetter
            @elseGetter
                <x-event :event="null"></x-event>
            @endifGetter
        </div>
    </main>
    <x-contact></x-contact>
    <x-footer></x-footer>
</x-app>
