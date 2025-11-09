<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-rose-700">Teman</h2>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-b from-rose-100 to-rose-200 py-10">
        <div class="max-w-3xl mx-auto space-y-8">

            @if(session('success'))
                <div class="flash p-3 rounded-lg bg-green-100 border border-green-300 text-green-700">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flash p-3 rounded-lg bg-red-100 border border-red-300 text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Tambah Teman --}}
            <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-md">
                <h3 class="text-lg font-semibold text-rose-700 mb-3">Tambah Teman</h3>
                <form action="{{ route('friends.send') }}" method="POST" class="flex gap-2">
                    @csrf
                    <input type="email" name="email"
                        class="flex-1 border-b border-rose-300 bg-transparent focus:border-rose-600 focus:ring-0 outline-none p-1"
                        placeholder="Masukkan email teman..." required>
                    <button class="px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-full transition">
                        Kirim
                    </button>
                </form>
            </div>

            {{-- Daftar Teman --}}
            <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-md">
                <h3 class="text-lg font-semibold text-rose-700 mb-3">Daftar Teman</h3>
                @forelse($friends as $f)
                    <div class="flex items-center justify-between p-3 border-b border-rose-100">
                        <div class="flex items-center gap-3">
                            <img src="{{ $f->avatar ? asset('storage/'.$f->avatar) : asset('images/default-avatar.png') }}"
                                 class="w-9 h-9 rounded-full object-cover border-2 border-rose-200">
                            <span class="text-rose-700">{{ $f->name }}</span>
                            <span class="text-xs {{ $f->is_online ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $f->is_online ? 'Online' : 'Offline' }}
                            </span>
                        </div>
                        <form action="{{ route('friends.remove', $f->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:underline text-sm">Hapus</button>
                        </form>
                    </div>
                @empty
                    <p class="text-gray-600 text-sm">Belum ada teman.</p>
                @endforelse
            </div>

            {{-- Permintaan Masuk (pending) --}}
            <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-md">
                <h3 class="text-lg font-semibold text-rose-700 mb-3">Permintaan Masuk</h3>
                @forelse($incoming as $req)
                    <div class="flex items-center justify-between p-3 border-b border-rose-100">
                        <span class="text-rose-700">{{ $req->requester->name }}</span>
                        <div class="flex gap-3">
                            <form method="POST" action="{{ route('friends.accept', $req->id) }}">@csrf
                                <button class="text-green-600 hover:underline text-sm">Terima</button>
                            </form>
                            <form method="POST" action="{{ route('friends.reject', $req->id) }}">@csrf
                                <button class="text-red-600 hover:underline text-sm">Tolak</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 text-sm">Tidak ada permintaan masuk.</p>
                @endforelse
            </div>

            {{-- Permintaan Terkirim (pending + rejected) --}}
            <div class="bg-white/80 backdrop-blur-sm p-6 rounded-2xl shadow-md">
                <h3 class="text-lg font-semibold text-rose-700 mb-3">Permintaan Terkirim</h3>
                @forelse($outgoing as $req)
                    <div class="flex items-center justify-between p-3 border-b border-rose-100">
                        <span class="text-gray-700 text-sm">{{ $req->receiver->name }}</span>
                        <div class="flex items-center gap-3">
                            @if($req->status === 'rejected')
                                <span class="text-red-500 text-xs italic">Ditolak</span>
                                <form method="POST" action="{{ route('friends.clear', $req->id) }}">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-400 hover:text-red-600 text-sm">x</button>
                                </form>
                            @else
                                <span class="italic text-gray-500 text-sm">Menunggu…</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 text-sm">Tidak ada permintaan terkirim.</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
          document.querySelectorAll('.flash').forEach(el => el.remove());
        }, 5000);
      });
    </script>
</x-app-layout>
