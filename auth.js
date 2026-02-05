

// Save user data
function saveUser(name, mobile) {
    localStorage.setItem(
        "aspordUser",
        JSON.stringify({ name: name.trim(), mobile: mobile.trim() })
    );
}

// Form submit
const form = document.getElementById("userForm");

if (form) {
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const name = document.getElementById("username").value;
        const mobile = document.getElementById("mobile").value;

        if (!name || !mobile) return;

        saveUser(name, mobile);

        // ✅ CORRECT redirect (same folder)
        window.location.href = "home.php";
    });
}

// adding username to the home
function getUser() {
    const data = localStorage.getItem("aspordUser");
    return data ? JSON.parse(data) : null;
}

const user = getUser();

// Auto-fill form if user exists
document.addEventListener('DOMContentLoaded', () => {
    const userData = getUser();
    if (userData) {
        const nameInput = document.getElementById('authName');
        const phoneInput = document.getElementById('authPhone');
        const welcomeSpan = document.getElementById('welcomeUser');

        if (nameInput) nameInput.value = userData.name || '';
        if (phoneInput) phoneInput.value = userData.mobile || '';

        // Only update welcome message if it's empty (PHP didn't set it)
        if (welcomeSpan && !welcomeSpan.textContent && userData.name) {
            welcomeSpan.textContent = 'Welcome, ' + userData.name;
        }
    }
});

