@extends('layouts.app')

@section('title', 'Privacy Policy | Elm Grove Liquor')
@section('meta_description', 'Privacy Policy for Elm Grove Liquor.')

@section('content')
    <x-page-hero title="Privacy Policy" />

    <div class="container-x section max-w-3xl space-y-10">
        <section>
            <h2>Introduction</h2>
            <p class="mt-3 leading-relaxed text-ink/80">
                Elm Grove Liquor ("we," "us," or "our") operates the website. This page informs you of our policies regarding the collection, use, and disclosure of personal data when you use our Service and the choices you have associated with that data.
            </p>
        </section>

        <section>
            <h2>Information Collection and Use</h2>
            <p class="mt-3 leading-relaxed text-ink/80">
                We collect several different types of information for various purposes to provide and improve our Service to you.
            </p>
            <ul class="mt-4 space-y-2 text-ink/80">
                <li><strong>Personal Data:</strong> While using our Service, we may ask you to provide us with certain personally identifiable information that can be used to contact or identify you ("Personal Data"). This may include, but is not limited to: Email address, Name, Phone number.</li>
                <li><strong>Usage Data:</strong> We may also collect information on how the Service is accessed and used ("Usage Data"). This may include information such as your computer's Internet Protocol address, browser type, pages visited, time and date of visit.</li>
            </ul>
        </section>

        <section>
            <h2>Security of Data</h2>
            <p class="mt-3 leading-relaxed text-ink/80">
                The security of your data is important to us, but remember that no method of transmission over the Internet or method of electronic storage is 100% secure. While we strive to use commercially acceptable means to protect your Personal Data, we cannot guarantee its absolute security.
            </p>
        </section>

        <section>
            <h2>Contact Us</h2>
            <p class="mt-3 leading-relaxed text-ink/80">
                If you have any questions about this Privacy Policy, please contact us at <a href="mailto:{{ \App\Models\Setting::get('email') ?: 'contact@example.com' }}" class="font-semibold text-mahogany hover:underline">{{ \App\Models\Setting::get('email') ?: 'contact@example.com' }}</a>.
            </p>
        </section>
    </div>
@endsection