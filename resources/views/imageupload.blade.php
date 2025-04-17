<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload and Gallery</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .upload-section {
            margin-bottom: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .upload-section input,
        .upload-section select,
        .upload-section button {
            margin: 10px 0;
            padding: 8px;
            font-size: 16px;
        }

        .view-toggle {
            margin-bottom: 20px;
        }

        .view-toggle button {
            padding: 10px 20px;
            margin-right: 10px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }

        .view-toggle button:hover {
            background-color: #0056b3;
        }

        .grid-view {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .linear-view {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .image-card {
            background-color: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .image-card img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .landscape {
            grid-column: span 3;
        }

        .portrait {
            grid-column: span 1;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="upload-section">
            <h2>Upload Image</h2>
            <input type="file" id="imageInput" accept=".jpg,.jpeg,.png">
            <select id="orientationSelect">
                <option value="portrait">Portrait</option>
                <option value="landscape">Landscape</option>
            </select>
            <button onclick="uploadImage()">Upload</button>
            <div id="error" class="error"></div>
        </div>

        <div class="view-toggle">
            <button onclick="toggleView('grid')">Grid View</button>
            <button onclick="toggleView('linear')">Linear View</button>
        </div>

        <div id="gallery" class="grid-view"></div>
    </div>

    <script>
        let images = [];
        let currentView = 'grid';
        const MAX_SIZE = 5 * 1024 * 1024; // 5MB max size

        function uploadImage() {
            const imageInput = document.getElementById('imageInput');
            const orientationSelect = document.getElementById('orientationSelect');
            const errorDiv = document.getElementById('error');
            const file = imageInput.files[0];

            errorDiv.textContent = '';

            if (!file) {
                errorDiv.textContent = 'Please select an image';
                return;
            }

            if (!['image/jpeg', 'image/png'].includes(file.type)) {
                errorDiv.textContent = 'Only JPG, JPEG, and PNG files are allowed';
                return;
            }

            if (file.size > MAX_SIZE) {
                errorDiv.textContent = 'File size exceeds 5MB limit';
                return;
            }

            const reader = new FileReader();
            reader.onload = function (e) {
                const img = new Image();
                img.onload = function () {
                    const orientation = orientationSelect.value;
                    images.push({
                        src: e.target.result,
                        orientation: orientation,
                        naturalWidth: img.width,
                        naturalHeight: img.height
                    });
                    renderGallery();
                    imageInput.value = '';
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        function toggleView(view) {
            currentView = view;
            renderGallery();
        }

        function arrangeImagesForGrid() {
            if (images.length === 0) return images;

            const arranged = new Array(9).fill(null); // Support up to 9 positions
            const isFirstLandscape = images[0]?.orientation === 'landscape';

            if (isFirstLandscape) {
                // 1st View (Landscape first)
                arranged[0] = images[0];  // 1st position (landscape)
                if (images[1] && images[1].orientation === 'portrait') arranged[1] = images[1];  // 2nd position
                if (images[2] && images[2].orientation === 'landscape') arranged[3] = images[2];  // 4th position
                if (images[3] && images[3].orientation === 'portrait') arranged[2] = images[3];  // 3rd position
                if (images[4] && images[4].orientation === 'landscape') arranged[6] = images[4];  // 7th position
                if (images[5] && images[5].orientation === 'portrait') arranged[4] = images[5];  // 5th position
                if (images[6] && images[6].orientation === 'portrait') arranged[5] = images[6];  // 6th position
            } else {
                // 2nd View (Portrait first)
                arranged[0] = images[0];  // 1st position (portrait)
                if (images[1] && images[1].orientation === 'landscape') arranged[2] = images[1];  // 3rd position
                if (images[2] && images[2].orientation === 'portrait') arranged[1] = images[2];  // 2nd position
                if (images[3] && images[3].orientation === 'landscape') arranged[5] = images[3];  // 6th position
                if (images[4] && images[4].orientation === 'portrait') arranged[3] = images[4];  // 4th position
                if (images[5] && images[5].orientation === 'landscape') arranged[8] = images[5];  // 9th position
                if (images[6] && images[6].orientation === 'portrait') arranged[4] = images[6];  // 5th position
            }

            return arranged.filter(img => img !== null);
        }

        function renderGallery() {
            const gallery = document.getElementById('gallery');
            gallery.className = currentView === 'grid' ? 'grid-view' : 'linear-view';
            gallery.innerHTML = '';

            const displayImages = currentView === 'grid' ? arrangeImagesForGrid() : images;

            displayImages.forEach((img, index) => {
                if (!img) return;
                const card = document.createElement('div');
                card.className = 'image-card';
                if ((index === 0 || index === 3 || index === 6 || index === 8) && img.orientation === 'landscape') {
                    card.className += ' landscape';
                } else {
                    card.className += ' portrait';
                }
                card.innerHTML = `
                    <img src="${img.src}" alt="Uploaded image">
                    <p>Orientation: ${img.orientation}</p>
                    <p>Position: ${index + 1}</p>
                `;
                gallery.appendChild(card);
            });
        }
    </script>
</body>

</html>