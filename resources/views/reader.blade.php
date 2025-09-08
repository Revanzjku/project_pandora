<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PANDORA Reader (PDF.js)</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="//unpkg.com/alpinejs" defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', sans-serif; }
    h1, h2, h3, nav, .btn { font-family: 'Poppins', sans-serif; }
    [x-cloak] { display: none !important; }
    canvas { display: block; margin: 0 auto; }
  </style>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen" 
      x-data="{ darkMode: false }" 
      :class="{ 'bg-gray-900 text-gray-100': darkMode }">

  <!-- Navbar -->
  <nav class="bg-white dark:bg-gray-800 shadow-md px-6 py-4 flex justify-between items-center">
    <div class="text-2xl font-bold text-[#3A6D8C] dark:text-[#E9B44C]">PANDORA</div>
    <div class="flex items-center gap-4">
      <a href="/katalog" class="text-gray-700 dark:text-gray-200 hover:underline">Kembali ke Katalog</a>
    </div>
  </nav>

  <!-- Toolbar -->
  <div class="bg-gray-200 dark:bg-gray-700 px-4 py-2 flex flex-wrap items-center justify-between gap-2">
    <div class="flex items-center gap-2 flex-wrap">
      <button id="prev" class="px-3 py-1 bg-gray-300 dark:bg-gray-600 rounded hover:bg-gray-400">⬅️ Prev</button>
      <button id="next" class="px-3 py-1 bg-gray-300 dark:bg-gray-600 rounded hover:bg-gray-400">Next ➡️</button>
      <span id="page_info" class="ml-2">Halaman 1 / ?</span>
    </div>
    <div class="flex items-center gap-2 flex-wrap">
      <button id="zoomOut" class="px-3 py-1 bg-gray-300 dark:bg-gray-600 rounded hover:bg-gray-400">A-</button>
      <button id="zoomIn" class="px-3 py-1 bg-gray-300 dark:bg-gray-600 rounded hover:bg-gray-400">A+</button>
      <button @click="darkMode = !darkMode" class="px-3 py-1 bg-gray-300 dark:bg-gray-600 rounded hover:bg-gray-400">🌓 Mode</button>
      <a href="/download/sample.pdf" 
        class="px-3 py-1 bg-[#3A6D8C] text-white rounded hover:bg-[#2C546C]">⬇️ Unduh PDF</a>
    </div>
  </div>

  <!-- PDF Canvas -->
  <main class="flex-1 flex items-center justify-center bg-gray-50 dark:bg-gray-900 p-4">
    <div class="w-full overflow-x-auto">
      <canvas id="pdf-render" class="mx-auto max-w-full h-auto shadow-lg border border-gray-300 dark:border-gray-700 rounded"></canvas>
    </div>
  </main>


  <!-- Footer -->
  <footer class="bg-[#3A6D8C] text-white text-center py-4 mt-auto">
    © 2025 PANDORA. Domain Publik – Semua orang bebas membaca 📚
  </footer>

  <script>
    const url = "/proposal.pdf"; // ganti dengan path PDF kamu

    let pdfDoc = null,
        pageNum = 1,
        pageIsRendering = false,
        pageNumIsPending = null,
        scale = 1.2,
        canvas = document.getElementById("pdf-render"),
        ctx = canvas.getContext("2d");

    // Render halaman
    const renderPage = num => {
      pageIsRendering = true;
      pdfDoc.getPage(num).then(page => {
        const viewport = page.getViewport({ scale });
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        const renderCtx = {
          canvasContext: ctx,
          viewport
        };

        page.render(renderCtx).promise.then(() => {
          pageIsRendering = false;
          if (pageNumIsPending !== null) {
            renderPage(pageNumIsPending);
            pageNumIsPending = null;
          }
        });

        document.getElementById("page_info").textContent = `Halaman ${num} / ${pdfDoc.numPages}`;
      });
    };

    // Antrian halaman
    const queueRenderPage = num => {
      if (pageIsRendering) {
        pageNumIsPending = num;
      } else {
        renderPage(num);
      }
    };

    // Navigasi halaman
    const showPrevPage = () => {
      if (pageNum <= 1) return;
      pageNum--;
      queueRenderPage(pageNum);
    };

    const showNextPage = () => {
      if (pageNum >= pdfDoc.numPages) return;
      pageNum++;
      queueRenderPage(pageNum);
    };

    // Zoom
    const zoomIn = () => {
      scale += 0.2;
      queueRenderPage(pageNum);
    };

    const zoomOut = () => {
      if (scale <= 0.6) return;
      scale -= 0.2;
      queueRenderPage(pageNum);
    };

    // Load dokumen PDF
    pdfjsLib.getDocument(url).promise.then(pdfDoc_ => {
      pdfDoc = pdfDoc_;
      document.getElementById("page_info").textContent = `Halaman 1 / ${pdfDoc.numPages}`;
      renderPage(pageNum);
    });

    // Event listener
    document.getElementById("prev").addEventListener("click", showPrevPage);
    document.getElementById("next").addEventListener("click", showNextPage);
    document.getElementById("zoomIn").addEventListener("click", zoomIn);
    document.getElementById("zoomOut").addEventListener("click", zoomOut);
  </script>
</body>
</html>