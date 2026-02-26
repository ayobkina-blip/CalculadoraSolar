---
name: doc-updater
description: >
  Actualiza automáticamente la documentación técnica de un proyecto Laravel cuando el usuario
  reporta o sube cambios importantes al código. Úsala siempre que el usuario mencione que ha
  modificado, añadido o eliminado alguno de estos elementos: un modelo, una migración, una tabla
  de base de datos, un controlador o método, una ruta, un middleware, un servicio, una vista o
  cualquier dependencia del proyecto. También debe activarse cuando el usuario diga frases como
  "he cambiado X", "añadí un campo a Y", "creé un nuevo controlador", "añadí una ruta",
  "cambié el middleware", "nueva funcionalidad", "borré el modelo X", o similares.
  El output es siempre el bloque o sección de la documentación .md actualizado, listo para
  sustituir al anterior, o el archivo completo si el cambio afecta a varias secciones.
---

# Skill: Actualizador de Documentación Técnica Laravel

## Propósito

Mantener la documentación técnica en formato Markdown sincronizada con los cambios reales
del proyecto, sin tener que regenerarla desde cero. El objetivo es detectar qué sección
de la documentación queda obsoleta por un cambio dado y reescribir únicamente esa parte.

---

## Paso 1 — Identificar el tipo de cambio

Cuando el usuario reporte un cambio, clasifícalo en una de estas categorías:

| Categoría | Ejemplos de cambio | Sección de doc afectada |
|-----------|-------------------|------------------------|
| **Modelo / BD** | nuevo campo, nueva tabla, nueva relación, cambio de tipo, FK nueva | §5 Modelos y Base de Datos |
| **Controlador** | nuevo método, método modificado, nuevo controlador, método eliminado | §6 Controladores |
| **Ruta** | ruta nueva, ruta eliminada, cambio de middleware en ruta, cambio de URI | §9 Rutas de la Aplicación |
| **Middleware** | nuevo middleware, cambio en lógica de handle, cambio de rutas aplicadas | §8 Middlewares Personalizados |
| **Servicio** | nuevo método en servicio, nuevo servicio, cambio de lógica de negocio | §7 Servicios — Lógica de Negocio |
| **Vista / Frontend** | nueva vista, nueva variable Blade, nuevo componente Alpine, nueva librería JS | §10 Vistas y Frontend |
| **Autenticación / Roles** | nuevo rol, cambio en flujo de auth, nuevo guard | §4 Autenticación y Roles |
| **Instalación / Config** | nueva variable de entorno, nuevo paquete composer/npm | §2 Instalación y Configuración |
| **Múltiple** | cambio que afecta a varias categorías a la vez | Todas las secciones implicadas |

Si el cambio no encaja claramente, pregunta al usuario una sola pregunta concreta para aclararlo.

---

## Paso 2 — Recopilar la información necesaria

Antes de actualizar la documentación, asegúrate de tener todos estos datos según el tipo de cambio.
Si el usuario no los ha proporcionado, pídelos explícitamente:

### Para cambios en Modelo / BD
- Nombre de la tabla y del modelo Eloquent
- Columnas nuevas/modificadas/eliminadas con tipo de dato exacto (`varchar(100)`, `decimal(10,2)`…)
- Si admite NULL y cuál es el valor por defecto
- Si es FK: tabla y columna a la que apunta
- Relaciones Eloquent nuevas o modificadas (tipo: hasMany, belongsTo…)
- Si se añadieron casts, scopes o appends

### Para cambios en Controlador
- Nombre del controlador
- Nombre del método y su firma completa
- Qué recibe (parámetros de ruta, Request, inyecciones)
- Qué lógica ejecuta (paso a paso si es compleja)
- Qué devuelve (vista, redirect, JSON, StreamedResponse)
- Si usa algún servicio o Form Request

### Para cambios en Ruta
- Método HTTP (GET, POST, PATCH, DELETE…)
- URI exacta
- Nombre de la ruta (`route()`)
- Controlador@método
- Middlewares aplicados

### Para cambios en Middleware
- Nombre de la clase del middleware
- Lógica del método `handle` (o descripción del cambio)
- Respuesta en caso de fallo (abort, redirect…)
- Rutas donde se aplica

### Para cambios en Servicio
- Nombre del servicio y del método
- Firma del método
- Lógica que ejecuta
- Valor de retorno
- Quién lo invoca (controladores, middlewares)

### Para cambios en Vista / Frontend
- Nombre del archivo blade
- Variables Blade que recibe (nuevas o modificadas)
- Cambios en Alpine.js (`x-data`, nuevas variables reactivas)
- Si usa nuevas librerías JS o endpoints fetch

---

## Paso 3 — Actualizar la documentación

Con toda la información recopilada:

1. **Localiza la sección exacta** dentro del documento de documentación que queda obsoleta.
2. **Reescribe únicamente esa sección** respetando el estilo y formato del documento original:
   - Tablas de BD con columnas: `| Columna | Tipo | Null | Default | Notas |`
   - Métodos de controlador con encabezado `####`, firma en bloque de código y descripción en prosa
   - Tablas de rutas con las 5 columnas estándar: `| Método | URI | Nombre | Controlador | Descripción |`
   - Bloques PHP para código de middlewares
   - Listas de relaciones Eloquent en bloques de código
3. **Indica explícitamente** al usuario qué sección ha cambiado (número y título) para que sepa dónde pegar el contenido actualizado.
4. Si el cambio afecta a **varias secciones**, genera cada bloque por separado con un encabezado claro indicando en cuál va.
5. Si el cambio es lo suficientemente grande como para afectar el **diagrama de relaciones** (§5), actualízalo también.

---

## Paso 4 — Formato de la respuesta

Estructura tu respuesta siempre así:

```
## Cambio detectado
[Una frase describiendo qué ha cambiado]

## Sección(es) afectada(s)
- §X — [Nombre de la sección]
- §Y — [Nombre de la sección] (si aplica)

## Documentación actualizada

### §X — [Nombre de la sección]
[Contenido Markdown de la sección reescrita, listo para copiar/pegar]

### §Y — [Nombre de la sección] (si aplica)
[Contenido Markdown...]
```

---

## Reglas de calidad

- **No inventes datos.** Si el usuario no te ha dado un detalle (ej: si una columna admite NULL),
  pregúntalo antes de escribir la documentación.
- **Mantén el estilo** del documento original: mismos estilos de tabla, mismos niveles de heading,
  mismo tono técnico.
- **No regeneres todo el documento** si el cambio es puntual. Sé quirúrgico.
- **Sí regenera el documento completo** si el usuario pide explícitamente una revisión global,
  o si los cambios afectan a más de 4 secciones distintas.
- Si el cambio elimina algo (método borrado, tabla eliminada, ruta deprecada), indícalo
  claramente en la respuesta: *"La siguiente entrada debe eliminarse de la sección §X"*.

---

## Ejemplo de flujo

**Usuario:** "Añadí un campo `telefono` varchar(20) nullable a la tabla `usuarios` y lo puse
en el `$fillable` del modelo User."

**Claude debe:**
1. Clasificar: cambio en Modelo / BD → afecta §5.
2. Verificar que tiene toda la info necesaria (tipo: varchar(20), null: sí, default: NULL, no es FK).
3. Actualizar la tabla de la sección §5.1 (Modelo `User`) añadiendo la fila del campo `telefono`.
4. Indicar que no hay cambios en relaciones ni en otras secciones.
5. Devolver solo el bloque de la tabla actualizada con la indicación de en qué sección va.
