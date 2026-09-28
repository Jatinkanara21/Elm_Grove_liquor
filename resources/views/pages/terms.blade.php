@extends('layouts.app')

@section('title', 'Terms of Service | Elm Grove Liquor')
@section('meta_description', 'Terms of Service for Elm Grove Liquor.')

@section('content')
    <x-page-hero title="Terms of Service" />

    <div class="container-x section max-w-3xl space-y-10">
        <section>
            <h2>Welcome to Elm Grove Liquor</h2>
            <p class="mt-3 leading-relaxed text-ink/80">
                These terms and conditions outline the rules and regulations for the use of Elm Grove Liquor's website.
            </p>
        </section>

        <section>
            <h2>License to Use Website</h2>
            <p class="mt-3 leading-relaxed text-ink/80">
                Unless otherwise stated, Elm Grove Liquor owns the intellectual property rights to all material on this website. All intellectual property rights are reserved. You may view and print pages from the website for personal use, subject to restrictions set in these terms and conditions.
            </p>
        </section>

        <section>
            <h2>User Responsibilities</h2>
            <p class="mt-3 leading-relaxed text-ink/80">
                In these terms and conditions, "User" or "you" refers to the person that accesses this website and accepts the company's terms and conditions. You agree not to reproduce, duplicate, copy, trade, resell or exploit any portion of this website for any commercial purposes.
            </p>
        </section>

        <section id="age-requirement">
            <h2>Age Requirement</h2>
            <p class="mt-3 leading-relaxed text-ink/80">
                By accessing this website, you confirm that you are at least 21 years of age and of legal drinking age in your jurisdiction. You are responsible for complying with all applicable laws and regulations in your area regarding the consumption of alcoholic beverages.
            </p>
        </section>

        <section>
            <h2>Disclaimers</h2>
            <p class="mt-3 leading-relaxed text-ink/80">
                The information on this website is provided on an "as is" basis. Elm Grove Liquor makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.
            </p>
        </section>

        <section>
            <h2>Limitation of Liability</h2>
            <p class="mt-3 leading-relaxed text-ink/80">
                In no event shall Elm Grove Liquor or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption) arising out of the use or inability to use the materials on this website, even if we have been notified orally or in writing of the possibility of such damage.
            </p>
        </section>

        <section>
            <h2>Contact Us</h2>
            <p class="mt-3 leading-relaxed text-ink/80">
                If you have any questions about these Terms, please contact us at <a href="mailto:{{ \App\Models\Setting::get('email') ?: 'contact@example.com' }}" class="font-semibold text-mahogany hover:underline">{{ \App\Models\Setting::get('email') ?: 'contact@example.com' }}</a>.
            </p>
        </section>
    </div>
@endsection