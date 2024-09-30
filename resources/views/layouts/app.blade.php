<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tickets</title>
    @vite('resources/css/app.css')

    <style>
        .collapsed .sidebar-content span {
            display: none;
        }
        .collapsed .sidebar-header h2 {
            display: none;
        }
        .collapsed .sidebar-header img {
            display: block;
        }
        #sidebar {
            overflow-y: auto;
        }
        /* Active link style */
        .active-link {
            background-color: #6b8f5e;
            border-left: 4px solid #d1d5db;
            color: white;
        }
    </style>
</head>
<body class="flex flex-col h-screen bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-[#87ab69] shadow-md px-4 py-3">
        <div class="flex justify-between items-center">
            <div class="flex items-center">
                <button id="toggle-btn" class="mr-4 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="white" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </button>
                <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-white">Lorem Ipsum</a>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Profile Dropdown -->
                <div class="relative">
                    <button id="profile-menu" class="focus:outline-none">
                        
                        <div class="flex items-center space-x-2">
                            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c-4.418 0-8 3.582-8 8h16c0-4.418-3.582 -8-8-8z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" />
                                </svg>
                            </div>
                            <!-- Display User's Name -->
                            <span class="text-white">{{ Auth::user()->name }}</span>
                        </div>
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="dropdown" class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md hidden">
                        <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-red-200">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex h-full flex-1">
        <!-- Sidebar -->
        <div class="transition-all duration-300 w-64 h-full px-4 py-8" style="background-color: #87ab69; color: white;" id="sidebar">
            <div class="flex items-center justify-between sidebar-header">
                <h2 class="text-lg font-semibold">Menu</h2>
            </div>

            <nav class="mt-10 sidebar-content space-y-2">
                
                <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded-md hover:bg-green-600 {{ request()->routeIs('dashboard') ? 'active-link' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                    </svg>
                    <span class="mx-4">Dashboard</span>
                </a>
               
                
                
                <a href="{{ route('issues.index') }}" class="flex items-center p-2 rounded-md hover:bg-green-600 {{ request()->routeIs('issues.index') ? 'active-link' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
</svg>
                    <span class="mx-4">Status Ticket
                </a>
                <a href="{{ route('request.index') }}" class="flex items-center p-2 rounded-md hover:bg-green-600 {{ request()->routeIs('request.index') ? 'active-link' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
</svg>

                    <span class="mx-4">Status Request System</span>
                </a>
                <a href="{{ route('issues.create') }}" class="flex items-center p-2 rounded-md hover:bg-green-600 {{ request()->routeIs('issues.create') ? 'active-link' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
</svg>


                    <span class="mx-4">Create Ticket Issue</span>
                </a>
                <a href="{{ route('request.create') }}" class="flex items-center p-2 rounded-md hover:bg-green-600  {{ request()->routeIs('request.create') ? 'active-link' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 10.5v6m3-3H9m4.06-7.19-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
</svg>

                    <span class="mx-4">Create Request System</span>
                </a>
                
            
                <a href="{{ route('report.show') }}" class="flex items-center p-2 rounded-md hover:bg-green-600  {{ request()->routeIs('report.show') ? 'active-link' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
</svg>
<span class="mx-4">Reports</span>
</a>
                <a href="{{ route('logout') }}" class="flex items-center p-2 rounded-md text-red-600 hover:bg-red-200 hover:text-red-600 ">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1 0 12.728 0M12 3v9" />
</svg>

    <span class="mx-5">Log Out</span>
</a>

            </nav>
            </div>

        
<div class="flex-1 p-6 bg-gray-100">
    @yield('content')
</div>
</div>

<script>
document.getElementById("toggle-btn").addEventListener("click", function () {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("w-64");
    sidebar.classList.toggle("w-16");
    sidebar.classList.toggle("collapsed");
});

document.getElementById("profile-menu").addEventListener("click", function () {
    const dropdown = document.getElementById("dropdown");
    dropdown.classList.toggle("hidden");
});
</script>
</body>
</html>

