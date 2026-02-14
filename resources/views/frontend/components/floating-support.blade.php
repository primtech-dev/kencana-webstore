<div class="fixed bottom-6 right-6 z-[99] flex flex-col items-end space-y-4">
    
    <div id="chatbot-window" class="hidden mb-4 w-80 md:w-96 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all duration-300 translate-y-10 opacity-0">
        <div class="bg-[#003d79] p-4 text-white flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <img src="{{ asset('asset/chatbot-assistant.png') }}" class="w-10 h-10 rounded-full border-2 border-white/20">
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-[#003d79] rounded-full"></span>
                </div>
                <div>
                    <p class="font-bold text-sm">Kencana Assistant</p>
                    <p class="text-[10px] opacity-80">Online | Siap Membantu</p>
                </div>
            </div>
            <button onclick="toggleChatbot()" class="hover:bg-white/10 p-1 rounded-full"><i class="fas fa-times"></i></button>
        </div>

        <div class="h-80 p-4 overflow-y-auto bg-gray-50 space-y-4" id="chat-content">
            <div class="flex items-start">
                <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm text-sm text-gray-700 max-w-[80%] border border-gray-100">
                    Halo! Ada yang bisa kami bantu mengenai produk atau lokasi cabang kami? 😊
                </div>
            </div>
        </div>

        <div class="p-3 border-t bg-white space-y-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase ml-1">Bantuan Cepat:</p>
            <div class="flex flex-wrap gap-2">
                <button onclick="botReply('Bagaimana cara pilih cabang?')" class="text-xs bg-gray-100 hover:bg-blue-50 hover:text-[#003d79] px-3 py-1.5 rounded-full transition border border-gray-200">📍 Pilih Cabang</button>
                <button onclick="botReply('Cek status pesanan')" class="text-xs bg-gray-100 hover:bg-blue-50 hover:text-[#003d79] px-3 py-1.5 rounded-full transition border border-gray-200">📦 Cek Pesanan</button>
            </div>
        </div>
    </div>

    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Kencana" target="_blank" 
        class="group flex items-center bg-[#25D366] text-white px-4 py-3 rounded-full shadow-lg hover:bg-[#128C7E] transition-all duration-300 hover:scale-105 active:scale-95">
        <span class="max-w-0 overflow-hidden group-hover:max-w-xs transition-all duration-500 ease-in-out whitespace-nowrap font-bold text-sm mr-0 group-hover:mr-2">
            Chat WhatsApp
        </span>
        <i class="fab fa-whatsapp text-2xl"></i>
    </a>

     <img onclick="toggleChatbot()" src="{{ asset('asset/chatbot-assistant.png') }}" class="w-13 h-13 rounded-full transition-all duration-300 flex items-center justify-center hover:rotate-12 active:scale-90 " alt="">

    
</div>

<script>
    function toggleChatbot() {
        const window = document.getElementById('chatbot-window');
        const icon = document.getElementById('chatbot-icon');
        
        if (window.classList.contains('hidden')) {
            window.classList.remove('hidden');
            setTimeout(() => {
                window.classList.remove('translate-y-10', 'opacity-0');
            }, 10);
            icon.classList.replace('fa-comment-dots', 'fa-chevron-down');
        } else {
            window.classList.add('translate-y-10', 'opacity-0');
            setTimeout(() => {
                window.classList.add('hidden');
            }, 300);
            icon.classList.replace('fa-chevron-down', 'fa-comment-dots');
        }
    }

    function botReply(message) {
        const chatContent = document.getElementById('chat-content');
        
        // Add User Message
        chatContent.innerHTML += `
            <div class="flex items-start justify-end">
                <div class="bg-[#003d79] text-white p-3 rounded-2xl rounded-tr-none shadow-sm text-sm max-w-[80%]">
                    ${message}
                </div>
            </div>
        `;

        // Mock Bot Response
        setTimeout(() => {
            let reply = "Mohon maaf, saat ini admin kami sedang melayani pelanggan lain. Silakan hubungi via WhatsApp untuk respon lebih cepat.";
            if(message.includes('cabang')) reply = "Anda bisa klik lokasi di header untuk mencari cabang terdekat dari posisi Anda!";
            
            chatContent.innerHTML += `
                <div class="flex items-start">
                    <div class="bg-white p-3 rounded-2xl rounded-tl-none shadow-sm text-sm text-gray-700 max-w-[80%] border border-gray-100">
                        ${reply}
                    </div>
                </div>
            `;
            chatContent.scrollTop = chatContent.scrollHeight;
        }, 1000);
    }
</script>