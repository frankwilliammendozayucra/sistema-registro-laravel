$jmeterBat = "E:\computacion\proyecto\tools\jmeter\bin\jmeter.bat"
$jmxFile = "E:\computacion\proyecto\jmeter_tests\plan_estres_registro.jmx"
$outputBase = "E:\computacion\proyecto\jmeter_tests\reports"

$scenarios = @(
    @{ Name = "1_Normal"; Threads = 10; RampUp = 2 },
    @{ Name = "2_Carga_Media"; Threads = 50; RampUp = 5 },
    @{ Name = "3_Carga_Alta"; Threads = 100; RampUp = 10 },
    @{ Name = "4_Estres"; Threads = 200; RampUp = 15 }
)

$summaryList = @()

foreach ($sc in $scenarios) {
    $scName = $sc.Name
    $threads = $sc.Threads
    $ramp = $sc.RampUp
    $jtlFile = "$outputBase\results_$scName.jtl"
    $htmlReport = "$outputBase\html_$scName"

    if (Test-Path $jtlFile) { Remove-Item -Force $jtlFile }
    if (Test-Path $htmlReport) { Remove-Item -Recurse -Force $htmlReport }

    Write-Host ""
    Write-Host "==========================================================" -ForegroundColor Cyan
    Write-Host "Iniciando Escenario: $scName" -ForegroundColor Yellow
    Write-Host "Hilos concurrentes: $threads | Rampa: $ramp seg | Host: 127.0.0.1:8000" -ForegroundColor Gray
    Write-Host "==========================================================" -ForegroundColor Cyan

    $cmd = "cmd.exe /c `"`"$jmeterBat`" -n -t `"$jmxFile`" -l `"$jtlFile`" -Jthreads=$threads -Jrampup=$ramp -Jloops=1 -Jhost=127.0.0.1 -Jport=8000"
    if ($scName -eq "4_Estres") {
        $cmd += " -e -o `"$htmlReport`""
    }
    $cmd += "`""

    $startTime = Get-Date
    Invoke-Expression $cmd
    $duration = ((Get-Date) - $startTime).TotalSeconds

    if (Test-Path $jtlFile) {
        $rows = Import-Csv -Path $jtlFile
        $totalReqs = $rows.Count
        $elapsed = $rows | ForEach-Object { [int]$_.elapsed }
        $successCount = ($rows | Where-Object { $_.success -eq "true" }).Count
        $errorCount = ($rows | Where-Object { $_.success -eq "false" }).Count
        
        $avgLat = [math]::Round(($elapsed | Measure-Object -Average).Average, 2)
        $minLat = ($elapsed | Measure-Object -Minimum).Minimum
        $maxLat = ($elapsed | Measure-Object -Maximum).Maximum
        $errorRate = [math]::Round(($errorCount / [math]::Max($totalReqs, 1)) * 100, 2)
        $tps = [math]::Round($totalReqs / [math]::Max($duration, 0.1), 2)

        $summaryList += [PSCustomObject]@{
            "Escenario"          = $scName
            "Usuarios"           = $threads
            "Total Solicitudes"  = $totalReqs
            "Exitosas"           = $successCount
            "Errores"            = $errorCount
            "Tasa Error (%)"     = "$errorRate %"
            "Latencia Prom (ms)" = $avgLat
            "Latencia Min (ms)"  = $minLat
            "Latencia Max (ms)"  = $maxLat
            "Throughput (req/s)" = $tps
            "Duración Total (s)" = [math]::Round($duration, 2)
        }
    }
}

Write-Host ""
Write-Host "==========================================================" -ForegroundColor Green
Write-Host "           RESUMEN COMPARATIVO DE RENDIMIENTO            " -ForegroundColor Green
Write-Host "==========================================================" -ForegroundColor Green
$summaryList | Format-Table -AutoSize
$summaryList | Export-Csv -Path "$outputBase\resumen_consolidado.csv" -NoTypeInformation -Encoding UTF8
Write-Host "Resultados exportados a: $outputBase\resumen_consolidado.csv" -ForegroundColor Green
