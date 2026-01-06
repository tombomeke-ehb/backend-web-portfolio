{{-- Admin Sidebar Navigation --}}
<aside class="admin-sidebar">
    <div class="admin-sidebar-header">
        <i class="fas fa-shield-alt"></i>
        <span>Admin Panel</span>
    </div>

    <nav class="admin-nav">
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i>
            <span>{{ __('admin.Dashboard') }}</span>
        </a>

        <div class="admin-nav-section">{{ __('admin.Content') }}</div>

        <a href="{{ route('admin.projects.index') }}" class="admin-nav-item {{ request()->routeIs('admin.projects.*') ? 'active' : '' }}">
            <i class="fas fa-folder-open"></i>
            <span>{{ __('admin.Projects') }}</span>
        </a>

        <a href="{{ route('admin.news.index') }}" class="admin-nav-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
            <i class="far fa-newspaper"></i>
            <span>{{ __('admin.News') }}</span>
        </a>

        <a href="{{ route('admin.tags.index') }}" class="admin-nav-item {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i>
            <span>{{ __('admin.Tags') }}</span>
        </a>

        <a href="{{ route('admin.faq.categories.index') }}" class="admin-nav-item {{ request()->routeIs('admin.faq.*') ? 'active' : '' }}">
            <i class="fas fa-question-circle"></i>
            <span>{{ __('admin.FAQ') }}</span>
        </a>

        <div class="admin-nav-section">{{ __('admin.Moderation') }}</div>

        <a href="{{ route('admin.news-comments.index') }}" class="admin-nav-item {{ request()->routeIs('admin.news-comments.*') ? 'active' : '' }}">
            <i class="fas fa-comments"></i>
            <span>{{ __('admin.Comments') }}</span>
            @php $pendingComments = \App\Models\NewsComment::where('is_approved', false)->count(); @endphp
            @if($pendingComments > 0)
                <span class="admin-nav-badge">{{ $pendingComments }}</span>
            @endif
        </a>

        <a href="{{ route('admin.contact.index') }}" class="admin-nav-item {{ request()->routeIs('admin.contact.*') ? 'active' : '' }}">
            <i class="fas fa-inbox"></i>
            <span>{{ __('admin.Messages') }}</span>
            @php $unreadMessages = \App\Models\ContactMessage::whereNull('read_at')->count(); @endphp
            @if($unreadMessages > 0)
                <span class="admin-nav-badge">{{ $unreadMessages }}</span>
            @endif
        </a>

        <div class="admin-nav-section">{{ __('admin.System') }}</div>

        <a href="{{ route('admin.users.index') }}" class="admin-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i>
            <span>{{ __('admin.Users') }}</span>
        </a>

        <a href="{{ route('admin.activity-logs.index') }}" class="admin-nav-item {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}">
            <i class="fas fa-history"></i>
            <span>{{ __('admin.Activity Log') }}</span>
        </a>

        <a href="{{ route('admin.settings.index') }}" class="admin-nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
            <i class="fas fa-cog"></i>
            <span>{{ __('admin.Settings') }}</span>
        </a>
    </nav>

    <div class="admin-sidebar-footer">
        <a href="{{ route('home') }}" class="admin-nav-item">
            <i class="fas fa-arrow-left"></i>
            <span>{{ __('admin.Back to site') }}</span>
        </a>
    </div>
</aside>
