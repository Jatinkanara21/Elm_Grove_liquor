@if (session('success'))
    <div role="status" class="mb-6 rounded-2xl border border-green-700/20 bg-green-50 px-5 py-4 text-sm text-green-900">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any() && ! $errors->hasBag('none'))
    <div role="alert" class="mb-6 rounded-2xl border border-red-700/20 bg-red-50 px-5 py-4 text-sm text-red-900">
        Something went wrong. Please check the highlighted fields and try again.
    </div>
@endif