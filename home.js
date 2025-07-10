// home.js - For Home Page Specific Interactions

document.addEventListener('DOMContentLoaded', () => {

    // --- Scroll-triggered Animations ---
    const scrollElements = document.querySelectorAll('.animate-on-scroll');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            }
        });
    }, { threshold: 0.1 });
    scrollElements.forEach(el => { observer.observe(el); });

    // --- FIXED: Restored AI Chatbot Logic ---
    const chatbotContainer = document.getElementById('chatbot-container');
    const chatbotToggleBtn = document.getElementById('chatbot-toggle-btn');
    const chatbotMessages = document.getElementById('chatbot-messages');
    const chatbotInput = document.getElementById('chatbot-input');
    const chatbotSendBtn = document.getElementById('chatbot-send-btn');

    // Check if chatbot elements exist on the page before adding listeners
    if (chatbotContainer && chatbotToggleBtn && chatbotMessages && chatbotInput && chatbotSendBtn) {
        // Toggle chatbot window visibility
        chatbotToggleBtn.addEventListener('click', () => {
            chatbotContainer.classList.toggle('active');
        });

        // Send message on button click
        chatbotSendBtn.addEventListener('click', sendMessage);

        // Send message on Enter key press
        chatbotInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    }

    async function sendMessage() {
        const userInput = chatbotInput.value.trim();
        if (!userInput) return;

        addMessage(userInput, 'user');
        chatbotInput.value = '';
        showLoadingIndicator();

        try {
            // --- Call Gemini API ---
            const prompt = `You are a friendly and helpful AI assistant for a public grievance website called "CivicPulse". Your role is to answer user questions about the platform. Be concise and clear. User's question: "${userInput}"`;

            let chatHistory = [{ role: "user", parts: [{ text: prompt }] }];
            const payload = { contents: chatHistory };
            const apiKey = "AIzaSyDWj_1B39HTzWUzkGw3KIvj8895c5-aouA"; // API key will be provided by the environment
            const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${apiKey}`;

            const response = await fetch(apiUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            if (!response.ok) {
                throw new Error(`API error: ${response.statusText}`);
            }

            const result = await response.json();
            hideLoadingIndicator();

            if (result.candidates?.[0]?.content?.parts?.[0]?.text) {
                const botResponse = result.candidates[0].content.parts[0].text;
                addMessage(botResponse, 'bot');
            } else {
                addMessage("Sorry, I couldn't process that. Please try again.", 'bot');
            }

        } catch (error) {
            console.error("Chatbot API Error:", error);
            hideLoadingIndicator();
            addMessage("I'm having trouble connecting right now. Please try again later.", 'bot');
        }
    }

    function addMessage(text, sender) {
        const messageElement = document.createElement('div');
        messageElement.className = `chat-message ${sender}-message`;
        const p = document.createElement('p');
        p.textContent = text;
        messageElement.appendChild(p);
        chatbotMessages.appendChild(messageElement);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    function showLoadingIndicator() {
        const loadingElement = document.createElement('div');
        loadingElement.className = 'chat-message bot-message';
        loadingElement.id = 'loading-indicator';
        loadingElement.innerHTML = '<div class="loading-dots"><span></span><span></span><span></span></div>';
        chatbotMessages.appendChild(loadingElement);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        chatbotSendBtn.disabled = true;
    }

    function hideLoadingIndicator() {
        const indicator = document.getElementById('loading-indicator');
        if (indicator) {
            indicator.remove();
        }
        chatbotSendBtn.disabled = false;
    }
});
