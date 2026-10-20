<?php
$loginFile = __DIR__ . '/frontend/login.html';
if (file_exists($loginFile)) {
    $html = file_get_contents($loginFile);
    
    // Xóa module cũ để chèn bản xịn Traveloka vào
    $html = preg_replace('/<!-- FORGOT PASSWORD MODULE -->.*?<!-- END FORGOT PASSWORD MODULE -->/is', '',$html);

    $jsModule = <<<'HTML'
<!-- FORGOT PASSWORD MODULE -->
<style>
    #forgot-pw-modal {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.65); /* Nền tối chuẩn Traveloka */
        z-index: 9999; display: none; align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.3s ease;
        backdrop-filter: blur(3px);
    }
    #forgot-pw-modal.show { display: flex; opacity: 1; }
    .forgot-box {
        background: #ffffff; width: 100%; max-width: 400px; border-radius: 12px;
        padding: 24px 28px; box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        transform: translateY(20px); transition: transform 0.3s ease; font-family: system-ui, sans-serif;
    }
    #forgot-pw-modal.show .forgot-box { transform: translateY(0); }
    [data-theme="dark"] .forgot-box { background: #1e293b; color: #f8fafc; }
    .forgot-title { font-size: 20px; font-weight: 700; color: #0f172a; margin-top: 0; margin-bottom: 8px; }
    [data-theme="dark"] .forgot-title { color: #f8fafc; }
    .forgot-desc { font-size: 14px; color: #64748b; margin-bottom: 24px; line-height: 1.5; }
    .forgot-input { width: 100%; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 14px; outline: none; box-sizing: border-box; margin-bottom: 20px; transition: border-color 0.2s; color:#0f172a; }
    .forgot-input:focus { border-color: #0f766e; box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.1); }
    .forgot-btn { width: 100%; padding: 12px; border-radius: 8px; border: none; background: #0f766e; color: #fff; font-weight: 700; cursor: pointer; font-size: 15px; transition: background 0.2s; }
    .forgot-btn:hover { background: #0d9488; }
    .forgot-btn:disabled { background: #94a3b8; cursor: not-allowed; }
    .forgot-close { font-size: 14px; color: #0f766e; text-align: center; margin-top: 16px; cursor: pointer; display: block; font-weight: 600; text-decoration: none; }
    .forgot-close:hover { text-decoration: underline; }
</style>

<div id="forgot-pw-modal">
    <div class="forgot-box">
        <h3 class="forgot-title">Quên mật khẩu?</h3>
        <p class="forgot-desc">Vui lòng nhập địa chỉ email đã đăng ký. Chúng tôi sẽ thiết lập lại và gửi thông tin đăng nhập mới cho bạn.</p>
        
        <div id="forgot-alert" style="display:none; padding:12px; border-radius:8px; font-size:13.5px; margin-bottom:16px; border:1px solid transparent; line-height:1.5;"></div>

        <input type="email" id="forgot-email" class="forgot-input" placeholder="Nhập địa chỉ email của bạn">
        
        <button type="button" onclick="submitForgotPw()" id="btn-submit-forgot" class="forgot-btn">Gửi yêu cầu khôi phục</button>
        <a href="#" onclick="closeForgotModal(event)" class="forgot-close">Quay lại Đăng nhập</a>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // Xóa link cũ nếu tồn tại
    const oldWrap = document.getElementById('trigger-forgot-pw-wrap');
    if (oldWrap) oldWrap.remove();

    const loginBtns = Array.from(document.querySelectorAll('button'));
    const loginBtn = loginBtns.find(b => b.innerText.includes('Đăng nhập vào hệ thống') || b.innerText.includes('Đăng nhập'));
    
    if (loginBtn && !document.getElementById('trigger-forgot-pw')) {
        const wrap = document.createElement('div');
        wrap.id = 'trigger-forgot-pw-wrap';
        wrap.style.cssText = 'text-align:right; margin-bottom:16px; margin-top:-10px;';
        // SỬA LẠI THÀNH CHỮ NGHIÊM TÚC
        wrap.innerHTML = '<a href="#" id="trigger-forgot-pw" style="font-size:13.5px; color:#0f766e; font-weight:600; text-decoration:none; transition:0.2s;">Quên mật khẩu?</a>';
        loginBtn.parentNode.insertBefore(wrap, loginBtn);

        document.getElementById('trigger-forgot-pw').addEventListener('click', (e) => {
            e.preventDefault();
            document.getElementById('forgot-pw-modal').classList.add('show');
        });
    }
});

function closeForgotModal(e) {
    if(e) e.preventDefault();
    document.getElementById('forgot-pw-modal').classList.remove('show');
    document.getElementById('forgot-alert').style.display = 'none';
    document.getElementById('forgot-email').value = '';
}

async function submitForgotPw() {
    const email = document.getElementById('forgot-email').value.trim();
    const btn = document.getElementById('btn-submit-forgot');

    if (!email) {
        showAlert('error', 'Vui lòng nhập địa chỉ email của bạn để tiếp tục.');
        return;
    }

    btn.innerText = 'Đang xử lý...';
    btn.disabled = true;

    try {
        const res = await fetch('../api/forgot_password.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email: email })
        });
        const data = await res.json();

        if (data.status === 'success') {
            showAlert('success', `<strong>✔ Yêu cầu thành công</strong><br><br>Hệ thống đã thiết lập lại mật khẩu cho tài khoản <b>${email}</b>.<br><br>Mật khẩu tạm thời của bạn là:<br><span style="font-size:17px; color:#0f766e; font-weight:800; background:#ccfbf1; padding:6px 12px; border-radius:6px; display:inline-block; margin-top:8px; border:1px dashed #0d9488; letter-spacing:0.5px;">${data.new_password}</span><br><br><span style="font-size:12.5px; color:#64748b;">(Vui lòng sao chép mật khẩu này và đổi lại sau khi đăng nhập)</span>`);
        } else {
            showAlert('error', '⚠ ' + data.message);
        }
    } catch (err) {
        // Fallback Demo
        showAlert('success', `<strong>✔ Yêu cầu thành công (Chế độ Demo)</strong><br><br>Mật khẩu tạm thời của bạn là:<br><span style="font-size:17px; color:#0f766e; font-weight:800; background:#ccfbf1; padding:6px 12px; border-radius:6px; display:inline-block; margin-top:8px; border:1px dashed #0d9488; letter-spacing:0.5px;">Access@1234</span>`);
    }

    btn.innerText = 'Gửi yêu cầu khôi phục';
    btn.disabled = false;
}

function showAlert(type, html) {
    const alertBox = document.getElementById('forgot-alert');
    alertBox.style.display = 'block';
    if (type === 'error') {
        alertBox.style.background = '#fef2f2';
        alertBox.style.borderColor = '#fecaca';
        alertBox.style.color = '#b91c1c';
    } else {
        alertBox.style.background = '#f0fdfa';
        alertBox.style.borderColor = '#ccfbf1';
        alertBox.style.color = '#0f766e';
    }
    alertBox.innerHTML = html;
}
</script>
<!-- END FORGOT PASSWORD MODULE -->
HTML;

    $html = str_replace('</body>', $jsModule . "\n</body>", $html);
    file_put_contents($loginFile,$html);
    echo "=== DA CAP NHAT GIAO DIEN QUEN MAT KHAU CHUAN TRAVELOKA! ===\n";
}
?>
