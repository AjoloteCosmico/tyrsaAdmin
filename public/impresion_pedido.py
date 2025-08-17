from xltpl.writerx import BookWriter  # writerx = para .xlsx (openpyxl)
import sys
# Carga la plantilla
folio='3253'
id=4

id=str(sys.argv[1])
tipo=str(sys.argv[2])
writer = BookWriter('plantilla_pedido.xlsx')

# Datos a renderizar (puedes anidar dicts/listas sin problema)
payload = {
    "cliente": "ACME S.A.",
    
    "folio": folio,
    "fecha": "2025-08-16",
    "items": [
        {"sku": "A1", "desc": "Tornillo", "qty": 10, "precio": 3.5, "importe": 35.0},
        {"sku": "B2", "desc": "Tuerca",  "qty": 5,  "precio": 2.0, "importe": 10.0},
    ],
}

# Renderiza (se pasa una lista de payloads si quieres varias “páginas/hojas”)
writer.render_book([payload])

# Guarda el resultado
writer.save(f'storage/report/temp.xlsx')
from openpyxl import load_workbook

# Abre el archivo generado por xltpl
wb = load_workbook(f'storage/report/temp.xlsx')
ws = wb.active  # o wb["NombreDeHoja"]

# Configurar impresión
ws.page_setup.orientation = ws.ORIENTATION_PORTRAIT   # Vertical
ws.page_setup.fitToWidth = 1  # Ajustar a 1 página de ancho
ws.page_setup.fitToHeight = 3  # Ajustar a 3 páginas de alto

# Guardar cambios
wb.save(f'storage/report/impresion_pedido{id}.xlsx')