<div class="row">
    <!-- Formulaire d'upload -->
    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-body">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Instructions :</strong> Sélectionnez le fichier des assurés (obligatoire) et éventuellement le fichier des enfants. 
                    Les fichiers doivent être au format Excel (.xlsx, .xls) ou CSV.
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
                <form action="{{ route('integrations.upload') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file_assures" class="font-weight-bold">
                                    <i class="fas fa-user-circle text-primary mr-1"></i>
                                    Fichier des assurés 
                                    <span class="text-danger">*</span>
                                    <span class="badge badge-danger badge-pill ml-1">Obligatoire</span>
                                </label>
                                <div class="custom-file">
                                    <input type="file" name="file_assures" class="custom-file-input" id="file_assures" accept=".xlsx,.xls,.csv" required>
                                    <label class="custom-file-label" for="file_assures" id="fileAssuresLabel">
                                        <i class="lni lni-files mr-1"></i>
                                        Choisir le fichier des assurés...
                                    </label>
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-check-circle text-success mr-1"></i>
                                    Formats acceptés : .xlsx, .xls, .csv
                                    <span class="ml-2">
                                        <i class="fas fa-weight-hanging mr-1"></i>
                                        Taille max : 2MB
                                    </span>
                                </small>
                            </div>
                            
                            <!-- Zone de drag & drop -->
                            <div class="drop-zone" id="dropZoneAssures">
                                <div class="drop-zone-content">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-2"></i>
                                    <p class="mb-0">Glissez-déposez votre fichier ici</p>
                                    <small class="text-muted">ou cliquez pour sélectionner</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="file_enfants" class="font-weight-bold">
                                    <i class="fas fa-child text-warning mr-1"></i>
                                    Fichier des enfants
                                    <span class="badge badge-secondary badge-pill ml-1">Optionnel</span>
                                </label>
                                <div class="custom-file">
                                    <input type="file" name="file_enfants" class="custom-file-input" id="file_enfants" accept=".xlsx,.xls,.csv" >
                                    <label class="custom-file-label" for="file_enfants" id="fileEnfantsLabel">
                                        <i class="lni lni-files mr-1"></i>
                                        Choisir le fichier des enfants...
                                    </label>
                                </div>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle text-info mr-1"></i>
                                    Formats : .xlsx, .xls, .csv
                                    <span class="ml-2">
                                        <i class="fas fa-weight-hanging mr-1"></i>
                                        Taille max : 2MB
                                    </span>
                                </small>
                            </div>
                            
                            <!-- Zone de drag & drop -->
                            <div class="drop-zone" id="dropZoneEnfants">
                                <div class="drop-zone-content">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-warning mb-2"></i>
                                    <p class="mb-0">Glissez-déposez votre fichier ici</p>
                                    <small class="text-muted">ou cliquez pour sélectionner</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="file-preview" id="filePreview" style="display: none;">
                                <div class="alert alert-success">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="lni lni-files fa-2x mr-3"></i>
                                            <span id="filePreviewName" class="font-weight-bold"></span>
                                            <span id="filePreviewSize" class="text-muted ml-2"></span>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile()">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mt-4 text-center float-end">
                        <button type="submit" class="btn btn-primary btn-md px-5 shadow-sm" id="submitBtn">
                            <i class="lni lni-upload mr-2"></i>
                            Importer les fichiers
                        </button>
                        <button type="reset" class="btn btn-secondary btn-md px-4 ml-2 shadow-sm">
                            <i class="lni lni-reload mr-2"></i>
                            Réinitialiser
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- @push('styles') --}}
<style>
    /* Drop Zone */
    .drop-zone {
        border: 2px dashed #ced4da;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f8f9fa;
        margin-top: 5px;
        position: relative;
    }
    .drop-zone:hover {
        border-color: #007bff;
        background: #e9ecef;
    }
    .drop-zone.dragover {
        border-color: #28a745;
        background: #d4edda;
        transform: scale(1.02);
    }
    .drop-zone-content {
        pointer-events: none;
    }
    .drop-zone-content i {
        display: block;
        margin: 0 auto;
    }
    .drop-zone-content p {
        font-weight: 500;
        margin-top: 5px;
    }
    
    /* Custom File Input */
    .custom-file-input:focus ~ .custom-file-label {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    }
    .custom-file-label {
        cursor: pointer;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .custom-file-label i {
        margin-right: 5px;
    }
    
    /* File Preview */
    .file-preview .alert {
        border-radius: 8px;
        border-left: 4px solid #28a745;
        margin-bottom: 0;
        padding: 12px 20px;
    }
    .file-preview .alert i {
        color: #28a745;
    }
    
    /* Badges */
    .badge-pill {
        padding: 5px 12px;
        font-weight: 500;
        font-size: 0.75rem;
    }
    
    /* Alert info */
    .alert-info {
        border-radius: 8px;
        border-left: 4px solid #17a2b8;
    }
    
    /* Boutons */
    .btn-lg {
        padding: 10px 35px;
        border-radius: 8px;
        font-weight: 500;
        letter-spacing: 0.3px;
        transition: all 0.3s ease;
    }
    .btn-lg:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .drop-zone {
            padding: 15px;
        }
        .drop-zone-content i {
            font-size: 2rem;
        }
        .btn-lg {
            padding: 8px 20px;
            font-size: 0.9rem;
        }
    }
</style>
{{-- @endpush --}}

{{-- @push('scripts') --}}
<script>
    // Gestion des noms de fichiers
    document.getElementById('file_assures').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : 'Choisir le fichier des assurés...';
        var label = document.getElementById('fileAssuresLabel');
        label.innerHTML = '<i class="lni lni-files mr-1"></i> ' + fileName;
        
        if (e.target.files[0]) {
            showFilePreview(fileName, e.target.files[0].size);
        }
    });
    
    document.getElementById('file_enfants').addEventListener('change', function(e) {
        var fileName = e.target.files[0] ? e.target.files[0].name : 'Choisir le fichier des enfants...';
        var label = document.getElementById('fileEnfantsLabel');
        label.innerHTML = '<i class="lni lni-files mr-1"></i> ' + fileName;
        
        if (e.target.files[0]) {
            showFilePreview(fileName, e.target.files[0].size);
        }
    });
    
    // Drag and Drop
    function setupDropZone(dropZoneId, fileInputId) {
        const dropZone = document.getElementById(dropZoneId);
        const fileInput = document.getElementById(fileInputId);
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight(e) {
            dropZone.classList.add('dragover');
        }
        
        function unhighlight(e) {
            dropZone.classList.remove('dragover');
        }
        
        dropZone.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            
            // Déclencher l'événement change
            const event = new Event('change');
            fileInput.dispatchEvent(event);
            
            // Mettre à jour le label
            if (files.length > 0) {
                const label = document.querySelector(`label[for="${fileInputId}"]`);
                label.innerHTML = '<i class="lni lni-files mr-1"></i> ' + files[0].name;
                showFilePreview(files[0].name, files[0].size);
            }
        }, false);
        
        dropZone.addEventListener('click', function() {
            fileInput.click();
        });
    }
    
    function showFilePreview(fileName, fileSize) {
        const preview = document.getElementById('filePreview');
        const name = document.getElementById('filePreviewName');
        const size = document.getElementById('filePreviewSize');
        
        name.textContent = fileName;
        size.textContent = ' (' + formatFileSize(fileSize) + ')';
        preview.style.display = 'block';
    }
    
    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / 1048576).toFixed(1) + ' MB';
    }
    
    function removeFile() {
        document.getElementById('file_assures').value = '';
        document.getElementById('file_enfants').value = '';
        document.getElementById('fileAssuresLabel').innerHTML = '<i class="lni lni-files mr-1"></i> Choisir le fichier des assurés...';
        document.getElementById('fileEnfantsLabel').innerHTML = '<i class="lni lni-files mr-1"></i> Choisir le fichier des enfants...';
        document.getElementById('filePreview').style.display = 'none';
    }
    
    // Initialiser les drop zones
    document.addEventListener('DOMContentLoaded', function() {
        setupDropZone('dropZoneAssures', 'file_assures');
        setupDropZone('dropZoneEnfants', 'file_enfants');
    });
</script>
{{-- @endpush --}}