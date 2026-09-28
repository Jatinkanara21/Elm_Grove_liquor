@php
    use App\Models\Setting;
    $phone = Setting::get('phone');
    $email = Setting::get('email');
    $address = Setting::get('address');
    $hours = Setting::get('opening_hours');
    $instagram = Setting::get('instagram_url');
    $facebook = Setting::get('facebook_url');
@endphp

<footer class="bg-espresso text-cream/80">
    <div class="container-x py-14 lg:py-16">
        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">

            <div>
                <a href="{{ route('home') }}" aria-label="{{ config('app.name') }} home"><x-logo light class="!items-start" /></a>
                <p class="mt-5 max-w-xs text-sm leading-relaxed">
                    Quality spirits, wines, and beverages. Discover our selection and find a store near you.
                </p>
            </div>

            <nav aria-label="Footer navigation">
                <h3 class="font-sans text-xs font-semibold uppercase tracking-[0.25em] !text-gold">Navigation</h3>
                <ul class="mt-4 space-y-1">
                    @foreach ($navLinks as $link)
                        <li>
                            <a href="{{ route($link['route']) }}" class="inline-flex min-h-9 items-center text-sm hover:text-gold">{{ $link['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div>
                <h3 class="font-sans text-xs font-semibold uppercase tracking-[0.25em] !text-gold">Contact</h3>
                <ul class="mt-4 space-y-3 text-sm">
                    @if ($phone)
                        <li><a href="tel:{{ preg_replace('/[^\d+]/', '', $phone) }}" class="hover:text-gold">{{ $phone }}</a></li>
                    @endif
                    @if ($email)
                        <li><a href="mailto:{{ $email }}" class="break-all hover:text-gold">{{ $email }}</a></li>
                    @endif
                    @if ($address)
                        <li class="whitespace-pre-line">{{ $address }}</li>
                    @endif
                    @if ($hours)
                        <li class="whitespace-pre-line text-cream/70">{{ $hours }}</li>
                    @endif
                    @unless ($phone || $email || $address || $hours)
                        <li class="text-cream/60">Contact details coming soon.</li>
                    @endunless
                </ul>
            </div>

            <div>
                <h3 class="font-sans text-xs font-semibold uppercase tracking-[0.25em] !text-gold">Follow &amp; Legal</h3>
                <ul class="mt-4 space-y-1 text-sm">
                    @if ($instagram)
                        <li><a href="{{ $instagram }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-9 items-center hover:text-gold">Instagram</a></li>
                    @endif
                    @if ($facebook)
                        <li><a href="{{ $facebook }}" target="_blank" rel="noopener noreferrer" class="inline-flex min-h-9 items-center hover:text-gold">Facebook</a></li>
                    @endif
                    <li><a href="{{ route('privacy') }}" class="inline-flex min-h-9 items-center hover:text-gold">Privacy Policy</a></li>
                    <li><a href="{{ route('terms') }}" class="inline-flex min-h-9 items-center hover:text-gold">Terms</a></li>
                    <li><a href="{{ route('terms') }}#age-requirement" class="inline-flex min-h-9 items-center hover:text-gold">Age Requirement</a></li>
                    <li><a href="{{ url('/admin/login') }}" class="inline-flex min-h-9 items-center hover:text-gold">Admin Login</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-12 border-t border-cream/10 pt-6 text-center text-xs text-cream/60">
            &copy; {{ now()->year }} Elm Grove Liquor. All rights reserved.
        </div>
    </div>
</footer>