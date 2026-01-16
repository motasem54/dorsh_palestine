/**
 * AI Chatbot JavaScript
 * Handles chatbot UI and interactions
 */

class Chatbot {
    constructor(options = {}) {
        this.apiUrl = options.apiUrl || '/api/chatbot.php';
        this.lang = options.lang || 'en';
        this.opened = false;
        this.conversationHistory = [];
        
        this.init();
    }
    
    init() {
        this.createChatWidget();
        this.attachEventListeners();
    }
    
    createChatWidget() {
        // Create chat button
        const chatButton = document.createElement('div');
        chatButton.id = 'chatbot-button';
        chatButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
        `;
        
        // Create chat window
        const chatWindow = document.createElement('div');
        chatWindow.id = 'chatbot-window';
        chatWindow.innerHTML = `
            <div class="chatbot-header">
                <div class="chatbot-header-content">
                    <div class="chatbot-avatar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                            <line x1="9" y1="9" x2="9.01" y2="9"></line>
                            <line x1="15" y1="9" x2="15.01" y2="9"></line>
                        </svg>
                    </div>
                    <div class="chatbot-title">
                        <h4>${this.lang === 'ar' ? 'المساعد الذكي' : 'AI Assistant'}</h4>
                        <span>${this.lang === 'ar' ? 'متصل' : 'Online'}</span>
                    </div>
                </div>
                <button id="chatbot-close" class="chatbot-close-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="chatbot-messages" id="chatbot-messages">
                <div class="chatbot-message bot-message">
                    <div class="message-content">
                        ${this.lang === 'ar' ? 'مرحباً! كيف يمكنني مساعدتك اليوم؟' : 'Hello! How can I help you today?'}
                    </div>
                </div>
            </div>
            <div class="chatbot-input-area">
                <input 
                    type="text" 
                    id="chatbot-input" 
                    placeholder="${this.lang === 'ar' ? 'اكتب رسالتك...' : 'Type your message...'}"
                    autocomplete="off"
                />
                <button id="chatbot-send" class="chatbot-send-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(chatButton);
        document.body.appendChild(chatWindow);
    }
    
    attachEventListeners() {
        const chatButton = document.getElementById('chatbot-button');
        const chatWindow = document.getElementById('chatbot-window');
        const closeBtn = document.getElementById('chatbot-close');
        const sendBtn = document.getElementById('chatbot-send');
        const input = document.getElementById('chatbot-input');
        
        chatButton.addEventListener('click', () => this.toggleChat());
        closeBtn.addEventListener('click', () => this.toggleChat());
        sendBtn.addEventListener('click', () => this.sendMessage());
        
        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.sendMessage();
            }
        });
    }
    
    toggleChat() {
        const chatWindow = document.getElementById('chatbot-window');
        const chatButton = document.getElementById('chatbot-button');
        
        this.opened = !this.opened;
        
        if (this.opened) {
            chatWindow.classList.add('active');
            chatButton.classList.add('hidden');
            document.getElementById('chatbot-input').focus();
        } else {
            chatWindow.classList.remove('active');
            chatButton.classList.remove('hidden');
        }
    }
    
    async sendMessage() {
        const input = document.getElementById('chatbot-input');
        const message = input.value.trim();
        
        if (!message) return;
        
        // Add user message to UI
        this.addMessage(message, 'user');
        input.value = '';
        
        // Show typing indicator
        this.showTyping();
        
        try {
            const response = await fetch(this.apiUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    message: message,
                    type: 'chat',
                    lang: this.lang,
                    history: this.conversationHistory
                })
            });
            
            const data = await response.json();
            
            // Remove typing indicator
            this.removeTyping();
            
            if (data.success) {
                // Add bot response
                this.addMessage(data.message, 'bot');
                
                // Update conversation history
                this.conversationHistory.push(
                    { role: 'user', content: message },
                    { role: 'assistant', content: data.message }
                );
                
                // Show products if any
                if (data.products && data.products.length > 0) {
                    this.showProducts(data.products);
                }
            } else {
                this.addMessage(
                    this.lang === 'ar' ? 'عذراً، حدث خطأ. حاول مرة أخرى.' : 'Sorry, an error occurred. Please try again.',
                    'bot'
                );
            }
        } catch (error) {
            this.removeTyping();
            this.addMessage(
                this.lang === 'ar' ? 'عذراً، فشل الاتصال. تحقق من اتصالك بالإنترنت.' : 'Sorry, connection failed. Check your internet.',
                'bot'
            );
        }
    }
    
    addMessage(text, sender) {
        const messagesContainer = document.getElementById('chatbot-messages');
        const messageDiv = document.createElement('div');
        messageDiv.className = `chatbot-message ${sender}-message`;
        messageDiv.innerHTML = `<div class="message-content">${this.escapeHtml(text)}</div>`;
        
        messagesContainer.appendChild(messageDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
    
    showTyping() {
        const messagesContainer = document.getElementById('chatbot-messages');
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typing-indicator';
        typingDiv.className = 'chatbot-message bot-message';
        typingDiv.innerHTML = `
            <div class="message-content typing">
                <span></span><span></span><span></span>
            </div>
        `;
        messagesContainer.appendChild(typingDiv);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
    
    removeTyping() {
        const typing = document.getElementById('typing-indicator');
        if (typing) typing.remove();
    }
    
    showProducts(productIds) {
        // Implementation for showing product cards
        // This would fetch and display product cards
    }
    
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Initialize chatbot when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    const lang = document.documentElement.lang || 'en';
    new Chatbot({ lang: lang });
});
