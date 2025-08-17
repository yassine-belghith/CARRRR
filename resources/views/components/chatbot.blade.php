<div id="chatbot-container" class="chatbot-container">
    <div id="chatbot-header" class="chatbot-header">
        <span>Assistance</span>
        <button id="close-chatbot" class="close-chatbot">&times;</button>
    </div>
    <div id="chat-messages" class="chat-messages">
    </div>
    <div class="chat-input-container">
        <input type="text" id="chat-input" class="chat-input" placeholder="Posez votre question...">
        <button id="send-chat" class="send-chat-btn">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>

<div id="chat-bubble" class="chat-bubble">
    <i class="fas fa-comment-dots"></i>
</div>

<style>
    /* Chat Bubble */
    .chat-bubble {
        position: fixed;
        bottom: 25px;
        right: 25px;
        width: 60px;
        height: 60px;
        background-color: #007bff;
        color: white;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 28px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: transform 0.2s ease, background-color 0.2s ease;
        z-index: 9998;
    }

    .chat-bubble:hover {
        transform: scale(1.1);
        background-color: #0056b3;
    }

    /* Chatbot Container */
    .chatbot-container {
        position: fixed;
        bottom: 100px;
        right: 25px;
        width: 350px;
        max-width: 90vw;
        height: 500px;
        max-height: 70vh;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        display: none; /* Initially hidden */
        flex-direction: column;
        overflow: hidden;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        transition: opacity 0.3s ease, transform 0.3s ease;
        transform: translateY(20px);
        opacity: 0;
        z-index: 9999;
    }

    .chatbot-container.active {
        display: flex;
        transform: translateY(0);
        opacity: 1;
    }

    /* Chatbot Header */
    .chatbot-header {
        background-color: #007bff;
        color: white;
        padding: 15px;
        font-weight: 600;
        font-size: 1.1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
    }

    .close-chatbot {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        opacity: 0.8;
        padding: 0;
        line-height: 1;
    }
    .close-chatbot:hover {
        opacity: 1;
    }

    /* Chat Messages */
    .chat-messages {
        flex-grow: 1;
        padding: 20px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        background-color: #f5f5f7;
    }

    .message {
        padding: 10px 15px;
        border-radius: 18px;
        max-width: 80%;
        line-height: 1.4;
        word-wrap: break-word;
    }

    .bot-message {
        background-color: #e9e9eb;
        color: #1c1c1e;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
    }

    .user-message {
        background-color: #007bff;
        color: white;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }

    /* Chat Input */
    .chat-input-container {
        display: flex;
        padding: 10px;
        border-top: 1px solid #e5e5e7;
        background-color: #ffffff;
        flex-shrink: 0;
    }

    .chat-input {
        flex-grow: 1;
        border: 1px solid #e5e5e7;
        border-radius: 20px;
        padding: 10px 15px;
        font-size: 1rem;
        outline: none;
        transition: border-color 0.2s ease;
    }

    .chat-input:focus {
        border-color: #007bff;
    }

    .send-chat-btn {
        background: none;
        border: none;
        color: #007bff;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: color 0.2s ease;
    }

    .send-chat-btn:hover {
        color: #0056b3;
    }
</style>




