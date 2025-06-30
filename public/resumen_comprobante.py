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
# id=0
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
#Seccion para traer informacion de la base
query = ('SELECT * from customers where id =1')

# join para cobros
# cobros=pd.read_sql('Select cobros.* ,customers.customer,internal_orders.invoice, users.name from ((cobros inner join internal_orders on internal_orders.id = cobros.order_id) inner join customers on customers.id = internal_orders.customer_id )inner join users on cobros.capturo=users.id',cnx)


#traer todas las cobros
cobros=pd.read_sql("""Select cobros.* ,
    customers.customer,customers.customer_suburb, customers.clave,
    internal_orders.invoice, internal_orders.payment_conditions,
    internal_orders.category,internal_orders.description,internal_orders.status,
    coins.exchange_sell, coins.coin, coins.symbol,
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


print(cobros)
nordenes=len(pd.read_sql(query,cnx))
df=cobros[['date']]
print(cobros['order_id'])
writer = pd.ExcelWriter('storage/report/resumen_comprobante'+str(id)+'.xlsx', engine='xlsxwriter')
if(int(id)!=0):
   cobros=cobros.loc[cobros['order_id']==int(id)]
workbook = writer.book
##FORMATOS PARA EL TITULO------------------------------------------------------------------------------
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


df[0:4].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=6, header=False, index=False)
worksheet = writer.sheets['Sheet1']


# Encabezado.
worksheet.insert_image("E1", "img/logo/logo.png",{"x_scale": 0.5, "y_scale": 0.5})
worksheet.merge_range('G2:K2', 'TYRSA CONSORCIO S.A. DE C.V. ', rojo_l)
worksheet.merge_range('G3:K3', 'Soluciones en logistica interior', negro_s)
worksheet.merge_range('G4:K4', 'RESUMEN DE COMPROBANTES DE INGRESO' ,negro_b)
worksheet.merge_range('G5:K5', 'Control de Cobros por P.I.', rojo_b)

worksheet.merge_range('L2:M3', """FECHA DEL REPORTE             
DD/MM/AAAA""", negro_b)

import datetime
currentDateTime = datetime.datetime.now()
date = currentDateTime.date()
year = date.strftime("%Y")
worksheet.merge_range('N2:O3', date, negro_b)
#Cabeceras
worksheet.merge_range('C6:C7', 'PDA', blue_header_format)
worksheet.merge_range('D6:D7', 'FECHA', blue_header_format)
worksheet.merge_range('E6:E7', 'NUMERO DE COMPROBANTE', blue_header_format)
worksheet.merge_range('F6:F7', 'BANCO', blue_header_format)
worksheet.merge_range('G6:G7', 'FACTURA', blue_header_format)
worksheet.merge_range('H6:H7', 'PI', blue_header_format)
worksheet.merge_range('I6:I7', 'CLIENTE', blue_header_format)
worksheet.merge_range('J6:J7', 'MONEDA', blue_header_format)
worksheet.merge_range('K6:K7', 'TC', blue_header_format)

worksheet.merge_range('L6:M6', 'IMPORTE TOTAL I/I', blue_header_format)
worksheet.write('L7', 'DLLS', blue_header_format)
worksheet.write('M7', 'MN', blue_header_format)

worksheet.merge_range('N6:N7', 'CAPTURO ', blue_header_format)
worksheet.merge_range('O6:O7', 'REVISO ', blue_header_format)
worksheet.merge_range('P6:P7', 'AUTORIZO', blue_header_format)

#ordenar por no. comprobante
cobros=cobros.sort_values(by='comp')

for i in range(0,len(cobros)):
   row_index=str(8+i)
   worksheet.write('C'+row_index, str(i+1), blue_content)
   worksheet.write('D'+row_index, cobros['date'].values[i], blue_content_date)
   worksheet.write('E'+row_index, str(cobros['comp'].values[i]), blue_content)
   worksheet.write('F'+row_index, str(cobros['bank_description'].values[i]), blue_content)
   worksheet.write('G'+row_index, str(cobros['facture'].values[i]), blue_content)
   worksheet.write('H'+row_index, str(cobros['invoice'].values[i]), blue_content)
   worksheet.write('I'+row_index, str(cobros['customer'].values[i]), blue_content)
   worksheet.write('J'+row_index, str(cobros['coin'].values[i]), blue_content)
   worksheet.write('K'+row_index, str(cobros['exchange_sell'].values[i]), blue_content)
   worksheet.write('L'+row_index, cobros['amount'].values[i], blue_content)
   worksheet.write('M'+row_index, cobros['exchange_sell'].values[i]*cobros['amount'].values[i], blue_content_dll)
   
   worksheet.write('N'+row_index, str(cobros['capturista'].values[i]), blue_content)
   worksheet.write('O'+row_index, str(cobros['revisor'].values[i]), blue_content)
   worksheet.write('P'+row_index, str(cobros['autorizador'].values[i]), blue_content)  
 
trow=8+len(cobros)

worksheet.merge_range('J'+str(trow)+':K'+str(trow), 'Total', blue_header_format_bold)

worksheet.write_formula('L'+str(trow),  '{=SUM(L8:L'+str(trow-1)+')}', blue_content_footer)
worksheet.write_formula('M'+str(trow),  '{=SUM(M8:M'+str(trow-1)+')}', blue_content_footer_dll)

worksheet.set_column('A:A',16)

worksheet.set_column('I:J',17)
worksheet.set_column('L:L',15)
worksheet.set_column('H:H',15)

worksheet.set_column('M:P',16)
worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
workbook.close()