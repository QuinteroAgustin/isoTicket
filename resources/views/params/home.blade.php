@extends('layouts.app')

@section('title', 'Paramètres')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Paramétrage des interfaces</h1>
        <p class="text-gray-600 mb-8">Panel administrateur d'E-Ticket</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @if(session('technicien')->role->id_role <= 2)
            <!-- Carte Configuration Tickets -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-5 bg-gradient-to-r from-blue-600 to-blue-700">
                    <h2 class="text-xl font-semibold text-white">Configuration Tickets</h2>
                </div>
                <div class="p-5 space-y-3">
                    <a href="{{ route('params.form.status') }}" class="flex items-center p-3 rounded-lg transition-all hover:bg-blue-50 group">
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 group-hover:bg-blue-200">
                            <svg class="w-6 h-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span class="ml-3 font-medium text-gray-700 group-hover:text-blue-600">Statuts</span>
                    </a>

                    <a href="{{ route('params.form.service') }}" class="flex items-center p-3 rounded-lg transition-all hover:bg-blue-50 group">
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 group-hover:bg-blue-200">
                            <svg class="w-6 h-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9" stroke-width="2"/>
                            </svg>
                        </span>
                        <span class="ml-3 font-medium text-gray-700 group-hover:text-blue-600">Services</span>
                    </a>

                    <a href="{{ route('params.form.categorie') }}" class="flex items-center p-3 rounded-lg transition-all hover:bg-blue-50 group">
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 group-hover:bg-blue-200">
                            <svg class="w-6 h-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M4 7a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V7zm0 8a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm8-8a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V7zm0 8a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" stroke-width="2"/>
                            </svg>
                        </span>
                        <span class="ml-3 font-medium text-gray-700 group-hover:text-blue-600">Catégories</span>
                    </a>

                    <a href="{{ route('params.form.fonction') }}" class="flex items-center p-3 rounded-lg transition-all hover:bg-blue-50 group">
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-blue-100 group-hover:bg-blue-200">
                            <svg class="w-6 h-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span class="ml-3 font-medium text-gray-700 group-hover:text-blue-600">Fonctions</span>
                    </a>
                    
                </div>
            </div>

            <!-- Carte Évaluation -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-5 bg-gradient-to-r from-orange-600 to-orange-700">
                    <h2 class="text-xl font-semibold text-white">Évaluation</h2>
                </div>
                <div class="p-5 space-y-3">
                    <a href="{{ route('params.form.priorite') }}" class="flex items-center p-3 rounded-lg transition-all hover:bg-orange-50 group">
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-orange-100 group-hover:bg-orange-200">
                            <svg class="w-6 h-6 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M13 7h8m0 4h-8m0 4h8M3 7l4-4 4 4M7 20V4" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span class="ml-3 font-medium text-gray-700 group-hover:text-orange-600">Priorité</span>
                    </a>

                    <a href="{{ route('params.form.impact') }}" class="flex items-center p-3 rounded-lg transition-all hover:bg-orange-50 group">
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-orange-100 group-hover:bg-orange-200">
                            <svg class="w-6 h-6 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M13 10V3L4 14h7v7l9-11h-7z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span class="ml-3 font-medium text-gray-700 group-hover:text-orange-600">Impact</span>
                    </a>

                    <a href="{{ route('params.form.risque') }}" class="flex items-center p-3 rounded-lg transition-all hover:bg-orange-50 group">
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-orange-100 group-hover:bg-orange-200">
                            <svg class="w-6 h-6 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <span class="ml-3 font-medium text-gray-700 group-hover:text-orange-600">Risques</span>
                    </a>
                </div>
            </div>
            @endif

            @if(session('technicien')->role->id_role <= 1)
            <!-- Carte Administration -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-5 bg-gradient-to-r from-purple-600 to-purple-700">
                    <h2 class="text-xl font-semibold text-white">Administration</h2>
                </div>
                <div class="p-5 space-y-3">
                    <a href="{{ route('params.form.role') }}" class="flex items-center p-3 rounded-lg transition-all hover:bg-purple-50 group">
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-purple-100 group-hover:bg-purple-200">
                            <svg class="w-6 h-6 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="2"/>
                            </svg>
                        </span>
                        <span class="ml-3 font-medium text-gray-700 group-hover:text-purple-600">Rôles</span>
                    </a>

                    <a href="{{ route('params.form.technicien') }}" class="flex items-center p-3 rounded-lg transition-all hover:bg-purple-50 group">
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-purple-100 group-hover:bg-purple-200">
                            <svg class="w-6 h-6 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2"/>
                            </svg>
                        </span>
                        <span class="ml-3 font-medium text-gray-700 group-hover:text-purple-600">Techniciens</span>
                    </a>

                    <a href="{{ route('params.form.api') }}" class="flex items-center p-3 rounded-lg transition-all hover:bg-purple-50 group">
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-purple-100 group-hover:bg-purple-200">
                            <svg class="w-6 h-6 text-purple-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <span class="ml-3 font-medium text-gray-700 group-hover:text-purple-600">Clés API</span>
                    </a>
                    <a href="{{ route('params.infos.index') }}" class="flex items-center p-3 rounded-lg transition-all hover:bg-purple-50 group">
                        <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-purple-100 text-purple-600 group-hover:bg-purple-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="font-medium">Informations Utiles</h3>
                            <p class="text-sm text-gray-500">Gérer les informations utiles</p>
                        </div>
                    </a>
                </div>
            </div>
            @endif

            @if(session('technicien')->role->id_role <= 4)
            <!-- Carte Forfaits -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-5 bg-gradient-to-r from-green-600 to-green-700">
                    <h2 class="text-xl font-semibold text-white">Gestion des forfaits</h2>
                </div>
                <div class="p-5 space-y-3">
                    <a href="{{ route('params.form.typeForfait') }}" class="flex items-center p-3 rounded-lg transition-all hover:bg-green-50 group">
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-100 group-hover:bg-green-200">
                            <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" stroke-width="2"/>
                            </svg>
                        </span>
                        <span class="ml-3 font-medium text-gray-700 group-hover:text-green-600">Types de forfait</span>
                    </a>

                    <a href="{{ route('params.form.forfait') }}" class="flex items-center p-3 rounded-lg transition-all hover:bg-green-50 group">
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-green-100 group-hover:bg-green-200">
                            <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/>
                            </svg>
                        </span>
                        <span class="ml-3 font-medium text-gray-700 group-hover:text-green-600">Forfaits</span>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
    
@endsection
