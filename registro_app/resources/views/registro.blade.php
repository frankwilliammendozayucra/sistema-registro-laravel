<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Registro - Laravel & MySQL</title>
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --bg-body: #eef2f7;
            --topbar-bg: #001254;
            --sidebar-bg: #000e42;
            --sidebar-active: #0d42d3;
            --sidebar-card: #041961;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --primary-blue: #0b3bb5;
            --primary-hover: #082d8d;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Topbar Header */
        .app-topbar {
            background-color: var(--topbar-bg);
            padding: 0.85rem 1.75rem;
            color: #ffffff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .topbar-logo-box {
            width: 44px;
            height: 44px;
            background-color: #1138b3;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.25);
        }
        .pill-status {
            background-color: rgba(16, 185, 129, 0.12);
            color: #34d399;
            border: 1px solid rgba(52, 211, 153, 0.4);
            font-size: 0.82rem;
            font-weight: 600;
            padding: 0.4rem 0.9rem;
            border-radius: 50rem;
        }
        .btn-metric-api {
            border: 1px solid rgba(255,255,255,0.3);
            color: #e2e8f0;
            background: transparent;
            font-size: 0.82rem;
            font-weight: 600;
            padding: 0.4rem 1rem;
            border-radius: 50rem;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-metric-api:hover {
            background: rgba(255,255,255,0.12);
            color: #ffffff;
        }

        /* Sidebar */
        .app-sidebar {
            background-color: var(--sidebar-bg);
            color: #cbd5e1;
            min-height: calc(100vh - 66px);
            padding: 1.25rem 1rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .nav-link-custom {
            display: flex;
            align-items: center;
            gap: 0.85rem;
            padding: 0.75rem 1rem;
            color: #94a3b8;
            font-weight: 600;
            font-size: 0.92rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.15s ease-in-out;
            margin-bottom: 0.35rem;
        }
        .nav-link-custom:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.06);
        }
        .nav-link-custom.active {
            background-color: var(--sidebar-active);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(13, 66, 211, 0.35);
        }

        /* Sidebar Info Card */
        .sidebar-sys-info {
            background-color: var(--sidebar-card);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 1rem;
            margin-top: 1.5rem;
            font-size: 0.82rem;
        }
        .sidebar-sys-info .info-title {
            color: #93c5fd;
            font-weight: 700;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .sidebar-sys-info .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.45rem;
            color: #94a3b8;
        }
        .sidebar-sys-info .info-val {
            color: #ffffff;
            font-weight: 600;
        }

        /* Main Content Cards */
        .content-area {
            padding: 1.5rem 1.75rem;
        }
        .stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 1.25rem 1.25rem;
            box-shadow: 0 2px 6px rgba(0, 20, 60, 0.03);
            display: flex;
            align-items: center;
            gap: 1.15rem;
            height: 100%;
        }
        .stat-icon-box {
            width: 54px;
            height: 54px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.5rem;
            flex-shrink: 0;
        }
        .stat-title {
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.2rem;
        }
        .stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
            margin-bottom: 0.2rem;
        }
        .stat-subtext {
            font-size: 0.78rem;
            color: #64748b;
            font-weight: 500;
        }
        .badge-trend {
            color: #16a34a;
            font-weight: 700;
        }

        /* Form Card */
        .card-panel {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 20, 60, 0.04);
            padding: 1.5rem 1.75rem;
        }
        .card-panel-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-bottom: 0.2rem;
        }
        .form-label-custom {
            font-size: 0.88rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 0.35rem;
        }
        .input-group-custom .input-group-text {
            background-color: #ffffff;
            border-right: none;
            border-color: #cbd5e1;
            color: #94a3b8;
            font-size: 1rem;
            border-radius: 10px 0 0 10px;
        }
        .input-group-custom .form-control {
            border-left: none;
            border-color: #cbd5e1;
            border-radius: 0 10px 10px 0;
            padding: 0.65rem 0.85rem;
            font-size: 0.92rem;
        }
        .input-group-custom .form-control:focus {
            box-shadow: none;
            border-color: #3b82f6;
        }

        /* Upload Dropzone */
        .upload-dropzone {
            border: 2px dashed #93c5fd;
            background-color: #f8fbff;
            border-radius: 14px;
            padding: 1.5rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            position: relative;
        }
        .upload-dropzone:hover, .upload-dropzone.dragover {
            background-color: #eff6ff;
            border-color: #3b82f6;
        }
        .upload-icon {
            font-size: 2.2rem;
            color: #2563eb;
            margin-bottom: 0.4rem;
        }
        .upload-title {
            font-weight: 700;
            font-size: 0.95rem;
            color: #1e3a8a;
            margin-bottom: 0.15rem;
        }
        .upload-link {
            color: #2563eb;
            font-size: 0.84rem;
            text-decoration: underline;
        }
        .upload-rules {
            font-size: 0.78rem;
            color: #64748b;
            margin-top: 0.5rem;
            margin-bottom: 0.6rem;
        }
        .file-status-pill {
            background: #e0eafc;
            color: #1e3a8a;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 0.35rem 0.85rem;
            border-radius: 8px;
            display: inline-block;
            max-width: 90%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .btn-register {
            background-color: var(--primary-blue);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.98rem;
            padding: 0.75rem;
            border-radius: 10px;
            border: none;
            box-shadow: 0 4px 14px rgba(11, 59, 181, 0.3);
            transition: all 0.2s ease;
        }
        .btn-register:hover {
            background-color: var(--primary-hover);
            color: #ffffff;
            box-shadow: 0 6px 18px rgba(11, 59, 181, 0.4);
        }

        .info-bottom-box {
            background-color: #eef5ff;
            border: 1px solid #bfdbfe;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            font-size: 0.82rem;
            margin-top: 1rem;
        }
        .info-bottom-box .info-icon {
            color: #2563eb;
            font-size: 1.15rem;
            margin-top: -1px;
        }

        /* Table */
        .table-custom {
            margin-bottom: 0;
            vertical-align: middle;
        }
        .table-custom thead th {
            font-size: 0.82rem;
            font-weight: 700;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.75rem 0.6rem;
            background-color: transparent;
        }
        .table-custom tbody td {
            font-size: 0.88rem;
            padding: 0.85rem 0.6rem;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }
        .avatar-initials {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 0.85rem;
            color: #ffffff;
            flex-shrink: 0;
        }
        .badge-filesize {
            background-color: #eff6ff;
            border: 1px solid #dbeafe;
            color: #1e40af;
            font-weight: 600;
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
        }
        .btn-action-dots {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #64748b;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s;
        }
        .btn-action-dots:hover {
            background: #f8fafc;
            color: #0f172a;
        }

        /* Avatar color variants matching screenshot */
        .bg-avatar-1 { background-color: #00227b; }
        .bg-avatar-2 { background-color: #2563eb; }
        .bg-avatar-3 { background-color: #16a34a; }
        .bg-avatar-4 { background-color: #ea580c; }
        .bg-avatar-5 { background-color: #0d9488; }
        .bg-avatar-6 { background-color: #dc2626; }
        .bg-avatar-7 { background-color: #4f46e5; }
        .bg-avatar-8 { background-color: #6b7280; }
    </style>
</head>
<body>

    <!-- TOPBAR -->
    <header class="app-topbar d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <div class="topbar-logo-box">
                <i class="bi bi-person-fill fs-4 text-white"></i>
            </div>
            <div>
                <h1 class="h5 fw-bold mb-0 text-white">Sistema de Registro</h1>
                <p class="small mb-0 text-white-50">Laravel 11/12 &bull; MySQL &bull; Puerto 8000</p>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="pill-status d-flex align-items-center gap-2">
                <i class="bi bi-circle-fill text-success" style="font-size: 8px;"></i>
                Servidor Online
            </span>
            <a href="/metricas" target="_blank" class="btn-metric-api d-flex align-items-center gap-2">
                <i class="bi bi-activity"></i>
                Ver Métricas API
            </a>
        </div>
    </header>

    <!-- WRAPPER -->
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- SIDEBAR -->
            <aside class="col-xl-2 col-lg-3 app-sidebar">
                <div>
                    <nav class="nav flex-column mb-3">
                        <a href="/registro" class="nav-link-custom active">
                            <i class="bi bi-house-door-fill"></i>
                            Dashboard
                        </a>
                        <a href="#nuevo-registro" class="nav-link-custom">
                            <i class="bi bi-person-plus"></i>
                            Nuevo Registro
                        </a>
                        <a href="/usuarios" class="nav-link-custom">
                            <i class="bi bi-people"></i>
                            Usuarios
                        </a>
                        <a href="/metricas" target="_blank" class="nav-link-custom">
                            <i class="bi bi-bar-chart-line"></i>
                            Métricas
                        </a>
                        <a href="/metricas#cors-info" target="_blank" class="nav-link-custom">
                            <i class="bi bi-shield-check"></i>
                            CORS
                        </a>
                        <a href="#" class="nav-link-custom">
                            <i class="bi bi-gear"></i>
                            Configuración
                        </a>
                    </nav>

                    <!-- Información del Sistema -->
                    <div class="sidebar-sys-info">
                        <div class="info-title">
                            <i class="bi bi-display"></i>
                            Información del Sistema
                        </div>
                        <div class="info-row">
                            <span>Versión</span>
                            <span class="info-val">1.0.0</span>
                        </div>
                        <div class="info-row">
                            <span>Entorno</span>
                            <span class="info-val">Producción</span>
                        </div>
                        <div class="info-row">
                            <span>Puerto</span>
                            <span class="info-val">8000</span>
                        </div>
                        <div class="info-row">
                            <span>Base de Datos</span>
                            <span class="info-val">MySQL</span>
                        </div>
                        <div class="info-row">
                            <span>Zona Horaria</span>
                            <span class="info-val">America/Lima</span>
                        </div>
                    </div>
                </div>

                <div class="pt-4 text-center text-white-50" style="font-size: 0.76rem;">
                    <div>&copy; 2026 Sistema de Registro</div>
                    <div>Desarrollado con Laravel ❤️</div>
                </div>
            </aside>

            <!-- MAIN CONTENT -->
            <main class="col-xl-10 col-lg-9 content-area">

                <!-- Alertas Flash -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm d-flex align-items-center justify-content-between mb-4" role="alert" style="background-color: #ecfdf5; border-left: 4px solid #10b981 !important; border-radius: 12px; color: #065f46;">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-check-circle-fill text-success fs-5"></i>
                            <div><strong>¡Éxito!</strong> {{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="background-color: #fef2f2; border-left: 4px solid #ef4444 !important; border-radius: 12px; color: #991b1b;">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                            <strong>Por favor corrija los siguientes errores:</strong>
                        </div>
                        <ul class="mb-0 ps-4 small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- 4 TARJETAS DE ESTADÍSTICAS -->
                <div class="row g-3 mb-4">
                    <!-- Total Registrados -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon-box" style="background-color: #041c6d;">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="stat-title">Total Registrados</div>
                                <div class="stat-value" id="cardTotalUsuarios">{{ $totalUsuarios }}</div>
                                <div class="stat-subtext">
                                    usuarios &nbsp;<span class="badge-trend">+12 hoy ↗</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RAM PHP en Uso -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon-box" style="background-color: #0b57d0;">
                                <i class="bi bi-hdd-stack-fill"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="stat-title">RAM PHP en Uso</div>
                                <div class="stat-value" id="cardRam">{{ $memMb }} MB</div>
                                <div class="stat-subtext mb-1">
                                    <span id="cardRamPct">{{ $memPct }}%</span> del límite
                                </div>
                                <div class="progress" style="height: 5px; border-radius: 10px;">
                                    <div class="progress-bar bg-primary" id="cardRamBar" role="progressbar" style="width: {{ $memPct }}%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Peticiones Hoy -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon-box" style="background-color: #5b21b6;">
                                <i class="bi bi-activity"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="stat-title">Peticiones Hoy</div>
                                <div class="stat-value" id="cardPeticiones">{{ number_format($peticionesHoy) }}</div>
                                <div class="stat-subtext">
                                    Solicitudes procesadas &nbsp;<span class="badge-trend">+8% vs ayer ↗</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CORS -->
                    <div class="col-xxl-3 col-md-6">
                        <div class="stat-card">
                            <div class="stat-icon-box" style="background-color: #ea580c;">
                                <i class="bi bi-shield-shaded"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="stat-title">CORS</div>
                                <div class="stat-value" style="color: #ea580c;">Habilitado</div>
                                <div class="stat-subtext">
                                    Configurado &bull; <span class="text-success fw-bold">Activo y seguro ✔</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CONTENEDOR FORMULARIO Y TABLA -->
                <div class="row g-4">
                    <!-- COLUMNA FORMULARIO: NUEVO REGISTRO -->
                    <div class="col-xl-5" id="nuevo-registro">
                        <div class="card-panel">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="stat-icon-box" style="background-color: #041c6d; width: 44px; height: 44px; border-radius: 10px; font-size: 1.2rem;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div>
                                    <div class="card-panel-title">Nuevo Registro</div>
                                    <div class="text-muted" style="font-size: 0.82rem;">Complete los datos para registrar un nuevo usuario</div>
                                </div>
                            </div>

                            <form action="/registro" method="POST" enctype="multipart/form-data" id="registroForm">
                                @csrf

                                <!-- DNI -->
                                <div class="mb-3">
                                    <label for="dni" class="form-label-custom">
                                        DNI <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-custom">
                                        <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                        <input type="text" 
                                               class="form-control @error('dni') is-invalid @enderror" 
                                               id="dni" 
                                               name="dni" 
                                               placeholder="Ingrese 8 dígitos numéricos" 
                                               maxlength="8" 
                                               pattern="[0-9]{8}" 
                                               required 
                                               value="{{ old('dni') }}">
                                    </div>
                                    <div class="text-muted mt-1" style="font-size: 0.78rem;">Debe contener exactamente 8 números.</div>
                                </div>

                                <!-- Nombres Completos -->
                                <div class="mb-3">
                                    <label for="nombres" class="form-label-custom">
                                        Nombres Completos <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group input-group-custom">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" 
                                               class="form-control @error('nombres') is-invalid @enderror" 
                                               id="nombres" 
                                               name="nombres" 
                                               placeholder="Ingrese nombres y apellidos completos" 
                                               maxlength="150" 
                                               required 
                                               value="{{ old('nombres') }}">
                                    </div>
                                </div>

                                <!-- Fotografía del Usuario -->
                                <div class="mb-3">
                                    <label class="form-label-custom d-flex justify-content-between align-items-center">
                                        <span>Fotografía del usuario <span class="text-danger">*</span></span>
                                        <span class="small fw-semibold text-muted" id="labelMaxWeight">Máximo: 1.00 MB</span>
                                    </label>

                                    <!-- Dropzone Clickable Area -->
                                    <div class="upload-dropzone" id="dropzoneBox">
                                        <input type="file" 
                                               name="imagen" 
                                               id="imagen" 
                                               accept=".jpg,.jpeg,.png" 
                                               class="d-none" 
                                               required>
                                        <div class="upload-icon" id="dropzoneIcon">
                                            <i class="bi bi-cloud-arrow-up"></i>
                                        </div>
                                        <div class="upload-title" id="dropzoneTitle">Arrastra tu imagen aquí</div>
                                        <div class="upload-link" id="dropzoneSub">o haz clic para seleccionar</div>
                                        <div class="upload-rules">
                                            Formatos permitidos: JPG, PNG<br>
                                            Tamaño máximo estricto: <strong>1 MB (1,048,576 bytes)</strong>
                                        </div>

                                        <!-- Píldora del Archivo y Peso -->
                                        <div class="file-status-pill border" id="fileStatusPill">
                                            Ningún archivo seleccionado
                                        </div>

                                        <!-- Medidor de Peso en Vivo (Rojo si > 1MB, Verde si <= 1MB) -->
                                        <div id="weightDisplay" class="mt-2 d-none">
                                            <span class="badge py-2 px-3 fw-bold fs-6 shadow-sm" id="weightBadge"></span>
                                        </div>
                                    </div>

                                    <!-- Alerta en ROJO si pesa más de 1 MB -->
                                    <div id="alertaReducir" class="alert alert-danger d-none mt-2 p-3 border-danger shadow-sm" role="alert" style="border-radius: 12px; background-color: #fef2f2; color: #991b1b;">
                                        <div class="d-flex align-items-start gap-2">
                                            <i class="bi bi-exclamation-triangle-fill fs-4 text-danger flex-shrink-0"></i>
                                            <div>
                                                <strong class="d-block mb-1 text-danger" style="font-size: 0.95rem;">
                                                    ⚠️ ALERTA: La fotografía supera el límite de 1 MB
                                                </strong>
                                                <div id="alertaReducirTexto" class="small mb-2">
                                                    El peso detectado excede el tamaño máximo permitido de 1,048,576 bytes.
                                                </div>
                                                <div class="small fw-bold text-danger bg-white p-2 rounded border border-danger-subtle">
                                                    💡 Por favor comprime, reduce la resolución o recorta la fotografía antes de continuar con el registro.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vista previa de la fotografía seleccionada -->
                                    <div id="previewArea" class="text-center mt-3 p-3 bg-white rounded-3 border d-none">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="small fw-bold text-muted">Vista previa de la fotografía:</span>
                                            <button type="button" class="btn btn-outline-danger btn-sm py-0 px-2 rounded-pill" id="btnQuitarFoto" title="Quitar foto">
                                                <i class="bi bi-trash3"></i> Quitar
                                            </button>
                                        </div>
                                        <div class="position-relative d-inline-block">
                                            <img id="previewImg" src="" alt="Vista previa" class="rounded-circle shadow object-fit-cover" width="100" height="100" style="border: 3px solid #2563eb;">
                                            <span id="previewBadge" class="position-absolute bottom-0 start-50 translate-middle-x badge bg-success shadow-sm" style="font-size: 0.72rem;">Válida</span>
                                        </div>
                                        <div class="mt-2 small fw-semibold text-dark" id="previewFileName"></div>
                                    </div>
                                </div>

                                <!-- Botón Submit -->
                                <button type="submit" class="btn btn-register w-100 mt-2 d-flex align-items-center justify-content-center gap-2" id="btnSubmit">
                                    <i class="bi bi-send-fill"></i>
                                    Registrar Usuario
                                </button>

                                <!-- Información importante -->
                                <div class="info-bottom-box">
                                    <i class="bi bi-info-circle-fill info-icon"></i>
                                    <div>
                                        <strong class="d-block text-primary" style="font-size: 0.85rem;">Información importante</strong>
                                        <span class="text-muted">Todos los campos marcados con * son obligatorios.</span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- COLUMNA TABLA: USUARIOS REGISTRADOS RECIENTEMENTE -->
                    <div class="col-xl-7" id="tabla-usuarios">
                        <div class="card-panel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-people fs-4 text-primary"></i>
                                    <h5 class="fw-bold mb-0 text-dark" style="font-size: 1.15rem;">Usuarios Registrados Recientemente</h5>
                                </div>
                                <a href="/usuarios" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1 fw-semibold d-flex align-items-center gap-1" style="font-size: 0.82rem;">
                                    <i class="bi bi-eye"></i> Ver todos
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-custom">
                                    <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>DNI</th>
                                            <th>Nombres</th>
                                            <th>Tamaño</th>
                                            <th>Fecha de Registro</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($usuarios as $index => $usr)
                                            @php
                                                // Extraer iniciales (ej. FRANK WILLIAM MENDOZA -> FM o U9 para Usuario_JMeter_948)
                                                if (str_starts_with($usr->nombres, 'Usuario_JMeter_')) {
                                                    $num = substr($usr->nombres, strlen('Usuario_JMeter_'), 1);
                                                    $iniciales = 'U' . $num;
                                                } else {
                                                    $partes = preg_split('/\s+/', trim($usr->nombres));
                                                    if (count($partes) >= 3) {
                                                        $iniciales = strtoupper(substr($partes[0], 0, 1) . substr($partes[2], 0, 1));
                                                    } elseif (count($partes) == 2) {
                                                        $iniciales = strtoupper(substr($partes[0], 0, 1) . substr($partes[1], 0, 1));
                                                    } else {
                                                        $iniciales = strtoupper(substr($usr->nombres, 0, 2));
                                                    }
                                                }
                                                // Colores según índice (avatar 1 es azul oscuro como en la imagen)
                                                $avatarColorClass = 'bg-avatar-' . (($index % 8) + 1);
                                                $sizeKb = round(($usr->imagen_size ?? 0) / 1024, 1);
                                                if ($sizeKb < 0.1) $sizeKb = 0.1;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($usr->imagen_path)
                                                            <div class="position-relative" style="width: 42px; height: 42px;">
                                                                <img src="/storage/{{ $usr->imagen_path }}" 
                                                                     alt="{{ $usr->nombres }}" 
                                                                     class="rounded-circle shadow-sm object-fit-cover border border-2 border-primary-subtle" 
                                                                     width="42" height="42"
                                                                     style="cursor: pointer; display: block;"
                                                                     title="Clic para ver foto de {{ $usr->nombres }}"
                                                                     onclick="verFotoModal('/storage/{{ $usr->imagen_path }}', '{{ addslashes($usr->nombres) }}', '{{ $usr->dni }}')"
                                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                                <div class="avatar-initials {{ $avatarColorClass }}" style="display: none; width: 42px; height: 42px;" title="{{ $usr->nombres }}">
                                                                    {{ $iniciales }}
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="avatar-initials {{ $avatarColorClass }}" title="{{ $usr->nombres }}">
                                                                {{ $iniciales }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-dark">{{ $usr->dni }}</td>
                                                <td class="fw-semibold text-secondary">{{ $usr->nombres }}</td>
                                                <td>
                                                    <span class="badge-filesize">{{ $sizeKb }} KB</span>
                                                </td>
                                                <td class="text-muted" style="font-size: 0.82rem;">
                                                    {{ $usr->created_at->format('H:i:s d/m/Y') }}
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn-action-dots" type="button" title="Ver foto" onclick="verFotoModal('/storage/{{ $usr->imagen_path }}', '{{ addslashes($usr->nombres) }}', '{{ $usr->dni }}')">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-5 text-muted">
                                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                                    No hay usuarios registrados aún.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Modal para Ver Foto del Usuario en Alta Resolución -->
    <div class="modal fade" id="modalVerFoto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                        <i class="bi bi-image text-primary"></i> Fotografía del Usuario
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <img id="modalFotoImg" src="" alt="Fotografía" class="img-fluid rounded-4 shadow-sm mb-3" style="max-height: 380px; object-fit: contain; border: 3px solid #2563eb;">
                    <h5 class="fw-bold text-dark mb-1" id="modalFotoNombre"></h5>
                    <p class="text-muted mb-0">DNI: <strong class="text-primary" id="modalFotoDni"></strong></p>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-4" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Elementos DOM
        const dropzoneBox = document.getElementById('dropzoneBox');
        const fileInput = document.getElementById('imagen');
        const fileStatusPill = document.getElementById('fileStatusPill');
        const dropzoneIcon = document.getElementById('dropzoneIcon');
        const dropzoneTitle = document.getElementById('dropzoneTitle');
        const dropzoneSub = document.getElementById('dropzoneSub');
        const weightDisplay = document.getElementById('weightDisplay');
        const weightBadge = document.getElementById('weightBadge');
        const alertaReducir = document.getElementById('alertaReducir');
        const alertaReducirTexto = document.getElementById('alertaReducirTexto');
        const previewArea = document.getElementById('previewArea');
        const previewImg = document.getElementById('previewImg');
        const previewBadge = document.getElementById('previewBadge');
        const previewFileName = document.getElementById('previewFileName');
        const btnQuitarFoto = document.getElementById('btnQuitarFoto');
        const btnSubmit = document.getElementById('btnSubmit');

        const MAX_BYTES = 1048576; // 1 MB estricto (1,048,576 bytes)

        // Clic en dropzone activa explorador de archivos
        dropzoneBox.addEventListener('click', (e) => {
            if (e.target !== fileInput) {
                fileInput.click();
            }
        });

        // Eventos Drag & Drop
        ['dragenter', 'dragover'].forEach(evtName => {
            dropzoneBox.addEventListener(evtName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzoneBox.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(evtName => {
            dropzoneBox.addEventListener(evtName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzoneBox.classList.remove('dragover');
            });
        });

        dropzoneBox.addEventListener('drop', (e) => {
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                fileInput.files = files;
                handleFileSelection(files[0]);
            }
        });

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                handleFileSelection(this.files[0]);
            }
        });

        // Procesamiento y Validación de Fotografía
        function handleFileSelection(file) {
            // 1. Validar Tipo MIME
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if (!validTypes.includes(file.type)) {
                mostrarErrorFormato('Formato no permitido. Solo se aceptan fotografías en formato JPG, JPEG o PNG.');
                return;
            }

            const sizeBytes = file.size;
            const sizeKb = (sizeBytes / 1024).toFixed(1);
            const sizeMb = (sizeBytes / 1024 / 1024).toFixed(2);

            // Leer vista previa en FileReader
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
            };
            reader.readAsDataURL(file);

            // 2. Comprobar si el archivo SUPERA 1 MB
            if (sizeBytes > MAX_BYTES) {
                // PESO SALE EN ROJO
                weightDisplay.classList.remove('d-none');
                weightBadge.className = 'badge py-2 px-3 fw-bold fs-6 shadow-sm bg-danger text-white border border-danger-subtle';
                weightBadge.innerHTML = '<i class="bi bi-exclamation-octagon-fill me-1"></i> Peso de la foto: ' + sizeMb + ' MB (Límite: 1.00 MB)';

                // ALERTA EN ROJO DE REDUCCIÓN
                alertaReducir.classList.remove('d-none');
                alertaReducirTexto.innerHTML = 'La imagen pesa <strong class="text-danger">' + sizeMb + ' MB (' + sizeBytes.toLocaleString() + ' bytes)</strong>, lo cual excede el límite máximo de <strong>1 MB (1,048,576 bytes)</strong>.';

                // Estilo Dropzone en ROJO
                dropzoneBox.style.borderColor = '#dc2626';
                dropzoneBox.style.backgroundColor = '#fef2f2';
                dropzoneIcon.innerHTML = '<i class="bi bi-exclamation-triangle-fill text-danger"></i>';
                dropzoneTitle.textContent = '¡Fotografía demasiado pesada!';
                dropzoneTitle.className = 'upload-title text-danger fw-bold';
                dropzoneSub.textContent = 'Haz clic para seleccionar otra fotografía reducida';

                // Píldora en rojo
                fileStatusPill.innerHTML = '<span class="text-danger fw-bold"><i class="bi bi-x-circle-fill me-1"></i> ' + file.name + ' (' + sizeMb + ' MB - EXCEDIDO)</span>';
                fileStatusPill.style.backgroundColor = '#fee2e2';
                fileStatusPill.style.borderColor = '#ef4444';

                // Vista previa con marco rojo y badge de rechazo
                previewArea.classList.remove('d-none');
                previewImg.style.border = '3px solid #dc2626';
                previewBadge.className = 'position-absolute bottom-0 start-50 translate-middle-x badge bg-danger shadow-sm';
                previewBadge.innerHTML = '<i class="bi bi-x-circle"></i> Rechazada (' + sizeMb + ' MB)';
                previewFileName.innerHTML = '<span class="text-danger fw-bold"><i class="bi bi-exclamation-circle me-1"></i> ' + file.name + '</span>';

                // BOTÓN BLOQUEADO
                btnSubmit.disabled = true;
                btnSubmit.className = 'btn btn-secondary w-100 mt-2 d-flex align-items-center justify-content-center gap-2 py-2 fw-semibold opacity-75';
                btnSubmit.innerHTML = '<i class="bi bi-slash-circle-fill me-1"></i> Registro Bloqueado (Foto > 1 MB)';
            } else {
                // PESO DENTRO DEL LÍMITE (<= 1MB)
                // PESO SALE EN VERDE
                weightDisplay.classList.remove('d-none');
                weightBadge.className = 'badge py-2 px-3 fw-bold fs-6 shadow-sm bg-success text-white border border-success-subtle';
                weightBadge.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Peso de la foto: ' + sizeKb + ' KB / 1.00 MB &bull; APROBADO';

                // Ocultar alerta de reducción
                alertaReducir.classList.add('d-none');

                // Estilo Dropzone en VERDE
                dropzoneBox.style.borderColor = '#16a34a';
                dropzoneBox.style.backgroundColor = '#f0fdf4';
                dropzoneIcon.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i>';
                dropzoneTitle.textContent = '¡Fotografía válida y lista!';
                dropzoneTitle.className = 'upload-title text-success fw-bold';
                dropzoneSub.textContent = 'Haz clic si deseas cambiar la foto';

                // Píldora en verde
                fileStatusPill.innerHTML = '<span class="text-success fw-bold"><i class="bi bi-check2-circle me-1"></i> ' + file.name + ' (' + sizeKb + ' KB)</span>';
                fileStatusPill.style.backgroundColor = '#dcfce7';
                fileStatusPill.style.borderColor = '#22c55e';

                // Vista previa con marco verde
                previewArea.classList.remove('d-none');
                previewImg.style.border = '3px solid #16a34a';
                previewBadge.className = 'position-absolute bottom-0 start-50 translate-middle-x badge bg-success shadow-sm';
                previewBadge.innerHTML = '<i class="bi bi-check2"></i> Aprobada (' + sizeKb + ' KB)';
                previewFileName.innerHTML = '<span class="text-success fw-bold"><i class="bi bi-file-earmark-image me-1"></i> ' + file.name + '</span>';

                // BOTÓN HABILITADO
                btnSubmit.disabled = false;
                btnSubmit.className = 'btn btn-register w-100 mt-2 d-flex align-items-center justify-content-center gap-2 py-2 fw-semibold';
                btnSubmit.innerHTML = '<i class="bi bi-send-fill me-1"></i> Registrar Usuario';
            }
        }

        function mostrarErrorFormato(msg) {
            fileInput.value = '';
            alertaReducir.classList.remove('d-none');
            alertaReducirTexto.innerHTML = '<strong class="text-danger">' + msg + '</strong>';
            weightDisplay.classList.add('d-none');
            previewArea.classList.add('d-none');
            btnSubmit.disabled = true;
            btnSubmit.className = 'btn btn-secondary w-100 mt-2 d-flex align-items-center justify-content-center gap-2 py-2 fw-semibold opacity-75';
            btnSubmit.innerHTML = '<i class="bi bi-slash-circle-fill me-1"></i> Formato de Foto Inválido';
        }

        // Quitar Foto
        btnQuitarFoto.addEventListener('click', function(e) {
            e.stopPropagation();
            fileInput.value = '';
            weightDisplay.classList.add('d-none');
            alertaReducir.classList.add('d-none');
            previewArea.classList.add('d-none');
            previewImg.src = '';

            dropzoneBox.style.borderColor = '#93c5fd';
            dropzoneBox.style.backgroundColor = '#f8fbff';
            dropzoneIcon.innerHTML = '<i class="bi bi-cloud-arrow-up"></i>';
            dropzoneTitle.textContent = 'Arrastra tu imagen aquí';
            dropzoneTitle.className = 'upload-title';
            dropzoneSub.textContent = 'o haz clic para seleccionar';

            fileStatusPill.textContent = 'Ningún archivo seleccionado';
            fileStatusPill.style.backgroundColor = '#e0eafc';
            fileStatusPill.style.borderColor = '#cbd5e1';

            btnSubmit.disabled = false;
            btnSubmit.className = 'btn btn-register w-100 mt-2 d-flex align-items-center justify-content-center gap-2 py-2 fw-semibold';
            btnSubmit.innerHTML = '<i class="bi bi-send-fill me-1"></i> Registrar Usuario';
        });

        // Abrir Modal de Foto Completa
        function verFotoModal(imgUrl, nombre, dni) {
            document.getElementById('modalFotoImg').src = imgUrl;
            document.getElementById('modalFotoNombre').textContent = nombre;
            document.getElementById('modalFotoDni').textContent = dni;
            const modalEl = document.getElementById('modalVerFoto');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }

        // Restricción numérica para DNI
        const dniInput = document.getElementById('dni');
        dniInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Actualización dinámica de métricas cada 5 segundos
        function syncMetrics() {
            fetch('/api/metricas')
                .then(r => r.json())
                .then(data => {
                    if (data.registered_users !== undefined) {
                        document.getElementById('cardTotalUsuarios').textContent = data.registered_users;
                    }
                    if (data.memory && data.memory.current_bytes) {
                        const mb = Math.round(data.memory.current_bytes / 1024 / 1024);
                        document.getElementById('cardRam').textContent = `${mb} MB`;
                        const pct = Math.min(Math.round((mb / 64) * 100), 100);
                        document.getElementById('cardRamPct').textContent = `${pct}%`;
                        document.getElementById('cardRamBar').style.width = `${pct}%`;
                    }
                })
                .catch(() => {});
        }
        setInterval(syncMetrics, 5000);
    </script>
</body>
</html>
