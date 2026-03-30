(function (window) {
    /* =========================================================
       GLOBAL AJAX HELPER (Reusable Everywhere)
    ========================================================= */

    function chatAjax(options) {
        const defaults = {
            url: "",
            method: "POST",
            data: {},
            onBefore: function () {},
            onSuccess: function () {},
            onError: function () {},
            onComplete: function () {},
        };

        const settings = Object.assign({}, defaults, options);

        $.ajax({
            url: settings.url,
            type: settings.method,
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify(settings.data),

            beforeSend: function () {
                settings.onBefore();
            },

            success: function (response) {
                settings.onSuccess(response);
            },

            error: function (xhr) {
                let message = "Something went wrong";

                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }

                settings.onError(message, xhr);
            },

            complete: function () {
                settings.onComplete();
            },
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
                    
                    <!-- NEW GRADIENT BOX (Replacing Header) -->
                    <div style="background: linear-gradient(135deg, #1E2939, #101828); padding: 16px; border-radius: 12px 12px 0 0; color: white; display: flex; flex-direction: column; gap: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); font-family: system-ui, -apple-system, sans-serif;">
                        
                        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                            <div style="background: #1E2939; border: 1px solid rgba(255,255,255,0.05); padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px; font-size: 11px; font-weight: 600; letter-spacing: 0.5px; text-transform: uppercase; color: #9CA3AF;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>
                                Support
                            </div>
                            
                            <!-- Small Close Button -->
                            <button onclick="ChatBot.toggleChat()" style="background: transparent; border: none; color: #9CA3AF; font-size: 16px; cursor: pointer; padding: 0; display: flex; align-items: center; justify-content: center; transition: color 0.2s ease;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#9CA3AF'">
                                ✕
                            </button>
                        </div>
                        
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #F9FAFB;">Need Help?</h3>
                            <p style="margin: 0; font-size: 13px; color: #9CA3AF; line-height: 1.4;">Contact your dedicated relationship manager for instant support.</p>
                        </div>
                        
                        <button style="display:flex; justify-content:center; gap:10px;  background: #10B981;  color: white; padding: 10px 16px; border-radius: 8px; border: none; font-weight: 600; font-size: 13px; cursor: pointer; text-align: center; transition: background 0.2s ease; width: 100%; margin-top: 4px; box-shadow: 0 2px 4px rgba(16, 185, 129, 0.2);" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='#10B981'">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
    </svg>  Start Chat
                        </button>
                    </div>

                    <!-- CHAT BODY -->
                    <div class="chat-body" id="chat-body"></div>

                </div>
            `;

            document.body.insertAdjacentHTML("beforeend", html);
            this.body = document.getElementById("chat-body");
        },

        bindEvents() {
            document
                .getElementById("chatbot-icon")
                .addEventListener("click", () => this.toggleChat());
        },

        toggleChat() {
            const box = document.getElementById("chatbot-box");
            box.style.display = box.style.display === "flex" ? "none" : "flex";

            if (this.body.innerHTML === "") {
                this.startChat();
            }
        },

        /* ================= CHAT START ================= */

        startChat() {
            sessionId =
                localStorage.getItem("chat_session_id") || crypto.randomUUID();
            chatAjax({
                url: "/api/chat/init",
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
                    localStorage.setItem("chat_session_id", this.sessionId);
                },
            });

            chatAjax({
                url: "/api/chat/welcome",
                onSuccess: (res) => {
                    this.body.innerHTML = "";
                    this.addBotMessage(res.html);
                    document.getElementById("chat-body").scrollTop = 0;
                },
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
            this.body.innerHTML = "";
            this.addBotMessage("📝 Please fill the onboarding form");

            // Get user_type from URL (last segment)
            const urlSegments = window.location.pathname.split("/");
            const userTypeFromUrl = urlSegments[urlSegments.length - 1];

            chatAjax({
                url: "/api/chat/onboarding/form",
                data: {
                    user_type: userTypeFromUrl,
                },

                onSuccess: (res) => {
                    this.addBotMessage(res.html);
                    this.initSelect2();

                    document
                        .getElementById("onboarding-form")
                        .addEventListener("submit", (e) =>
                            this.submitOnboarding(e),
                        );
                },

                onError: (msg) => {
                    this.addBotMessage("❌ " + msg);
                },
            });
        },

        submitOnboarding(e) {
            e.preventDefault();

            const data = Object.fromEntries(new FormData(e.target));

            chatAjax({
                url: "/api/chat/onboarding/submit",
                data: {
                    session_id: this.sessionId,
                    ...data,
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
                },
            });
        },

        /* ================= PAYMENT ================= */

        openPayment(enquiryId) {
            chatAjax({
                url: "/api/chat/payment/create",
                data: { enquiry_id: enquiryId },

                onSuccess: (order) => {
                    const options = {
                        key: order.key,
                        amount: order.amount,
                        currency: order.currency,
                        order_id: order.order_id,
                        handler: (response) => {
                            this.verifyPayment(response, enquiryId);
                        },
                    };

                    new Razorpay(options).open();
                },
            });
        },

        verifyPayment(response, enquiryId) {
            chatAjax({
                url: "/api/chat/payment/verify",
                data: {
                    session_id: this.sessionId,
                    enquiry_id: enquiryId,
                    ...response,
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
                    this.body.innerHTML = "";
                    this.addBotMessage("🎉 " + res.message);
                    setTimeout(() => {
                        this.startChat();
                    }, 2000);
                },

                onError: (msg) => {
                    this.body.innerHTML = "";
                    this.addBotMessage("❌ " + msg);
                },
            });
        },

        /* =========================================================
           OTHER TALK (AI CHAT)
        ========================================================= */

        startOtherTalk() {
            this.body.innerHTML = "";

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
            const email = document.getElementById("chat-email").value;

            if (!email) {
                this.addBotMessage("❌ Please enter a valid email");
                return;
            }

            this.email = email;

            this.body.innerHTML = "";
            this.addBotMessage("✅ Email saved. Ask your question.");

            this.body.innerHTML += `
                <input id="chat-input" placeholder="Ask something..." />
                <button onclick="ChatBot.sendMessage()">Send</button>
            `;
        },

        sendMessage() {
            const message = document.getElementById("chat-input").value;

            if (!message.trim()) return;

            chatAjax({
                url: "/api/chat/message",
                data: {
                    session_id: this.sessionId,
                    email: this.email,
                    message: message,
                },

                onSuccess: (res) => {
                    this.addBotMessage(res.reply);
                },

                onError: (msg) => {
                    this.addBotMessage("❌ " + msg);
                },
            });
        },

        // TECHNOLOGY SOLUTION FLOW
        startTechnologySolution() {
            this.body.innerHTML = "";

            this.body.innerHTML += `
                <input id="chat-input" placeholder="Ask something..." />
                <button onclick="ChatBot.sendMessageTechnologySolution()">Send</button>
            `;
        },

        sendMessageTechnologySolution() {
            const message = document.getElementById("chat-input").value;

            if (!message.trim()) return;

            chatAjax({
                url: "/api/chat/technolog/solution/message",
                data: {
                    session_id: this.sessionId,
                    email: this.email,
                    message: message,
                },

                onSuccess: (res) => {
                    this.addBotMessage(res.reply);
                },

                onError: (msg) => {
                    this.addBotMessage("❌ " + msg);
                },
            });
        },

        initSelect2() {
            setTimeout(() => {
                if (!$.fn.select2) {
                    console.error("Select2 not loaded");
                    return;
                }

                $("#chatbot-box .select2").select2({
                    placeholder: "Select option",
                    allowClear: true,
                    width: "100%",
                    dropdownParent: $("#chatbot-box"),
                });

                // Autofill name from referred user
                $("#referred_by").on(
                    "select2:select select2:clear",
                    function () {
                        let name = $(this).find(":selected").data("name") || "";

                        $('input[name="name"]').val(name);
                    },
                );
            }, 200);
        },
    };

    /* =========================================================
       BOOTSTRAP
    ========================================================= */

    window.ChatBot = ChatBot;

    document.addEventListener("DOMContentLoaded", () => {
        ChatBot.init();
    });
})(window);
