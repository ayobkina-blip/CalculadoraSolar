<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Presupuesto Fotovoltaico #{{ $resultado->id_resultado }}</title>
    <style>
        @page { margin: 40px; }
        body { 
            font-family: 'Helvetica', Arial, sans-serif; 
            color: #1e293b; 
            margin: 0; 
            line-height: 1.5;
        }
        
        /* Encabezado Elegante */
        .header { 
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .brand { font-size: 24px; font-weight: 800; letter-spacing: -1px; color: #0f172a; }
        .brand span { color: #eab308; }
        .meta-table { width: 100%; font-size: 11px; color: #64748b; }

        /* Títulos de Sección */
        .section-title { 
            font-size: 11px; 
            font-weight: 800; 
            color: #475569; 
            text-transform: uppercase; 
            letter-spacing: 1px;
            margin-bottom: 12px;
            margin-top: 30px;
        }

        /* Tabla de Datos Técnica */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table td { 
            padding: 15px; 
            border: 1px solid #f1f5f9;
            vertical-align: top;
        }
        .label { 
            display: block;
            font-size: 9px; 
            text-transform: uppercase; 
            color: #94a3b8; 
            font-weight: bold;
            margin-bottom: 4px;
        }
        .value { font-size: 14px; font-weight: bold; color: #1e293b; }

        /* Bloque de ROI y Ahorro (Limpio) */
        .summary-grid { width: 100%; margin-top: 10px; }
        .summary-card { 
            border: 1px solid #e2e8f0; 
            padding: 20px; 
            border-radius: 8px;
            text-align: center;
        }
        .highlight-green { color: #16a34a; font-size: 22px; font-weight: 800; }
        .highlight-dark { color: #0f172a; font-size: 22px; font-weight: 800; }

        /* Nota Ecológica */
        .eco-badge {
            margin-top: 40px;
            padding: 15px;
            background-color: #f8fafc;
            border-left: 4px solid #10b981;
            font-size: 11px;
            color: #334155;
        }

        .footer { 
            position: absolute; 
            bottom: 0; 
            width: 100%; 
            font-size: 9px; 
            color: #94a3b8; 
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <table width="100%">
            <tr>
                <td>
                    <div class="brand">SOLAR<span>CALC</span></div>
                    <div style="font-size: 11px; color: #64748b;">Informe Técnico de Rendimiento Energético</div>
                </td>
                <td align="right" style="text-align: right;">
                    <table class="meta-table">
                        <tr><td align="right">REFERENCIA: <strong>#{{ $resultado->id_resultado }}</strong></td></tr>
                        <tr><td align="right">FECHA DE EMISIÓN: <strong>{{ $fecha }}</strong></td></tr>
                        <tr><td align="right">UBICACIÓN: {{ $resultado->ubicacion }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Especificaciones Técnicas</div>
    <table class="data-table">
        <tr>
            <td width="33%">
                <span class="label">Potencia Nominal</span>
                <span class="value">{{ number_format($resultado->potencia_instalacion_kwp, 2, ',', '.') }} kWp</span>
            </td>
            <td width="33%">
                <span class="label">Configuración</span>
                <span class="value">{{ $resultado->paneles_sugeridos }} Módulos 450Wp</span>
            </td>
            <td width="33%">
                <span class="label">Generación Anual</span>
                <span class="value">{{ number_format($resultado->produccion_anual_kwh, 0, ',', '.') }} kWh</span>
            </td>
        </tr>
    </table>

    <div class="section-title">Análisis de Viabilidad Económica</div>
    <table class="summary-grid" cellspacing="10">
        <tr>
            <td width="50%" class="summary-card">
                <span class="label">Ahorro Estimado Anual</span>
                <span class="highlight-green">{{ number_format($resultado->ahorro_estimado_eur, 2, ',', '.') }} €</span>
            </td>
            <td width="50%" class="summary-card">
                <span class="label">Periodo de Amortización (ROI)</span>
                <span class="highlight-dark">
                    @if($resultado->roi_anyos > 0)
                        {{ number_format($resultado->roi_anyos, 1, ',', '.') }} Años
                    @else
                        <span style="font-size: 12px; color: #94a3b8;">Sujeto a auditoría</span>
                    @endif
                </span>
            </td>
        </tr>
    </table>

    <div class="eco-badge">
        <strong>Impacto Ambiental Positivo:</strong><br>
        Esta instalación evitará la emisión de <strong>{{ number_format(($resultado->produccion_anual_kwh * 0.25) / 1000, 2, ',', '.') }} toneladas de CO2</strong> al año, equivalente a plantar aproximadamente {{ round(($resultado->produccion_anual_kwh * 0.25) / 20) }} árboles.
    </div>

    <div style="margin-top: 40px; font-size: 10px; color: #64748b; font-style: italic;">
        * Los cálculos presentados en este informe técnico se basan en algoritmos de radiación solar promedio y eficiencia de componentes estándar. Este documento no constituye un contrato final de obra.
    </div>

    <div class="footer">
        <table width="100%">
            <tr>
                <td>SOLARCALC Ingenierías | Algemesí, España</td>
                <td align="right">Página 1 de 1</td>
            </tr>
        </table>
    </div>
</body>
</html>