@extends('layouts.app')
@section('title', 'Сообщения с сайта')
@section('content')
<div class="admin-users-section">
    <div class="admin-users-container">
        <div class="admin-breadcrumbs" style="margin-bottom: 24px;">
            <a href="{{ route('admin.dashboard') }}" class="admin-breadcrumb-link">Админ-панель</a>
            <span class="admin-breadcrumb-sep">/</span>
            <span class="admin-breadcrumb-current">Сообщения</span>
        </div>
        <h1 class="admin-dashboard-title">Сообщения с сайта</h1>
        @if(session('success'))
            <div id="admin-modal-success" class="admin-modal-success">
                <span class="admin-modal-success-text">{{ session('success') }}</span>
            </div>
        @endif
        <div class="admin-table-responsive">
            <table class="admin-users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Сообщение</th>
                        <th>Дата</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($messages as $message)
                    <tr>
                        <td>{{ $message->id }}</td>
                        <td>{{ $message->name }}</td>
                        <td>{{ $message->email }}</td>
                        <td style="max-width: 320px; white-space: pre-line; overflow: hidden; text-overflow: ellipsis;">{{ Str::limit($message->message, 80) }}</td>
                        <td>{{ $message->created_at->format('d.m.Y H:i') }}</td>
                        <td style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.messages.show', $message) }}" class="admin-action-btn admin-action-view" title="Подробнее"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-action-btn admin-action-delete" title="Удалить" onclick="return confirm('Удалить сообщение?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;">Сообщений нет</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="admin-pagination-container">
            {{ $messages->withQueryString()->onEachSide(1)->links('vendor.pagination.admin') }}
        </div>
    </div>
</div>
@include('layouts.footer')
@endsection
@push('scripts')
<style>
.admin-users-section {
    padding: 32px 0 0 0;
    min-height: 80vh;
}
.admin-users-container {
    max-width: 1100px;
    margin: 0 auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 2px 16px 0 rgba(0,0,0,0.07);
    padding: 32px 32px 24px 32px;
}
.admin-dashboard-title {
    font-size: 2.1rem;
    font-weight: 700;
    margin-bottom: 24px;
}
.admin-table-responsive {
    overflow-x: auto;
    margin-bottom: 18px;
}
.admin-users-table {
    width: 100%;
    border-collapse: collapse;
    background: #fafbfc;
    border-radius: 12px;
    overflow: hidden;
    font-size: 1rem;
}
.admin-users-table th, .admin-users-table td {
    padding: 12px 14px;
    border-bottom: 1px solid #e5e7eb;
    text-align: left;
}
.admin-users-table th {
    background: #f3f4f6;
    font-weight: 600;
    color: #333;
}
.admin-users-table tr:last-child td {
    border-bottom: none;
}
.admin-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border-radius: 8px;
    border: none;
    background: #f3f4f6;
    color: #444;
    font-size: 1.1rem;
    transition: background 0.15s, color 0.15s;
    cursor: pointer;
}
.admin-action-btn.admin-action-view:hover {
    background: #e0e7ff;
    color: #3730a3;
}
.admin-action-btn.admin-action-delete:hover {
    background: #fee2e2;
    color: #b91c1c;
}
.admin-modal-success {
    background: #e0fce0;
    color: #166534;
    border-radius: 8px;
    padding: 10px 18px;
    margin-bottom: 18px;
    font-size: 1rem;
    box-shadow: 0 2px 8px 0 rgba(0,0,0,0.04);
}
.admin-pagination-container {
    margin-top: 18px;
    display: flex;
    justify-content: center;
}
.admin-breadcrumbs {
    display: flex;
    align-items: center;
    font-size: 1rem;
    margin-bottom: 18px;
    gap: 6px;
    color: #888;
}
.admin-breadcrumb-link {
    color: #6366f1;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.15s;
}
.admin-breadcrumb-link:hover {
    color: #3730a3;
    text-decoration: underline;
}
.admin-breadcrumb-sep {
    color: #bbb;
    font-size: 1.1em;
    margin: 0 2px;
}
.admin-breadcrumb-current {
    color: #222;
    font-weight: 600;
}
</style>
@endpush 