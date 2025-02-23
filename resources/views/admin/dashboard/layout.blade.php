<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg"
    data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">
<head>
    @include('admin.dashboard.components.head')
</head>

<body>
    <div
        class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">
        @include('admin.dashboard.components.sidebar')
        @include('admin.dashboard.components.navbar')
        @include($template)
    </div>
    @include('admin.dashboard.components.script')
</body>

</html>
