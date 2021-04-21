<footer class="bg-blue-gray-800 text-gray-300 text-sm font-light text-left p-5 flex flex-col md:flex-row md:justify-around">
    <p class="mt-4 mb-8 mx-auto md:hidden">Clean Up Garner by Shawn Corrigan</p>
    <div class="mx-auto md:mx-0 flex flex-col">
        <p class="flex flex-row items-start md:items-center py-2 border-b md:border-b-0 border-t md:border-t-0 border-blue-gray-700"><span class="leading-5"><i class="fas fa-home mr-2 leading-5"></i></span><span class="leading-5 block"><span class="block">@config('address-line-1')</span><span class="block">@config('address-line-2')</span></span></p>
        <a href="tel:@config('phone-href')" class="flex flex-row items-center py-2 border-b md:border-b-0 border-blue-gray-700"><i class="fas fa-phone mr-2"></i>@config('phone')</a>
        <a href="mailto:@config('email')" class="flex flex-row items-center py-2 border-b md:border-b-0 border-blue-gray-700"><i class="fas fa-home mr-2"></i>@config('email')</a>
    </div>
    <div class="border-l border-blue-gray-700 hidden md:block lg:hidden"></div>
    <div class="flex flex-col md:justify-center">
        <p class="mb-8 md:mb-0 mx-auto hidden md:block md:py-1">Clean Up Garner by Shawn Corrigan</p>
        <a href="{{ url('privacy-policy') }}" class="text-center mt-5 md:mt-0 py-2 md:py-1 text-gray-400">Privacy Policy</a>
    </div>
</footer>
