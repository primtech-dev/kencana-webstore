<div id="chatbot-overlay" onclick="toggleChatbot()" class="fixed inset-0 bg-black/40 backdrop-blur-md z-[98] hidden opacity-0 transition-all duration-300"></div>

<div class="fixed bottom-6 right-6 z-[99] flex flex-col items-end space-y-4">

    <div id="chatbot-window"
        class="hidden fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[95%] md:w-150 max-w-lg bg-white rounded-3xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all duration-300 scale-90 opacity-0 z-[100]">

        <div class="bg-[#003d79] p-5 text-white flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <img src="{{ asset('asset/MAS KENS.png') }}" class="w-12 h-12 rounded-full border-2 border-white/20 object-cover">
                    <span class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-green-400 border-2 border-[#003d79] rounded-full"></span>
                </div>
                <div>
                    <p class="font-bold text-base">Mas Kens</p>
                    <p class="text-[11px] opacity-80 flex items-center">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse mr-1.5"></span> Online | Siap Membantu
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button onclick="resetChat()" title="Mulai Baru" class="hover:bg-white/10 p-2 rounded-full transition-colors text-lg">
                    <i class="fas fa-redo-alt"></i>
                </button>
                <button onclick="toggleChatbot()" class="hover:bg-white/10 p-2 rounded-full transition-colors text-xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="h-96 p-5 overflow-y-auto bg-gray-50/50 space-y-4" id="chat-content">
            <div class="flex items-start">
                <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm text-sm text-gray-700 max-w-[85%] border border-gray-100 leading-relaxed">
                    Halo! Ada yang bisa Mas Kens bantu hari ini? 😊
                </div>
            </div>
        </div>

        <div class="p-4 border-t bg-white" id="menu-container">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider ml-1 mb-3">Layanan Cepat:</p>
            <div class="grid grid-cols-2 gap-2">
                <button onclick="handleMenu('cek_pesanan', 'Cek Pesanan')" class="text-xs bg-gray-50 hover:bg-blue-50 p-3 rounded-xl border border-gray-100 text-left flex items-center gap-2 transition-all active:scale-95">
                    <span>📦</span> Cek Pesanan
                </button>
                <button onclick="handleMenu('cek_stok', 'Cek Stok')" class="text-xs bg-gray-50 hover:bg-blue-50 p-3 rounded-xl border border-gray-100 text-left flex items-center gap-2 transition-all active:scale-95">
                    <span>🛒</span> Cek Stok
                </button>
                <button onclick="handleMenu('cari_produk', 'Cari Produk')" class="text-xs bg-gray-50 hover:bg-blue-50 p-3 rounded-xl border border-gray-100 text-left flex items-center gap-2 transition-all active:scale-95">
                    <span>💡</span> Cari Produk
                </button>
                <button onclick="handleMenu('admin', 'Admin')" class="text-xs bg-gray-50 hover:bg-blue-50 p-3 rounded-xl border border-gray-100 text-left flex items-center gap-2 transition-all active:scale-95">
                    <span>👨‍💼</span> Admin Toko
                </button>
            </div>
        </div>

        <div class="p-4 border-t bg-white flex items-center gap-3">
            <input type="text" id="user-input" onkeypress="handleKeyPress(event)"
                class="flex-1 text-sm border border-gray-200 rounded-2xl px-5 py-3 focus:outline-none focus:ring-2 focus:ring-[#003d79]/20 transition-all"
                placeholder="Tanya Mas Kens...">
            <button onclick="sendMessage()" class="bg-[#003d79] text-white p-3 rounded-xl hover:bg-[#002a54] transition-all active:scale-90 shadow-lg shadow-[#003d79]/20">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <img onclick="toggleChatbot()" src="{{ asset('asset/MAS KENS.png') }}"
        class="w-14 h-14 rounded-full shadow-xl cursor-pointer hover:rotate-6 active:scale-90 transition-all duration-300 border-2 border-[#003d79] object-cover">

    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Kencana" target="_blank"
        class="group flex items-center bg-[#25D366] text-white px-5 py-3.5 rounded-full shadow-lg hover:bg-[#128C7E] transition-all duration-300 hover:scale-105">
        <span class="max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-500 ease-in-out whitespace-nowrap font-bold text-sm mr-0 group-hover:mr-3">
            Chat WhatsApp
        </span>
        <i class="fab fa-whatsapp text-2xl"></i>
    </a>
</div>

<!-- <script>
    let currentAction = null;

    // Toggle Window & Overlay
    function toggleChatbot() {
        const windowEl = document.getElementById('chatbot-window');
        const overlayEl = document.getElementById('chatbot-overlay');

        if (windowEl.classList.contains('hidden')) {
            windowEl.classList.remove('hidden');
            overlayEl.classList.remove('hidden');
            setTimeout(() => {
                windowEl.classList.remove('scale-90', 'opacity-0');
                overlayEl.classList.remove('opacity-0');
            }, 10);
        } else {
            windowEl.classList.add('scale-90', 'opacity-0');
            overlayEl.classList.add('opacity-0');
            setTimeout(() => {
                windowEl.classList.add('hidden');
                overlayEl.classList.add('hidden');
            }, 300);
        }
    }

    function handleKeyPress(e) {
        if (e.key === 'Enter') sendMessage();
    }

    function appendChat(message, isUser = false) {
        const chatContent = document.getElementById('chat-content');
        const msgHtml = `
        <div class="flex items-start ${isUser ? 'justify-end' : ''}">
            <div class="${isUser ? 'bg-[#003d79] text-white shadow-[#003d79]/20' : 'bg-white text-gray-700 border border-gray-100'} p-4 rounded-2xl ${isUser ? 'rounded-tr-none' : 'rounded-tl-none'} shadow-md text-sm max-w-[85%] leading-relaxed">
                ${message}
            </div>
        </div>`;
        chatContent.insertAdjacentHTML('beforeend', msgHtml);
        chatContent.scrollTop = chatContent.scrollHeight;
    }

    function handleMenu(option, label) {
        appendChat(label, true);
        setTimeout(() => {
            switch (option) {
                case 1:
                    currentAction = 'cek_pesanan';
                    appendChat("Boleh minta **Nomor Order** Anda? (Contoh: ORD12345678)<br><br>Atau ketik **'terakhir'** untuk cek pesanan terbaru Anda.");
                    break;
                case 2:
                    currentAction = 'cek_stok';
                    appendChat("Produk apa yang ingin Anda cek stoknya?");
                    break;
                case 3:
                    appendChat("Mas Kens menyarankan Anda mengecek menu **Katalog Produk** di website untuk detail teknis lengkap.");
                    break;
                case 4:
                    appendChat("Menghubungkan ke Admin Toko...");
                    window.open('https://wa.me/6281234567890', '_blank');
                    break;
            }
        }, 600);
    }

    async function sendMessage() {
        const input = document.getElementById('user-input');
        const message = input.value.trim();
        if (!message) return;

        appendChat(message, true);
        input.value = '';

        const loadingId = 'loading-' + Date.now();
        appendChat(`<div class="flex items-center gap-2" id="${loadingId}"><span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"></span><span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce [animation-delay:0.2s]"></span><span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce [animation-delay:0.4s]"></span></div>`, false);

        try {
            // Ambil token dengan aman
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (!csrfToken) {
                console.error("CSRF Token tidak ditemukan! Pastikan <meta name='csrf-token'> sudah dipasang.");
            }

            const response = await axios.post('/chatbot/query', {
                action: currentAction,
                message: message
            }, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const loadingEl = document.getElementById(loadingId);
            if (loadingEl) {
                loadingEl.parentElement.innerHTML = response.data.reply;
            }
        } catch (error) {
            const loadingEl = document.getElementById(loadingId);
            if (loadingEl) {
                loadingEl.parentElement.innerHTML = "Maaf, sistem sedang sibuk atau sesi Anda berakhir. Coba segarkan halaman.";
            }
        }
    }
</script> -->

<!-- <script>
    let currentAction = null;

    // Toggle Window & Overlay
    function toggleChatbot() {
        const windowEl = document.getElementById('chatbot-window');
        const overlayEl = document.getElementById('chatbot-overlay');

        if (windowEl.classList.contains('hidden')) {
            windowEl.classList.remove('hidden');
            overlayEl.classList.remove('hidden');
            setTimeout(() => {
                windowEl.classList.remove('scale-90', 'opacity-0');
                overlayEl.classList.remove('opacity-0');
            }, 10);
        } else {
            windowEl.classList.add('scale-90', 'opacity-0');
            overlayEl.classList.add('opacity-0');
            setTimeout(() => {
                windowEl.classList.add('hidden');
                overlayEl.classList.add('hidden');
            }, 300);
        }
    }

    function handleKeyPress(e) {
        if (e.key === 'Enter') sendMessage();
    }

    function appendChat(message, isUser = false) {
        const chatContent = document.getElementById('chat-content');
        const msgHtml = `
        <div class="flex items-start ${isUser ? 'justify-end' : ''} animate-fade-in">
            <div class="${isUser ? 'bg-[#003d79] text-white shadow-[#003d79]/20' : 'bg-white text-gray-700 border border-gray-100'} p-4 rounded-2xl ${isUser ? 'rounded-tr-none' : 'rounded-tl-none'} shadow-md text-sm max-w-[85%] leading-relaxed">
                ${message}
            </div>
        </div>`;
        chatContent.insertAdjacentHTML('beforeend', msgHtml);
        chatContent.scrollTop = chatContent.scrollHeight;
    }

    /**
     * PERBAIKAN: Fungsi Handle Menu sekarang meneruskan pesan ke AI
     */
  function handleMenu(option, label) {
    appendChat(label, true);

    let messageForAI = "";
    // Pastikan option yang dikirim sesuai dengan yang dicek di Controller
    switch (option) {
        case 'cek_pesanan': // Gunakan string sesuai id action
            currentAction = 'cek_pesanan';
            messageForAI = "SAYA INGIN CEK PESANAN";
            break;
        case 'cek_stok':
            currentAction = 'cek_stok';
            messageForAI = "SAYA INGIN CEK STOK BARANG";
            break;
        case 'cari_produk':
            currentAction = 'cari_produk';
            messageForAI = "Bantu saya cari produk";
            break;
        case 'admin':
            appendChat("Menghubungkan ke Admin...", false);
            window.open('https://wa.me/6281234567890', '_blank');
            return;
    }

    processQuery(messageForAI, currentAction);
}

    /**
     * PERBAIKAN: Fungsi sendMessage memanggil core logic processQuery
     */
    async function sendMessage() {
        const input = document.getElementById('user-input');
        const message = input.value.trim();
        if (!message) return;

        appendChat(message, true);
        input.value = '';

        // Kirim pesan teks dan sertakan currentAction (jika ada konteks sebelumnya)
        await processQuery(message, currentAction);
    }

    /**
     * CORE LOGIC: Fungsi tunggal untuk berkomunikasi dengan Backend AI
     */
    async function processQuery(message, action) {
        const loadingId = 'loading-' + Date.now();

        // Tampilkan loading animation
        appendChat(`<div class="flex items-center gap-2" id="${loadingId}"><span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"></span><span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce [animation-delay:0.2s]"></span><span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce [animation-delay:0.4s]"></span></div>`, false);

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const response = await axios.post('/chatbot/query', {
                action: action,
                message: message
            }, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const loadingEl = document.getElementById(loadingId);
            if (loadingEl) {
                // Gunakan innerHTML karena AI mungkin mengirimkan format HTML/Badge
                const parentEl = loadingEl.parentElement;
                parentEl.innerHTML = response.data.reply;
            }
        } catch (error) {
            const loadingEl = document.getElementById(loadingId);
            if (loadingEl) {
                loadingEl.parentElement.innerHTML = "Waduh Kak, Mas Kens lagi gangguan koneksi nih. Coba lagi ya?";
            }
            console.error("Chatbot Error:", error);
        }
    }
</script> -->


<script>
    let currentAction = null;

    // Toggle Window & Overlay
    function toggleChatbot() {
        const windowEl = document.getElementById('chatbot-window');
        const overlayEl = document.getElementById('chatbot-overlay');

        if (windowEl.classList.contains('hidden')) {
            windowEl.classList.remove('hidden');
            overlayEl.classList.remove('hidden');
            setTimeout(() => {
                windowEl.classList.remove('scale-90', 'opacity-0');
                overlayEl.classList.remove('opacity-0');
            }, 10);
        } else {
            windowEl.classList.add('scale-90', 'opacity-0');
            overlayEl.classList.add('opacity-0');
            setTimeout(() => {
                windowEl.classList.add('hidden');
                overlayEl.classList.add('hidden');
            }, 300);
        }
    }

    function handleKeyPress(e) {
        if (e.key === 'Enter') sendMessage();
    }

    function appendChat(message, isUser = false) {
        const chatContent = document.getElementById('chat-content');
        const msgHtml = `
        <div class="flex items-start ${isUser ? 'justify-end' : ''} animate-fade-in">
            <div class="${isUser ? 'bg-[#003d79] text-white shadow-[#003d79]/20' : 'bg-white text-gray-700 border border-gray-100'} p-4 rounded-2xl ${isUser ? 'rounded-tr-none' : 'rounded-tl-none'} shadow-md text-sm max-w-[85%] leading-relaxed">
                ${message}
            </div>
        </div>`;
        chatContent.insertAdjacentHTML('beforeend', msgHtml);
        chatContent.scrollTop = chatContent.scrollHeight;
    }

    /**
     * HANDLE MENU: Mengirim instruksi khusus ke Controller & AI
     */
    function handleMenu(option, label) {
        appendChat(label, true);

        let messageForAI = "";

        switch (option) {
            case 'cek_pesanan':
                currentAction = 'cek_pesanan';
                messageForAI = "SAYA INGIN CEK PESANAN";
                break;
            case 'cek_stok':
                currentAction = 'cek_stok';
                messageForAI = "SAYA INGIN CEK STOK BARANG";
                break;
            case 'cari_produk':
                currentAction = 'cari_produk';
                messageForAI = "Bantu saya cari produk";
                break;
            case 'admin':
                appendChat("Menghubungkan ke Admin... Mohon tunggu sebentar ya Kak. 😊", false);
                window.open('https://wa.me/6281234567890', '_blank');
                return;
        }

        processQuery(messageForAI, currentAction);
    }

    /**
     * SEND MESSAGE: Mengambil input manual user
     */
    async function sendMessage() {
        const input = document.getElementById('user-input');
        const message = input.value.trim();
        if (!message) return;

        appendChat(message, true);
        input.value = '';

        await processQuery(message, currentAction);
    }

    /**
     * CORE LOGIC: Komunikasi dengan Backend AI + Update Konteks
     */
    async function processQuery(message, action) {
        const loadingId = 'loading-' + Date.now();
        appendChat(`<div class="flex items-center gap-2" id="${loadingId}"><span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"></span><span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce [animation-delay:0.2s]"></span><span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce [animation-delay:0.4s]"></span></div>`, false);

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const response = await axios.post('/chatbot/query', {
                action: action,
                message: message
            }, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            const loadingEl = document.getElementById(loadingId);
            if (loadingEl) {
                const parentEl = loadingEl.parentElement;
                parentEl.innerHTML = response.data.reply;

                // --- PERBAIKAN KONTEKS OTOMATIS ---
                // Jika jawaban AI mengandung info stok, otomatis kunci action ke 'cek_stok'
                // Ini membantu jika user tadi cuma tanya umum tapi berujung cek stok
                const lowerReply = response.data.reply.toLowerCase();
                if (lowerReply.includes('stok') || lowerReply.includes('unit')) {
                    currentAction = 'cek_stok';
                } else if (lowerReply.includes('order') || lowerReply.includes('pesanan')) {
                    currentAction = 'cek_pesanan';
                }
            }
        } catch (error) {
            const loadingEl = document.getElementById(loadingId);
            if (loadingEl) {
                loadingEl.parentElement.innerHTML = "Waduh Kak, Mas Kens lagi gangguan koneksi nih. Coba lagi ya?";
            }
            console.error("Chatbot Error:", error);
        }
    }

    async function resetChat() {
        if (!confirm("Hapus percakapan dan mulai baru?")) return;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Panggil endpoint reset di Laravel
            await axios.post('/chatbot/reset', {}, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            // Bersihkan tampilan chat
            const chatContent = document.getElementById('chat-content');
            chatContent.innerHTML = `
            <div class="flex items-start">
                <div class="bg-white p-4 rounded-2xl rounded-tl-none shadow-sm text-sm text-gray-700 max-w-[85%] border border-gray-100 leading-relaxed">
                    Halo lagi Kak! Ada yang bisa Mas Kens bantu dari awal? 😊
                </div>
            </div>`;

            currentAction = null;
            console.log("Session Reset Berhasil");
        } catch (error) {
            console.error("Gagal reset session", error);
        }
    }
</script>