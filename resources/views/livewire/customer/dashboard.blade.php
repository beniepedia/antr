<div class="grid gap-4">
  <h2 class="text-lg font-semibold">Dashboard Customer</h2>
  <div class="card">
    <div class="card-body">
      <p>Nomor antrean aktif: <span class="font-bold">—</span></p>
      <a class="btn btn-primary mt-3" href="{{ route('customer.queues.create') }}" wire:navigate>Ambil tiket baru</a>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <p>Riwayat antrean (stub)</p>
    </div>
  </div>
</div>
