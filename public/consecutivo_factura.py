import sys
import mysql.connector
import xlsxwriter
import pandas as pd
import sys
import mysql.connector
import os
from dotenv import load_dotenv
load_dotenv()
#id del pedido en cuestion
id=str(sys.argv[1])
#configurar la conexion a la base de datos
DB_USERNAME = os.getenv('DB_USERNAME')
DB_DATABASE = os.getenv('DB_DATABASE')
DB_PASSWORD = os.getenv('DB_PASSWORD')
DB_PORT = os.getenv('DB_PORT')

a_color='#354F84'
b_color='#91959E'
# Conectar a DB
cnx = mysql.connector.connect(user=DB_USERNAME,
                              password=DB_PASSWORD,
                              host='localhost',
                              port=DB_PORT,
                              database=DB_DATABASE,
                              use_pure=False)
facturas=pd.read_sql("""Select factures.* ,
    customers.customer,customers.customer_suburb, customers.clave,
    internal_orders.invoice, internal_orders.payment_conditions,internal_orders.noha,
    internal_orders.category,internal_orders.description,internal_orders.status as estado,
    coins.exchange_sell, coins.coin, coins.symbol,
    capturistas.name as capturista, revisores.name as revisor, autorizadores.name as autorizador
    from ((((((
    factures inner join internal_orders on internal_orders.id = factures.order_id) 
    inner join customers on customers.id = internal_orders.customer_id )
    inner join coins on internal_orders.coin_id = coins.id)
    left join cobros on factures.id=cobros.facture_id)
    left join users as capturistas on cobros.capturo=capturistas.id)
    left join users as revisores on cobros.reviso=revisores.id)
    left join users as autorizadores on cobros.autorizo=autorizadores.id
     """,cnx)

writer = pd.ExcelWriter('storage/report/consecutivo_factura1.xlsx', engine='xlsxwriter')
workbook = writer.book

##FORMATOS PARA EL TITULO------------------------------------------------------------------------------
rojo_l = workbook.add_format({
    'bold': 0,
    'border': 0,
    'align': 'center',
    'valign': 'vcenter',
    #'fg_color': 'yellow',
    'font_color': 'red',
    'font_size':16})
negro_s = workbook.add_format({
    'bold': 0,
    'border': 0,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12})
negro_b = workbook.add_format({
    'bold': 2,
    'border': 0,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':13,
    
    'text_wrap': True,
    'num_format': 'dd/mm/yyyy'}) 
rojo_b = workbook.add_format({
    'bold': 2,
    'border': 0,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'red',
    'font_size':13})      

#FORMATOS PARA CABECERAS DE TABLA --------------------------------
header_format = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'center',
    'fg_color': 'yellow',
    'border': 1,})

blue_header_format = workbook.add_format({
    'bold': True,
    'bg_color': a_color,
    'text_wrap': True,
    'valign': 'top',
    'align': 'center',
    'border_color':'white',
    'font_color': 'white',
    'num_format': '[$$-409]#,##0.00',
    'border': 1})
blue_header_format_bold = workbook.add_format({
    'bold': True,
    'bg_color': a_color,
    'text_wrap': True,
    'valign': 'top',
    'align': 'center',
    'border_color':'white',
    'font_color': 'white',
    'num_format': '[$$-409]#,##0.00',
    'border': 1,
    'font_size':13})
blue_footer_format_bold = workbook.add_format({
    'bold': True,
    'bg_color': a_color,
    'text_wrap': True,
    'valign': 'top',
    'align': 'center',
    'border_color':'white',
    'font_color': 'white',
    'border': 1,
    'num_format': '[$$-409]#,##0.00',
    'font_size':11})
red_header_format = workbook.add_format({
    'bold': True,
    'bg_color': b_color,
    'text_wrap': True,
    'valign': 'top',
    'align': 'center',
    'border_color':'white',
    'font_color': 'white',
    'border': 1})

red_header_format_bold = workbook.add_format({
    'bold': True,
    'bg_color': b_color,
    'text_wrap': True,
    'valign': 'top',
    'align': 'center',
    'border_color':'white',
    'font_color': 'white',
    'border': 1,
    'font_size':13})


#FORMATOS PARA TABLAS PER CE------------------------------------

blue_content = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    
    'border_color':a_color,
    'font_size':10,
    'num_format': '[$$-409]#,##0.00'})

blue_content_bold = workbook.add_format({
    'bold': True,
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':11,
    'border_color':a_color,
    'num_format': '[$$-409]#,##0.00'})

blue_content_bold_dll = workbook.add_format({
    'bold': True,
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':11,
    'bg_color': '#b4e3b1',
    'border_color':a_color,
    'num_format': '[$$-409]#,##0.00'})
blue_content_footer_dll = workbook.add_format({
    'bold': True,
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'white',
    'font_size':11,
    'bg_color': '#356e31',
    'border_color':'white',
    'num_format': '[$$-409]#,##0.00'})
blue_content_footer = workbook.add_format({
    'bold': True,
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'white',
    'font_size':11,
    'bg_color': '#3e5585',
    'border_color':'white',
    'num_format': '[$$-409]#,##0.00'})
blue_content_date = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':9,
    'border_color':a_color,
    'num_format': 'dd/mm/yyyy'})
#FOOTER FORMATS---------------------------------------------------------
observaciones_format = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#BDD7EE',
    'border': 1})

blue_content_dll = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'bg_color': '#b4e3b1',
    'border_color':a_color,
    'font_size':10,
    'num_format': '[$$-409]#,##0.00'})
total_cereza_format = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#F4B084',
    'border': 1})

#dataframes

facturas['date'][0:1].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=2, header=False, index=False)
worksheet = writer.sheets['Sheet1']
#worksheet.set_column(2,19,15)
# Encabezado.

facturas['clave'] = facturas['clave'].replace({' ':''}, regex=True)
worksheet.insert_image("E1", "img/logo/logo.png",{"x_scale": 0.5, "y_scale": 0.5})
worksheet.merge_range('G2:K2', 'TYRSA CONSORCIO S.A. DE C.V. ', rojo_l)
worksheet.merge_range('G3:K3', 'Soluciones en logistica interior', negro_s)
worksheet.merge_range('G4:K4', 'CONSECUTIVO DE FACTURAS' ,negro_b)
worksheet.merge_range('G5:K5', 'Control de Cobros por P.I.', rojo_b)

worksheet.merge_range('L2:M3', """FECHA DEL REPORTE             
DD/MM/AAAA""", negro_b)

import datetime
currentDateTime = datetime.datetime.now()
date = currentDateTime.date()
year = date.strftime("%Y")
worksheet.merge_range('N2:O3', date, negro_b)
#Dataframe yellow headers bitch xd
worksheet.merge_range('B6:B7', 'NOH', blue_header_format)
worksheet.merge_range('C6:C7', 'FECHA D-M-A', blue_header_format)
worksheet.merge_range('D6:D7', 'P.I. NO.', blue_header_format)
worksheet.merge_range('E6:E7', 'NUMERO DE PAGO', blue_header_format)
worksheet.merge_range('F6:F7', 'NUMERO TOTAL DE PAGOS', blue_header_format)
worksheet.merge_range('G6:G7', 'FACTURA FOLIO NO.', blue_header_format)
worksheet.merge_range('H6:H7', 'CLIENTE NO', blue_header_format)
worksheet.merge_range('I6:I7', 'NOMBRE CORTO CLIENTE', blue_header_format)
worksheet.merge_range('J6:J7', 'CATEGORIA EQUIPO', blue_header_format)
worksheet.merge_range('K6:K7', 'DESCRIPCION BREVE', blue_header_format)
worksheet.merge_range('L6:L7', 'UBI / SUC / TIENDA PROYECTO', blue_header_format)
worksheet.merge_range('M6:M7', 'TIPO DE MOBEDA', blue_header_format)
worksheet.merge_range('N6:N7', 'TIPO DE CAMBIO', blue_header_format)

worksheet.merge_range('O6:P6', 'IMPORTE TOTAL SIN IVA', blue_header_format)
worksheet.write(6, 14, "DLLS", blue_header_format)
worksheet.write(6, 15, "M.N.(Equivalente)", blue_header_format)

worksheet.merge_range('Q6:Q7', 'CAPTURO', blue_header_format)
worksheet.merge_range('R6:R7', 'REVISO', blue_header_format)
worksheet.merge_range('S6:S7', 'AUTORIZO', blue_header_format)
worksheet.merge_range('T6:T7', 'STATUS', blue_header_format)

for i in range(0,len(facturas)):
    worksheet.write(7+i, 1,str(facturas['noha'].values[i]), blue_content)
    worksheet.write(7+i, 2,str(facturas['date'].values[i]), blue_content)
    worksheet.write(7+i, 3,str(facturas['invoice'].values[i]), blue_content)
    worksheet.write(7+i, 4,str(facturas['ordinal'].values[i]), blue_content)
    worksheet.write(7+i, 5,str(facturas['payment_conditions'].values[i]), blue_content)
    worksheet.write(7+i, 6,str(facturas['facture'].values[i]), blue_content)
    worksheet.write(7+i, 7,str(facturas['clave'].values[i]), blue_content)
    worksheet.write(7+i, 8,str(facturas['customer'].values[i]), blue_content)
    worksheet.write(7+i, 9,str(facturas['category'].values[i]), blue_content)
    worksheet.write(7+i, 10,str(facturas['description'].values[i]), blue_content)
    worksheet.write(7+i, 11,str(facturas['customer_suburb'].values[i]), blue_content)
    worksheet.write(7+i, 12,str(facturas['coin'].values[i]), blue_content)
    worksheet.write(7+i, 13,str(facturas['exchange_sell'].values[i]), blue_content)
    if(facturas['exchange_sell'].values[i]>1):
        worksheet.write(7+i, 14, 0,blue_content)
        worksheet.write(7+i, 15, facturas['amount'].values[i]*facturas['exchange_sell'].values[i],blue_content_dll)
    else:
        worksheet.write(7+i, 14, facturas['amount'].values[i],blue_content)
        worksheet.write(7+i, 15,0,blue_content_dll)
    worksheet.write(7+i, 16, str(facturas['capturista'].values[i]),blue_content)
    worksheet.write(7+i, 17, str(facturas['revisor'].values[i]),blue_content)
    worksheet.write(7+i, 18, str(facturas['autorizador'].values[i]),blue_content)
    worksheet.write(7+i, 19, str(facturas['status'].values[i]),blue_content)

worksheet.set_column('C:C',15)
worksheet.set_column('I:I',19)
worksheet.set_column('L:M',15)
worksheet.set_column('O:P',19)
worksheet.set_column('Q:T',20)
worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
workbook.close()

