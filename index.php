<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chủ đề 15: UX/UI hiện đại cho dữ liệu lớn</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 font-sans min-h-screen">
    
    <!-- Header -->
    <header class="bg-indigo-600 text-white shadow-md py-4 px-6 mb-6">
        <h1 class="text-2xl font-bold">Đồ án BE1: UX/UI hiện đại cho Dữ liệu lớn</h1>
        <p class="text-indigo-200 text-sm">So sánh Phân trang truyền thống, Cuộn vô tận và Giao diện Chatbot UI</p>
    </header>

    <div class="max-w-5xl mx-auto px-4 pb-12">
        <!-- Navigation Tabs -->
        <div class="flex space-x-2 mb-6 bg-white p-2 rounded-xl shadow-sm">
            <button onclick="switchTab('pagination')" id="btn-pagination" class="flex-1 py-2.5 px-4 font-semibold rounded-lg bg-indigo-600 text-white transition text-sm">1. Phân trang truyền thống</button>
            <button onclick="switchTab('infinite')" id="btn-infinite" class="flex-1 py-2.5 px-4 font-semibold rounded-lg text-slate-600 hover:bg-slate-100 transition text-sm">2. Cuộn vô tận</button>
            <button onclick="switchTab('chatbot')" id="btn-chatbot" class="flex-1 py-2.5 px-4 font-semibold rounded-lg text-slate-600 hover:bg-slate-100 transition text-sm">3. Giao diện Chatbot UI</button>
        </div>

        <!-- VIEW 1: PAGINATION -->
        <div id="view-pagination" class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-bold text-slate-800">Danh sách sản phẩm (Phân trang)</h2>
                <div class="flex items-center space-x-2 text-sm">
                    <span>Số dòng/trang:</span>
                    <select id="limit-select" onchange="loadPagination(1)" class="border rounded px-2 py-1 outline-none">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                    </select>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b text-slate-600 text-sm">
                            <th class="p-3">ID</th>
                            <th class="p-3">Tên sản phẩm</th>
                            <th class="p-3">Danh mục</th>
                            <th class="p-3">Giá tiền</th>
                        </tr>
                    </thead>
                    <tbody id="pagination-tbody" class="divide-y text-sm text-slate-700"></tbody>
                </table>
            </div>
            <div class="flex justify-between items-center mt-6 pt-4 border-t">
                <span id="pagination-info" class="text-sm text-slate-500">Đang tải...</span>
                <div class="space-x-2" id="pagination-buttons"></div>
            </div>
        </div>

        <!-- VIEW 2: INFINITE SCROLL -->
        <div id="view-infinite" class="bg-white rounded-xl shadow-sm p-6 hidden">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Khám phá sản phẩm (Cuộn vô tận)</h2>
            <div id="infinite-container" class="space-y-3 max-h-[500px] overflow-y-auto pr-2"></div>
            <div id="infinite-loading" class="text-center py-4 text-slate-500 font-medium text-sm">Đang tải thêm dữ liệu...</div>
        </div>

        <!-- VIEW 3: CHATBOT UI -->
        <div id="view-chatbot" class="bg-white rounded-xl shadow-sm p-6 hidden flex flex-col h-[550px]">
            <h2 class="text-lg font-bold text-slate-800 mb-4">Trợ lý AI tra cứu dữ liệu</h2>
            <div id="chat-messages" class="flex-1 overflow-y-auto space-y-4 pr-2 border rounded-xl p-4 bg-slate-50 mb-4">
                <div class="flex items-start space-x-3">
                    <div class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs">AI</div>
                    <div class="bg-white p-3 rounded-2xl shadow-sm border max-w-md text-sm text-slate-700">
                        Xin chào! Bạn muốn tìm sản phẩm nào? (Ví dụ nhập: <i>"Laptop"</i> hoặc <i>"Smartphone"</i>)
                    </div>
                </div>
            </div>
            <div class="flex space-x-2">
                <input type="text" id="chat-input" placeholder="Nhập tên sản phẩm cần tìm..." class="flex-1 border rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm" onkeypress="if(event.key==='Enter') sendMessage()">
                <button onclick="sendMessage()" class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-semibold hover:bg-indigo-700 transition text-sm">Gửi</button>
            </div>
        </div>
    </div>

    <!-- JavaScript Logic -->
    <script>
        function switchTab(tab) {
            ['pagination', 'infinite', 'chatbot'].forEach(t => {
                document.getElementById(`view-${t}`).classList.add('hidden');
                document.getElementById(`btn-${t}`).className = "flex-1 py-2.5 px-4 font-semibold rounded-lg text-slate-600 hover:bg-slate-100 transition text-sm";
            });
            document.getElementById(`view-${tab}`).classList.remove('hidden');
            document.getElementById(`btn-${tab}`).className = "flex-1 py-2.5 px-4 font-semibold rounded-lg bg-indigo-600 text-white transition text-sm";

            if (tab === 'infinite' && infiniteDataLoaded.length === 0) {
                loadInfinite();
            }
        }

        // 1. Phân trang
        let currentPageData = [];
        function loadPagination(page) {
            let limit = document.getElementById('limit-select').value;
            fetch(`api_pagination.php?page=${page}&limit=${limit}`)
                .then(res => res.json())
                .then(res => {
                    let tbody = document.getElementById('pagination-tbody');
                    tbody.innerHTML = '';
                    if (res.data.length === 0) {
                        tbody.innerHTML = `<tr><td colspan="4" class="p-4 text-center text-slate-400">Chưa có dữ liệu trong CSDL. Hãy thêm dữ liệu qua phpMyAdmin!</td></tr>`;
                        return;
                    }
                    res.data.forEach(item => {
                        tbody.innerHTML += `
                            <tr class="hover:bg-slate-50">
                                <td class="p-3 font-medium">#${item.id}</td>
                                <td class="p-3">${item.name}</td>
                                <td class="p-3"><span class="bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-full text-xs font-medium">${item.category}</span></td>
                                <td class="p-3 font-semibold text-emerald-600">${Number(item.price).toLocaleString()} VNĐ</td>
                            </tr>
                        `;
                    });
                    document.getElementById('pagination-info').innerText = `Trang ${res.page} / ${res.totalPages} (Tổng số ${res.totalRows} bản ghi)`;
                    
                    let btnContainer = document.getElementById('pagination-buttons');
                    btnContainer.innerHTML = `
                        <button onclick="loadPagination(${page - 1})" ${page <= 1 ? 'disabled class="opacity-40 cursor-not-allowed"' : ''} class="px-3 py-1.5 border rounded bg-white hover:bg-slate-100 text-sm">Trước</button>
                        <button onclick="loadPagination(${page + 1})" ${page >= res.totalPages ? 'disabled class="opacity-40 cursor-not-allowed"' : ''} class="px-3 py-1.5 border rounded bg-white hover:bg-slate-100 text-sm">Sau</button>
                    `;
                });
        }

        // 2. Cuộn vô tận
        let infiniteDataLoaded = [];
        let lastId = 0;
        let isLoading = false;
        let hasMore = true;

        function loadInfinite() {
            if (isLoading || !hasMore) return;
            isLoading = true;
            document.getElementById('infinite-loading').style.display = 'block';

            fetch(`api_infinite.php?last_id=${lastId}`)
                .then(res => res.json())
                .then(res => {
                    isLoading = false;
                    if (res.data.length === 0) {
                        hasMore = false;
                        document.getElementById('infinite-loading').innerText = 'Đã hiển thị toàn bộ dữ liệu.';
                        return;
                    }
                    let container = document.getElementById('infinite-container');
                    res.data.forEach(item => {
                        lastId = item.id;
                        infiniteDataLoaded.push(item);
                        container.innerHTML += `
                            <div class="border p-3.5 rounded-xl bg-slate-50 flex justify-between items-center text-sm">
                                <div>
                                    <span class="text-xs text-slate-400 font-semibold">#${item.id}</span>
                                    <h4 class="font-bold text-slate-800">${item.name}</h4>
                                    <span class="inline-block mt-1 bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded text-xs font-medium">${item.category}</span>
                                </div>
                                <span class="font-bold text-emerald-600">${Number(item.price).toLocaleString()} VNĐ</span>
                            </div>
                        `;
                    });
                    document.getElementById('infinite-loading').style.display = 'none';
                });
        }

        document.getElementById('view-infinite').addEventListener('scroll', function() {
            if (this.scrollTop + this.clientHeight >= this.scrollHeight - 30) {
                loadInfinite();
            }
        });

        // 3. Chatbot UI
        function sendMessage() {
            let input = document.getElementById('chat-input');
            let text = input.value.trim();
            if (!text) return;

            let chatBox = document.getElementById('chat-messages');
            chatBox.innerHTML += `
                <div class="flex items-start justify-end space-x-3">
                    <div class="bg-indigo-600 text-white p-3 rounded-2xl max-w-md text-sm">${text}</div>
                </div>
            `;
            input.value = '';
            chatBox.scrollTop = chatBox.scrollHeight;

            fetch('api_chat.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ message: text })
            })
            .then(res => res.json())
            .then(res => {
                let productsHtml = '';
                if (res.products && res.products.length > 0) {
                    productsHtml = '<div class="grid grid-cols-2 gap-2 mt-3">';
                    res.products.forEach(p => {
                        productsHtml += `
                            <div class="bg-white border p-2.5 rounded-lg shadow-sm text-xs">
                                <p class="font-bold text-slate-800 truncate">${p.name}</p>
                                <p class="text-emerald-600 font-semibold mt-1">${Number(p.price).toLocaleString()} VNĐ</p>
                            </div>
                        `;
                    });
                    productsHtml += '</div>';
                }

                chatBox.innerHTML += `
                    <div class="flex items-start space-x-3">
                        <div class="bg-indigo-600 text-white w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs">AI</div>
                        <div class="bg-white p-3 rounded-2xl shadow-sm border max-w-lg text-sm text-slate-700">
                            <p>${res.reply}</p>
                            ${productsHtml}
                        </div>
                    </div>
                `;
                chatBox.scrollTop = chatBox.scrollHeight;
            });
        }

        // Chạy mặc định tải phân trang khi mở web
        loadPagination(1);
    </script>
</body>
</html>