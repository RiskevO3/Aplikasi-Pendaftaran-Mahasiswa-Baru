<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="dashboard" x-cloak>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-col justify-center items-center gap-2 py-2 px-4">
                    <h1 class="text-white text-2xl font-bold">Selamat datang di aplikasi PSSB!</h1>
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/R4Hv7pffuwo?si=a0B9GdAlKgAYemA-" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    @if(Auth::user()->role != 'admin')
                    <div class="flex justify-center items-center w-full mt-5">
                        <a href="{{ route("register-form") }}" class="font-bold text-center w-1/2 bg-green-500 py-2 px-4 rounded-md hover:opacity-85 hover:scale-95 transition ease-in">Daftar Disini!</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    document.addEventListener('alpine:init',()=>{
        console.log(Alpine);
        Alpine.data('dashboard', () => ({
            message: 'Hello, World!'
        }));
    })
    </script>
</x-app-layout>
