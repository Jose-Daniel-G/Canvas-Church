                                <div class="form-group">
                                    <label>Subir archivo</label>
                                    <div class="file-upload-area"  onclick="document.getElementById('fileInput').click()">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-3"></i>
                                        <h5>Arrastra tus archivos aquí</h5>
                                        <p class="text-muted">o haz clic para seleccionar</p>
                                        <small class="text-muted">Formatos aceptados: .docx, .pdf, .jpg, .png (máx. 50MB)</small>
                                        <input type="file"
                                            class="custom-file-input @error('archivo') is-invalid @enderror" 
                                            name="archivo" accept=".docx,.pdf,.jpg,.jpeg,.png"  id="fileInput" style="display: none;">
 
                                        </label>
                                    </div> 
                                    @error('archivo')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                @section('css')
    <style>
        .file-upload-area {
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.2s;
        }
    </style>
@section('js')
    <script>
        // Actualizar el nombre del archivo seleccionado
        document.getElementById('taskFile').addEventListener('change', function(e) {
            var fileName = e.target.files[0]?.name || 'Seleccionar archivo ZIP';
            e.target.nextElementSibling.textContent = fileName;
        });

        // File upload handler
        document.getElementById('fileInput').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const fileName = e.target.files[0].name;
                alert(`Archivo seleccionado: ${fileName}`);
            }
        });
    </script>
@stop