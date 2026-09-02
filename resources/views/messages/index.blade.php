@extends('layouts.app')

@section('title', 'Communication')

@section('content')
<main class="ml-0 lg:ml-64 pt-20 px-4 pb-4 lg:px-6 lg:pt-20 lg:pb-6 h-[calc(100vh-4rem)] bg-slate-50 flex flex-col min-h-0 overflow-hidden">

        @include('messages.tabs')

        <div class="grid flex-1 min-h-0 grid-cols-1 gap-4 xl:grid-cols-12 overflow-hidden">
            <section class="h-full min-h-0 xl:col-span-3">
                <div id="internalModePane" data-mode-pane="internal" class="flex h-full min-h-0 flex-col bg-white">
                    <div class="border-b border-slate-200 p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <h2 id="listTitle" class="text-base font-semibold text-slate-900">Internal Conversations</h2>
                                <p id="listSubtitle" class="text-sm text-slate-500">Departments and employees</p>
                            </div>
                            <span id="listCount" class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">12</span>
                        </div>

                        <div class="mt-4 flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4 text-slate-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 5.65 5.65a7.5 7.5 0 0 0 10.6 10.6Z" />
                            </svg>
                            <input type="text" value="" placeholder="Search conversations" class="w-full border-0 bg-transparent p-0 text-sm text-slate-600 outline-none placeholder:text-slate-400">
                        </div>
                    </div>

                    <div id="conversationList" class="min-h-0 flex-1 overflow-y-auto scrollbar-hide p-2 bg-white">
                        @include('messages.internalmessages')
                    </div>
                </div>

                <div id="smsModePane" data-mode-pane="sms" class="hidden flex h-full min-h-0 flex-col bg-white">
                    <div class="border-b border-slate-200 p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <h2 class="text-base font-semibold text-slate-900">SMS Threads</h2>
                                <p class="text-sm text-slate-500">External phone conversations</p>
                            </div>
                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">8</span>
                        </div>

                        <div class="mt-4 flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-3 py-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4 text-slate-400">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 5.65 5.65a7.5 7.5 0 0 0 10.6 10.6Z" />
                            </svg>
                            <input type="text" value="" placeholder="Search threads" class="w-full border-0 bg-transparent p-0 text-sm text-slate-600 outline-none placeholder:text-slate-400">
                        </div>
                    </div>

                    <div class="min-h-0 flex-1 overflow-y-auto scrollbar-hide p-2 bg-white">
                        @include('messages.smsmessages')
                    </div>
                </div>
            </section>

            <section class="h-full min-h-0 xl:col-span-9">
                <div class="h-full min-h-0 bg-white">
                    
                    @include('messages.thread')
                    
                </div>
            </section>

        </div>
    </main>

    @vite(['resources/js/app.js'])

    @includeIf('messages.scripts')
@endsection
