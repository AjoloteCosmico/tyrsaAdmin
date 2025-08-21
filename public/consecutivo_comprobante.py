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
query = ('SELECT * from payments')
pagos=pd.read_sql(query,cnx)
#order_id=pagos.loc[(pagos["id"]==int(id),"order_id") ].values[0]
writer = pd.ExcelWriter("storage/report/consecutivo_comprobante1.xlsx", engine='xlsxwriter')
cobros=pd.read_sql("""Select cobros.* ,
    customers.alias,customers.customer_suburb, customers.clave,
    internal_orders.invoice, internal_orders.payment_conditions,
    internal_orders.category,internal_orders.description,internal_orders.status,
    coins.exchange_sell, coins.code, coins.symbol,
    banks.bank_description, factures.facture, factures.ordinal,
    capturistas.name as capturista, revisores.name as revisor, autorizadores.name as autorizador
    from (((((((
    cobros inner join internal_orders on internal_orders.id = cobros.order_id) 
    inner join customers on customers.id = internal_orders.customer_id )
    inner join coins on internal_orders.coin_id = coins.id)
    left join users as capturistas on cobros.capturo=capturistas.id)
    left join users as revisores on cobros.reviso=revisores.id)
    left join users as autorizadores on cobros.autorizo=autorizadores.id)
    inner join factures on factures.id = cobros.facture_id)
    inner join banks on banks.id=cobros.bank_id """,cnx)


cobros['date'][0:1].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=2, header=False, index=False)

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

    
worksheet = writer.sheets['Sheet1']
cobros['code']=cobros['code'].str.replace('MN','MXN')
cobros['clave']=cobros['clave'].str.replace(' ','')

# Encabezado.
worksheet.insert_image("E1", "img/logo/logo.png",{"x_scale": 0.5, "y_scale": 0.5})
worksheet.merge_range('G2:K2', 'TYRSA CONSORCIO S.A. DE C.V. ', rojo_l)
worksheet.merge_range('G3:K3', 'Soluciones en logistica interior', negro_s)
worksheet.merge_range('G4:K4', 'CONSECUTIVO DE COMPROBANTES DE INGRESO' ,negro_b)
worksheet.merge_range('G5:K5', 'Control de Cobros por P.I.', rojo_b)

worksheet.merge_range('L2:M3', """FECHA DEL REPORTE             
DD/MM/AAAA""", negro_b)

import datetime
currentDateTime = datetime.datetime.now()
date = currentDateTime.date()
year = date.strftime("%Y")
worksheet.merge_range('N2:O3', date, negro_b)

#Dataframe yellow headers bitch xd
worksheet.merge_range('B6:B7', 'NOHA', blue_header_format)

worksheet.merge_range('C6:C7', 'NO. COMPROBANTE', blue_header_format)
worksheet.merge_range('D6:D7', 'FECHA D-M-A', blue_header_format)
worksheet.merge_range('E6:E7', 'P.I. NO.', blue_header_format)
worksheet.merge_range('F6:F7', 'NUMERO DE COBROS', blue_header_format)
worksheet.merge_range('G6:G7', 'NUMERO TOTAL DE COBROS', blue_header_format)
worksheet.merge_range('H6:H7', 'FACTURA FOLIO NO.', blue_header_format)
worksheet.merge_range('I6:I7', 'CLIENTE NO', blue_header_format)
worksheet.merge_range('J6:J7', 'NOMBRE CORTO CLIENTE', blue_header_format)
worksheet.merge_range('K6:K7', 'CATEGORIA EQUIPO', blue_header_format)
worksheet.merge_range('L6:L7', 'DESCRIPCION BREVE', blue_header_format)
worksheet.merge_range('M6:M7', 'UBI / SUC / TIENDA PROYECTO', blue_header_format)
worksheet.merge_range('N6:N7', 'TIPO DE MONEDA', blue_header_format)
worksheet.merge_range('O6:O7', 'TIPO DE CAMBIO', blue_header_format)

worksheet.merge_range('P6:Q6', 'IMPORTE TOTAL SIN IVA', blue_header_format)
worksheet.write(6, 15, "DLLS", blue_header_format_bold)
worksheet.write(6, 16, "M.N.(Equivalente)", blue_header_format)

worksheet.merge_range('R6:R7', 'CAPTURO', blue_header_format)
worksheet.merge_range('S6:S7', 'REVISO', blue_header_format)
worksheet.merge_range('T6:T7', 'AUTORIZO', blue_header_format)
worksheet.merge_range('U6:U7', 'STATUS', blue_header_format)

##columnas y tablas como tal pues
#ordenar los cobros antes de iterar

cobros=cobros.sort_values(by='comp')
acum=0
for i in range(0,len(cobros)):
     acum=acum+cobros['amount'].values[i]*cobros['tc'].values[i]
     worksheet.write(7+i, 1, str(i+1),blue_content)
     worksheet.write(7+i, 2, str(cobros['comp'].values[i]),blue_content)
     worksheet.write(7+i, 3, cobros['date'].values[i],blue_content_date)
     worksheet.write(7+i, 4, str(cobros['invoice'].values[i]),blue_content)
     worksheet.write(7+i, 5, str(cobros['ordinal'].values[i]),blue_content)
     worksheet.write(7+i, 6, str(cobros['payment_conditions'].values[i]),blue_content)
     worksheet.write(7+i, 7, str(cobros['facture'].values[i]),blue_content)
     worksheet.write(7+i, 8, str(cobros['clave'].values[i]),blue_content)
     worksheet.write(7+i, 9, str(cobros['alias'].values[i]),blue_content)
     worksheet.write(7+i, 10, str(cobros['category'].values[i]).upper(),blue_content)
     worksheet.write(7+i, 11, str(cobros['description'].values[i]).upper(),blue_content)
     worksheet.write(7+i, 12, str(cobros['customer_suburb'].values[i]).upper(),blue_content)
     worksheet.write(7+i, 13, str(cobros['code'].values[i]),blue_content)
     worksheet.write(7+i, 14, str(cobros['tc'].values[i]),blue_content)
     worksheet.write(7+i, 15, cobros['amount'].values[i],blue_content)
     worksheet.write(7+i, 16, cobros['amount'].values[i]*cobros['tc'].values[i],blue_content_dll)
     worksheet.write(7+i, 17, cobros['capturista'].values[i].split()[0]+' '+cobros['capturista'].values[i].split()[1],blue_content)
     worksheet.write(7+i, 18, str(cobros['revisor'].values[i]),blue_content)
     worksheet.write(7+i, 19, str(cobros['autorizador'].values[i]),blue_content)
     worksheet.write(7+i, 20, str(cobros['status'].values[i].upper()),blue_content)

#barra inferior de totales
trow=8+len(cobros)
worksheet.merge_range(trow,13,trow,14 ,'Total sin iva', blue_header_format)
worksheet.write(trow, 15, cobros["amount"].sum(),blue_header_format_bold)
worksheet.write(trow, 16, acum,blue_header_format)
worksheet.set_column('C:C',15)
worksheet.set_column('I:I',19)
worksheet.set_column('L:M',15)
worksheet.set_column('O:P',19)
worksheet.set_column('Q:Q',20)
worksheet.set_column('U:U',15)
for df_col,col in zip(["alias",'category','description','customer_suburb','capturista','revisor','autorizador'],['J','K','L','M','R','S','T']):
    col_width = min(cobros[df_col].str.len().max(),45)
    if(pd.isna(col_width)):
        col_width = 15
    worksheet.set_column(f'{col}:{col}', col_width)
    print(col_width,col)

worksheet.set_column('R:T',29)
worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 0)  
workbook.close()