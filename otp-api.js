/**
 * Email OTP Integration Functions
 */

const API_BASE = './api';
let currentEmail = '';
let resendTimer = null;

function sendEmailOTP() {
    const name = document.getElementById("authName").value.trim();
    const email = document.getElementById("authEmail").value.trim();

    console.log('Attempting to send Email OTP to:', email);

    // Clear previous errors
    hideError('authError');

    if (!name || !email) {
        showError('authError', 'Please enter name and email');
        return;
    }

    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        showError('authError', 'Please enter a valid email address');
        return;
    }

    // Show loading state
    setButtonLoading('sendOtpBtn', true);

    // Call API
    fetch(`${API_BASE}/send-otp-email.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ name, email })
    })
        .then(response => response.json())
        .then(data => {
            setButtonLoading('sendOtpBtn', false);

            if (data.success) {
                currentEmail = email;

                // Switch to OTP section
                document.getElementById("authDetailsSection").style.display = "none";
                document.getElementById("otpSection").style.display = "block";

                document.getElementById("otpMessage").textContent = data.message || `Code sent to ${email}`;
                showPopup("Verification code sent!", '<i class="fas fa-envelope"></i>');

                // Focus first input
                const firstInput = document.querySelector(".otp-digit");
                if (firstInput) firstInput.focus();

                startResendTimer();
            } else {
                showError('authError', data.error || 'Failed to send email');
                alert('Error: ' + (data.error || 'Failed to send email'));
            }
        })
        .catch(error => {
            setButtonLoading('sendOtpBtn', false);
            console.error('Email OTP Error:', error);
            showError('authError', 'Network error. Please try again.');
        });
}

function verifyEmailOTP() {
    const otpInputs = document.querySelectorAll(".otp-digit");
    const enteredOTP = Array.from(otpInputs).map(input => input.value).join("");

    hideError('otpError');

    if (enteredOTP.length !== 6) {
        showError('otpError', 'Please enter 6-digit code');
        return;
    }

    setButtonLoading('verifyOtpBtn', true);

    fetch(`${API_BASE}/verify-otp-email.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        credentials: 'include',
        body: JSON.stringify({ email: currentEmail, otp: enteredOTP })
    })
        .then(async response => {
            const text = await response.text();
            try {
                const data = JSON.parse(text);
                setButtonLoading('verifyOtpBtn', false);
                if (data.success) {
                    showPopup("Email verified!", '<i class="fas fa-check-circle"></i>');
                    document.getElementById("authModal").style.display = "none";
                    window.isVerified = true;
                    localStorage.setItem("aspordUser", JSON.stringify({
                        name: document.getElementById("authName").value,
                        email: currentEmail
                    }));
                    sessionStorage.setItem("aspord_cart", JSON.stringify(cart));
                    setTimeout(() => window.location.href = "payment.php", 800);
                } else {
                    showError('otpError', data.error || 'Invalid code');
                }
            } catch (e) {
                setButtonLoading('verifyOtpBtn', false);
                alert('Server Error: ' + text.substring(0, 300));
                console.error('Raw Server Response:', text);
            }
        })
        .catch(error => {
            setButtonLoading('verifyOtpBtn', false);
            showError('otpError', 'Network error: ' + error.message);
        });
}

function moveFocus(current, index) {
    const inputs = document.querySelectorAll(".otp-digit");
    if (current.value.length > 1) current.value = current.value.slice(0, 1);
    if (current.value && index < inputs.length - 1) inputs[index + 1].focus();
}

function startResendTimer() {
    let seconds = 60;
    const resendBtn = document.getElementById("resendOtpBtn");
    const countdown = document.getElementById("resendCountdown");
    resendBtn.style.display = "none";
    if (resendTimer) clearInterval(resendTimer);
    resendTimer = setInterval(() => {
        seconds--;
        if (seconds > 0) {
            countdown.textContent = ` (${seconds}s)`;
        } else {
            clearInterval(resendTimer);
            resendBtn.style.display = "block";
            countdown.textContent = "";
        }
    }, 1000);
}

// Reuse helper functions from previous setup
function showError(elementId, message) {
    const errorEl = document.getElementById(elementId);
    if (errorEl) {
        errorEl.textContent = message;
        errorEl.style.display = 'block';
    }
}

function hideError(elementId) {
    const errorEl = document.getElementById(elementId);
    if (errorEl) errorEl.style.display = 'none';
}

function setButtonLoading(buttonId, isLoading) {
    const button = document.getElementById(buttonId);
    if (!button) return;
    const textSpan = button.querySelector('[id$="Text"]');
    const loaderSpan = button.querySelector('[id$="Loader"]');
    if (isLoading) {
        button.disabled = true;
        button.style.opacity = '0.7';
        if (textSpan) textSpan.style.display = 'none';
        if (loaderSpan) loaderSpan.style.display = 'inline';
    } else {
        button.disabled = false;
        button.style.opacity = '1';
        if (textSpan) textSpan.style.display = 'inline';
        if (loaderSpan) loaderSpan.style.display = 'none';
    }
}
