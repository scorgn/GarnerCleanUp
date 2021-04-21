<?php

$defaults = [
    'title' => 'Clean Up Garner! Community Trash Pickup Events in Garner, NC.',
    'description' => 'Clean Up Garner! A community of people who are interested in cleaning up trash in their local community in Garner, NC.',
    'email' => 'shawn.james.c@gmail.com',
    'phone' => '(919) 809-5371',
    'address-line-1' => '106 Audrey Ct',
    'address-line-2' => 'Garner, NC, 27529',
    'recaptcha-site-key' => env("RECAPTCHA_SITE_KEY"),
];

$defaults['phone-href'] =  preg_replace('/[\D]/', '', $defaults['phone']);

return $defaults;
