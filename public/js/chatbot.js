document.addEventListener('DOMContentLoaded', function() {
    console.log('Chatbot script loaded.');

    const chatBubble = document.getElementById('chat-bubble');
    const chatbotContainer = document.getElementById('chatbot-container');
    const chatInput = document.querySelector('.chat-input');
    const chatMessages = document.querySelector('.chat-messages');

    if (!chatBubble) {
        console.error('Chatbot Error: Bubble element not found.');
        return;
    }
    if (!chatbotContainer) {
        console.error('Chatbot Error: Container element not found.');
        return;
    }

    console.log('Chatbot elements found.');

    chatBubble.addEventListener('click', () => {
        console.log('Chat bubble clicked.');
        chatbotContainer.style.display = chatbotContainer.style.display === 'none' || chatbotContainer.style.display === '' ? 'flex' : 'none';
        // Add a welcome message only on the first open
        if (chatbotContainer.style.display === 'flex' && chatMessages.children.length === 0) {
            console.log('Initializing chat with welcome message.');
            addMessage('Hello! How can I help you today?', true);
        }
    });

    let currentStep = 'reservation_start';

    function addMessage(text, isBot = false) {
        const msg = document.createElement('div');
        const msgClass = isBot ? 'bot-message' : 'user-message';
        msg.classList.add(msgClass);
        msg.textContent = text;
        chatMessages.appendChild(msg);
        chatMessages.scrollTop = chatMessages.scrollHeight; // Auto-scroll
    }

    async function handleResponse(data) {
        currentStep = data.next_step;
        addMessage(data.message, true);
        // Handle options if provided
    }

    chatInput.addEventListener('keypress', async function(e) {
        if (e.key === 'Enter') {
            const message = chatInput.value.trim();
            if (message) {
                addMessage(message);
                chatInput.value = '';
                
                try {
                    const response = await fetch('/chatbot', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Important for Laravel
                        },
                        body: JSON.stringify({ step: currentStep, message })
                    });

                    if (!response.ok) {
                        console.error('Chatbot API Error:', response.statusText);
                        addMessage('Sorry, something went wrong.', true);
                        return;
                    }

                    const responseData = await response.json();
                    handleResponse(responseData);
                } catch (error) {
                    console.error('Chatbot Fetch Error:', error);
                    addMessage('Sorry, I cannot connect to the server right now.', true);
                }
            }
        }
    });

    console.log('Chatbot script initialized successfully.');
});
