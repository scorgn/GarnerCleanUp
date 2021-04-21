<div class="contact flex w-full border-green-200 py-10 px-5 relative">
    <div id="contactFormContainer" class="w-full">
        <div class="contact-inner-container w-full">
            <form id="contactForm" action="/api/contact" method="POST" class="flex flex-col items-center max-w-620px mx-auto w-full">
                <h2 class="text-3xl text-gray-900 mb-3 font-semibold text-left w-full">Contact Clean Up Garner</h2>
                <label for="contactName" class="sr-only">Full Name</label>
                <input type="text" id="contactName" name="name" placeholder="Full Name *" class="my-1 w-full">
                <label for="contactEmail" class="sr-only">Email Address</label>
                <input type="email" id="contactEmail" name="email" placeholder="Email Address" class="my-1 w-full">
                <label for="contactPhone" class="sr-only">Phone Number</label>
                <input type="tel" id="contactPhone" name="phone" placeholder="Phone Number" class="my-1 w-full">
                <label for="contactMessage" class="sr-only">Message</label>
                <textarea id="contactMessage" name="message" placeholder="Message" rows="4" class="my-1 w-full" onkeydown="if (event.keyCode == 13) { this.form.requestSubmit(); return false; }"></textarea>
                <label class="my-4 w-full flex items-center"><input type="checkbox" name="subscribe" value="1" class="p-3 mr-3">Subscribe To Future Events</label>
                <x-captcha id="g-recaptcha-contact"></x-captcha>
                <input type="submit" class="submit-subscribe py-3 px-4 w-full border border-transparent font-semibold bg-primary-deep text-white hover:bg-primary-dark transition-colors cursor-pointer outline-none text-lg my-1">
            </form>
        </div>
        @push('scripts')
    <style>#contactFormContainer .success { opacity: 0; }</style>
        @endpush
        <div class="success absolute top-0 left-0 w-full h-full flex items-center justify-center text-lg text-gray-800">
            <span>Thank you for your submission! We will be in touch shortly.</span>
        </div>
    </div>
</div>

