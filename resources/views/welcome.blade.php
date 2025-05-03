<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />


    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            @if (Route::has('login'))
                <nav class="flex items-center justify-end gap-4">
                    @auth
                        <a
                            href="{{ url('/admin/dashboard') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                        >
                            Log in
                        </a>

                        {{-- @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                                Register
                            </a>
                        @endif --}}
                    @endauth
                </nav>
            @endif
        </header>
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row gap-10 items-center">
                <div class="flex-1">
                    <h1 class="text-3xl lg:text-4xl font-bold text-[#1b1b18] dark:text-white mb-4">Selamat Datang 👋</h1>
                    <p class="text-base lg:text-lg text-gray-600 dark:text-gray-400 mb-6">
                        Saya <strong>Aryunda Juante</strong>, seorang profesional yang berdedikasi dalam bidang <em>Teknik Informasi</em>. Di halaman ini, Anda dapat melihat informasi lengkap tentang pengalaman, pendidikan, dan keterampilan saya.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('login') }}" class="bg-[#1b1b18] text-white px-5 py-2 rounded-md text-sm hover:bg-[#333] transition">Masuk untuk Melihat CV Lengkap</a>
                        <a href="#tentang" class="border border-[#1b1b18] dark:border-white px-5 py-2 rounded-md text-sm text-[#1b1b18] dark:text-white hover:bg-gray-100 dark:hover:bg-[#1b1b18] dark:hover:text-white transition">Pelajari Lebih Lanjut</a>
                    </div>
                </div>

                <div class="flex-1">
                    <img src="https://source.unsplash.com/500x400/?professional,technology" alt="Illustration" class="rounded-xl shadow-lg w-full h-auto object-cover" />
                </div>
            </main>

        </div>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
