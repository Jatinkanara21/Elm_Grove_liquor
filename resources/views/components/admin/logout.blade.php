<form method="POST" action="{{ route('admin.logout') }}"
      data-confirm="Are you sure you want to logout?" data-confirm-title="Logout" data-confirm-label="Logout">
    @csrf
    <button type="submit" {{ $attributes->class(['inline-flex items-center justify-center']) }}>{{ $slot }}</button>
</form>