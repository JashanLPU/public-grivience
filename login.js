// =================================================================
// login.js - The Complete Connector for the Login & Signup Page
// =================================================================
// This script handles ALL client-side interactions on the index.html page.
// It includes logic to switch between a live database mode and an online demo mode.
// =================================================================

document.addEventListener('DOMContentLoaded', () => {

    // --- Element References ---
    const loginBg = document.getElementById('login-bg');
    const signupBg = document.getElementById('signup-bg');
    const loginPage = document.getElementById('login-page');
    const signupPage = document.getElementById('signup-page');
    const gotoSignupBtn = document.getElementById('goto-signup-btn');
    const gotoLoginBtn = document.getElementById('goto-login-btn');
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');
    const notification = document.getElementById('notification');

    // --- DUAL MODE LOGIC ---
    // This checks if the website is running on a live server (like XAMPP's localhost)
    // or as a simple file online (like on GitHub Pages).
    const isOnlineDemo = window.location.protocol.startsWith('file:') || !['localhost', '127.0.0.1'].includes(window.location.hostname);
    console.log(isOnlineDemo ? "Running in Online Demo Mode" : "Running in Local Database Mode");


    // --- Image URLs ---
    const loginImageUrl = 'login.jpg';
    const signupImageUrl = 'signup.jpg';

    // --- Set Initial State on Load ---
    if (loginBg && signupBg) {
        loginBg.style.backgroundImage = `url('${loginImageUrl}')`;
        signupBg.style.backgroundImage = `url('${signupImageUrl}')`;
        loginBg.classList.add('is-active');
        signupBg.classList.add('is-inactive-right');
    }

    // --- Event Listeners for Toggling Pages ---
    function showLoginPage() {
        loginBg.classList.remove('is-inactive-left');
        loginBg.classList.add('is-active');
        signupBg.classList.remove('is-active');
        signupBg.classList.add('is-inactive-right');
        loginPage.classList.remove('is-inactive-left');
        loginPage.classList.add('is-active');
        signupPage.classList.remove('is-active');
        signupPage.classList.add('is-inactive-right');
    }

    function showSignupPage() {
        loginBg.classList.remove('is-active');
        loginBg.classList.add('is-inactive-left');
        signupBg.classList.remove('is-inactive-right');
        signupBg.classList.add('is-active');
        loginPage.classList.remove('is-active');
        loginPage.classList.add('is-inactive-left');
        signupPage.classList.remove('is-inactive-right');
        signupPage.classList.add('is-active');
    }

    if (gotoLoginBtn) gotoLoginBtn.addEventListener('click', showLoginPage);
    if (gotoSignupBtn) gotoSignupBtn.addEventListener('click', showSignupPage);

    // --- Custom Notification Function ---
    function showNotification(message, type = 'success') {
        if (!notification) {
            alert(message);
            return;
        }
        notification.textContent = message;
        notification.className = `notification show ${type}`;
        setTimeout(() => {
            notification.classList.remove('show');
        }, 4000);
    }

    // --- Form Submission Logic ---

    // Event Listener for Signup Form
    if (signupForm) {
        signupForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (isOnlineDemo) {
                showNotification('Signup is disabled in demo mode.', 'error');
                return;
            }
            
            // --- Database Mode Logic ---
            const formData = new FormData(signupForm);
            const submitButton = signupForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'Creating Account...';
            try {
                const response = await fetch('register.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.status === 'success') {
                    showNotification(result.message, 'success');
                    signupForm.reset();
                    showLoginPage();
                } else {
                    showNotification(result.message, 'error');
                }
            } catch (error) {
                showNotification('An error occurred. Please try again.', 'error');
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Create Account';
            }
        });
    }

    // Event Listener for Login Form
    if (loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitButton = loginForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.textContent = 'Logging In...';

            if (isOnlineDemo) {
                // --- Online Demo Mode ---
                showNotification('Login successful! Redirecting...', 'success');
                setTimeout(() => {
                    window.location.href = 'home.php'; 
                }, 1500);
            } else {
                // --- Database Mode ---
                const formData = new FormData(loginForm);
                try {
                    const response = await fetch('login.php', { method: 'POST', body: formData });
                    const result = await response.json();
                    if (result.status === 'success') {
                        showNotification('Login successful! Redirecting...', 'success');
                        setTimeout(() => {
                            window.location.href = 'home.php';
                        }, 1500);
                    } else {
                        showNotification(result.message, 'error');
                    }
                } catch (error) {
                    showNotification('An error occurred. Please try again.', 'error');
                } finally {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Login';
                }
            }
        });
    }

    // --- Gemini API Logic (remains the same) ---
    // ... (The Gemini API code for "Forgot Email" and "Suggest Username" goes here) ...
});
