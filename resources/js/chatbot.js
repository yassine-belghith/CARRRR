document.addEventListener('DOMContentLoaded', function() {
    // --- Element Selectors ---
    const chatBubble = document.getElementById('chat-bubble');
    const chatbotContainer = document.getElementById('chatbot-container');
    const closeChatbotBtn = document.getElementById('close-chatbot');
    const chatMessages = document.getElementById('chat-messages');
    const chatInput = document.getElementById('chat-input');
    const sendChatBtn = document.getElementById('send-chat');

    // --- Basic element validation ---
    if (!chatBubble || !chatbotContainer || !closeChatbotBtn || !chatMessages || !chatInput || !sendChatBtn) {
        console.error('[Chatbot] A critical element is missing. Chatbot cannot initialize.');
        return;
    }

    // --- Event Listeners ---
    chatBubble.addEventListener('click', toggleChatbot);
    closeChatbotBtn.addEventListener('click', toggleChatbot);
    sendChatBtn.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Prevents form submission if it's in a form
            sendMessage();
        }
    });

    // --- Functions ---
    function toggleChatbot() {
        const isActive = chatbotContainer.classList.toggle('active');
        if (isActive && chatMessages.children.length === 0) {
            // Add a small delay for the welcome message to appear after animation
            setTimeout(() => {
                addMessage('Bonjour! Comment puis-je vous aider aujourd\'hui?', 'bot-message');
            }, 300);
        }
    }

    function addMessage(text, type) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `message ${type}`; // e.g., 'message bot-message'
        msgDiv.innerHTML = text; // Use innerHTML to allow for links or other HTML
        chatMessages.appendChild(msgDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    async function sendMessage() {
        const messageText = chatInput.value.trim();
        if (!messageText) return;

        addMessage(messageText, 'user-message');
        chatInput.value = '';
        chatInput.focus();

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch('/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: messageText })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const responseData = await response.json();
            handleBotResponse(responseData);

        } catch (error) {
            console.error('[Chatbot] Fetch Error:', error);
            addMessage('Désolé, une erreur de connexion est survenue.', 'bot-message');
        }
    }

    function handleBotResponse(data) {
        addMessage(data.message, 'bot-message');

        if (data.action === 'redirect' && data.url) {
            addMessage('Je vous redirige...', 'bot-message');
            setTimeout(() => {
                window.location.href = data.url;
            }, 1500); // Wait 1.5 seconds before redirecting
        }
    }

    console.log('[Chatbot] Script initialized successfully.');
});
