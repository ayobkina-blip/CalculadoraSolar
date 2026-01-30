<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Informe Técnico Fotovoltaico #{{ $resultado->id_resultado }}</title>
    <style>
        /* Tipografía y Base */
        @page { margin: 0; } /* Control total del margen */
        body { 
            font-family: 'Helvetica', Arial, sans-serif; 
            color: #334155; 
            margin: 0; 
            padding: 0;
            background-color: #ffffff;
        }

        /* Acentos de Color */
        .bg-navy { background-color: #0f172a; color: #ffffff; }
        .text-amber { color: #f59e0b; }
        .border-amber { border-left: 4px solid #f59e0b; }

        /* Contenedores */
        .container { padding: 40px; }
        
        /* Cabecera Estilo Corporativo */
        .header { padding: 40px; background-color: #f8fafc; border-bottom: 1px solid #e2e8f0; }
        .brand { font-size: 28px; font-weight: bold; letter-spacing: -1px; }
        
        /* Grid de Datos Técnicos */
        .section-header { 
            font-size: 10px; 
            font-weight: bold; 
            text-transform: uppercase; 
            letter-spacing: 1.5px; 
            color: #64748b;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #f1f5f9;
        }

        .stat-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .stat-label { font-size: 9px; color: #94a3b8; text-transform: uppercase; font-weight: bold; }
        .stat-value { font-size: 16px; font-weight: bold; color: #0f172a; display: block; margin-top: 5px; }

        /* Tabla de Resultados */
        .results-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .results-table th { background: #f8fafc; text-align: left; padding: 12px; font-size: 10px; color: #64748b; text-transform: uppercase; }
        .results-table td { padding: 15px 12px; border-bottom: 1px solid #f1f5f9; font-size: 12px; }

        /* Badge de ROI */
        .roi-badge {
            background: #f0fdf4;
            color: #16a34a;
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 12px;
        }

        /* Footer */
        .footer { 
            position: absolute; 
            bottom: 0; 
            width: 100%; 
            padding: 30px 40px; 
            background: #f8fafc; 
            font-size: 9px; 
            color: #94a3b8;
        }

        /* Notación Técnica */
        .technical-note {
            font-size: 10px;
            color: #64748b;
            background: #fffbeb;
            border: 1px solid #fef3c7;
            padding: 15px;
            border-radius: 8px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <div class="header">
        <table width="100%">
            <tr>
                <td>
                    <div class="brand">SOLAR<span class="text-amber">CALC</span></div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 5px;">Ingeniería Fotovoltaica de Precisión</div>
                </td>
                <td align="right">
                    <div style="font-size: 10px; line-height: 1.6;">
                        <strong>PROYECTO:</strong> #{{ str_pad($resultado->id_resultado, 5, '0', STR_PAD_LEFT) }}<br>
                        <strong>FECHA:</strong> {{ $fecha }}<br>
                        <strong>ESTADO:</strong> <span style="color: #16a34a;">VÁLIDO</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="container">
        
        {{-- SECCIÓN 1: DATOS DE GEOPOSICIONAMIENTO --}}
        <div class="section-header">1. Geoposicionamiento y Radiación</div>
        <table width="100%" cellspacing="0" cellpadding="0">
            <tr>
                <td width="60%" style="padding-right: 20px;">
                    <div class="stat-box border-amber">
                        <span class="stat-label">Ubicación del Proyecto</span>
                        <span class="stat-value">{{ $resultado->ubicacion }}</span>
                        <div style="font-size: 10px; color: #64748b; margin-top: 5px;">
                            Coordenadas: {{ $resultado->latitud }}, {{ $resultado->longitud }}
                        </div>
                    </div>
                </td>
                <td width="40%">
                    <div class="stat-box">
                        <span class="stat-label">Fuente de Radiación</span>
                        <span class="stat-value" style="font-size: 12px;">Base Datos Satelital PVGIS v5.2</span>
                    </div>
                </td>
            </tr>
        </table>

        {{-- SECCIÓN 2: DIMENSIONAMIENTO TÉCNICO --}}
        <div class="section-header" style="margin-top: 20px;">2. Configuración del Sistema</div>
        <table class="results-table">
            <thead>
                <tr>
                    <th>Componente</th>
                    <th>Detalle</th>
                    <th>Valor Nominal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Módulos Fotovoltaicos</strong></td>
                    <td>{{ $resultado->paneles_sugeridos }} Unidades x 450Wp</td>
                    <td>{{ number_format($resultado->potencia_instalacion_kwp, 2) }} kWp</td>
                </tr>
                <tr>
                    <td><strong>Producción Estimada</strong></td>
                    <td>Rendimiento anual del sistema</td>
                    <td><strong>{{ number_format($resultado->produccion_anual_kwh, 0, ',', '.') }} kWh/año</strong></td>
                </tr>
                <tr>
                    <td><strong>Orientación / Incl.</strong></td>
                    <td>Azimut: {{ $resultado->orientacion }}° | Ángulo: {{ $resultado->inclinacion }}°</td>
                    <td>Óptimo local</td>
                </tr>
            </tbody>
        </table>

        {{-- SECCIÓN 3: VIABILIDAD FINANCIERA --}}
        <div class="section-header" style="margin-top: 20px;">3. Análisis Financiero</div>
        <table width="100%" cellspacing="10">
            <tr>
                <td width="33%">
                    <div class="stat-box" style="text-align: center;">
                        <span class="stat-label">Ahorro Anual</span>
                        <span class="stat-value" style="color: #16a34a;">{{ number_format($resultado->ahorro_estimado_eur, 2, ',', '.') }} €</span>
                    </div>
                </td>
                <td width="33%">
                    <div class="stat-box" style="text-align: center;">
                        <span class="stat-label">Amortización</span>
                        <span class="roi-badge">{{ number_format($resultado->roi_anyos, 1) }} Años</span>
                    </div>
                </td>
                <td width="33%">
                    <div class="stat-box" style="text-align: center;">
                        <span class="stat-label">Valor Activo</span>
                        <span class="stat-value">{{ number_format($resultado->paneles_sugeridos * 470, 0, ',', '.') }} €</span>
                    </div>
                </td>
            </tr>
        </table>

        {{-- NOTA TÉCNICA --}}
        <div class="technical-note">
            <strong>Certificación de Datos:</strong> Este análisis integra la base de datos de radiación <strong>PVGIS-SARAH2</strong>. Los cálculos consideran un índice de pérdidas de sistema (LID, cableado, suciedad) del 14% de acuerdo a estándares europeos.
        </div>

        {{-- IMPACTO --}}
        <div style="margin-top: 30px; text-align: center;">
            <table width="100%">
                <tr>
                    <td style="background: #f0fdf4; border-radius: 12px; padding: 20px;">
                        <div style="color: #15803d; font-size: 11px; font-weight: bold;">REDUCCIÓN DE HUELLA DE CARBONO</div>
                        <div style="font-size: 18px; font-weight: bold; color: #166534; margin-top: 5px;">
                            {{ number_format(($resultado->produccion_anual_kwh * 0.25) / 1000, 2) }} Toneladas de CO2 / año
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>

    <div class="footer">
        <table width="100%">
            <tr>
                <td>SOLARCALC | Especialistas en Ingeniería Fotovoltaica Autoconsumo</td>
                <td align="right">solarcalc.es | Informe de Validez Técnica</td>
            </tr>
        </table>
    </div>

</body>
</html>