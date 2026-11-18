<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor de Métricas del Servidor - Laravel & JMeter</title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --bg-body: #eef2f7;
            --topbar-bg: #001254;
            --card-border: #e2e8f0;
            --primary-blue: #0b3bb5;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-body);
            color: #0f172a;
            min-height: 100vh;
        }

        /* Topbar Header */
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

        .metric-card {
            background: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 1.35rem;
            box-shadow: 0 2px 8px rgba(0, 20, 60, 0.04);
            height: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .metric-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 20, 60, 0.06);
        }

        .metric-icon-box {
            width: 52px;
            height: 52px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .card-stat-label {
            font-size: 0.82rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.25rem;
        }
        .card-stat-value {
            font-size: 1.85rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
            margin-bottom: 0.35rem;
        }

        .panel-box {
            background: #ffffff;
            border: 1px solid var(--card-border);
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 20, 60, 0.04);
            padding: 1.5rem 1.75rem;
        }

        .code-box {
            font-family: 'JetBrains Mono', monospace;
            background-color: #0f172a;
            color: #38bdf8;
            border-radius: 12px;
            padding: 1.25rem;
            font-size: 0.82rem;
            max-height: 320px;
            overflow-y: auto;
        }

        .pulse-live {
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #10b981;
            box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-animation 1.5s infinite;
        }
        @keyframes pulse-animation {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 8px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }
    </style>
</head>
<body class="pb-5">

    <!-- TOPBAR -->
    <header class="app-topbar d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <div class="topbar-logo-box">
                <i class="bi bi-activity fs-4 text-white"></i>
            </div>
            <div>
                <h1 class="h5 fw-bold mb-0 text-white">Panel de Métricas y Monitoreo del Servidor</h1>
                <p class="small mb-0 text-white-50">Laravel 11/12 &bull; MySQL &bull; Puerto 8000 &bull; Apache JMeter</p>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill d-flex align-items-center gap-2" style="font-size: 0.82rem;">
                <span class="pulse-live"></span>
                <span>Monitoreo en Vivo (<span id="countdown">3s</span>)</span>
            </span>
            <a href="/api/metricas?format=json" target="_blank" class="btn btn-outline-light btn-sm rounded-pill px-3 py-1 fw-semibold d-flex align-items-center gap-1" style="font-size: 0.82rem;">
                <i class="bi bi-code-slash"></i> JSON Crudo
            </a>
            <a href="/registro" class="btn-back d-flex align-items-center gap-2">
                <i class="bi bi-arrow-left"></i> Volver al Registro
            </a>
        </div>
    </header>

    <div class="container-fluid px-lg-5 px-3 py-4">

        <!-- FILA DE TARJETAS PRINCIPALES DE SALUD DEL SISTEMA -->
        <div class="row g-3 mb-4">
            <!-- 1. Memoria RAM PHP -->
            <div class="col-xl-3 col-md-6">
                <div class="metric-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="metric-icon-box" style="background-color: #0b57d0;">
                            <i class="bi bi-memory"></i>
                        </div>
                        <div>
                            <div class="card-stat-label">Memoria RAM PHP</div>
                            <div class="card-stat-value" id="valMem">{{ $memMb }} MB</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between small text-muted mb-1">
                        <span>Pico registrado: <strong id="valMemPeak">{{ $memPeakMb }} MB</strong></span>
                        <span class="fw-bold text-primary" id="valMemPct">{{ $memPct }}%</span>
                    </div>
                    <div class="progress" style="height: 7px; border-radius: 10px;">
                        <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" id="barMem" role="progressbar" style="width: {{ $memPct }}%;"></div>
                    </div>
                </div>
            </div>

            <!-- 2. Base de Datos MySQL -->
            <div class="col-xl-3 col-md-6">
                <div class="metric-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="metric-icon-box" style="background-color: #041c6d;">
                            <i class="bi bi-database-check"></i>
                        </div>
                        <div>
                            <div class="card-stat-label">Base de Datos</div>
                            <div class="card-stat-value" id="valUsuarios">{{ $totalUsuarios }}</div>
                        </div>
                    </div>
                    <div class="small text-muted mb-1">
                        Usuarios guardados en MySQL &bull; <span class="badge bg-success-subtle text-success border border-success-subtle">Online</span>
                    </div>
                    <div class="small fw-semibold text-secondary text-truncate" title="{{ $dbVersion }}">
                        Motor: {{ $dbVersion }} (Puerto 3306)
                    </div>
                </div>
            </div>

            <!-- 3. CORS & Seguridad -->
            <div class="col-xl-3 col-md-6">
                <div class="metric-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="metric-icon-box" style="background-color: #ea580c;">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <div>
                            <div class="card-stat-label">Seguridad CORS</div>
                            <div class="card-stat-value" style="color: #ea580c;">Habilitado</div>
                        </div>
                    </div>
                    <div class="small text-muted mb-1">
                        Orígenes: <code class="text-primary fw-bold">*</code> &bull; Preflight: <span class="text-success fw-bold">204 OK</span>
                    </div>
                    <div class="small text-muted">
                        Métodos: <code>GET, POST, OPTIONS</code>
                    </div>
                </div>
            </div>

            <!-- 4. Servidor Web & Entorno -->
            <div class="col-xl-3 col-md-6">
                <div class="metric-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="metric-icon-box" style="background-color: #059669;">
                            <i class="bi bi-hdd-network-fill"></i>
                        </div>
                        <div>
                            <div class="card-stat-label">Puerto Web</div>
                            <div class="card-stat-value text-success">8000</div>
                        </div>
                    </div>
                    <div class="small text-muted mb-1">
                        PHP <strong>{{ PHP_VERSION }}</strong> &bull; Laravel <strong>{{ app()->version() }}</strong>
                    </div>
                    <div class="small text-muted">
                        Host vinculado: <code class="text-dark">0.0.0.0:8000</code> (Local & Red)
                    </div>
                </div>
            </div>
        </div>

        <!-- PANEL INTERACTIVO: EJECUTAR / REINICIAR PRUEBA DE ESTRÉS EN TIEMPO REAL -->
        <div class="panel-box mb-4 shadow" style="background: linear-gradient(135deg, #001254 0%, #0d288d 100%); color: #ffffff; border: none;">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h5 class="fw-bold mb-1 d-flex align-items-center gap-2 text-white">
                        <i class="bi bi-lightning-charge-fill text-warning fs-4"></i> Simulador y Prueba de Estrés en Tiempo Real
                    </h5>
                    <p class="mb-0 text-white-50 small">Ejecuta o reinicia peticiones concurrentes para ver en vivo la latencia, el uso de RAM y el comportamiento del servidor.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <select class="form-select form-select-sm shadow-sm" id="stressUserCount" style="width: auto; font-weight: 700; background-color: #ffffff; color: #0f172a; border-radius: 20px; padding: 0.45rem 1rem;">
                        <option value="10">10 Peticiones Concurrentes (Rápido)</option>
                        <option value="50" selected>50 Peticiones Concurrentes (Carga Media)</option>
                        <option value="100">100 Peticiones Concurrentes (Carga Alta)</option>
                        <option value="200">200 Peticiones Concurrentes (Estrés Máximo)</option>
                    </select>

                    <button class="btn btn-warning btn-sm fw-bold px-3 py-2 rounded-pill shadow d-flex align-items-center gap-2" id="btnRunLiveStress">
                        <i class="bi bi-play-circle-fill"></i> Iniciar Prueba de Estrés
                    </button>

                    <button class="btn btn-outline-light btn-sm fw-semibold px-3 py-2 rounded-pill d-flex align-items-center gap-2" id="btnResetStress" title="Reiniciar gráfica y métricas de estrés">
                        <i class="bi bi-arrow-counterclockwise"></i> Reiniciar
                    </button>
                </div>
            </div>

            <!-- Barra de Progreso y Telemetría en Vivo -->
            <div id="stressProgressContainer" class="mt-3 p-3 rounded-3 d-none" style="background: rgba(0,0,0,0.25);">
                <div class="d-flex flex-wrap justify-content-between align-items-center small mb-2 gap-2">
                    <span class="text-white-50">
                        Progreso: <strong class="text-white fs-6" id="stressCounter">0 / 50</strong>
                    </span>
                    <span class="text-white-50">
                        Latencia instantánea: <strong class="text-warning fs-6" id="stressCurrentLatency">0 ms</strong>
                    </span>
                    <span class="text-white-50">
                        Latencia promedio: <strong class="text-info fs-6" id="stressAvgLatency">0 ms</strong>
                    </span>
                    <span class="text-white-50">
                        Throughput estimado: <strong class="text-success fs-6" id="stressCurrentTps">0 req/s</strong>
                    </span>
                </div>
                <div class="progress" style="height: 12px; border-radius: 10px; background-color: rgba(255,255,255,0.2);">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" id="stressProgressBar" role="progressbar" style="width: 0%;"></div>
                </div>
                <div class="d-flex justify-content-between small text-white-50 mt-1">
                    <span id="stressStatusMessage">Enviando peticiones concurrentes al servidor...</span>
                    <span class="text-success fw-bold" id="stressErrorRate">0% Errores</span>
                </div>
            </div>
        </div>

        <!-- SECCIÓN DE PRUEBAS DE ESTRÉS APACHE JMETER -->
        <div class="row g-4 mb-4">
            <!-- Gráfico de Latencia -->
            <div class="col-lg-7">
                <div class="panel-box h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">
                                <i class="bi bi-bar-chart-fill text-primary me-2"></i> Latencia Media vs Concurrencia (Apache JMeter)
                            </h5>
                            <span class="text-muted small">Tiempos de respuesta evaluados bajo diferentes cargas (10, 50, 100 y 200 usuarios)</span>
                        </div>
                        <span class="badge bg-primary px-3 py-2 rounded-pill">0.00% Errores</span>
                    </div>

                    <div style="position: relative; height: 310px;">
                        <canvas id="jmeterChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Tabla de Resultados JMeter -->
            <div class="col-lg-5">
                <div class="panel-box h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-speedometer2 text-danger me-2"></i> Resumen de Estrés
                        </h5>
                        <a href="/jmeter_tests/reports/html_4_Estres/index.html" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3 py-0">
                            Reporte HTML Completo
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="font-size: 0.86rem;">
                            <thead class="table-light">
                                <tr>
                                    <th>Escenario</th>
                                    <th>Usuarios</th>
                                    <th>Latencia Prom.</th>
                                    <th>Throughput</th>
                                    <th>Errores</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jmeterResults as $jm)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $jm['escenario'] }}</td>
                                        <td><span class="badge bg-secondary-subtle text-dark border">{{ $jm['usuarios'] }} hilos</span></td>
                                        <td class="fw-bold text-primary">{{ round($jm['latencia_prom']) }} ms</td>
                                        <td>{{ $jm['throughput'] }} req/s</td>
                                        <td><span class="badge bg-success-subtle text-success border border-success-subtle">0%</span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-info mt-3 py-2 px-3 mb-0 small d-flex align-items-center gap-2 border-0" style="background-color: #eff6ff; color: #1e40af; border-radius: 10px;">
                        <i class="bi bi-info-circle-fill fs-5"></i>
                        <div>
                            Total de <strong>1,080 solicitudes</strong> procesadas con <strong>cero errores HTTP</strong> y persistencia íntegra en MySQL.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- INSPECTOR DE JSON EN TIEMPO REAL -->
        <div class="panel-box">
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-braces fs-4 text-primary"></i>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">Inspector de API JSON en Tiempo Real</h5>
                        <span class="text-muted small">Estructura devuelta por el endpoint <code>/api/metricas</code></span>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 d-flex align-items-center gap-1" id="btnCopiarJson">
                        <i class="bi bi-clipboard"></i> Copiar JSON
                    </button>
                    <button class="btn btn-primary btn-sm rounded-pill px-3 d-flex align-items-center gap-1" id="btnRefrescarManual">
                        <i class="bi bi-arrow-clockwise"></i> Refrescar Ahora
                    </button>
                </div>
            </div>

            <pre class="code-box mb-0" id="jsonViewer"><code>{{ json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</code></pre>
        </div>

    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Inicializar Gráfico con Chart.js
        const ctx = document.getElementById('jmeterChart').getContext('2d');
        const jmeterChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['10 Usuarios', '50 Usuarios', '100 Usuarios', '200 Usuarios (Estrés)'],
                datasets: [{
                    label: 'Latencia Media (ms)',
                    data: [787, 4814, 10390, 23724],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.75)',
                        'rgba(59, 130, 246, 0.75)',
                        'rgba(245, 158, 11, 0.75)',
                        'rgba(239, 68, 68, 0.85)'
                    ],
                    borderColor: [
                        '#10b981',
                        '#3b82f6',
                        '#f59e0b',
                        '#ef4444'
                    ],
                    borderWidth: 2,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ` Latencia: ${context.parsed.y} ms`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Milisegundos (ms)', color: '#64748b', font: { weight: 'bold' } },
                        grid: { color: 'rgba(0, 0, 0, 0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // Lógica de Ejecución y Reinicio de Prueba de Estrés en Tiempo Real
        const btnRunLiveStress = document.getElementById('btnRunLiveStress');
        const btnResetStress = document.getElementById('btnResetStress');
        const stressUserCount = document.getElementById('stressUserCount');
        const stressProgressContainer = document.getElementById('stressProgressContainer');
        const stressProgressBar = document.getElementById('stressProgressBar');
        const stressCounter = document.getElementById('stressCounter');
        const stressCurrentLatency = document.getElementById('stressCurrentLatency');
        const stressAvgLatency = document.getElementById('stressAvgLatency');
        const stressCurrentTps = document.getElementById('stressCurrentTps');
        const stressStatusMessage = document.getElementById('stressStatusMessage');
        const stressErrorRate = document.getElementById('stressErrorRate');

        let isRunningStress = false;

        btnRunLiveStress.addEventListener('click', async function() {
            if (isRunningStress) return;
            isRunningStress = true;

            const totalReqs = parseInt(stressUserCount.value, 10);
            stressProgressContainer.classList.remove('d-none');
            stressProgressBar.style.width = '0%';
            stressProgressBar.className = 'progress-bar progress-bar-striped progress-bar-animated bg-warning';
            stressCounter.textContent = `0 / ${totalReqs}`;
            stressCurrentLatency.textContent = '0 ms';
            stressAvgLatency.textContent = '0 ms';
            stressCurrentTps.textContent = '0 req/s';
            stressStatusMessage.textContent = `Enviando ${totalReqs} peticiones concurrentes a Laravel...`;
            stressErrorRate.textContent = '0% Errores';

            btnRunLiveStress.disabled = true;
            btnRunLiveStress.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Ejecutando Estrés...';

            const latencies = [];
            let completed = 0;
            let errors = 0;
            const startTime = performance.now();

            // Función individual de petición de estrés
            async function sendPing(iteration) {
                const reqStart = performance.now();
                try {
                    const res = await fetch(`/api/stress-ping?iteration=${iteration}&_t=${Date.now()}`, { cache: 'no-store' });
                    const reqElapsed = Math.round(performance.now() - reqStart);
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    latencies.push(reqElapsed);
                } catch (e) {
                    errors++;
                    latencies.push(Math.round(performance.now() - reqStart));
                }

                completed++;
                const progressPct = Math.round((completed / totalReqs) * 100);
                stressProgressBar.style.width = `${progressPct}%`;
                stressCounter.textContent = `${completed} / ${totalReqs}`;

                const lastLat = latencies[latencies.length - 1];
                stressCurrentLatency.textContent = `${lastLat} ms`;

                const sumLat = latencies.reduce((a, b) => a + b, 0);
                const avgLat = Math.round(sumLat / latencies.length);
                stressAvgLatency.textContent = `${avgLat} ms`;

                const totalElapsedSec = Math.max((performance.now() - startTime) / 1000, 0.05);
                const tps = (completed / totalElapsedSec).toFixed(1);
                stressCurrentTps.textContent = `${tps} req/s`;

                if (errors > 0) {
                    stressErrorRate.textContent = `${((errors / completed) * 100).toFixed(1)}% Errores`;
                    stressErrorRate.className = 'text-danger fw-bold';
                }
            }

            // Enviar en grupos concurrentes de 5 para simular carga simultánea realista
            const batchSize = 5;
            for (let i = 0; i < totalReqs; i += batchSize) {
                const batch = [];
                for (let j = 0; j < batchSize && (i + j) < totalReqs; j++) {
                    batch.push(sendPing(i + j + 1));
                }
                await Promise.all(batch);
            }

            // Finalización de la prueba
            const totalDurationSec = ((performance.now() - startTime) / 1000).toFixed(2);
            const finalAvgLat = Math.round(latencies.reduce((a, b) => a + b, 0) / latencies.length);
            const finalTps = (totalReqs / totalDurationSec).toFixed(1);

            stressProgressBar.className = 'progress-bar bg-success';
            stressStatusMessage.textContent = `¡Prueba completada en ${totalDurationSec}s! Promedio: ${finalAvgLat} ms | Throughput: ${finalTps} req/s`;
            btnRunLiveStress.disabled = false;
            btnRunLiveStress.innerHTML = '<i class="bi bi-play-circle-fill"></i> Iniciar Prueba de Estrés';
            isRunningStress = false;

            // Actualizar la barra correspondiente en la gráfica de Chart.js
            let chartIndex = 0;
            if (totalReqs === 50) chartIndex = 1;
            else if (totalReqs === 100) chartIndex = 2;
            else if (totalReqs === 200) chartIndex = 3;

            jmeterChart.data.datasets[0].data[chartIndex] = finalAvgLat;
            jmeterChart.update();

            // Refrescar métricas del servidor inmediatamente para ver el pico de RAM
            actualizarMetricas();
        });

        // Botón Reiniciar
        btnResetStress.addEventListener('click', function() {
            // Restaurar datos originales de la prueba de JMeter
            jmeterChart.data.datasets[0].data = [787, 4814, 10390, 23724];
            jmeterChart.update();

            stressProgressContainer.classList.add('d-none');
            stressProgressBar.style.width = '0%';
            stressCounter.textContent = '0 / 0';
            stressCurrentLatency.textContent = '0 ms';
            stressAvgLatency.textContent = '0 ms';
            stressCurrentTps.textContent = '0 req/s';

            actualizarMetricas();

            const origHtml = this.innerHTML;
            this.innerHTML = '<i class="bi bi-check2 text-success"></i> ¡Reiniciado!';
            setTimeout(() => this.innerHTML = origHtml, 1500);
        });

        // Copiar JSON al portapapeles
        document.getElementById('btnCopiarJson').addEventListener('click', function() {
            const code = document.getElementById('jsonViewer').innerText;
            navigator.clipboard.writeText(code).then(() => {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check2 text-success"></i> ¡Copiado!';
                setTimeout(() => this.innerHTML = originalText, 2000);
            });
        });

        // Actualización en Tiempo Real cada 3 segundos
        let timeLeft = 3;
        const countdownEl = document.getElementById('countdown');

        function actualizarMetricas() {
            fetch('/api/metricas?format=json')
                .then(r => r.json())
                .then(data => {
                    if (data.memory) {
                        document.getElementById('valMem').textContent = data.memory.current_formatted;
                        document.getElementById('valMemPeak').textContent = data.memory.peak_formatted;
                        document.getElementById('valMemPct').textContent = data.memory.percentage;
                        document.getElementById('barMem').style.width = data.memory.percentage;
                    }
                    if (data.database) {
                        document.getElementById('valUsuarios').textContent = data.database.total_users;
                    }
                    document.getElementById('jsonViewer').innerHTML = '<code>' + JSON.stringify(data, null, 4) + '</code>';
                })
                .catch(() => {});
        }

        document.getElementById('btnRefrescarManual').addEventListener('click', () => {
            actualizarMetricas();
            timeLeft = 3;
        });

        setInterval(() => {
            timeLeft--;
            if (timeLeft <= 0) {
                actualizarMetricas();
                timeLeft = 3;
            }
            countdownEl.textContent = `${timeLeft}s`;
        }, 1000);
    </script>
</body>
</html>
