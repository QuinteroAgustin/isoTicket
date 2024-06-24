@extends('layouts.app')

@section('title', 'Paramètres')

@section('content')
    <!-- Your Page Content Here -->
    <h1 class="text-2xl font-semibold">Paramètrage des interfaces</h1>
    <p>Panel administrateur d'E-Ticket</p>
    <div class="grid grid-cols-4 divide-x">
        <div class="border m-5 p-5">
            <ul class="my-2">
                <li class="mt-2">
                    <a href="{{ route('params.form.status') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 rounded-full text-white hover:bg-blue-600 transition-colors duration-300 ease-in-out">
                        <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M6.87988 18.1501V16.0801" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M12 18.15V14.01" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M17.1201 18.1499V11.9299" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M17.1199 5.8501L16.6599 6.3901C14.1099 9.3701 10.6899 11.4801 6.87988 12.4301" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M14.1899 5.8501H17.1199V8.7701" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Satus
                    </a>
                </li>
                <li class="mt-2">
                    <a href="{{ route('params.form.service') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 rounded-full text-white hover:bg-blue-600 transition-colors duration-300 ease-in-out">
                        <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16 6C14.3432 6 13 7.34315 13 9C13 10.6569 14.3432 12 16 12C17.6569 12 19 10.6569 19 9C19 7.34315 17.6569 6 16 6ZM11 9C11 6.23858 13.2386 4 16 4C18.7614 4 21 6.23858 21 9C21 10.3193 20.489 11.5193 19.6542 12.4128C21.4951 13.0124 22.9176 14.1993 23.8264 15.5329C24.1374 15.9893 24.0195 16.6114 23.5631 16.9224C23.1068 17.2334 22.4846 17.1155 22.1736 16.6591C21.1979 15.2273 19.4178 14 17 14C13.166 14 11 17.0742 11 19C11 19.5523 10.5523 20 10 20C9.44773 20 9.00001 19.5523 9.00001 19C9.00001 18.308 9.15848 17.57 9.46082 16.8425C9.38379 16.7931 9.3123 16.7323 9.24889 16.6602C8.42804 15.7262 7.15417 15 5.50001 15C3.84585 15 2.57199 15.7262 1.75114 16.6602C1.38655 17.075 0.754692 17.1157 0.339855 16.7511C-0.0749807 16.3865 -0.115709 15.7547 0.248886 15.3398C0.809035 14.7025 1.51784 14.1364 2.35725 13.7207C1.51989 12.9035 1.00001 11.7625 1.00001 10.5C1.00001 8.01472 3.01473 6 5.50001 6C7.98529 6 10 8.01472 10 10.5C10 11.7625 9.48013 12.9035 8.64278 13.7207C9.36518 14.0785 9.99085 14.5476 10.5083 15.0777C11.152 14.2659 11.9886 13.5382 12.9922 12.9945C11.7822 12.0819 11 10.6323 11 9ZM3.00001 10.5C3.00001 9.11929 4.1193 8 5.50001 8C6.88072 8 8.00001 9.11929 8.00001 10.5C8.00001 11.8807 6.88072 13 5.50001 13C4.1193 13 3.00001 11.8807 3.00001 10.5Z" fill="#ffffff"/>
                        </svg>
                        Services
                    </a>
                </li>
                <li class="mt-2">
                    <a href="{{ route('params.form.categorie') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 rounded-full text-white hover:bg-blue-600 transition-colors duration-300 ease-in-out">
                        <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M17 10H19C21 10 22 9 22 7V5C22 3 21 2 19 2H17C15 2 14 3 14 5V7C14 9 15 10 17 10Z" stroke="#ffffff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M5 22H7C9 22 10 21 10 19V17C10 15 9 14 7 14H5C3 14 2 15 2 17V19C2 21 3 22 5 22Z" stroke="#ffffff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M6 10C8.20914 10 10 8.20914 10 6C10 3.79086 8.20914 2 6 2C3.79086 2 2 3.79086 2 6C2 8.20914 3.79086 10 6 10Z" stroke="#ffffff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M18 22C20.2091 22 22 20.2091 22 18C22 15.7909 20.2091 14 18 14C15.7909 14 14 15.7909 14 18C14 20.2091 15.7909 22 18 22Z" stroke="#ffffff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>

                        </svg>
                        Categories
                    </a>
                </li>
                <li class="mt-2">
                    <a href="{{ route('params.form.fonction') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 rounded-full text-white hover:bg-blue-600 transition-colors duration-300 ease-in-out">
                        <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.92789 6.39814C3.16565 4.88765 4.23386 2 6.55487 2H19C19.5523 2 20 2.44772 20 3C20 3.55228 19.5523 4 19 4H6.55487C6.09067 4 5.87703 4.57753 6.22948 4.87963L12.3221 10.1019C13.4861 11.0996 13.4861 12.9004 12.3221 13.8981L6.22948 19.1204C5.87703 19.4225 6.09067 20 6.55487 20H19C19.5523 20 20 20.4477 20 21C20 21.5523 19.5523 22 19 22H6.55487C4.23386 22 3.16565 19.1124 4.92789 17.6019L11.0205 12.3796C11.2533 12.1801 11.2533 11.8199 11.0205 11.6204L4.92789 6.39814Z" fill="#ffffff"/>
                        </svg>
                        Fonctions
                    </a>
                </li>
            </ul>
        </div>
        <div class="border m-5 p-5">
            <ul class="my-2">
                <li class="mt-2">
                    <a href="{{ route('params.form.priorite') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 rounded-full text-white hover:bg-blue-600 transition-colors duration-300 ease-in-out">
                        <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <polyline id="primary" points="2 8 6 4 10 8" style="fill: none; stroke:#ffffff; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></polyline><path id="primary-2" data-name="primary" d="M6,4V19M20,7H15m5,5H13m7,5H10" style="fill: none; stroke:#ffffff; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path>
                        </svg>
                        Priorite
                    </a>
                </li>
                <li class="mt-2">
                    <a href="{{ route('params.form.impact') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 rounded-full text-white hover:bg-blue-600 transition-colors duration-300 ease-in-out">
                        <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M4.42602 12.3115L12 19.8854L19.574 12.3115C21.4753 10.4101 21.4753 7.32738 19.574 5.42602C17.6726 3.52466 14.5899 3.52466 12.6885 5.42602L12 6.11456L11.3115 5.42602C9.4101 3.52466 6.32738 3.52466 4.42602 5.42602C2.52466 7.32738 2.52466 10.4101 4.42602 12.3115Z" stroke="#ffffff" stroke-width="2" stroke-linejoin="round"/>
                            <path d="M12 6L10 9.99995L14 11L12 14" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Impact
                    </a>
                </li>
                <li class="mt-2">
                    <a href="{{ route('params.form.risque') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 rounded-full text-white hover:bg-blue-600 transition-colors duration-300 ease-in-out">
                        <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 14.75C11.59 14.75 11.25 14.41 11.25 14V9C11.25 8.59 11.59 8.25 12 8.25C12.41 8.25 12.75 8.59 12.75 9V14C12.75 14.41 12.41 14.75 12 14.75Z" fill="#ffffff"/>
                            <path d="M12 18C11.94 18 11.87 17.99 11.8 17.98C11.74 17.97 11.68 17.95 11.62 17.92C11.56 17.9 11.5 17.87 11.44 17.83C11.39 17.79 11.34 17.75 11.29 17.71C11.11 17.52 11 17.26 11 17C11 16.74 11.11 16.48 11.29 16.29C11.34 16.25 11.39 16.21 11.44 16.17C11.5 16.13 11.56 16.1 11.62 16.08C11.68 16.05 11.74 16.03 11.8 16.02C11.93 15.99 12.07 15.99 12.19 16.02C12.26 16.03 12.32 16.05 12.38 16.08C12.44 16.1 12.5 16.13 12.56 16.17C12.61 16.21 12.66 16.25 12.71 16.29C12.89 16.48 13 16.74 13 17C13 17.26 12.89 17.52 12.71 17.71C12.66 17.75 12.61 17.79 12.56 17.83C12.5 17.87 12.44 17.9 12.38 17.92C12.32 17.95 12.26 17.97 12.19 17.98C12.13 17.99 12.06 18 12 18Z" fill="#ffffff"/>
                            <path d="M18.06 22.16H5.93998C3.98998 22.16 2.49998 21.45 1.73998 20.17C0.989976 18.89 1.08998 17.24 2.03998 15.53L8.09998 4.63C9.09998 2.83 10.48 1.84 12 1.84C13.52 1.84 14.9 2.83 15.9 4.63L21.96 15.54C22.91 17.25 23.02 18.89 22.26 20.18C21.5 21.45 20.01 22.16 18.06 22.16ZM12 3.34C11.06 3.34 10.14 4.06 9.40998 5.36L3.35998 16.27C2.67998 17.49 2.56998 18.61 3.03998 19.42C3.50998 20.23 4.54998 20.67 5.94998 20.67H18.07C19.47 20.67 20.5 20.23 20.98 19.42C21.46 18.61 21.34 17.5 20.66 16.27L14.59 5.36C13.86 4.06 12.94 3.34 12 3.34Z" fill="#ffffff"/>
                        </svg>
                        Risques
                    </a>
                </li>
            </ul>
        </div>
        <div class="border m-5 p-5">
            <ul class="my-2">
                <li class="mt-2">
                    <a href="{{ route('params.form.role') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 rounded-full text-white hover:bg-blue-600 transition-colors duration-300 ease-in-out">
                        <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.3375 19C5.815 19 5.33219 18.7141 5.07094 18.25C4.80969 17.7859 4.80969 17.2141 5.07094 16.75C5.33219 16.2859 5.815 16 6.3375 16H17.0625C17.8702 16 18.525 16.6716 18.525 17.5C18.525 18.3284 17.8702 19 17.0625 19H6.3375Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.875 8C6.10837 10.228 8.83837 13.569 11.7 8C14.5616 13.569 17.2916 10.228 18.525 8L17.16 16H6.24L4.875 8Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7 8C10.8923 8 10.2375 7.32843 10.2375 6.5C10.2375 5.67157 10.8923 5 11.7 5C12.5078 5 13.1625 5.67157 13.1625 6.5C13.1625 6.89782 13.0085 7.27936 12.7342 7.56066C12.4599 7.84196 12.0879 8 11.7 8Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M18.525 8C17.9866 8 17.55 7.55228 17.55 7C17.55 6.44772 17.9866 6 18.525 6C19.0635 6 19.5 6.44772 19.5 7C19.5 7.26522 19.3973 7.51957 19.2145 7.70711C19.0316 7.89464 18.7836 8 18.525 8Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4.87502 8C4.33655 8 3.90002 7.55228 3.90002 7C3.90002 6.44772 4.33655 6 4.87502 6C5.4135 6 5.85002 6.44772 5.85002 7C5.85002 7.26522 5.7473 7.51957 5.56445 7.70711C5.38161 7.89464 5.13361 8 4.87502 8Z" stroke="#ffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Role
                    </a>
                </li>
                <li class="mt-2">
                    <a href="{{ route('params.form.technicien') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 rounded-full text-white hover:bg-blue-600 transition-colors duration-300 ease-in-out">
                        <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 15C7.58 15 4 16.79 4 19V21H20V19C20 16.79 16.42 15 12 15ZM8 9C8 10.0609 8.42143 11.0783 9.17157 11.8284C9.92172 12.5786 10.9391 13 12 13C13.0609 13 14.0783 12.5786 14.8284 11.8284C15.5786 11.0783 16 10.0609 16 9H8ZM11.5 2C11.2 2 11 2.21 11 2.5V5.5H10V3C10 3 7.75 3.86 7.75 6.75C7.75 6.75 7 6.89 7 8H17C16.95 6.89 16.25 6.75 16.25 6.75C16.25 3.86 14 3 14 3V5.5H13V2.5C13 2.21 12.81 2 12.5 2H11.5Z"/>
                        </svg>
                        Techniciens
                    </a>
                </li>
            </ul>
        </div>
        <div class="border m-5 p-5">
            <ul>
                <li class="mt-2">
                    <a href="{{ route('params.form.typeForfait') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 rounded-full text-white hover:bg-blue-600 transition-colors duration-300 ease-in-out">
                        <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                        </svg>
                        Type de forfait
                    </a>
                </li>
                <li class="mt-2">
                    <a href="{{ route('params.form.forfait') }}" class="inline-flex items-center justify-center px-4 py-2 bg-blue-500 rounded-full text-white hover:bg-blue-600 transition-colors duration-300 ease-in-out">
                        <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">

                        </svg>
                        Forfait
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection
