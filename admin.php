<?php
require_once 'auth_check.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Panel Publicitario</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 10px;
        }
        
        .top-bar {
            background: white;
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-info span {
            color: #666;
            font-size: 14px;
        }
        
        .btn-logout {
            background: #f44336;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-logout:hover {
            background: #da190b;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            font-size: 24px;
        }
        
        h2 {
            font-size: 18px;
            margin-bottom: 15px;
        }
        
        .upload-section {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 25px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 6px;
            color: #555;
            font-weight: 600;
            font-size: 14px;
        }
        
        input[type="file"] {
            width: 100%;
            padding: 8px;
            border: 2px dashed #ddd;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        
        .btn-submit {
            background: #4CAF50;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
        }
        
        .btn-submit:hover {
            background: #45a049;
        }
        
        .btn-submit:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        .images-list {
            margin-top: 25px;
        }
        
        .image-item {
            display: flex;
            align-items: center;
            background: #f9f9f9;
            padding: 12px;
            margin-bottom: 12px;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
            cursor: move;
            transition: all 0.2s;
        }
        
        .image-item:hover {
            background: #f0f0f0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .image-item.dragging {
            opacity: 0.5;
            background: #e3f2fd;
        }
        
        .drag-handle {
            font-size: 20px;
            color: #999;
            margin-right: 10px;
            cursor: grab;
            user-select: none;
            min-width: 20px;
        }
        
        .drag-handle:active {
            cursor: grabbing;
        }
        
        .order-number {
            font-size: 16px;
            font-weight: bold;
            color: #666;
            min-width: 32px;
            text-align: center;
            margin-right: 10px;
        }
        
        .image-item img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            margin-right: 12px;
            flex-shrink: 0;
        }
        
        .image-info {
            flex: 1;
            min-width: 0;
        }
        
        .image-info p {
            margin: 3px 0;
            color: #666;
            font-size: 13px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .button-group {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-shrink: 0;
        }
        
        .order-buttons {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .order-btn {
            background: #2196F3;
            color: white;
            padding: 4px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            min-width: 36px;
        }
        
        .order-btn:hover {
            background: #0b7dda;
        }
        
        .order-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        
        .delete-btn {
            background: #f44336;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        
        .delete-btn:hover {
            background: #da190b;
        }
        
        .message {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 15px;
            display: none;
            font-size: 14px;
        }
        
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .preview {
            margin-top: 12px;
            display: none;
        }
        
        .preview img {
            max-width: 100%;
            max-height: 180px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        
        .drag-info {
            background: #e3f2fd;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 12px;
            color: #1976d2;
            font-size: 13px;
            text-align: center;
        }
        
        @media (max-width: 768px) {
            body {
                padding: 5px;
            }
            
            .top-bar {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
            
            .container {
                padding: 15px;
            }
            
            h1 {
                font-size: 20px;
                margin-bottom: 15px;
            }
            
            h2 {
                font-size: 16px;
            }
            
            .upload-section {
                padding: 15px;
            }
            
            .image-item {
                padding: 10px;
                flex-wrap: wrap;
            }
            
            .image-item img {
                width: 60px;
                height: 45px;
            }
            
            .drag-handle {
                font-size: 18px;
                margin-right: 6px;
            }
            
            .order-number {
                font-size: 14px;
                min-width: 28px;
                margin-right: 6px;
            }
            
            .image-info {
                flex: 1 1 100%;
                order: 3;
                margin-top: 8px;
            }
            
            .button-group {
                gap: 6px;
            }
            
            .order-btn {
                padding: 6px 8px;
                font-size: 12px;
                min-width: 32px;
            }
            
            .delete-btn {
                padding: 6px 12px;
                font-size: 13px;
            }
            
            .drag-info {
                font-size: 12px;
                padding: 8px;
            }
        }
        
        @media (max-width: 480px) {
            h1 {
                font-size: 18px;
            }
            
            .image-item img {
                width: 50px;
                height: 40px;
            }
            
            .image-info p {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <div class="user-info">
            <span>👤 Usuario: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
        </div>
        <a href="logout.php" class="btn-logout">Cerrar Sesión</a>
    </div>

    <div class="container">
        <h1>🖼️ Panel de Administración</h1>
        
        <div id="message" class="message"></div>
        
        <div class="upload-section">
            <h2>Subir Nueva Imagen</h2>
            <div class="form-group">
                <label for="imageFile">Seleccionar imagen:</label>
                <input type="file" id="imageFile" accept="image/*">
                <div id="preview" class="preview">
                    <img id="previewImg" src="" alt="Vista previa">
                </div>
            </div>
            
            <div class="form-group">
                <label for="duration">Duración en pantalla (segundos):</label>
                <input type="number" id="duration" min="1" max="300" value="5">
            </div>
            
            <button type="button" id="submitBtn" class="btn-submit">Subir Imagen</button>
        </div>
        
        <div class="images-list">
            <h2>Imágenes Actuales</h2>
            <div class="drag-info">
                💡 Usa los botones ↑ ↓ para reordenar las imágenes
            </div>
            <div id="imagesList"></div>
        </div>
    </div>

    <script>
        const fileInput = document.getElementById('imageFile');
        const preview = document.getElementById('preview');
        const previewImg = document.getElementById('previewImg');
        const submitBtn = document.getElementById('submitBtn');
        const durationInput = document.getElementById('duration');
        const messageDiv = document.getElementById('message');
        let draggedElement = null;
        let isReordering = false;

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });

        submitBtn.addEventListener('click', async function() {
            if (!fileInput.files || !fileInput.files[0]) {
                showMessage('Por favor selecciona una imagen', 'error');
                return;
            }
            
            const formData = new FormData();
            formData.append('image', fileInput.files[0]);
            formData.append('duration', durationInput.value);
            
            submitBtn.disabled = true;
            submitBtn.textContent = 'Subiendo...';
            
            try {
                const response = await fetch('upload.php', {
                    method: 'POST',
                    body: formData
                });
                
                const result = await response.json();
                
                if (result.success) {
                    showMessage('Imagen subida exitosamente', 'success');
                    fileInput.value = '';
                    durationInput.value = '5';
                    preview.style.display = 'none';
                    await loadImages();
                } else {
                    showMessage('Error: ' + result.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showMessage('Error al subir la imagen', 'error');
            }
            
            submitBtn.disabled = false;
            submitBtn.textContent = 'Subir Imagen';
        });

        async function loadImages() {
            try {
                const response = await fetch('get_images.php?t=' + Date.now());
                const data = await response.json();
                
                const listDiv = document.getElementById('imagesList');
                
                if (data.success && data.images.length > 0) {
                    listDiv.innerHTML = data.images.map((img, index) => `
                        <div class="image-item" draggable="true" data-filename="${img.filename}" data-index="${index}">
                            <div class="drag-handle">⋮⋮</div>
                            <div class="order-number">#${index + 1}</div>
                            <img src="uploads/${img.filename}" alt="Imagen ${index + 1}">
                            <div class="image-info">
                                <p><strong>Archivo:</strong> ${img.filename}</p>
                                <p><strong>Duración:</strong> ${img.duration} segundos</p>
                            </div>
                            <div class="button-group">
                                <div class="order-buttons">
                                    <button class="order-btn" onclick="moveImage(${index}, 'up')" ${index === 0 ? 'disabled' : ''}>↑</button>
                                    <button class="order-btn" onclick="moveImage(${index}, 'down')" ${index === data.images.length - 1 ? 'disabled' : ''}>↓</button>
                                </div>
                                <button class="delete-btn" onclick="deleteImage('${img.filename}')">Eliminar</button>
                            </div>
                        </div>
                    `).join('');
                    
                    setupDragAndDrop();
                } else {
                    listDiv.innerHTML = '<p style="color: #999; text-align: center;">No hay imágenes subidas</p>';
                }
            } catch (error) {
                console.error('Error al cargar imágenes:', error);
            }
        }

        function setupDragAndDrop() {
            const items = document.querySelectorAll('.image-item');
            
            items.forEach(item => {
                item.addEventListener('dragstart', handleDragStart);
                item.addEventListener('dragover', handleDragOver);
                item.addEventListener('drop', handleDrop);
                item.addEventListener('dragend', handleDragEnd);
                item.addEventListener('dragenter', handleDragEnter);
                item.addEventListener('dragleave', handleDragLeave);
            });
        }

        function handleDragStart(e) {
            draggedElement = this;
            this.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.innerHTML);
        }

        function handleDragOver(e) {
            if (e.preventDefault) {
                e.preventDefault();
            }
            e.dataTransfer.dropEffect = 'move';
            return false;
        }

        function handleDragEnter(e) {
            if (this !== draggedElement) {
                this.style.borderTop = '3px solid #2196F3';
            }
        }

        function handleDragLeave(e) {
            this.style.borderTop = '';
        }

        async function handleDrop(e) {
            if (e.stopPropagation) {
                e.stopPropagation();
            }
            
            this.style.borderTop = '';
            
            if (draggedElement !== this && !isReordering) {
                const fromIndex = parseInt(draggedElement.dataset.index);
                const toIndex = parseInt(this.dataset.index);
                await reorderImages(fromIndex, toIndex);
            }
            
            return false;
        }

        function handleDragEnd(e) {
            this.classList.remove('dragging');
            document.querySelectorAll('.image-item').forEach(item => {
                item.style.borderTop = '';
            });
        }

        async function moveImage(index, direction) {
            if (isReordering) return;
            const newIndex = direction === 'up' ? index - 1 : index + 1;
            await reorderImages(index, newIndex);
        }

        async function reorderImages(fromIndex, toIndex) {
            if (isReordering) return;
            isReordering = true;
            
            try {
                const response = await fetch('reorder.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `fromIndex=${fromIndex}&toIndex=${toIndex}`
                });
                
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                
                const text = await response.text();
                let result;
                
                try {
                    result = JSON.parse(text);
                } catch (e) {
                    console.error('Respuesta del servidor:', text);
                    throw new Error('Respuesta inválida del servidor');
                }
                
                await new Promise(resolve => setTimeout(resolve, 200));
                await loadImages();
                
                if (!result.success) {
                    showMessage('Advertencia: ' + (result.message || 'Posible error al reordenar'), 'error');
                }
            } catch (error) {
                console.error('Error completo:', error);
                await new Promise(resolve => setTimeout(resolve, 300));
                await loadImages();
                showMessage('Cambio realizado (verificar si es correcto)', 'success');
            } finally {
                isReordering = false;
            }
        }

        async function deleteImage(filename) {
            if (!confirm('¿Estás seguro de eliminar esta imagen?')) return;
            
            try {
                const response = await fetch('delete.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'filename=' + encodeURIComponent(filename)
                });
                
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                
                const text = await response.text();
                let result;
                
                try {
                    result = JSON.parse(text);
                } catch (e) {
                    console.error('Respuesta del servidor:', text);
                    throw new Error('Respuesta inválida del servidor');
                }
                
                await new Promise(resolve => setTimeout(resolve, 200));
                await loadImages();
                
                if (result.success) {
                    showMessage('Imagen eliminada exitosamente', 'success');
                } else {
                    showMessage('Advertencia: ' + (result.message || 'Posible error al eliminar'), 'error');
                }
            } catch (error) {
                console.error('Error completo:', error);
                await new Promise(resolve => setTimeout(resolve, 300));
                await loadImages();
                showMessage('Verificando cambios...', 'success');
            }
        }

        function showMessage(text, type) {
            messageDiv.textContent = text;
            messageDiv.className = 'message ' + type;
            messageDiv.style.display = 'block';
            
            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 5000);
        }

        loadImages();
    </script>
</body>
</html>