<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
  
  <!-- SEO Completo e Otimizado -->
  <title>Gerador de QR Code Grátis com Logo em JPG e PNG | Projeto Open Source por Pedro Falconi</title>
  <meta name="description" content="Gerador de QR Code 100% gratuito, sem pegadinhas e para sempre grátis. Crie QR Code para google.com.br ou qualquer link, adicione seu logotipo/imagem e baixe em alta resolução JPG ou PNG no celular ou PC. Projeto Open Source criado por Pedro Falconi.">
  <meta name="keywords" content="gerador qr code gratis, qr code jpg celular, qr code com imagem, qr code com logotipo, pedro falconi open source, criar qr code png jpg sem cadastro">
  <meta name="author" content="Pedro Falconi">
  <meta name="robots" content="index, follow">
  <link rel="canonical" href="https://www.google.com.br/">

  <!-- Open Graph / Redes Sociais -->
  <meta property="og:type" content="website">
  <meta property="og:title" content="Gerador de QR Code 100% Grátis e Para Sempre - JPG & PNG">
  <meta property="og:description" content="Gere QR Code de alta resolução em segundos. Suba sua própria logo/imagem, personalize e baixe em JPG ou PNG. Projeto Open Source criado por Pedro Falconi.">
  <meta property="og:image" content="generate.php?format=jpg&url=https%3A%2F%2Fwww.google.com.br%2F">
  
  <!-- Fontes Google -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Schema.org Rich Snippets / Structured Data -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebApplication",
    "name": "Gerador de QR Code Open Source - Pedro Falconi",
    "applicationCategory": "UtilityApplication",
    "operatingSystem": "All (Android, iOS, Windows, macOS, Linux)",
    "author": {
      "@type": "Person",
      "name": "Pedro Falconi"
    },
    "offers": {
      "@type": "Offer",
      "price": "0",
      "priceCurrency": "BRL"
    },
    "description": "Ferramenta 100% gratuita e open source criada por Pedro Falconi para gerar QR Code em JPG e PNG com suporte a upload de logotipo no centro."
  }
  </script>

  <style>
    :root {
      --bg-gradient: radial-gradient(circle at 10% 10%, #1e1b4b 0%, #0f172a 45%, #020617 100%);
      --card-bg: rgba(255, 255, 255, 0.05);
      --card-border: rgba(255, 255, 255, 0.12);
      --accent-gradient: linear-gradient(135deg, #f59e0b 0%, #ec4899 50%, #8b5cf6 100%);
      --accent-primary: #f59e0b;
      --text-main: #f8fafc;
      --text-muted: #94a3b8;
      --success: #10b981;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
      -webkit-tap-highlight-color: transparent;
    }

    body {
      min-height: 100vh;
      background: var(--bg-gradient);
      color: var(--text-main);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
      padding: 1rem 0.85rem 3rem;
      position: relative;
      overflow-x: hidden;
    }

    /* Iluminação ambiente sutil */
    body::before, body::after {
      content: '';
      position: absolute;
      width: 320px;
      height: 320px;
      border-radius: 50%;
      filter: blur(100px);
      z-index: 0;
      pointer-events: none;
      opacity: 0.3;
    }
    body::before { background: #f59e0b; top: -50px; left: -50px; }
    body::after { background: #8b5cf6; bottom: 50px; right: -50px; }

    .wrapper {
      position: relative;
      z-index: 1;
      width: 100%;
      max-width: 520px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    /* Banner "Grátis para Sempre" */
    .guarantee-bar {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      background: rgba(16, 185, 129, 0.15);
      border: 1px solid rgba(16, 185, 129, 0.35);
      color: #6ee7b7;
      padding: 0.5rem 1rem;
      border-radius: 9999px;
      font-size: 0.82rem;
      font-weight: 700;
      margin-bottom: 1.25rem;
      box-shadow: 0 4px 15px rgba(16, 185, 129, 0.15);
      text-align: center;
    }

    .container {
      width: 100%;
      background: var(--card-bg);
      backdrop-filter: blur(25px);
      -webkit-backdrop-filter: blur(25px);
      border: 1px solid var(--card-border);
      border-radius: 24px;
      padding: 1.75rem 1.25rem;
      box-shadow: 0 20px 45px -10px rgba(0, 0, 0, 0.55);
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
    }

    header h1 {
      font-size: 1.55rem;
      font-weight: 800;
      line-height: 1.25;
      margin-bottom: 0.35rem;
      background: var(--accent-gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    header p {
      color: var(--text-muted);
      font-size: 0.88rem;
      margin-bottom: 1.25rem;
    }

    /* Quadro do QR Code otimizado para celular */
    .qr-card {
      position: relative;
      background: #ffffff;
      padding: 0.9rem;
      border-radius: 18px;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4);
      margin-bottom: 1.25rem;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 240px;
      height: 240px;
      max-width: 85vw;
      max-height: 85vw;
      transition: transform 0.25s ease;
    }

    .qr-card img {
      width: 100%;
      height: 100%;
      object-fit: contain;
      border-radius: 10px;
      display: block;
    }

    .loading-overlay {
      position: absolute;
      inset: 0;
      background: rgba(255, 255, 255, 0.85);
      border-radius: 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      color: #1e1b4b;
      font-size: 0.9rem;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.2s ease;
    }
    .loading-overlay.active {
      opacity: 1;
      pointer-events: auto;
    }

    /* Formulário & Upload */
    .form-section {
      width: 100%;
      display: flex;
      flex-direction: column;
      gap: 0.85rem;
      margin-bottom: 1.25rem;
    }

    .input-group {
      width: 100%;
      text-align: left;
    }

    .input-label {
      display: block;
      font-size: 0.78rem;
      font-weight: 700;
      color: #cbd5e1;
      margin-bottom: 0.35rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .input-field {
      width: 100%;
      background: rgba(15, 23, 42, 0.75);
      border: 1.5px solid rgba(255, 255, 255, 0.12);
      border-radius: 12px;
      padding: 0.8rem 0.9rem;
      color: #ffffff;
      font-size: 0.9rem;
      outline: none;
      transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .input-field:focus {
      border-color: #f59e0b;
      box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
    }

    /* Seletor de Formato (JPG / PNG) */
    .format-pills {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.5rem;
      background: rgba(15, 23, 42, 0.6);
      padding: 0.35rem;
      border-radius: 12px;
      border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .pill-btn {
      padding: 0.6rem 0.5rem;
      border-radius: 9px;
      border: none;
      background: transparent;
      color: var(--text-muted);
      font-size: 0.85rem;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .pill-btn.active {
      background: var(--accent-gradient);
      color: #ffffff;
      box-shadow: 0 4px 12px rgba(245, 158, 11, 0.35);
    }

    /* Upload de Logo / Imagem */
    .upload-zone {
      position: relative;
      border: 2px dashed rgba(255, 255, 255, 0.2);
      border-radius: 14px;
      padding: 0.9rem;
      background: rgba(255, 255, 255, 0.03);
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.65rem;
      transition: all 0.2s ease;
    }
    .upload-zone:hover, .upload-zone:active {
      border-color: #f59e0b;
      background: rgba(245, 158, 11, 0.06);
    }

    .upload-zone input[type="file"] {
      position: absolute;
      inset: 0;
      opacity: 0;
      cursor: pointer;
      width: 100%;
      height: 100%;
    }

    .upload-info {
      font-size: 0.82rem;
      color: #e2e8f0;
      display: flex;
      align-items: center;
      gap: 0.4rem;
    }

    .logo-preview-badge {
      display: none;
      align-items: center;
      gap: 0.5rem;
      background: rgba(16, 185, 129, 0.15);
      border: 1px solid rgba(16, 185, 129, 0.3);
      color: #6ee7b7;
      padding: 0.35rem 0.75rem;
      border-radius: 8px;
      font-size: 0.78rem;
      font-weight: 600;
      margin-top: 0.4rem;
    }

    .logo-remove-btn {
      background: none;
      border: none;
      color: #f87171;
      font-weight: bold;
      cursor: pointer;
      margin-left: auto;
      font-size: 0.9rem;
    }

    /* Botões Principais - Touch Friendly no Mobile (mínimo 48px) */
    .btn-group {
      width: 100%;
      display: flex;
      flex-direction: column;
      gap: 0.75rem;
    }

    .btn {
      min-height: 50px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.6rem;
      width: 100%;
      padding: 0.85rem 1.25rem;
      border-radius: 14px;
      font-size: 0.95rem;
      font-weight: 700;
      text-decoration: none;
      cursor: pointer;
      border: none;
      transition: transform 0.15s ease, opacity 0.15s ease, box-shadow 0.15s ease;
    }

    .btn:active {
      transform: scale(0.98);
    }

    .btn-primary {
      background: var(--accent-gradient);
      color: #ffffff;
      box-shadow: 0 10px 25px -5px rgba(245, 158, 11, 0.45);
    }

    .btn-secondary {
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.15);
      color: #f8fafc;
    }

    /* Seção de Vantagens SEO & Confiança */
    .benefits-grid {
      width: 100%;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 0.65rem;
      margin-top: 1.5rem;
      text-align: left;
    }

    .benefit-item {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.08);
      border-radius: 12px;
      padding: 0.75rem;
      font-size: 0.76rem;
      color: #cbd5e1;
      display: flex;
      align-items: flex-start;
      gap: 0.5rem;
    }

    .benefit-item strong {
      display: block;
      color: #f8fafc;
      font-size: 0.8rem;
      margin-bottom: 0.1rem;
    }

    /* Rodapé & Notificação Toast */
    footer {
      margin-top: 1.75rem;
      text-align: center;
      font-size: 0.78rem;
      color: var(--text-muted);
      line-height: 1.5;
    }

    footer a {
      color: #fde68a;
      text-decoration: none;
      font-weight: 600;
    }

    .toast {
      position: fixed;
      bottom: 1.5rem;
      left: 50%;
      transform: translateX(-50%) translateY(30px);
      background: #10b981;
      color: #ffffff;
      padding: 0.75rem 1.4rem;
      border-radius: 9999px;
      font-size: 0.85rem;
      font-weight: 700;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
      opacity: 0;
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
      pointer-events: none;
      z-index: 9999;
      white-space: nowrap;
    }

    .toast.show {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }

    @media (max-width: 480px) {
      .container { padding: 1.4rem 1rem; }
      header h1 { font-size: 1.4rem; }
      .qr-card { width: 220px; height: 220px; }
      .benefits-grid { grid-template-columns: 1fr; }
    }
  </style>
</head>
<body>

  <div class="wrapper">
    <!-- Garantia Permanente de Gratuidade -->
    <div class="guarantee-bar">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
      </svg>
      100% Grátis • Sem Pegadinhas • Para Sempre
    </div>

    <main class="container">
      <header>
        <h1>Gerador de QR Code</h1>
        <p>Converta links e imagens em QR Code de alta resolução</p>
      </header>

      <!-- QR Code Preview -->
      <div class="qr-card">
        <img id="qrImage" src="generate.php?format=jpg&url=https%3A%2F%2Fwww.google.com.br%2F" alt="QR Code Open Source Gratuito">
        <div id="loadingOverlay" class="loading-overlay">Atualizando...</div>
      </div>

      <!-- Formulário de Personalização -->
      <section class="form-section">
        <!-- URL de Destino -->
        <div class="input-group">
          <label class="input-label" for="targetUrl">Link / Destino do QR Code</label>
          <input type="url" id="targetUrl" class="input-field" value="https://www.google.com.br/" placeholder="https://seu-link-aqui.com" autocomplete="off" spellcheck="false">
        </div>

        <!-- Seletor de Formato -->
        <div class="input-group">
          <label class="input-label">Formato de Saída</label>
          <div class="format-pills">
            <button type="button" class="pill-btn active" data-format="jpg">JPG (Padrão / Rápido)</button>
            <button type="button" class="pill-btn" data-format="png">PNG (Sem perda)</button>
          </div>
        </div>

        <!-- Upload de Imagem / Logo no Centro -->
        <div class="input-group">
          <label class="input-label">Subir Logo ou Imagem no Centro (Opcional)</label>
          <div class="upload-zone" id="uploadZone">
            <input type="file" id="logoInput" accept="image/png, image/jpeg, image/jpg, image/webp">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
              <polyline points="17 8 12 3 7 8"></polyline>
              <line x1="12" y1="3" x2="12" y2="15"></line>
            </svg>
            <span class="upload-info" id="uploadInfoText">Toque para selecionar imagem/logo</span>
          </div>

          <!-- Indicador de logo anexada -->
          <div id="logoBadge" class="logo-preview-badge">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            <span id="logoFileName">Imagem carregada</span>
            <button type="button" class="logo-remove-btn" id="btnRemoveLogo" title="Remover imagem">&times;</button>
          </div>
        </div>
      </section>

      <!-- Botões de Ação Otimizados para Celular -->
      <div class="btn-group">
        <button id="btnDownload" class="btn btn-primary">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
            <polyline points="7 10 12 15 17 10"></polyline>
            <line x1="12" y1="15" x2="12" y2="3"></line>
          </svg>
          <span id="btnDownloadText">Baixar QR Code (JPG)</span>
        </button>

        <button id="btnCopy" class="btn btn-secondary">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
          </svg>
          Copiar Link
        </button>
      </div>

      <!-- Garantias SEO & Benefícios -->
      <section class="benefits-grid" aria-label="Vantagens do Gerador">
        <div class="benefit-item">
          <span>⚡</span>
          <div>
            <strong>100% Gratuito</strong>
            Sem mensalidades, sem limites de escaneamento.
          </div>
        </div>
        <div class="benefit-item">
          <span>🛡️</span>
          <div>
            <strong>Sem Pegadinhas</strong>
            Não expira nunca. Seu QR Code é permanente.
          </div>
        </div>
        <div class="benefit-item">
          <span>📱</span>
          <div>
            <strong>Otimizado p/ Celular</strong>
            Compatível com iOS, Android e leitores nativos.
          </div>
        </div>
        <div class="benefit-item">
          <span>🎨</span>
          <div>
            <strong>Com Logo & Foto</strong>
            Personalize com sua marca com leitura perfeita.
          </div>
        </div>
      </section>

      <footer>
        Projeto Open Source criado por <strong>Pedro Falconi</strong> • 100% Gratuito para Sempre.<br>
        Destino padrão: <a href="https://www.google.com.br/" target="_blank" rel="noopener noreferrer">google.com.br</a>
      </footer>
    </main>
  </div>

  <div id="toast" class="toast">Ação concluída com sucesso!</div>

  <script>
    const inputUrl = document.getElementById('targetUrl');
    const qrImage = document.getElementById('qrImage');
    const btnDownload = document.getElementById('btnDownload');
    const btnDownloadText = document.getElementById('btnDownloadText');
    const btnCopy = document.getElementById('btnCopy');
    const toast = document.getElementById('toast');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const formatButtons = document.querySelectorAll('.pill-btn');
    const logoInput = document.getElementById('logoInput');
    const uploadInfoText = document.getElementById('uploadInfoText');
    const logoBadge = document.getElementById('logoBadge');
    const logoFileName = document.getElementById('logoFileName');
    const btnRemoveLogo = document.getElementById('btnRemoveLogo');

    let currentFormat = 'jpg';
    let currentLogoBase64 = '';

    // Alternar Formato (JPG / PNG)
    formatButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        formatButtons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        currentFormat = btn.dataset.format;
        btnDownloadText.textContent = `Baixar QR Code (${currentFormat.toUpperCase()})`;
        triggerUpdate();
      });
    });

    // Upload de Imagem / Logo
    logoInput.addEventListener('change', (e) => {
      const file = e.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = function(event) {
        currentLogoBase64 = event.target.result;
        logoFileName.textContent = file.name.length > 20 ? file.name.substring(0, 17) + '...' : file.name;
        logoBadge.style.display = 'inline-flex';
        uploadInfoText.textContent = 'Alterar logotipo';
        showToast('Logo adicionado com sucesso!');
        triggerUpdate();
      };
      reader.readAsDataURL(file);
    });

    btnRemoveLogo.addEventListener('click', (e) => {
      e.stopPropagation();
      currentLogoBase64 = '';
      logoInput.value = '';
      logoBadge.style.display = 'none';
      uploadInfoText.textContent = 'Toque para selecionar imagem/logo';
      showToast('Logo removido');
      triggerUpdate();
    });

    // Atualização com debounce
    function triggerUpdate() {
      loadingOverlay.classList.add('active');
      const url = encodeURIComponent(inputUrl.value.trim() || 'https://www.google.com.br/');

      if (currentLogoBase64) {
        // Envio via POST se houver imagem/logo
        const formData = new FormData();
        formData.append('url', inputUrl.value.trim() || 'https://www.google.com.br/');
        formData.append('format', currentFormat);
        formData.append('logo_base64', currentLogoBase64);

        fetch('generate.php', {
          method: 'POST',
          body: formData
        })
        .then(res => res.blob())
        .then(blob => {
          const objectUrl = URL.createObjectURL(blob);
          qrImage.src = objectUrl;
          loadingOverlay.classList.remove('active');
        })
        .catch(() => {
          loadingOverlay.classList.remove('active');
          showToast('Erro ao atualizar QR Code');
        });
      } else {
        const fullUrl = `generate.php?format=${currentFormat}&url=${url}&t=${Date.now()}`;
        qrImage.src = fullUrl;
        qrImage.onload = () => loadingOverlay.classList.remove('active');
        qrImage.onerror = () => loadingOverlay.classList.remove('active');
      }
    }

    inputUrl.addEventListener('input', () => {
      clearTimeout(window.qrTimer);
      window.qrTimer = setTimeout(triggerUpdate, 450);
    });

    // Download do QR Code
    btnDownload.addEventListener('click', async () => {
      const url = inputUrl.value.trim() || 'https://www.google.com.br/';
      showToast(`Baixando QR Code em ${currentFormat.toUpperCase()}...`);

      if (currentLogoBase64) {
        const formData = new FormData();
        formData.append('url', url);
        formData.append('format', currentFormat);
        formData.append('download', '1');
        formData.append('logo_base64', currentLogoBase64);

        try {
          const res = await fetch('generate.php', { method: 'POST', body: formData });
          const blob = await res.blob();
          const downloadUrl = window.URL.createObjectURL(blob);
          const a = document.createElement('a');
          a.href = downloadUrl;
          a.download = `qrcode.${currentFormat}`;
          document.body.appendChild(a);
          a.click();
          a.remove();
          window.URL.revokeObjectURL(downloadUrl);
        } catch (err) {
          showToast('Erro ao baixar QR Code');
        }
      } else {
        window.location.href = `generate.php?format=${currentFormat}&url=${encodeURIComponent(url)}&download=1`;
      }
    });

    // Copiar Link
    btnCopy.addEventListener('click', async () => {
      try {
        await navigator.clipboard.writeText(inputUrl.value.trim() || 'https://www.google.com.br/');
        showToast('Link copiado para a área de transferência!');
      } catch (err) {
        showToast('Erro ao copiar link');
      }
    });

    function showToast(msg) {
      toast.textContent = msg;
      toast.classList.add('show');
      setTimeout(() => toast.classList.remove('show'), 2800);
    }
  </script>
</body>
</html>
