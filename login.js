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
    const isOnlineDemo = window.location.protocol.startsWith('file:') || !['localhost', '127.0.0.1'].includes(window.location.hostname);
    console.log(isOnlineDemo ? "Running in Online Demo Mode" : "Running in Local Database Mode");


    // --- Image URLs ---
    const loginImageUrl = 'login.jpg';
    const signupImageUrl = 'signup.jpg'
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
                showNotification('Login successful! Redirecting...', 'success');
                setTimeout(() => {
                    window.location.href = 'home.php'; 
                }, 1500);
            } else {
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

    // --- FIXED: Restored Gemini API Logic ---
    
    // Gemini API: Forgot Email
    const geminiModal = document.getElementById('gemini-modal');
    const openModalBtn = document.getElementById('open-gemini-modal-btn');
    const closeModalBtn = document.getElementById('close-gemini-modal-btn');
    const getHelpBtn = document.getElementById('get-gemini-help-btn');
    const promptInput = document.getElementById('gemini-prompt-input');
    const resultDiv = document.getElementById('gemini-result');
    const spinner = document.getElementById('gemini-spinner');
    const btnText = document.getElementById('gemini-btn-text');

    if(openModalBtn) openModalBtn.addEventListener('click', () => geminiModal.classList.remove('hidden'));
    if(closeModalBtn) closeModalBtn.addEventListener('click', () => geminiModal.classList.add('hidden'));

    if(getHelpBtn) getHelpBtn.addEventListener('click', async () => {
        const userInput = promptInput.value.trim();
        if (!userInput) {
            resultDiv.textContent = 'Please enter some information first.';
            resultDiv.classList.remove('hidden');
            return;
        }

        getHelpBtn.disabled = true;
        spinner.classList.remove('hidden');
        btnText.textContent = 'Thinking...';
        resultDiv.classList.add('hidden');

        try {
            const prompt = `A user of a "Public Grievance System" forgot their login email. Based on their self-description, suggest 3 plausible email address formats they might have used. Provide a friendly, encouraging sentence and the email suggestions. User description: "${userInput}". Respond with a JSON object containing two keys: "suggestion" (a string) and "possible_emails" (an array of 3 strings).`;
            let chatHistory = [{ role: "user", parts: [{ text: prompt }] }];
            const payload = { 
                contents: chatHistory,
                generationConfig: {
                    responseMimeType: "application/json",
                    responseSchema: {
                        type: "OBJECT",
                        properties: {
                            "suggestion": { "type": "STRING" },
                            "possible_emails": { "type": "ARRAY", "items": { "type": "STRING" } }
                        },
                        required: ["suggestion", "possible_emails"]
                    }
                }
            };
            const apiKey = "AIzaSyB0sStkQR33CYSglbISAKmg5HIQ6glKi2o"; 
            const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${apiKey}`;
            const response = await fetch(apiUrl, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
            if (!response.ok) throw new Error(`API error: ${response.statusText}`);
            const result = await response.json();
            if (result.candidates?.[0]?.content?.parts?.[0]) {
                const parsedJson = JSON.parse(result.candidates[0].content.parts[0].text);
                let htmlResult = `<p class="modal-description">${parsedJson.suggestion}</p><ul>`;
                parsedJson.possible_emails.forEach(email => { htmlResult += `<li><code>${email}</code></li>`; });
                htmlResult += `</ul>`;
                resultDiv.innerHTML = htmlResult;
            } else { throw new Error("Could not parse the response from the AI."); }
        } catch (error) {
            console.error("Gemini API Error:", error);
            resultDiv.textContent = 'Sorry, I had trouble connecting to the AI. Please try again later.';
        } finally {
            getHelpBtn.disabled = false;
            spinner.classList.add('hidden');
            btnText.textContent = 'Get Help';
            resultDiv.classList.remove('hidden');
        }
    });

    // Gemini API: Suggest Username
    const suggestUsernameBtn = document.getElementById('suggest-username-btn');
    const signupNameInput = document.getElementById('signup-name');
    const signupUsernameInput = document.getElementById('signup-username');
    const usernameSuggestionsDiv = document.getElementById('username-suggestions');

    if(suggestUsernameBtn) suggestUsernameBtn.addEventListener('click', async () => {
        const fullName = signupNameInput.value.trim();
        if (!fullName) {
            showNotification('Please enter your full name first.', 'error');
            return;
        }

        suggestUsernameBtn.disabled = true;
        suggestUsernameBtn.textContent = 'Thinking...';
        usernameSuggestionsDiv.innerHTML = '';

        try {
            const prompt = `Based on the name "${fullName}", suggest 4 creative and unique usernames for a public service app. Respond with a JSON object containing one key: "usernames" (an array of 4 strings).`;
            let chatHistory = [{ role: "user", parts: [{ text: prompt }] }];
            const payload = {
                contents: chatHistory,
                generationConfig: {
                    responseMimeType: "application/json",
                    responseSchema: {
                        type: "OBJECT",
                        properties: { "usernames": { "type": "ARRAY", "items": { "type": "STRING" } } },
                        required: ["usernames"]
                    }
                }
            };
            const apiKey = "AIzaSyB0sStkQR33CYSglbISAKmg5HIQ6glKi2o";
            const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${apiKey}`;
            const response = await fetch(apiUrl, { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(payload) });
            if (!response.ok) throw new Error(`API error: ${response.statusText}`);
            const result = await response.json();

            if (result.candidates?.[0]?.content?.parts?.[0]) {
                const parsedJson = JSON.parse(result.candidates[0].content.parts[0].text);
                parsedJson.usernames.forEach(username => {
                    const btn = document.createElement('button');
                    btn.textContent = username;
                    btn.className = 'username-choice';
                    btn.type = 'button';
                    btn.onclick = () => {
                        signupUsernameInput.value = username;
                        signupUsernameInput.dispatchEvent(new Event('focus'));
                        signupUsernameInput.dispatchEvent(new Event('blur'));
                    };
                    usernameSuggestionsDiv.appendChild(btn);
                });
            } else {
                throw new Error("Could not parse username suggestions from the AI.");
            }
        } catch (error) {
            console.error("Gemini Username Suggester Error:", error);
            showNotification('Could not get suggestions. Please try again.', 'error');
        } finally {
            suggestUsernameBtn.disabled = false;
            suggestUsernameBtn.innerHTML = 'Suggest Usernames ✨';
        }
    });
});
