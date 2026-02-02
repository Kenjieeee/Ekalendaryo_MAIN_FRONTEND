<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>eKalendaryo</title>
    @vite(['resources/css/editor/dashboard.css', 'resources/js/editor/dashboard.js'])

    <style>
        /* Menu button */
        .menu-btn {
            display: none;
            font-size: 1.6rem;
            cursor: pointer;
            border: none;
            background: none;
            color: #064420;
        }

        @media (max-width: 900px) {
            .header {
                flex-wrap: wrap;
                justify-content: space-between;
                padding: 10px 15px;
            }

            .logo img {
                width: 100px;
                height: auto;
            }

            .navbar {
                display: none; /* hide nav by default on mobile */
                flex-direction: column;
                width: 100%;
                padding-left: 0;
                gap: 0;
                border-top: 1px solid #cde3d3;
            }

            .nav_item {
                padding: 12px 20px;
                border-bottom: 1px solid #cde3d3;
            }

            .menu-btn {
                display: block; /* show menu button on mobile */
            }

            .navbar.active {
                display: flex; /* show nav when menu is active */
            }
        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <header class="header">
        <div class="logo">
            <img src="{{ asset('img/BPCLOGO.png') }}" alt="BPC Logo" style="width: 60px;">
            <img src="{{ asset('img/Main_logo.png') }}" alt="eKalendaryo Logo">
        </div>
        <form action="{{ route('Editor.logout') }}" method="post">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </header>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="{{ route('Editor.dashboard') }}" class="nav_item {{ request()->routeIs('Editor.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('Editor.calendar') }}" class="nav_item {{ request()->routeIs('Editor.calendar') ? 'active' : '' }}">Calendar</a>
        <a href="{{ route('Editor.index') }}" class="nav_item {{ request()->routeIs('Editor.index') ? 'active' : '' }}">Manage Events</a>
        <a href="{{ route('Editor.activity_log') }}" class="nav_item {{ request()->routeIs('Editor.activity_log') ? 'active' : '' }}">Activity Log</a>
        <a href="{{ route('Editor.history') }}" class="nav_item {{ request()->routeIs('Editor.history') ? 'active' : '' }}">History</a>
        <a href="{{ route('Editor.archive') }}" class="nav_item {{ request()->routeIs('Editor.archive') ? 'active' : '' }}">Archive</a>
        <a href="{{ route('Editor.profile') }}" class="nav_item {{ request()->routeIs('Editor.profile') ? 'active' : '' }}">Profile</a>
    </nav>

    <!-- MAIN CONTENT -->
    {{ $slot }}

    <!-- JS -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const header = document.querySelector(".header");
            const navbar = document.querySelector(".navbar");

            // Create menu button
            const menuBtn = document.createElement("button");
            menuBtn.classList.add("menu-btn");
            menuBtn.innerHTML = "☰"; // hamburger icon
            header.prepend(menuBtn);

            // Toggle navbar on click
            menuBtn.addEventListener("click", () => {
                navbar.classList.toggle("active");
            });

            // Close navbar on mobile when clicking a nav item
            const navItems = document.querySelectorAll(".nav_item");
            navItems.forEach(item => {
                item.addEventListener("click", () => {
                    if (window.innerWidth <= 900) {
                        navbar.classList.remove("active");
                    }
                });
            });

            // Tab highlighting / loadTab logic
            navItems.forEach(item => {
                item.addEventListener("click", () => {
                    navItems.forEach(i => i.classList.remove("active"));
                    item.classList.add("active");
                    if (item.dataset.page) {
                        loadTab(item.dataset.page);
                    }
                });
            });

            // Reload if page loaded from bfcache
            window.addEventListener('pageshow', function (event) {
                if (event.persisted) {
                    window.location.reload();
                }
            });
        });
    </script>
</body>

</html>
