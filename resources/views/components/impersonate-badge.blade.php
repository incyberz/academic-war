@if (session()->has('impersonated_by'))
	<div class="fixed bottom-4 right-4 z-50 w-80 bg-red-600 text-white p-4 rounded shadow-lg">

		<div class="flex flex-col gap-2">

			<div>
				Anda sedang impersonate sebagai
				<strong>{{ Auth::user()->name }}</strong>.
			</div>

			<a class="underline font-semibold hover:opacity-80" href="{{ route('impersonate.leave') }}">
				← Kembali ke akun asli
			</a>

		</div>

	</div>
@endif
