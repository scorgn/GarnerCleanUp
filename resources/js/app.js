require('./bootstrap');
const _ = require('underscore');
import isEmail from "validator/es/lib/isEmail";
import isMobilePhone from "validator/es/lib/isMobilePhone";
const alertify = require('alertifyjs');
const axios = require('axios');
console.log("Script started");

function myInitCode() {
    let scrollToSubscribeElement = document.getElementById("scrollToSubscribe");
    if (scrollToSubscribeElement) {
        scrollToSubscribeElement.addEventListener('click', (e) => {
            scrollToSubscribe();
        })
    }

    let formElement = document.getElementById("subscribeForm");
    formElement.addEventListener('submit', (e) => {
        e.preventDefault();
        submitSubscribe();
    })

    let contactFormElement = document.getElementById("contactForm");
    contactFormElement.addEventListener('submit', (e) => {
        e.preventDefault();
        submitContact();
    })
}

var contactCaptchaId, subscribeCaptchaId;

function renderReCaptchas() {
    let siteKey = document.getElementById('recaptcha-site-key').innerText;

    let contactCaptcha = document.getElementById('g-recaptcha-contact');
    contactCaptchaId = grecaptcha.render(contactCaptcha, {
        sitekey: siteKey,
        size: 'invisible',
        callback: postContact,
        isolate: true,
    });

    let subscribeCaptcha = document.getElementById('g-recaptcha-subscribe');
    subscribeCaptchaId = grecaptcha.render(subscribeCaptcha, {
        sitekey: siteKey,
        size: 'invisible',
        callback: postSubscribe,
        isolate: true,
    });
}

var recaptchaOnLoad = function () {
    if( document.readyState !== 'loading' ) {
        renderReCaptchas();
    } else {
        document.addEventListener('DOMContentLoaded', function () {
            renderReCaptchas();
        });
    }
}

window.recaptchaOnLoad = recaptchaOnLoad;

let scrollTimeout;
let scrollFinishedChecker;

let checkIfFinishedScrolling = function(e) {
    clearTimeout(scrollTimeout);

    scrollTimeout = setTimeout(function () {
        document.getElementById("subscribeForm").classList.add('animate-pulse-fast-2x');

        removeTheEventListener();

        setTimeout(function () {
            document.getElementById("subscribeForm").classList.remove('animate-pulse-fast-2x')
        }, 2000)
    }, 30);
}
let removeTheEventListener = function () {
    console.log("Remove the event listener");
    removeEventListener('scroll', scrollFinishedChecker)
}

let scrollToSubscribe = function() {
    let subscribeForm = document.getElementById("subscribeForm");

    subscribeForm.scrollIntoView({
        behavior: "smooth",
        block: "center",
        inline: "nearest"
    });

    scrollFinishedChecker = _.throttle(checkIfFinishedScrolling, 10)
    addEventListener('scroll', scrollFinishedChecker);
}

var canSubmit = {
    contactForm: true,
    subscribeForm: true,
};

function submitSubscribe() {
    if (canSubmit.subscribeForm === false) {
        return;
    }

    let formInput = document.getElementById("subscribeEmail");

    if (!isEmail(formInput.value)) {
        initError("Please enter a valid email address");
        return
    }

    formLoading('subscribeForm');
    grecaptcha.execute(subscribeCaptchaId);
}

function postSubscribe(captcha)
{
    console.log(captcha);
    let formData = getFormData("subscribeForm");

    axios.post('/api/subscribe', formData, {
        responseType: "json"
    }).then(() => {
        successfulSubscribe();
    }).catch((error) => {
        initError(getErrorMessage(error));
    }).then(() => {
        formNotLoading('subscribeForm');
        grecaptcha.reset(subscribeCaptchaId);
    });
}

function getErrorMessage(error) {
    console.log(error);
    if (!error.hasOwnProperty("response") || !error.response.hasOwnProperty("data")) {
        return defaultErrorMessage();
    }

    if (error.response.data.hasOwnProperty('errors')) {
        let errors = error.response.data.errors;
        let errorGroup = errors[Object.keys(errors)[0]];
        if (errorGroup && isArray(errorGroup)) {
            return _.first(errorGroup);
        }
    }

    if (error.response.data.hasOwnProperty("message")) {
        return error.response.data.message;
    }


    return defaultErrorMessage();
}

function defaultErrorMessage()
{
    return "There was an unexpected error with your request. Please try again later."
}

function initError(message, input) {
    input = input || document.getElementById("subscribeForm");

    alertify.error(message);

    if (input) {
        shakeInput(input);
    }
}

function shakeInput(input) {
    input.classList.add("animate-error");
    setTimeout(function() {
        input.classList.remove("animate-error");
    }, 620);
}

function successfulSubscribe() {
    let formElement = document.getElementById("subscribeFormContainer");

    formElement.classList.add("complete");
}

let submitContact = function()
{
    if (canSubmit.contactForm === false) {
        return false;
    }

    let formData = getFormData("contactForm");

    let contactNameInput = document.getElementById("contactName");
    let contactEmailInput = document.getElementById("contactEmail");
    let contactPhoneInput = document.getElementById("contactPhone");
    let contactMessageInput = document.getElementById("contactMessage");

    if (!formData.hasOwnProperty("name") || formData.name.length === 0) {
        return initError("Please enter your name.", contactNameInput);
    }

    if ((!formData.hasOwnProperty("email") || formData.email.length === 0)
        && (!formData.hasOwnProperty("phone") || formData.phone.length === 0)
    ) {
        return initError("You must provide either an email address or a phone number.", contactEmailInput);
    }

    if (formData.hasOwnProperty("phone") && formData.phone.length > 0 && !isMobilePhone(formData.phone)) {
        return initError("Invalid phone number.", contactPhoneInput);
    }

    if (formData.hasOwnProperty("email") && formData.email.length > 0 && !isEmail(formData.email)) {
        return initError("Invalid email address.", contactEmailInput);
    }

    if (!formData.hasOwnProperty("message") || formData.message.length === 0) {
        return initError("Please enter a message.", contactMessageInput);
    }

    formLoading("contactForm");
    grecaptcha.execute(contactCaptchaId);
}


function formLoading(formId, maxMilliseconds = 10000)
{
    canSubmit[formId] = false;
    document.getElementById(formId).classList.add('loading');

    if (maxMilliseconds !== 0) {
        setTimeout(function () {
            formNotLoading(formId);
        }, maxMilliseconds)
    }
}

function formNotLoading(formId)
{
    canSubmit[formId] = true;
    document.getElementById(formId).classList.remove('loading');
}

function postContact(captcha)
{
    let formData = getFormData("contactForm");

    axios.post('/api/contact', formData, {
        responseType: "json"
    }).then(() => {
        successfulContact();
    }).catch((error) => {
        if (error.hasOwnProperty("response")
            && error.response.hasOwnProperty("data")
            && error.response.data.hasOwnProperty("message")
            && error.response.data.message.length > 0
        ) {
            initError(error.response.data.message);
        } else {
            initError("There was an unexpected error with your request. Please try again later.");
        }
    }).then(() => {
        formNotLoading('contactForm');
        grecaptcha.reset(contactCaptchaId);
    });
}

window.postContact = postContact;

function getFormData(formId) {
    let formData = {};

    let contactForm = document.getElementById(formId);
    Array.from(contactForm.elements).forEach((element) => {
        if (!controlIsSuccessful(element)) {
            return;
        }

        if (element.type === 'checkbox') {
            formData[element.name] = element.checked;
            return;
        }

        formData[element.name] = element.value;
    });

    return formData;
}

/**
 *
 * @param {Element} control
 * @returns {boolean}
 */
function controlIsSuccessful(control) {
    if (control instanceof RadioNodeList) {
        return false;
    }

    if (control.disabled) {
        return false;
    }

    if (control.name === undefined || control.name.length === 0) {
        return false;
    }

    if (control.value === undefined || control.value.length === 0) {
        return false;
    }

    return true;
}

function successfulContact() {
    let formElement = document.getElementById("contactFormContainer");

    formElement.classList.add("complete");
}

if( document.readyState !== 'loading' ) {
    console.log( 'document is already ready, just execute code here' );
    myInitCode();
} else {
    document.addEventListener('DOMContentLoaded', function () {
        console.log( 'document was not ready, place code here' );
        myInitCode();
    });
}
