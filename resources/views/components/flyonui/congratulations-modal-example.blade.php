<!-- Contoh penggunaan dasar -->
<x-flyonui.congratulations-modal />

<!-- Contoh penggunaan dengan atribut kustom -->
<x-flyonui.congratulations-modal
    id="my-custom-modal"
    title="Well Done!"
    message="Your account has been successfully created!<br>Welcome to our platform."
    thankYouMessage="We're glad to have you with us!"
    buttonText="Get Started"
    buttonAction="/dashboard"
    triggerText="Create Account"
    class="bg-gray-100 h-screen py-12"
/>