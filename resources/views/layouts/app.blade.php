<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ISOCIEL - @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/isociel-logo_ic-blanc-png.png') }}">
    @vite('resources/css/app.css')
    <!-- Include stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.1/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.1/dist/quill.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body class="bg-gray-100 h-screen overflow"><!-- overflow-hidden -->
    <div class="flex flex-col h-screen">

        <div class="container flex flex-col flex-wrap items-center justify-between py-2 mx-auto md:flex-row max-w-7xl">
            <a href="{{ route('home') }}" class="relative z-10 flex items-center w-auto text-2xl font-extrabold leading-none text-black select-none"><img width="100" src="{{ asset('images/Logo-couleur-Transparent.png')}}" alt="ISOCIEL"></a>
            <div>@yield('page_title')</div>
            <!-- Bouton d'avatar avec nom et menu déroulant -->
            <div class="relative z-10 flex items-center space-x-3 md:ml-5 lg:justify-end">
                <!-- Nom de l'utilisateur -->
                <div class="hidden md:block text-gray-600">{{ app\Models\Technicien::findorfail(app\Models\Technicien::getTechId())->nom }} {{ app\Models\Technicien::findorfail(app\Models\Technicien::getTechId())->prenom }}</div>
                <!-- Avatar avec menu déroulant -->
                <div class="relative flex-shrink-0">
                    <button id="avatarButton" class="flex items-center justify-center w-10 h-10 border-2 border-gray-300 rounded-full focus:outline-none">
                        <!-- Placeholder Avatar -->
                        <svg class="w-full h-full text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 0C17.5228 0 22 4.47715 22 10C22 14.6867 17.5228 20 12 20C6.47715 20 2 14.6867 2 10C2 4.47715 6.47715 0 12 0ZM12 2C7.0335 2 3 6.69159 3 10C3 13.8659 7.02944 18 12 18C16.9706 18 21 13.8659 21 10C21 6.69159 16.9665 2 12 2Z"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6 14C6 11.7909 7.79086 10 10 10C12.2091 10 14 11.7909 14 14C14 16.2091 12.2091 18 10 18C7.79086 18 6 16.2091 6 14ZM10 12C8.90714 12 8 12.9071 8 14C8 15.0929 8.90714 16 10 16C11.0929 16 12 15.0929 12 14C12 12.9071 11.0929 12 10 12Z"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20 18C19.8 17.3 19.1 16.8 18.4 16.8C18.3 16.7 18.2 16.7 18.1 16.6C16.7 15.8 14.9 15.3 13 15.3C11.1 15.3 9.3 15.8 7.9 16.6C7.8 16.7 7.7 16.7 7.6 16.8C6.9 16.8 6.2 17.3 6 18C6.5 18 7 18 7.6 18.2C9 18.6 10.5 18.8 12 18.8C13.5 18.8 15 18.6 16.4 18.2C16.9 18 17.4 18 18 18C18.6 18 19.1 18 19.6 18C19.7 18 19.9 18 20 18Z"/>
                        </svg>
                    </button>
                    <!-- Menu déroulant -->
                    <div id="avatarDropdown" class="absolute top-10 right-0 z-10 hidden bg-white border border-gray-300 rounded-md shadow-lg">
                        <a href="#" class="block px-10 py-1 text-sm text-gray-700 hover:bg-gray-100 max-w-xs overflow-hidden whitespace-no-wrap flex items-center rounded-md">
                            <!-- Icône SVG -->
                            <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.5 4.29076C13.0368 4.10325 12.5305 4 12 4C9.79086 4 8 5.79086 8 8C8 10.2091 9.79086 12 12 12C13.1947 12 14.2671 11.4762 15 10.6458M18.2015 1.21321C18.1111 1.34235 18.1111 1.52453 18.1111 1.88889V2.48507C18.0219 2.5166 17.9349 2.55273 17.8504 2.59319L17.4287 2.17155C17.1711 1.91391 17.0423 1.78509 16.887 1.75772C16.8296 1.74759 16.7708 1.74759 16.7134 1.75772C16.5581 1.78509 16.4293 1.91391 16.1716 2.17155C15.914 2.4292 15.7852 2.55802 15.7578 2.71327C15.7477 2.77071 15.7477 2.82948 15.7578 2.88692C15.7852 3.04217 15.914 3.17099 16.1716 3.42863L16.5932 3.85024C16.5528 3.93483 16.5166 4.02188 16.4851 4.11111H15.8889C15.5245 4.11111 15.3424 4.11111 15.2132 4.20154C15.1654 4.23499 15.1239 4.27655 15.0904 4.32432C15 4.45346 15 4.63564 15 5C15 5.36436 15 5.54654 15.0904 5.67568C15.1239 5.72345 15.1654 5.76501 15.2132 5.79846C15.3423 5.88889 15.5245 5.88889 15.8889 5.88889H16.4851C16.5166 5.9781 16.5527 6.06512 16.5932 6.14968L16.1716 6.57134C15.9139 6.82898 15.7851 6.9578 15.7577 7.11305C15.7476 7.17049 15.7476 7.22926 15.7577 7.2867C15.7851 7.44196 15.9139 7.57078 16.1716 7.82842C16.4292 8.08606 16.558 8.21488 16.7133 8.24225C16.7707 8.25238 16.8295 8.25238 16.8869 8.24225C17.0422 8.21488 17.171 8.08606 17.4286 7.82842L17.8503 7.40677C17.9349 7.44725 18.0219 7.48339 18.1111 7.51493V8.11111C18.1111 8.47547 18.1111 8.65765 18.2015 8.78679C18.235 8.83457 18.2765 8.87612 18.3243 8.90958C18.4535 9 18.6356 9 19 9C19.3644 9 19.5465 9 19.6757 8.90958C19.7235 8.87612 19.765 8.83457 19.7985 8.78679C19.8889 8.65765 19.8889 8.47547 19.8889 8.11111V7.51493C19.9781 7.48339 20.0652 7.44724 20.1498 7.40675L20.5714 7.82841C20.8291 8.08605 20.9579 8.21487 21.1131 8.24225C21.1706 8.25237 21.2293 8.25237 21.2868 8.24225C21.442 8.21487 21.5709 8.08605 21.8285 7.82841C22.0861 7.57077 22.215 7.44195 22.2423 7.28669C22.2525 7.22925 22.2525 7.17049 22.2423 7.11305C22.215 6.95779 22.0861 6.82897 21.8285 6.57133L21.4068 6.14965C21.4473 6.0651 21.4834 5.97808 21.5149 5.88889H22.1111C22.4755 5.88889 22.6576 5.88889 22.7868 5.79846C22.8346 5.76501 22.8761 5.72345 22.9096 5.67568C23 5.54654 23 5.36436 23 5C23 4.63564 23 4.45346 22.9096 4.32432C22.8761 4.27655 22.8346 4.23499 22.7868 4.20154C22.6576 4.11111 22.4755 4.11111 22.1111 4.11111H21.5149C21.4834 4.02189 21.4472 3.93485 21.4068 3.85028L21.8284 3.42864C22.0861 3.171 22.2149 3.04218 22.2422 2.88693C22.2524 2.82949 22.2524 2.77072 22.2422 2.71328C22.2149 2.55802 22.086 2.4292 21.8284 2.17156C21.5708 1.91392 21.4419 1.7851 21.2867 1.75773C21.2293 1.7476 21.1705 1.7476 21.113 1.75773C20.9578 1.7851 20.829 1.91392 20.5713 2.17156L20.1497 2.59321C20.0651 2.55274 19.9781 2.5166 19.8889 2.48507V1.88889C19.8889 1.52453 19.8889 1.34235 19.7985 1.21321C19.765 1.16543 19.7235 1.12388 19.6757 1.09042C19.5465 1 19.3644 1 19 1C18.6356 1 18.4535 1 18.3243 1.09042C18.2765 1.12388 18.235 1.16543 18.2015 1.21321ZM20 5C20 5.55228 19.5523 6 19 6C18.4477 6 18 5.55228 18 5C18 4.44772 18.4477 4 19 4C19.5523 4 20 4.44772 20 5ZM9.31765 14H14.6824C15.1649 14 15.4061 14 15.6219 14.0461C16.3688 14.2056 17.0147 14.7661 17.3765 15.569C17.4811 15.8009 17.5574 16.0765 17.71 16.6278C17.8933 17.2901 17.985 17.6213 17.9974 17.8884C18.0411 18.8308 17.5318 19.6817 16.7756 19.9297C16.5613 20 16.2714 20 15.6916 20H8.30844C7.72864 20 7.43875 20 7.22441 19.9297C6.46818 19.6817 5.95888 18.8308 6.00261 17.8884C6.01501 17.6213 6.10668 17.2901 6.29003 16.6278C6.44262 16.0765 6.51891 15.8009 6.62346 15.569C6.9853 14.7661 7.63116 14.2056 8.37806 14.0461C8.59387 14 8.83513 14 9.31765 14Z" stroke="#464455" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            Mon compte
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="block px-10 py-1 text-sm text-gray-700 hover:bg-gray-100 max-w-xs overflow-hidden whitespace-no-wrap flex items-center rounded-md" type="submit"><svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 12L2 12M2 12L5.5 9M2 12L5.5 15" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9.00195 7C9.01406 4.82497 9.11051 3.64706 9.87889 2.87868C10.7576 2 12.1718 2 15.0002 2L16.0002 2C18.8286 2 20.2429 2 21.1215 2.87868C22.0002 3.75736 22.0002 5.17157 22.0002 8L22.0002 16C22.0002 18.8284 22.0002 20.2426 21.1215 21.1213C20.3531 21.8897 19.1752 21.9862 17 21.9983M9.00195 17C9.01406 19.175 9.11051 20.3529 9.87889 21.1213C10.5202 21.7626 11.4467 21.9359 13 21.9827" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            Déconnexion</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Main Content -->
        <div class="flex-1 flex">
            <!-- Sidebar -->
            <div class="w-1/10 bg-gray-800 text-white">
                <div class="p-4">
                    <!-- Page Links -->
                    <div>
                        <!-- Add your page links/buttons here -->
                        <ul>
                            <li>
                                <a href="{{ route('home') }}" class="flex items-center py-2 px-4 text-white hover:bg-gray-700 rounded-lg transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.918 10.0005H7.082C6.66587 9.99708 6.26541 10.1591 5.96873 10.4509C5.67204 10.7427 5.50343 11.1404 5.5 11.5565V17.4455C5.5077 18.3117 6.21584 19.0078 7.082 19.0005H9.918C10.3341 19.004 10.7346 18.842 11.0313 18.5502C11.328 18.2584 11.4966 17.8607 11.5 17.4445V11.5565C11.4966 11.1404 11.328 10.7427 11.0313 10.4509C10.7346 10.1591 10.3341 9.99708 9.918 10.0005Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.918 4.0006H7.082C6.23326 3.97706 5.52559 4.64492 5.5 5.4936V6.5076C5.52559 7.35629 6.23326 8.02415 7.082 8.0006H9.918C10.7667 8.02415 11.4744 7.35629 11.5 6.5076V5.4936C11.4744 4.64492 10.7667 3.97706 9.918 4.0006Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.082 13.0007H17.917C18.3333 13.0044 18.734 12.8425 19.0309 12.5507C19.3278 12.2588 19.4966 11.861 19.5 11.4447V5.55666C19.4966 5.14054 19.328 4.74282 19.0313 4.45101C18.7346 4.1592 18.3341 3.9972 17.918 4.00066H15.082C14.6659 3.9972 14.2654 4.1592 13.9687 4.45101C13.672 4.74282 13.5034 5.14054 13.5 5.55666V11.4447C13.5034 11.8608 13.672 12.2585 13.9687 12.5503C14.2654 12.8421 14.6659 13.0041 15.082 13.0007Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.082 19.0006H17.917C18.7661 19.0247 19.4744 18.3567 19.5 17.5076V16.4936C19.4744 15.6449 18.7667 14.9771 17.918 15.0006H15.082C14.2333 14.9771 13.5256 15.6449 13.5 16.4936V17.5066C13.525 18.3557 14.2329 19.0241 15.082 19.0006Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Tableau de bord
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('create') }}" class="flex items-center py-2 px-4 text-white hover:bg-gray-700 rounded-lg transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    Crée
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('ticket') }}" class="flex items-center py-2 px-4 text-white hover:bg-gray-700 rounded-lg transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M18 10L13 10" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M22 11.7979C22 9.16554 22 7.84935 21.2305 6.99383C21.1598 6.91514 21.0849 6.84024 21.0062 6.76946C20.1506 6 18.8345 6 16.2021 6H15.8284C14.6747 6 14.0979 6 13.5604 5.84678C13.2651 5.7626 12.9804 5.64471 12.7121 5.49543C12.2237 5.22367 11.8158 4.81578 11 4L10.4497 3.44975C10.1763 3.17633 10.0396 3.03961 9.89594 2.92051C9.27652 2.40704 8.51665 2.09229 7.71557 2.01738C7.52976 2 7.33642 2 6.94975 2C6.06722 2 5.62595 2 5.25839 2.06935C3.64031 2.37464 2.37464 3.64031 2.06935 5.25839C2 5.62595 2 6.06722 2 6.94975M21.9913 16C21.9554 18.4796 21.7715 19.8853 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V11" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    Tickets
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('ticket.clots') }}" class="flex items-center py-2 px-4 text-white hover:bg-gray-700 rounded-lg transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M10.5 15L13.5 12M13.5 15L10.5 12" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                                        <path d="M22 11.7979C22 9.16554 22 7.84935 21.2305 6.99383C21.1598 6.91514 21.0849 6.84024 21.0062 6.76946C20.1506 6 18.8345 6 16.2021 6H15.8284C14.6747 6 14.0979 6 13.5604 5.84678C13.2651 5.7626 12.9804 5.64471 12.7121 5.49543C12.2237 5.22367 11.8158 4.81578 11 4L10.4497 3.44975C10.1763 3.17633 10.0396 3.03961 9.89594 2.92051C9.27652 2.40704 8.51665 2.09229 7.71557 2.01738C7.52976 2 7.33642 2 6.94975 2C6.06722 2 5.62595 2 5.25839 2.06935C3.64031 2.37464 2.37464 3.64031 2.06935 5.25839C2 5.62595 2 6.06722 2 6.94975M21.9913 16C21.9554 18.4796 21.7715 19.8853 20.8284 20.8284C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V11" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    Tickets Clôturés
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('home') }}" class="flex items-center py-2 px-4 text-white hover:bg-gray-700 rounded-lg transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M11 6C13.7614 6 16 8.23858 16 11M16.6588 16.6549L21 21M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Recherche
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('clients.index') }}" class="flex items-center py-2 px-4 text-white hover:bg-gray-700 rounded-lg transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <circle cx="12" cy="6" r="4" stroke="#ffffff" stroke-width="1.5"/>
                                        <path d="M19.9975 18C20 17.8358 20 17.669 20 17.5C20 15.0147 16.4183 13 12 13C7.58172 13 4 15.0147 4 17.5C4 19.9853 4 22 12 22C14.231 22 15.8398 21.8433 17 21.5634" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                                    </svg>
                                    Clients
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('params') }}" class="flex items-center py-2 px-4 text-white hover:bg-gray-700 rounded-lg transition duration-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <circle cx="12" cy="12" r="3" stroke="#ffffff" stroke-width="1.5"/>
                                        <path d="M13.7654 2.15224C13.3978 2 12.9319 2 12 2C11.0681 2 10.6022 2 10.2346 2.15224C9.74457 2.35523 9.35522 2.74458 9.15223 3.23463C9.05957 3.45834 9.0233 3.7185 9.00911 4.09799C8.98826 4.65568 8.70226 5.17189 8.21894 5.45093C7.73564 5.72996 7.14559 5.71954 6.65219 5.45876C6.31645 5.2813 6.07301 5.18262 5.83294 5.15102C5.30704 5.08178 4.77518 5.22429 4.35436 5.5472C4.03874 5.78938 3.80577 6.1929 3.33983 6.99993C2.87389 7.80697 2.64092 8.21048 2.58899 8.60491C2.51976 9.1308 2.66227 9.66266 2.98518 10.0835C3.13256 10.2756 3.3397 10.437 3.66119 10.639C4.1338 10.936 4.43789 11.4419 4.43786 12C4.43783 12.5581 4.13375 13.0639 3.66118 13.3608C3.33965 13.5629 3.13248 13.7244 2.98508 13.9165C2.66217 14.3373 2.51966 14.8691 2.5889 15.395C2.64082 15.7894 2.87379 16.193 3.33973 17C3.80568 17.807 4.03865 18.2106 4.35426 18.4527C4.77508 18.7756 5.30694 18.9181 5.83284 18.8489C6.07289 18.8173 6.31632 18.7186 6.65204 18.5412C7.14547 18.2804 7.73556 18.27 8.2189 18.549C8.70224 18.8281 8.98826 19.3443 9.00911 19.9021C9.02331 20.2815 9.05957 20.5417 9.15223 20.7654C9.35522 21.2554 9.74457 21.6448 10.2346 21.8478C10.6022 22 11.0681 22 12 22C12.9319 22 13.3978 22 13.7654 21.8478C14.2554 21.6448 14.6448 21.2554 14.8477 20.7654C14.9404 20.5417 14.9767 20.2815 14.9909 19.902C15.0117 19.3443 15.2977 18.8281 15.781 18.549C16.2643 18.2699 16.8544 18.2804 17.3479 18.5412C17.6836 18.7186 17.927 18.8172 18.167 18.8488C18.6929 18.9181 19.2248 18.7756 19.6456 18.4527C19.9612 18.2105 20.1942 17.807 20.6601 16.9999C21.1261 16.1929 21.3591 15.7894 21.411 15.395C21.4802 14.8691 21.3377 14.3372 21.0148 13.9164C20.8674 13.7243 20.6602 13.5628 20.3387 13.3608C19.8662 13.0639 19.5621 12.558 19.5621 11.9999C19.5621 11.4418 19.8662 10.9361 20.3387 10.6392C20.6603 10.4371 20.8675 10.2757 21.0149 10.0835C21.3378 9.66273 21.4803 9.13087 21.4111 8.60497C21.3592 8.21055 21.1262 7.80703 20.6602 7C20.1943 6.19297 19.9613 5.78945 19.6457 5.54727C19.2249 5.22436 18.693 5.08185 18.1671 5.15109C17.9271 5.18269 17.6837 5.28136 17.3479 5.4588C16.8545 5.71959 16.2644 5.73002 15.7811 5.45096C15.2977 5.17191 15.0117 4.65566 14.9909 4.09794C14.9767 3.71848 14.9404 3.45833 14.8477 3.23463C14.6448 2.74458 14.2554 2.35523 13.7654 2.15224Z" stroke="#ffffff" stroke-width="1.5"/>
                                    </svg>
                                    Paramètrage
                                </a>
                            </li>
                            <!-- Add more links/buttons as needed -->
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Main Content -->
            <div class="w-9/10 px-8 w-full">
                <!-- Inclure le composant des messages flash -->
                @include('components.messages')

                <div class="overflow-y-auto">
                    <!-- Page Content -->
                    <main class="">
                        @yield('content')
                    </main>

                </div>
            </div>
        </div>

    </div>

    <script>
        // Récupérer le bouton d'avatar et le menu déroulant
        const avatarButton = document.getElementById('avatarButton');
        const avatarDropdown = document.getElementById('avatarDropdown');

        // Ajouter un écouteur d'événement pour le clic sur le bouton d'avatar
        avatarButton.addEventListener('click', () => {
            // Vérifier si le menu déroulant est visible ou non
            const isVisible = avatarDropdown.classList.contains('hidden');

            // Inverser la visibilité du menu déroulant
            if (isVisible) {
                // Si le menu est caché, le montrer
                avatarDropdown.classList.remove('hidden');
            } else {
                // Sinon, le cacher
                avatarDropdown.classList.add('hidden');
            }
        });

        // Ajouter un écouteur d'événement pour fermer le menu déroulant lorsque l'utilisateur clique en dehors de celui-ci
        document.addEventListener('click', (event) => {
            // Vérifier si l'élément cliqué est en dehors du bouton d'avatar et du menu déroulant
            const isOutsideAvatarButton = !avatarButton.contains(event.target);
            const isOutsideAvatarDropdown = !avatarDropdown.contains(event.target);

            // Si l'utilisateur clique en dehors du bouton d'avatar et du menu déroulant, cacher le menu déroulant
            if (isOutsideAvatarButton && isOutsideAvatarDropdown) {
                avatarDropdown.classList.add('hidden');
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
    </body>

</html>
