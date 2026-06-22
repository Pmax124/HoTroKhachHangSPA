<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Tư Vấn Liệu Trình - Spa Luxury</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
    .ai-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 20px;
    }
    .ai-chat-box {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.1);
        overflow: hidden;
        height: 80vh;
        display: flex;
        flex-direction: column;
    }
    .ai-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 30px;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .ai-header i {
        font-size: 32px;
    }
    .ai-header h2 {
        margin: 0;
        font-size: 20px;
        font-family: 'Roboto', sans-serif;
    }
    .ai-header p {
        margin: 5px 0 0;
        opacity: 0.9;
        font-size: 14px;
    }
    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 20px;
        background: #f8f9fa;
    }
    .message {
        margin-bottom: 20px;
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .message-content {
        max-width: 80%;
        padding: 15px 20px;
        border-radius: 15px;
        line-height: 1.6;
    }
    .message.ai .message-content {
        background: white;
        border: 1px solid #e2e8f0;
    }
    .message.user .message-content {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        margin-left: auto;
    }
    .message-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        font-size: 13px;
        color: #718096;
    }
    .message.user .message-header {
        justify-content: flex-end;
        color: rgba(255,255,255,0.8);
    }
    .message-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }
    .message.ai .message-avatar {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }
    .message.user .message-avatar {
        background: #48bb78;
        color: white;
    }
    /* AI Response Styling */
    .ai-response {
        line-height: 1.7;
    }
    .ai-response h4 {
        color: #667eea;
        margin: 15px 0 8px;
        font-size: 16px;
    }
    .ai-response .diagnosis {
        background: #eef2ff;
        padding: 12px 15px;
        border-radius: 10px;
        border-left: 4px solid #667eea;
        margin-bottom: 15px;
    }
    .ai-response .severity {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .severity-nhe { background: #c6f6d5; color: #22543d; }
    .severity-trung-binh { background: #fefcbf; color: #744210; }
    .severity-nang { background: #fed7d7; color: #742a2a; }
    .ai-response .treatment-route {
        background: #f7fafc;
        padding: 15px;
        border-radius: 10px;
        margin: 15px 0;
    }
    .ai-response .treatment-route h5 {
        color: #2d3748;
        margin: 0 0 10px;
    }
    .ai-response .treatment-route .phase {
        background: white;
        padding: 10px 15px;
        border-radius: 8px;
        margin-bottom: 8px;
        border-left: 3px solid #667eea;
    }
    .ai-response .service-card {
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 15px;
        margin: 10px 0;
        transition: all 0.3s;
    }
    .ai-response .service-card:hover {
        border-color: #667eea;
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
    }
    .ai-response .service-card h5 {
        margin: 0 0 5px;
        color: #2d3748;
    }
    .ai-response .service-card .price {
        color: #667eea;
        font-weight: 600;
        font-size: 18px;
    }
    .ai-response .precautions {
        background: #fff5f5;
        padding: 12px 15px;
        border-radius: 10px;
        border-left: 4px solid #fc8181;
        margin: 15px 0;
    }
    .ai-response .estimated-cost {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
        margin: 15px 0;
    }
    .ai-response .estimated-cost .amount {
        font-size: 24px;
        font-weight: 700;
    }
    .typing-indicator {
        display: flex;
        gap: 5px;
        padding: 15px 20px;
        background: white;
        border-radius: 15px;
        width: fit-content;
        border: 1px solid #e2e8f0;
    }
    .typing-indicator span {
        width: 8px;
        height: 8px;
        background: #667eea;
        border-radius: 50%;
        animation: typing 1.4s infinite;
    }
    .typing-indicator span:nth-child(2) { animation-delay: 0.2s; }
    .typing-indicator span:nth-child(3) { animation-delay: 0.4s; }
    @keyframes typing {
        0%, 60%, 100% { transform: translateY(0); }
        30% { transform: translateY(-10px); }
    }
    /* Input Area */
    .chat-input-area {
        padding: 20px;
        background: white;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 10px;
        align-items: flex-end;
    }
    .chat-input-wrapper {
        flex: 1;
        position: relative;
    }
    .chat-input-wrapper textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e2e8f0;
        border-radius: 20px;
        resize: none;
        font-size: 15px;
        min-height: 45px;
        max-height: 120px;
        font-family: inherit;
    }
    .chat-input-wrapper textarea:focus {
        outline: none;
        border-color: #667eea;
    }
    .chat-input-wrapper .quick-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 8px;
    }
    .quick-tag {
        padding: 4px 12px;
        background: #f7fafc;
        border: 1px solid #e2e8f0;
        border-radius: 15px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .quick-tag:hover {
        background: #667eea;
        color: white;
        border-color: #667eea;
    }
    .btn-send {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        transition: transform 0.3s;
    }
    .btn-send:hover {
        transform: scale(1.1);
    }
    .btn-send:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    /* Form Options */
    .ai-options {
        padding: 15px 20px;
        background: #f8f9fa;
        border-top: 1px solid #e2e8f0;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }
    .ai-options select {
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 13px;
    }
    .history-panel {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    }
    .history-panel h3 {
        margin: 0 0 15px;
        color: #2d3748;
        font-size: 16px;
    }
    .history-item {
        padding: 12px;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .history-item:hover {
        background: #eef2ff;
    }
    .history-item .symptom {
        font-weight: 500;
        color: #2d3748;
    }
    .history-item .date {
        font-size: 12px;
        color: #718096;
    }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar">
            <div class="container">
                <div class="nav-wrapper">
                    <div class="logo">
                        <i class="fas fa-spa"></i>
                        <span>Spa Luxury</span>
                    </div>
                    <ul class="nav-menu">
                        <li><a href="<?php echo BASE_URL; ?>/" class="nav-link">Trang chủ</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/services" class="nav-link">Dịch vụ</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/staff" class="nav-link">Nhân viên</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/ai-consultation" class="nav-link active"><i class="fas fa-robot"></i> AI Tư vấn</a></li>
                        <?php if (isset($_SESSION['customer_id'])): ?>
                            <li><a href="<?php echo BASE_URL; ?>/my-appointments" class="nav-link">Lịch của tôi</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/logout" class="btn btn-outline">Đăng xuất</a></li>
                        <?php else: ?>
                            <li><a href="<?php echo BASE_URL; ?>/login" class="btn btn-primary">Đăng nhập</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Page Header -->
    <section class="page-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 100px 0 60px; text-align: center;">
        <div class="container">
            <h1><i class="fas fa-robot"></i> AI Tư Vấn Liệu Trình</h1>
            <p>Chuyên gia AI phân tích vấn đề da và đề xuất lộ trình điều trị phù hợp</p>
        </div>
    </section>

    <!-- AI Chat Section -->
    <section class="section-padding" style="background: #f7fafc;">
        <div class="ai-container">
            <?php if (!empty($history)): ?>
            <div class="history-panel">
                <h3><i class="fas fa-history"></i> Lịch sử tư vấn</h3>
                <div id="historyList">
                    <?php foreach ($history as $item): 
                        $response = json_decode($item['ai_response'], true);
                    ?>
                    <div class="history-item" onclick="loadHistory('<?php echo addslashes($item['user_message']); ?>')">
                        <div class="symptom"><?= htmlspecialchars($item['user_message']) ?></div>
                        <div class="date"><?= date('d/m/Y H:i', strtotime($item['created_at'])) ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="ai-chat-box">
                <div class="ai-header">
                    <i class="fas fa-robot"></i>
                    <div>
                        <h2>Trợ Lý AI Spa Luxury</h2>
                        <p>Tư vấn 24/7 • Phân tích da • Đề xuất liệu trình</p>
                    </div>
                </div>

                <div class="chat-messages" id="chatMessages">
                    <div class="message ai">
                        <div class="message-header">
                            <div class="message-avatar"><i class="fas fa-robot"></i></div>
                            <span>AI Spa Luxury</span>
                        </div>
                        <div class="message-content ai-response">
                            <p>Xin chào! 👋 Tôi là trợ lý AI chuyên gia về da liễu và spa trị liệu.</p>
                            <p>Hãy mô tả vấn đề của bạn, ví dụ:</p>
                            <ul style="margin: 10px 0; padding-left: 20px;">
                                <li>Da tôi bị mụn nhiều</li>
                                <li>Da lão hóa, có nếp nhăn</li>
                                <li>Da khô, bong tróc</li>
                                <li>Da thâm nám, không đều màu</li>
                                <li>Da dầu, lỗ chân lông to</li>
                            </ul>
                            <p>Tôi sẽ phân tích và đề xuất <strong>lộ trình điều trị chi tiết</strong> với các dịch vụ phù hợp nhất! 💆‍♀️</p>
                        </div>
                    </div>
                </div>

                <!-- Options -->
                <div class="ai-options">
                    <span style="font-size: 13px; color: #718096;"><i class="fas fa-sliders-h"></i> Tùy chọn:</span>
                    <select id="skinType">
                        <option value="">Loại da</option>
                        <option value="da_thuong">Da thường</option>
                        <option value="da_dau">Da dầu</option>
                        <option value="da_kho">Da khô</option>
                        <option value="da_hon_hop">Da hỗn hợp</option>
                        <option value="da_nhay_cam">Da nhạy cảm</option>
                    </select>
                    <select id="budget">
                        <option value="">Ngân sách</option>
                        <option value="duoi_500k">Dưới 500k</option>
                        <option value="500k_1tr">500k - 1 triệu</option>
                        <option value="1tr_2tr">1 - 2 triệu</option>
                        <option value="tren_2tr">Trên 2 triệu</option>
                    </select>
                </div>

                <!-- Input -->
                <div class="chat-input-area">
                    <div class="chat-input-wrapper">
                        <textarea id="userInput" placeholder="Mô tả vấn đề da của bạn..." rows="1" onkeypress="handleKeyPress(event)"></textarea>
                        <div class="quick-tags">
                            <span class="quick-tag" onclick="setInput('Da tôi bị mụn viêm, mụn ẩn')">😓 Mụn</span>
                            <span class="quick-tag" onclick="setInput('Da lão hóa, chảy xệ, có nếp nhăn')">👵 Lão hóa</span>
                            <span class="quick-tag" onclick="setInput('Da thâm nám, tàn nhang')">🌟 Nám</span>
                            <span class="quick-tag" onclick="setInput('Da khô, bong tróc, căng rát')">💧 Da khô</span>
                            <span class="quick-tag" onclick="setInput('Da dầu, lỗ chân lông to, đổ bóng')"> Da dầu</span>
                            <span class="quick-tag" onclick="setInput('Da nhạy cảm, dễ kích ứng, đỏ')"> Nhạy cảm</span>
                        </div>
                    </div>
                    <button class="btn-send" id="sendBtn" onclick="sendMessage()">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer style="background: #2d3748; color: white; padding: 40px 20px; text-align: center;">
        <p>&copy; 2026 Spa Luxury. All rights reserved.</p>
    </footer>

    <script>
    const chatMessages = document.getElementById('chatMessages');
    const userInput = document.getElementById('userInput');
    const sendBtn = document.getElementById('sendBtn');
    let sessionId = '<?php echo session_id(); ?>';
    let conversationHistory = [];

    // Auto-resize textarea
    userInput.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    function setInput(text) {
        userInput.value = text;
        userInput.style.height = 'auto';
        userInput.style.height = Math.min(userInput.scrollHeight, 120) + 'px';
        userInput.focus();
    }

    function handleKeyPress(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    }

    function loadHistory(symptom) {
        setInput(symptom);
        sendMessage();
    }

    async function sendMessage() {
        const message = userInput.value.trim();
        if (!message) return;

        const skinType = document.getElementById('skinType').value;
        const budget = document.getElementById('budget').value;

        // Add user message
        addMessage(message, 'user');
        userInput.value = '';
        userInput.style.height = 'auto';

        // Show typing
        showTyping();
        sendBtn.disabled = true;

        try {
            const response = await fetch('<?php echo BASE_URL; ?>/ai-consultation', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    symptoms: message,
                    skin_type: skinType,
                    budget: budget,
                    session_id: sessionId,
                    history: conversationHistory.slice(-3).map(h => h.message).join('; ')
                })
            });

            const result = await response.json();
            removeTyping();

            if (result.success) {
                // Add to history
                conversationHistory.push({ role: 'user', message: message });
                
                // Format AI response
                const formattedResponse = formatAIResponse(result);
                addMessage(formattedResponse, 'ai', true);
                
                conversationHistory.push({ role: 'ai', message: result.message });
            } else {
                addMessage(result.message || 'Có lỗi xảy ra, vui lòng thử lại.', 'ai');
            }
        } catch (error) {
            removeTyping();
            addMessage('Lỗi kết nối. Vui lòng kiểm tra internet.', 'ai');
        }

        sendBtn.disabled = false;
    }

    function formatAIResponse(data) {
        let html = '';

        // Diagnosis
        if (data.diagnosis) {
            const severityClass = data.severity === 'Nhẹ' ? 'severity-nhe' : 
                                 data.severity === 'Trung bình' ? 'severity-trung-binh' : 'severity-nang';
            html += `
                <div class="diagnosis">
                    <strong>🔍 Chẩn đoán:</strong> ${data.diagnosis}
                    ${data.severity ? `<span class="severity ${severityClass}">${data.severity}</span>` : ''}
                </div>
            `;
        }

        // Treatment Route
        if (data.treatment_route) {
            html += '<div class="treatment-route"><h5>📋 Lộ trình điều trị đề xuất:</h5>';
            
            if (data.treatment_route.phase1) {
                html += `<div class="phase"><strong>Giai đoạn 1:</strong> ${data.treatment_route.phase1}</div>`;
            }
            if (data.treatment_route.phase2) {
                html += `<div class="phase"><strong>Giai đoạn 2:</strong> ${data.treatment_route.phase2}</div>`;
            }
            if (data.treatment_route.phase3) {
                html += `<div class="phase"><strong>Giai đoạn 3:</strong> ${data.treatment_route.phase3}</div>`;
            }
            
            html += `
                <p style="margin-top: 10px;">
                    <strong>Tổng số buổi:</strong> ${data.treatment_route.total_sessions || 'N/A'}<br>
                    <strong>Tần suất:</strong> ${data.treatment_route.frequency || 'N/A'}
                </p>
            </div>`;
        }

        // Recommended Services
        if (data.services && data.services.length > 0) {
            html += '<h4>💆‍♀️ Liệu trình đề xuất:</h4>';
            data.services.forEach(service => {
                const price = service.discount_price || service.price;
                html += `
                    <div class="service-card">
                        <h5>${service.name}</h5>
                        <p style="font-size: 13px; color: #718096; margin: 5px 0;">${service.description || ''}</p>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 10px;">
                            <span class="price">${new Intl.NumberFormat('vi-VN').format(price)}₫</span>
                            <span style="font-size: 13px; color: #718096;"><i class="far fa-clock"></i> ${service.duration} phút</span>
                            <a href="<?php echo BASE_URL; ?>/booking?service_id=${service.id}" 
                               style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 8px 15px; border-radius: 20px; text-decoration: none; font-size: 13px;">
                                <i class="fas fa-calendar-plus"></i> Đặt lịch
                            </a>
                        </div>
                    </div>
                `;
            });
        }

        // Estimated Cost
        if (data.estimated_cost) {
            html += `
                <div class="estimated-cost">
                    <div>Ước tính chi phí lộ trình</div>
                    <div class="amount">${data.estimated_cost}</div>
                </div>
            `;
        }

        // Expert Advice
        if (data.message) {
            html += `<h4>💡 Lời khuyên chuyên gia:</h4><p>${data.message}</p>`;
        }

        // Precautions
        if (data.precautions) {
            html += `
                <div class="precautions">
                    <strong>⚠️ Lưu ý:</strong> ${data.precautions}
                </div>
            `;
        }

        // Expected Results
        if (data.expected_results) {
            html += `<h4>✨ Kết quả mong đợi:</h4><p>${data.expected_results}</p>`;
        }

        return html;
    }

    function addMessage(content, sender, isHTML = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}`;
        
        const avatarIcon = sender === 'ai' ? 'fa-robot' : 'fa-user';
        const senderName = sender === 'ai' ? 'AI Spa Luxury' : 'Bạn';
        
        messageDiv.innerHTML = `
            <div class="message-header">
                <div class="message-avatar"><i class="fas ${avatarIcon}"></i></div>
                <span>${senderName}</span>
            </div>
            <div class="message-content ai-response">${isHTML ? content : escapeHtml(content)}</div>
        `;
        
        chatMessages.appendChild(messageDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function showTyping() {
        const typingDiv = document.createElement('div');
        typingDiv.className = 'message ai';
        typingDiv.id = 'typingIndicator';
        typingDiv.innerHTML = `
            <div class="message-header">
                <div class="message-avatar"><i class="fas fa-robot"></i></div>
                <span>AI Spa Luxury đang phân tích...</span>
            </div>
            <div class="typing-indicator">
                <span></span><span></span><span></span>
            </div>
        `;
        chatMessages.appendChild(typingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function removeTyping() {
        const indicator = document.getElementById('typingIndicator');
        if (indicator) indicator.remove();
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    </script>
</body>
</html>