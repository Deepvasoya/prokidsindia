<section class="edu_admin_content">
    <div class="edu_admin_right sectionHolder edu_video_manager">
        <div class="row">
            <div id="pdfLoader">
                <div class="loader"></div>
            </div>
            <div id="pdfContainer"></div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 ">
                <!-- Remove unnecessary iframe placeholders -->

                <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.9.359/pdf.min.js"></script>
                <div id="pdfLoader">
                    <div class="loader"></div>
                </div>
                <div id="pdfContainer"></div>

                <script>
                    // PDF.js setup
                    const pdfUrl = "<?php echo $file_name; ?>";
                    const pdfContainer = document.getElementById('pdfContainer');
                    const pdfLoader = document.getElementById('pdfLoader');

                    // Show loader
                    pdfLoader.style.display = 'block';

                    // Function to render a single page
                    function renderPage(pdf, pageNumber) {
                        return pdf.getPage(pageNumber).then(function(page) {
                            const canvas = document.createElement('canvas');
                            const context = canvas.getContext('2d');
                            const viewport = page.getViewport({ scale: 1.5 });

                            canvas.height = viewport.height;
                            canvas.width = viewport.width;

                            return page.render({
                                canvasContext: context,
                                viewport: viewport
                            }).promise.then(function() {
                                pdfContainer.appendChild(canvas);
                            });
                        });
                    }

                    // Function to render all pages sequentially
                    function renderAllPages(pdf, totalPages) {
                        let renderPromise = Promise.resolve();

                        for (let pageNumber = 1; pageNumber <= totalPages; pageNumber++) {
                            renderPromise = renderPromise.then(() => renderPage(pdf, pageNumber));
                        }

                        return renderPromise;
                    }

                    // Fetch and render the PDF
                    pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
                        const totalPages = pdf.numPages;

                        renderAllPages(pdf, totalPages).then(function() {
                            // Hide loader after all pages are rendered
                            pdfLoader.style.display = 'none';
                        });
                    });
                </script>

            </div>
        </div>
    </div>
</section>
<style>
#pdfLoader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.5);
    z-index: 9999;
    display: none;
}

.loader {
    border: 8px solid #f3f3f3;
    border-radius: 50%;
    border-top: 8px solid #3498db;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
    position: absolute;
    top: 50%;
    left: 50%;
    margin-top: -25px;
    margin-left: -25px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
