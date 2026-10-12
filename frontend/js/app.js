function initAccessibilityTheme() {
    const savedTheme = localStorage.getItem('accesstravel_theme') || 'light';
    if (savedTheme === 'accessible') {
        document.documentElement.setAttribute('data-theme', 'accessible');
    }
    updateThemeButtonText();
}

function toggleAccessibilityTheme() {
    const current = document.documentElement.getAttribute('data-theme');
    if (current === 'accessible') {
        document.documentElement.removeAttribute('data-theme');
        localStorage.setItem('accesstravel_theme', 'light');
    } else {
        document.documentElement.setAttribute('data-theme', 'accessible');
        localStorage.setItem('accesstravel_theme', 'accessible');
    }
    updateThemeButtonText();
}

function updateThemeButtonText() {
    const btn = document.getElementById('btnThemeToggle');
    if (!btn) return;
    const isAcc = document.documentElement.getAttribute('data-theme') === 'accessible';
    btn.innerHTML = isAcc 
        ? '👁️ Tắt Chế Độ Chữ To / Tương Phản Cao' 
        : '♿ Chế Độ Người Cao Tuổi (Chữ To)';
}

function getCurrentUser() {
    const raw = localStorage.getItem('accesstravel_user');
    if (!raw) return null;
    try { return JSON.parse(raw); } catch (e) { return null; }
}

function renderNavbarAuth() {
    const user = getCurrentUser();
    const authBox = document.getElementById('navAuthArea');
    const adminLink = document.getElementById('navAdminLink');

    if (!user) {
        if (adminLink) adminLink.style.display = 'none';
        if (authBox) {
            authBox.innerHTML = '<a href="login.html" class="btn btn-primary">👤 Đăng nhập</a>';
        }
        return;
    }

    if (adminLink) {
        adminLink.style.display = (user.role === 'admin') ? 'inline-flex' : 'none';
    }

    const roleLabel = user.role === 'admin' ? 'Quản trị viên (Admin)' : 'Thành viên (User)';
    if (authBox) {
        authBox.innerHTML = '<span style="font-weight:700; padding:6px 12px; background:var(--color-primary-light); border-radius:8px; margin-right:8px;">👋 ' + user.full_name + ' <small>(' + roleLabel + ')</small></span>' +
            '<button onclick="logoutUser()" class="btn btn-outline" style="padding:8px 14px;">Đăng xuất</button>';
    }
}

async function logoutUser() {
    try { await fetch('../api/logout.php', { method: 'POST' }); } catch (e) {}
    localStorage.removeItem('accesstravel_user');
    sessionStorage.clear();
    window.location.href = 'login.html';
}

document.addEventListener('DOMContentLoaded', () => {
    initAccessibilityTheme();
    renderNavbarAuth();
});
