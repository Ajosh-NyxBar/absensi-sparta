@extends('layouts.modern')

@section('title', __('notifications.all_notifications'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ showMarkAllModal: false }">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <i class="fas fa-bell text-white text-xl"></i>
                    </div>
                    {{ __('notifications.all_notifications') }}
                </h1>
                <p class="text-gray-600 mt-2">{{ __('notifications.subtitle') }}</p>
            </div>
            @if($notifications->where('is_read', false)->count() > 0)
            <button @click="showMarkAllModal = true" 
                    type="button"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white text-indigo-600 font-semibold rounded-xl border-2 border-indigo-200 hover:bg-indigo-50 transition-all duration-200">
                <i class="fas fa-check-double"></i>
                <span>{{ __('notifications.mark_all_read') }}</span>
            </button>
            @endif
        </div>
    </div>

    <!-- Notifications List -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
        @forelse($notifications as $notification)
            <div class="flex items-start gap-4 p-4 sm:p-6 border-b border-gray-100 hover:bg-gray-50 transition-colors {{ !$notification->is_read ? 'bg-indigo-50/50' : '' }}">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-full flex items-center justify-center flex-shrink-0 {{ $notification->type_color }}">
                    <i class="fas {{ $notification->icon }} text-lg"></i>
                </div>
                
                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <h3 class="font-semibold text-gray-900 {{ !$notification->is_read ? 'text-indigo-900' : '' }}">
                                {{ $notification->title }}
                                @if(!$notification->is_read)
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ __('notifications.unread') }}
                                    </span>
                                @endif
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                            <p class="text-xs text-gray-400 mt-2">
                                <i class="fas fa-clock mr-1"></i>
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                        
                        <!-- Actions -->
                        <div class="flex items-center gap-2 flex-shrink-0">
                            @if($notification->link)
                                <a href="{{ $notification->link }}" class="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="{{ __('general.view') }}">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            @endif
                            @if(!$notification->is_read)
                                <form action="{{ route('notifications.api.mark-read', $notification) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="{{ __('notifications.mark_read') }}">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                            <form action="{{ route('notifications.api.destroy', $notification) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="{{ __('notifications.delete') }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="px-6 py-16 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-bell-slash text-4xl text-gray-300"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('notifications.no_notifications_yet') }}</h3>
                <p class="text-gray-500">{{ __('notifications.check_back_later') }}</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($notifications->hasPages())
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    @endif
    
    <!-- Mark All Read Modal -->
    <div x-show="showMarkAllModal"
         x-cloak
         class="fixed inset-0 z-[100] overflow-y-auto"
         role="dialog"
         aria-modal="true">
        <!-- Backdrop with blur -->
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
             x-show="showMarkAllModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="showMarkAllModal = false">
        </div>
        
        <!-- Modal Panel -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="showMarkAllModal"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white shadow-2xl transition-all w-full max-w-md"
                 @click.away="showMarkAllModal = false">
                
                <!-- Modal Header with Animated Icon -->
                <div class="bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 px-6 pt-8 pb-6 relative overflow-hidden">
                    <!-- Decorative circles -->
                    <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full"></div>
                    <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-white/10 rounded-full"></div>
                    
                    <div class="relative mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm ring-4 ring-white/30 shadow-xl">
                        <div class="absolute inset-0 rounded-full bg-gradient-to-br from-white/30 to-transparent"></div>
                        <i class="fas fa-check-double text-white text-3xl relative z-10 animate-pulse"></i>
                    </div>
                </div>
                
                <!-- Modal Body -->
                <div class="px-6 py-6 text-center">
                    <h3 class="text-xl font-bold text-gray-900">
                        {{ __('notifications.confirm_mark_all_title') }}
                    </h3>
                    <p class="mt-3 text-sm text-gray-500 leading-relaxed">
                        {{ __('notifications.confirm_mark_all_message') }}
                    </p>
                    
                    <!-- Info badge -->
                    <div class="mt-4 inline-flex items-center gap-2 px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-full text-xs font-medium">
                        <i class="fas fa-info-circle"></i>
                        <span>{{ $notifications->where('is_read', false)->count() }} {{ __('notifications.unread_notifications') }}</span>
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="px-6 pb-6 flex gap-3">
                    <button @click="showMarkAllModal = false"
                            type="button"
                            class="flex-1 rounded-xl border-2 border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-all duration-200 group">
                        <i class="fas fa-times mr-2 text-gray-400 group-hover:text-gray-600 transition-colors"></i>
                        {{ __('general.cancel') }}
                    </button>
                    <form action="{{ route('notifications.api.mark-all-read') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit"
                                class="w-full rounded-xl bg-gradient-to-r from-indigo-500 to-purple-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40 hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200">
                            <i class="fas fa-check mr-2"></i>
                            {{ __('notifications.confirm_button') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
