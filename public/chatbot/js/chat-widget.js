(function (window) {

    /* =========================================================
       GLOBAL AJAX HELPER (Reusable Everywhere)
    ========================================================= */

    function chatAjax(options) {

        const defaults = {
            url: '',
            method: 'POST',
            data: {},
            onBefore: function () {}, 
            onSuccess: function () {},
            onError: function () {},
            onComplete: function () {}
        };

        const settings = Object.assign({}, defaults, options);

        $.ajax({
            url: settings.url,
            type: settings.method,
            contentType: 'application/json',
            dataType: 'json',
            data: JSON.stringify(settings.data),

            beforeSend: function () {
                settings.onBefore();
            },
            
            success: function (response) {
                settings.onSuccess(response);
            },

            error: function (xhr) {
                let message = 'Something went wrong';

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                settings.onError(message, xhr);
            },

            complete: function () {
                settings.onComplete();
            }
        });
    }

    /* =========================================================
       CHATBOT OBJECT
    ========================================================= */

    const ChatBot = {

        sessionId: null,
        body: null,
        email: null,

        /* ================= INIT ================= */

        init() {
            // this.sessionId = localStorage.getItem('chat_session_id') || crypto.randomUUID();
            this.injectHTML();
            this.bindEvents();
        },

        injectHTML() {

            const html = `
                <div id="chatbot-icon">
                    <img src="https://thegoldengreens.com/chatbot/images/grace-ai-2.jpg"
                        alt="Grace AI"
                        style="width: 64px; height: 64px; border-radius: 50%; object-fit: cover;"
                    >
                    <span class="chatbot-dot"></span>

                </div>

                <div id="chatbot-box">
                    <div class="chat-header">
                        <span>
                            <div style="display: flex; align-items: center; gap: 10px;">
                            <img  src="https://thegoldengreens.com/chatbot/images/grace-ai-2.jpg"
                                    alt="Grace AI"
                                    style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;"
                                >
                               Grace Anandita
                                </div>
                            </span>
                        <div style="display: flex; gap: 10px;">
                        <button class="chat-close" style="background: linear-gradient(135deg,#4f46e5,#22d3ee); border: none;color: white; padding: 6px 14px; border-radius: 12px;font-size: 12px;  font-weight: 600; cursor: pointer; box-shadow: 0 0 10px rgba(34,211,238,.6);
                        transition: all .2s ease;" onclick="ChatBot.startChat()">Restart</button>
                        <button class="chat-close" onclick="ChatBot.toggleChat()">✕</button>
                        </div>

                    </div>

                    <div class="chat-body" id="chat-body"></div>

                    <div class="chat-footer">
                        <small> Powered by TGG Meta</small>
                    </div>
                </div>
            `;

            document.body.insertAdjacentHTML('beforeend', html);
            this.body = document.getElementById('chat-body');
        },

        bindEvents() {
            document
                .getElementById('chatbot-icon')
                .addEventListener('click', () => this.toggleChat());
        },

        toggleChat() {

            const box = document.getElementById('chatbot-box');
            box.style.display = box.style.display === 'flex' ? 'none' : 'flex';

            if (this.body.innerHTML === '') {
                this.startChat();
            }
        },

        /* ================= CHAT START ================= */

        startChat() {

            sessionId = localStorage.getItem('chat_session_id') || crypto.randomUUID();
            chatAjax({
                url: '/api/chat/init',
                data: { session_id: sessionId },
                onBefore: () => {
                    this.body.innerHTML = `
                        <div class="loader-wrapper">
                            <div class="loader"></div>
                            <p>Processing...</p>
                        </div>
                    `;
                },
                onSuccess: (res) => {
                    this.sessionId = res.session_id;
                    localStorage.setItem('chat_session_id', this.sessionId);
                }
            });

            chatAjax({
                url: '/api/chat/welcome',
                onSuccess: (res) => {
                    this.body.innerHTML = '';
                    this.addBotMessage(res.html);
                    document.getElementById("chat-body").scrollTop = 0;
                }
            });
        },

        addBotMessage(html) {
            this.body.innerHTML += `<div class="chat-message bot">${html}</div>`;
            this.body.scrollTop = this.body.scrollHeight;
        },

        /* =========================================================
           ONBOARDING FLOW
        ========================================================= */

        startOnboarding() {

            this.body.innerHTML = '';
            this.addBotMessage("📝 Please fill the onboarding form");

            // Get user_type from URL (last segment)
            const urlSegments = window.location.pathname.split('/');
            const userTypeFromUrl = urlSegments[urlSegments.length - 1];

            chatAjax({
                url: '/api/chat/onboarding/form',
                data: {
                    user_type: userTypeFromUrl
                },

                onSuccess: (res) => {
                    this.addBotMessage(res.html);
                    this.initSelect2();

                    document
                        .getElementById('onboarding-form')
                        .addEventListener('submit', (e) => this.submitOnboarding(e));
                },

                onError: (msg) => {
                    this.addBotMessage("❌ " + msg);
                }
            });
        },

        submitOnboarding(e) {

            e.preventDefault();

            const data = Object.fromEntries(new FormData(e.target));

            chatAjax({
                url: '/api/chat/onboarding/submit',
                data: {
                    session_id: this.sessionId,
                    ...data
                },

                onBefore: () => {
                    this.body.innerHTML = `
                        <div class="loader-wrapper">
                            <div class="loader"></div>
                            <p>Processing payment...</p>
                        </div>
                    `;
                },

                onSuccess: (res) => {

                    this.addBotMessage("✅ " + res.message);
                    this.openPayment(res.enquiry_id);
                },

                onError: (msg) => {
                    this.addBotMessage("❌ " + msg);
                }
            });
        },

        /* ================= PAYMENT ================= */

        openPayment(enquiryId) {

            chatAjax({
                url: '/api/chat/payment/create',
                data: { enquiry_id: enquiryId },

                onSuccess: (order) => {

                    const options = {
                        key: order.key,
                        amount: order.amount,
                        currency: order.currency,
                        order_id: order.order_id,
                        handler: (response) => {
                            this.verifyPayment(response, enquiryId);
                        }
                    };

                    new Razorpay(options).open();
                }
            });
        },

        verifyPayment(response, enquiryId) {

            chatAjax({
                url: '/api/chat/payment/verify',
                data: {
                    session_id: this.sessionId,
                    enquiry_id: enquiryId,
                    ...response
                },

                onBefore: () => {
                    this.body.innerHTML = `
                        <div class="loader-wrapper">
                            <div class="loader"></div>
                            <p>Processing payment...</p>
                        </div>
                    `;
                },

                onSuccess: (res) => {
                    this.body.innerHTML = '';
                    this.addBotMessage("🎉 " + res.message);
                    setTimeout(() => {
                        this.startChat();
                    }, 2000);
                },

                onError: (msg) => {
                    this.body.innerHTML = '';
                    this.addBotMessage("❌ " + msg);
                }
            });
        },

        /* =========================================================
           OTHER TALK (AI CHAT)
        ========================================================= */

        startOtherTalk() {

            this.body.innerHTML = '';

            // chatAjax({
            //     url: '/api/chat/ask-email',
            //     onSuccess: (res) => {
            //         this.addBotMessage(res.html);
            //     }
            // });

            this.body.innerHTML += `
                <input id="chat-input" placeholder="Ask something..." />
                <button onclick="ChatBot.sendMessage()">Send</button>
            `;
        },

        saveEmail() {

            const email = document.getElementById('chat-email').value;

            if (!email) {
                this.addBotMessage("❌ Please enter a valid email");
                return;
            }

            this.email = email;

            this.body.innerHTML = '';
            this.addBotMessage("✅ Email saved. Ask your question.");

            this.body.innerHTML += `
                <input id="chat-input" placeholder="Ask something..." />
                <button onclick="ChatBot.sendMessage()">Send</button>
            `;
        },

        sendMessage() {

            const message = document.getElementById('chat-input').value;

            if (!message.trim()) return;

            chatAjax({
                url: '/api/chat/message',
                data: {
                    session_id: this.sessionId,
                    email: this.email,
                    message: message
                },

                onSuccess: (res) => {
                    this.addBotMessage(res.reply);
                },

                onError: (msg) => {
                    this.addBotMessage("❌ " + msg);
                }
            });
        },

        // TECHNOLOGY SOLUTION FLOW
        startTechnologySolution() {

            this.body.innerHTML = '';

            this.body.innerHTML += `
                <input id="chat-input" placeholder="Ask something..." />
                <button onclick="ChatBot.sendMessageTechnologySolution()">Send</button>
            `;
        },

        sendMessageTechnologySolution() {

            const message = document.getElementById('chat-input').value;

            if (!message.trim()) return;

            chatAjax({
                url: '/api/chat/technolog/solution/message',
                data: {
                    session_id: this.sessionId,
                    email: this.email,
                    message: message
                },

                onSuccess: (res) => {
                    this.addBotMessage(res.reply);
                },

                onError: (msg) => {
                    this.addBotMessage("❌ " + msg);
                }
            });
        },


        initSelect2() {

            setTimeout(() => {

                if (!$.fn.select2) {
                    console.error('Select2 not loaded');
                    return;
                }

                $('#chatbot-box .select2').select2({
                    placeholder: 'Select option',
                    allowClear: true,
                    width: '100%',
                    dropdownParent: $('#chatbot-box')
                });

                // Autofill name from referred user
                $('#referred_by').on('select2:select select2:clear', function () {

                    let name = $(this).find(':selected').data('name') || '';

                    $('input[name="name"]').val(name);

                });

            }, 200);
        }
    };

    /* =========================================================
       BOOTSTRAP
    ========================================================= */

    window.ChatBot = ChatBot;

    document.addEventListener('DOMContentLoaded', () => {
        ChatBot.init();
    });


    

})(window);