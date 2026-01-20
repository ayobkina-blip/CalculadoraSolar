<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        @page { margin: 0px; }
        body { font-family: 'Helvetica', sans-serif; color: #333; margin: 0; padding: 0; }
        .header { background-color: #1e3a8a; color: #ffffff; padding: 30px; }
        .brand { font-size: 28px; font-weight: bold; }
        .brand span { color: #fbbf24; }
        .container { padding: 30px; }
        .section-title { color: #1e3a8a; font-size: 12px; font-weight: bold; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-top: 20px; text-transform: uppercase; }
        .tabla-full { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .tabla-full td { padding: 12px; border: 1px solid #f1f5f9; background-color: #f8fafc; }
        .label { color: #64748b; font-size: 9px; text-transform: uppercase; font-weight: bold; }
        .value { font-size: 15px; font-weight: bold; }
        .card-table { width: 100%; margin-top: 20px; border-spacing: 10px; border-collapse: separate; }
        .card { padding: 25px 10px; border-radius: 10px; text-align: center; color: white; }
        .azul { background-color: #1e3a8a; }
        .naranja { background-color: #f59e0b; }
        .card-label { font-size: 10px; text-transform: uppercase; display: block; margin-bottom: 8px; }
        .card-value { font-size: 24px; font-weight: bold; }
        .footer { position: absolute; bottom: 0; width: 100%; padding: 15px; text-align: center; font-size: 10px; color: #94a3b8; background-color: #f8fafc; }
    </style>
</head>
<body>
    <div class="header">
        <table width="100%">
            <tr>
                <td>
                    <div class="brand">SOLAR<span>CALC</span></div>
                    <div style="font-size: 11px; opacity: 0.8;">Cálculos Fotovoltaicos de Precisión</div>
                </td>
                <td align="right">
                    <div style="font-size: 10px;">PRESUPUESTO #{{ $resultado->id_resultado }}</div>
                    <div style="font-size: 12px; font-weight: bold;">{{ $fecha }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="container">
        <div class="section-title">Configuración del Sistema</div>
        <table class="tabla-full">
            <tr>
                <td width="50%">
                    <div class="label">Ubicación</div>
                    <div class="value">{{ $resultado->ubicacion }}</div>
                </td>
                <td width="50%">
                    <div class="label">Potencia Instalada</div>
                    <div class="value">{{ number_format($resultado->potencia_instalacion_kwp, 2, ',', '.') }} kWp</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="label">Número de Paneles</div>
                    <div class="value">{{ $resultado->paneles_sugeridos }} Módulos 450Wp</div>
                </td>
                <td>
                    <div class="label">Producción Anual</div>
                    <div class="value">{{ number_format($resultado->produccion_anual_kwh, 0, ',', '.') }} kWh</div>
                </td>
            </tr>
        </table>

        <div class="section-title">Retorno Económico</div>
        <table class="card-table">
            <tr>
                <td width="50%" class="card azul">
                    <span class="card-label">Ahorro Estimado</span>
                    <span class="card-value">{{ number_format($resultado->ahorro_estimado_eur, 2, ',', '.') }} €/año</span>
                </td>
                <td width="50%" class="card naranja">
                    <span class="card-label">Tiempo de Amortización</span>
                    <span class="card-value">
                        @if($resultado->roi_anyos > 0)
                            {{ number_format($resultado->roi_anyos, 1, ',', '.') }} Años
                        @else
                            <span style="font-size: 14px;">Pendiente de revisión técnica</span>
                        @endif
                    </span>
                </td>
            </tr>
        </table>

        <div style="margin-top: 30px; padding: 20px; border: 1px dashed #166534; background-color: #f0fdf4; border-radius: 10px; text-align: center;">
            <p style="color: #166534; font-size: 12px; margin: 0;">
                <strong>Huella de Carbono:</strong> Con esta instalación dejará de emitir aproximadamente 
                <strong>{{ number_format(($resultado->produccion_anual_kwh * 0.25) / 1000, 2, ',', '.') }} toneladas</strong> 
                de CO2 al año.
            </p>
        </div>
    </div>

    <div class="footer">
        SOLARCALC - Especialistas en Energía Solar. <br>
        Este documento es una simulación informativa basada en datos promedio.
    </div>
</body>
</html>