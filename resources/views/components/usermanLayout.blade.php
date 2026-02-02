<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>eKalendaryo</title>
    @vite(['resources/css/userman/UserManDashboard.css', 'resources/js/userman/UserManDashboard.js'])

    <style>
        /* --- MENU BUTTON STYLES --- */
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
                display: none; /* hide nav on mobile */
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
                display: flex; /* show nav when active */
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
            {{-- <span>User Management</span> --}}
        </div>
        <form action="{{ route('UserManagement.logout') }}" method="post">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </header>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="{{ route('UserManagement.dashboard') }}" class="nav_item {{ request()->routeIs('UserManagement.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('UserManagement.calendar') }}" class="nav_item {{ request()->routeIs('UserManagement.calendar') ? 'active' : '' }}">Calendar</a>
        <a href="{{ route('UserManagement.users') }}" class="nav_item {{ request()->routeIs('UserManagement.users') ? 'active' : '' }}">Users</a>
        <a href="{{ route('UserManagement.archive') }}" class="nav_item {{ request()->routeIs('UserManagement.archive') ? 'active' : '' }}">Archive</a>
        <a href="{{ route('UserManagement.profile') }}" class="nav_item {{ request()->routeIs('UserManagement.profile') ? 'active' : '' }}">Profile</a>
    </nav>

    <!-- MAIN SLOT -->
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

            // Existing tab highlight/loadTab code
            navItems.forEach(item => {
                item.addEventListener("click", () => {
                    navItems.forEach(i => i.classList.remove("active"));
                    item.classList.add("active");

                    if (item.dataset.page) {
                        loadTab(item.dataset.page);
                    }
                });
            });

            // Reload if loaded from bfcache
            window.addEventListener('pageshow', function (event) {
                if (event.persisted) {
                    window.location.reload();
                }
            });
        });
    </script>
</body>

</html>
