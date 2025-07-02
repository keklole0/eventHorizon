@extends('layouts.app')
@section('title', 'Пользователи')
@section('content')
<div class="admin-users-section">
    <div class="admin-users-container">
        <div class="admin-breadcrumbs" style="margin-bottom: 24px;">
            <a href="{{ route('admin.dashboard') }}" class="admin-breadcrumb-link">Админ-панель</a>
            <span class="admin-breadcrumb-sep">/</span>
            <span class="admin-breadcrumb-current">Пользователи</span>
        </div>
        <h1 class="admin-dashboard-title">Пользователи</h1>
        <form method="GET" action="" class="admin-user-search-form">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Поиск по имени, email, логину или ID..." class="input-field admin-user-search-input">
            <button type="submit" class="admin-form-btn">Найти</button>
            <a href="{{ route('admin.users.create') }}" class="admin-form-btn admin-form-btn-secondary">Добавить пользователя</a>
        </form>
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
                        <th>Логин</th>
                        <th>Роль</th>
                        <th>Дата регистрации</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->username }}</td>
                        <td>
                            <span class="role-badge role-{{ $user->role }}">{{ $user->role == 'admin' ? 'Админ' : 'Пользователь' }}</span>
                        </td>
                        <td>{{ $user->created_at->format('d.m.Y') }}</td>
                        <td style="display: flex; gap: 8px;">
                            <a href="{{ route('admin.users.show', $user) }}" class="admin-action-btn admin-action-view" title="Профиль"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="admin-action-btn admin-action-edit" title="Редактировать"><i class="fas fa-edit"></i></a>
                            <button type="button" class="admin-action-btn admin-action-delete" title="Удалить" onclick="showDeleteModal({{ $user->id }}, '{{ $user->first_name }} {{ $user->last_name }}')"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center;">Пользователи не найдены</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="admin-pagination-container">
            {{ $users->withQueryString()->onEachSide(1)->links('vendor.pagination.admin') }}
        </div>
    </div>
</div>
<!-- Модальное окно подтверждения удаления -->
<div id="deleteUserModal" class="admin-modal-delete-bg" style="display:none;">
    <div class="admin-modal-delete">
        <div class="admin-modal-delete-title">Удалить пользователя?</div>
        <div class="admin-modal-delete-desc"><span id="deleteUserName"></span></div>
        <form id="deleteUserForm" method="POST" style="margin-top: 18px;">
            @csrf
            @method('DELETE')
            <button type="submit" class="admin-form-btn" style="margin-right: 10px;">Удалить</button>
            <button type="button" class="admin-form-btn admin-form-btn-secondary" onclick="closeDeleteModal()">Отмена</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<style>
.admin-users-section {
    min-height: 100vh;
    padding: 40px 0;
    background: none;
}
.admin-users-container {
    max-width: 1300px;
    margin: 0 auto;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
    padding: 40px 32px 32px 32px;
}
.admin-user-search-form {
    margin-bottom: 24px;
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    align-items: center;
    justify-content: flex-start;
}
.admin-user-search-input {
    max-width: 320px;
    flex: 1 1 220px;
}
.admin-table-responsive {
    overflow-x: auto;
    border-radius: 12px;
    margin-bottom: 18px;
}
.admin-users-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    min-width: 900px;
}
.admin-users-table th, .admin-users-table td {
    padding: 14px 12px;
    border-bottom: 1px solid #f1f1f1;
    text-align: left;
    font-size: 16px;
}
.admin-users-table th {
    background: #f7f8fa;
    font-weight: 700;
    color: #2d3748;
    letter-spacing: 0.5px;
}
.admin-users-table tr:last-child td {
    border-bottom: none;
}
.role-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #fff;
    background: #009ffd;
    letter-spacing: 0.5px;
}
.role-admin {
    background: #2563eb;
}
.role-user {
    background: #009ffd;
}
.admin-pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 24px;
}
/* Красивая пагинация */
.pagination {
    display: flex;
    gap: 6px;
    list-style: none;
    padding: 0;
    margin: 0;
}
.pagination li {
    display: inline-block;
}
.pagination a, .pagination span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 16px;
    height: 40px;
    min-width: 40px;
    border-radius: 8px;
    background: #f7f8fa;
    color: #2563eb;
    font-weight: 500;
    text-decoration: none !important;
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
    border: none;
    font-size: 16px;
    box-shadow: none;
    margin: 0 2px;
}
.pagination a:hover {
    background: #2563eb;
    color: #fff;
    box-shadow: 0 2px 8px rgba(37,99,235,0.08);
    text-decoration: none !important;
}
.pagination .active span {
    background: #2563eb;
    color: #fff;
    font-weight: 700;
    cursor: default;
    box-shadow: 0 2px 8px rgba(37,99,235,0.12);
}
.pagination .disabled span,
.pagination .disabled a {
    background: #ececec;
    color: #b0b0b0;
    cursor: not-allowed;
    pointer-events: none;
    text-decoration: none !important;
}
@media (max-width: 1100px) {
    .admin-users-container {
        max-width: 100vw;
        padding: 20px 4px;
    }
    .admin-users-table {
        min-width: 700px;
    }
}
@media (max-width: 700px) {
    .admin-users-table th, .admin-users-table td {
        font-size: 13px;
        padding: 8px 6px;
    }
    .admin-users-table {
        min-width: 500px;
    }
    .admin-users-container {
        padding: 10px 2px;
    }
}
.admin-action-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    font-size: 1.1rem;
    border: none;
    background: #f7f8fa;
    color: #2563eb;
    transition: background 0.18s, color 0.18s, box-shadow 0.18s;
    cursor: pointer;
    box-shadow: 0 1px 4px rgba(37,99,235,0.04);
    padding: 0;
    outline: none;
    text-decoration: none !important;
}
.admin-action-btn i {
    pointer-events: none;
}
.admin-action-btn:hover, .admin-action-btn:focus {
    background: #2563eb;
    color: #fff;
    box-shadow: 0 2px 8px rgba(37,99,235,0.10);
    text-decoration: none !important;
}
.admin-action-view {
    background: #e3f0ff;
    color: #2563eb;
}
.admin-action-view:hover, .admin-action-view:focus {
    background: #2563eb;
    color: #fff;
}
.admin-action-edit {
    background: #e6ffe3;
    color: #1e7e34;
}
.admin-action-edit:hover, .admin-action-edit:focus {
    background: #1e7e34;
    color: #fff;
}
.admin-action-delete {
    background: #fff5f5;
    color: #d9363e;
}
.admin-action-delete:hover, .admin-action-delete:focus {
    background: #d9363e;
    color: #fff;
}
.admin-modal-success {
    position: fixed;
    top: 40px;
    left: 50%;
    transform: translateX(-50%);
    background: #2563eb;
    color: #fff;
    padding: 18px 38px;
    border-radius: 12px;
    box-shadow: 0 6px 32px rgba(37,99,235,0.18);
    font-size: 1.1rem;
    font-weight: 600;
    z-index: 9999;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s;
}
.admin-modal-success.active {
    opacity: 1;
    pointer-events: auto;
}
.admin-modal-delete-bg {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.25);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
}
.admin-modal-delete {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(37,99,235,0.18);
    padding: 36px 32px 28px 32px;
    min-width: 320px;
    max-width: 95vw;
    text-align: center;
    position: relative;
}
.admin-modal-delete-title {
    font-size: 1.25rem;
    font-weight: 700;
    margin-bottom: 10px;
    color: #d9363e;
}
.admin-modal-delete-desc {
    color: #333;
    font-size: 1.08rem;
    margin-bottom: 8px;
}
.admin-breadcrumbs {
    font-size: 1.05rem;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.admin-breadcrumb-link {
    color: #2563eb;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.18s;
}
.admin-breadcrumb-link:hover {
    color: #009ffd;
    text-decoration: underline;
}
.admin-breadcrumb-sep {
    color: #b0b0b0;
    font-size: 1.1em;
}
.admin-breadcrumb-current {
    color: #888;
    font-weight: 500;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('admin-modal-success');
    if (modal) {
        setTimeout(function() {
            modal.classList.add('active');
            setTimeout(function() {
                modal.classList.remove('active');
            }, 2000);
        }, 100);
    }
});
function showDeleteModal(userId, userName) {
    document.getElementById('deleteUserModal').style.display = 'flex';
    document.getElementById('deleteUserName').textContent = userName;
    var form = document.getElementById('deleteUserForm');
    form.action = '/admin/users/' + userId;
}
function closeDeleteModal() {
    document.getElementById('deleteUserModal').style.display = 'none';
}
// Закрытие по ESC
window.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeDeleteModal();
});
// Клик вне модального окна
window.addEventListener('mousedown', function(e) {
    var modal = document.querySelector('.admin-modal-delete');
    var bg = document.getElementById('deleteUserModal');
    if (bg.style.display === 'flex' && !modal.contains(e.target)) closeDeleteModal();
});
</script>
@endpush 