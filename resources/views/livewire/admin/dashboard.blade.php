<div>
    <!-- HEADER -->
    <x-header :title="$title" separator progress-indicator />

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
        <x-stat
            title="Total Users"
            value="{{ $totalUsers }}"
            icon="o-users"
            color="text-primary" />

        <x-stat
            title="Active Users"
            value="{{ $approvedUsers }}"
            icon="o-users"
            class="text-green-500"
            color="text-green-500" />

        <x-stat
            title="Pending Users"
            value="{{ $pendingUsers }}"
            icon="o-users"
            class="text-yellow-500"
            color="text-yellow-500" />

        <x-stat
            title="Rejected Users"
            value="{{ $rejectedUsers }}"
            icon="o-no-symbol"
            class="text-red-500"
            color="text-red-500" />

        <x-stat
            title="Inactive Users"
            value="{{ $inactiveUsers }}"
            icon="o-archive-box-x-mark"
            class="text-gray-500"
            color="text-gray-500" />
    </div>
</div>
