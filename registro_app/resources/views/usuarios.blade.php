<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos los Usuarios Registrados - Sistema de Registro</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
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
            --primary-blue: #0b3bb5;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-body);
            color: #0f172a;
            min-height: 100vh;
        }

        .app-topbar {
            background-color: var(--topbar-bg);
            padding: 0.9rem 2rem;
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
        .btn-back {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.25);
            font-size: 0.85rem;
            font-weight: 600;
            padding: 0.45rem 1rem;
            border-radius: 50rem;
            transition: all 0.2s;
            text-decoration: none;
        }
        .btn-back:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
        }

        .panel-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 20, 60, 0.04);
            padding: 1.5rem 1.75rem;
        }

        .table-custom {
            margin-bottom: 0;
            vertical-align: middle;
        }
        .table-custom thead th {
            font-size: 0.82rem;
            font-weight: 700;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.85rem 0.75rem;
            background-color: #f8fafc;
        }
        .table-custom tbody td {
            font-size: 0.9rem;
            padding: 0.85rem 0.75rem;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }

        .avatar-initials {
            width: 40px;
            height: 40px;
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
            font-size: 0.78rem;
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
        }

        .btn-action-dots {
            width: 34px;
            height: 34px;
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
<body class="pb-5">

    <!-- TOPBAR -->
    <header class="app-topbar d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="topbar-logo-box">
                <i class="bi bi-people-fill fs-4 text-white"></i>
            </div>
            <div>
                <h1 class="h5 fw-bold mb-0 text-white">Directorio Completo de Usuarios</h1>
                <p class="small mb-0 text-white-50">Total en Base de Datos: <strong>{{ number_format($totalUsuarios) }}</strong> usuarios</p>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="/metricas" class="btn btn-outline-light btn-sm rounded-pill px-3 py-1 fw-semibold d-flex align-items-center gap-1">
                <i class="bi bi-activity"></i> Panel Métricas
            </a>
            <a href="/registro" class="btn-back d-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i> Volver al Registro
            </a>
        </div>
    </header>

    <div class="container-fluid px-lg-5 px-3 py-4">

        <div class="panel-box">
            <!-- Barra de Búsqueda y Filtros -->
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-3 border-bottom">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">
                        <i class="bi bi-person-lines-fill text-primary me-2"></i> Todos los Usuarios Registrados
                    </h4>
                    <span class="text-muted small">Visualiza todas las fotografías, documentos de identidad y fechas registradas en MySQL</span>
                </div>

                <form action="/usuarios" method="GET" class="d-flex align-items-center gap-2" style="max-width: 420px; width: 100%;">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" 
                               name="q" 
                               class="form-control border-start-0" 
                               placeholder="Buscar por DNI o Nombres..." 
                               value="{{ $q }}">
                    </div>
                    <button type="submit" class="btn btn-primary px-3 fw-semibold">Buscar</button>
                    @if($q !== '')
                        <a href="/usuarios" class="btn btn-outline-secondary" title="Limpiar filtro"><i class="bi bi-x-lg"></i></a>
                    @endif
                </form>
            </div>

            <!-- Tabla de Usuarios -->
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th style="width: 70px;">Foto</th>
                            <th style="width: 130px;">DNI</th>
                            <th>Nombres Completos</th>
                            <th style="width: 120px;">Tamaño</th>
                            <th style="width: 200px;">Fecha de Registro</th>
                            <th style="width: 100px;" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $index => $usr)
                            @php
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
                                $avatarColorClass = 'bg-avatar-' . (($index % 8) + 1);
                                $sizeKb = round(($usr->imagen_size ?? 0) / 1024, 1);
                                if ($sizeKb < 0.1) $sizeKb = 0.1;
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($usr->imagen_path)
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
                                <td class="text-muted small">
                                    {{ $usr->created_at->format('H:i:s d/m/Y') }}
                                </td>
                                <td class="text-center">
                                    <button class="btn-action-dots" type="button" title="Ver foto completa" onclick="verFotoModal('/storage/{{ $usr->imagen_path }}', '{{ addslashes($usr->nombres) }}', '{{ $usr->dni }}')">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No se encontraron usuarios con el criterio de búsqueda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 pt-3 border-top gap-3">
                <span class="text-muted small">
                    Mostrando <strong>{{ $usuarios->firstItem() ?? 0 }}</strong> a <strong>{{ $usuarios->lastItem() ?? 0 }}</strong> de <strong>{{ $usuarios->total() }}</strong> usuarios
                </span>
                <div>
                    {{ $usuarios->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>

    </div>

    <!-- Modal para Ver Foto del Usuario -->
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
        function verFotoModal(imgUrl, nombre, dni) {
            document.getElementById('modalFotoImg').src = imgUrl;
            document.getElementById('modalFotoNombre').textContent = nombre;
            document.getElementById('modalFotoDni').textContent = dni;
            const modalEl = document.getElementById('modalVerFoto');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
    </script>
</body>
</html>
