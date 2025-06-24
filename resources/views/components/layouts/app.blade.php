<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- EasyMDE --}}
    <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
</head>
<body class="min-h-screen font-sans antialiased bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-brand />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main full-width full-height>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <x-app-brand class="px-5 pt-4" />

            {{-- MENU --}}
            <x-menu activate-by-route>

                <x-menu-separator />

                @if(Auth()->user()->hasRole(\App\Models\User::ROLE_STUDENT))
                    <x-menu-item title="Dashboard" icon="o-sparkles" link="{{ route('student.dashboard') }}" />
                    <x-menu-item title="Projects" icon="o-book-open" link="{{ route('student.projects.index') }}" />
                    <x-menu-item title="My Projects" icon="o-book-open" link="{{ route('student.projects.self') }}" />
                    <x-menu-item title="Project Requests" icon="o-book-open" link="{{ route('student.projects.requests') }}" />
                @elseif(Auth()->user()->hasRole(\App\Models\User::ROLE_SUPERVISOR))
                    <x-menu-item title="Dashboard" icon="o-sparkles" link="{{ route('supervisor.dashboard') }}" />
                    <x-menu-item title="Projects" icon="o-book-open" link="{{ route('supervisor.projects.index') }}" />
                    <x-menu-item title="My Projects" icon="o-book-open" link="{{ route('supervisor.projects.self') }}" />
                @elseif(Auth()->user()->hasRole(\App\Models\User::ROLE_MODERATOR))
                    <x-menu-item title="Dashboard" icon="o-sparkles" link="{{ route('moderator.dashboard') }}" />
                    <x-menu-item title="My Projects" icon="o-book-open" link="{{ route('moderator.projects.self') }}" />
{{--                @elseif(Auth()->user()->hasRole(\App\Models\User::ROLE_EXAMINER))--}}
{{--                    <x-menu-item title="Dashboard" icon="o-sparkles" link="{{ route('examiner.dashboard') }}" />--}}
                @elseif(Auth()->user()->hasRole(\App\Models\User::ROLE_ADMIN))
                    <x-menu-item title="Dashboard" icon="o-sparkles" link="{{ route('admin.dashboard') }}" />
                    <x-menu-item title="Users" icon="o-users" link="{{ route('admin.users.index') }}" />
                    <x-menu-item title="Reports" icon="o-clipboard-document-list" link="{{ route('admin.reports.index') }}" />
                @endif

                <x-menu-item title="Profile" icon="m-user" link="{{ route('profile') }}" />

                {{--                <x-menu-sub title="Settings" icon="o-cog-6-tooth">--}}
                {{--                    <x-menu-item title="Wifi" icon="o-wifi" link="####" />--}}
                {{--                    <x-menu-item title="Archives" icon="o-archive-box" link="####" />--}}
                {{--                </x-menu-sub>--}}

                {{-- User --}}
                @if($user = auth()->user())
                    <x-menu-separator />

                    <x-list-item :item="$user" value="name" sub-value="email" no-separator no-hover class="mx-2 !-my-2 rounded">
                        <x-slot:actions>
                            <x-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff" no-wire-navigate link="/logout" />
                        </x-slot:actions>
                    </x-list-item>

                    <x-menu-separator />
                @endif

            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{--  TOAST area --}}
    <x-toast />
</body>
</html>
