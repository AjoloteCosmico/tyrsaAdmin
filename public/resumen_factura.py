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
# facturas=pd.read_sql('Select factures.* ,customers.customer,internal_orders.invoice, users.name from ((factures inner join internal_orders on internal_orders.id = factures.order_id) inner join customers on customers.id = internal_orders.customer_id )inner join users on factures.capturo=users.id',cnx)
id=str(sys.argv[1])

tipo=str(sys.argv[2])

#traer todas las facturas
facturas=pd.read_sql("""Select factures.* ,customers.customer ,customers.id as customer_id,
                               internal_orders.invoice, internal_orders.payment_conditions,coins.exchange_sell, coins.coin, coins.symbol 
                          from (((factures inner join internal_orders on internal_orders.id = factures.order_id) 
                                 inner join customers on customers.id = internal_orders.customer_id )
                                        inner join coins on internal_orders.coin_id = coins.id)
                                            """,cnx)
nordenes=len(pd.read_sql(query,cnx))
df=facturas[['date']]
print(facturas.columns)
writer = pd.ExcelWriter('storage/report/resumen_factura'+str(id)+'.xlsx', engine='xlsxwriter')
if((int(id)!=0)&(int(tipo)==0)):
   facturas=facturas.loc[facturas['order_id']==int(id)]
if((int(id)!=0)&(int(tipo)==1)):
   facturas=facturas.loc[facturas['customer_id']==int(id)]
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
    'valign': 'vcenter',
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

df[0:1].to_excel(writer, sheet_name='Sheet1', startrow=6,startcol=6, header=False, index=False)
worksheet = writer.sheets['Sheet1']
#Encabezado del documento--------------
worksheet.insert_image("A1", "img/logo/logo.png",{"x_scale": 0.6, "y_scale": 0.6})

worksheet.merge_range('C2:G3', 'TYRSA CONSORCIO S.A. DE C.V. ', rojo_l)
worksheet.merge_range('C4:G4', 'Soluciones en logistica interior', negro_s)

worksheet.merge_range('H2:K2', 'RESUMEN DE FACTURAS', negro_b)
worksheet.merge_range('H3:K3', 'CONTROL DE FACTURAS', negro_s)

import datetime

currentDateTime = datetime.datetime.now()
date = currentDateTime.date()

worksheet.merge_range('L2:M3', """FECHA DEL REPORTE
(DD/MM/AAAA)""", negro_b)
worksheet.merge_range('N2:N3', date, negro_b)

worksheet.merge_range('C6:C7', 'PDA', blue_header_format)
worksheet.merge_range('D6:D7', """FECHA
(DD/MM/AAAA)""", blue_header_format)

worksheet.merge_range('E6:F6', 'COBROS', blue_header_format)
worksheet.write('E7', 'PROGRAMADO', blue_header_format)
worksheet.write('F7', 'REAL', blue_header_format)

# worksheet.merge_range('G6:G7', 'BANCO', blue_header_format)
# worksheet.merge_range('H6:H7', 'FACTURA', blue_header_format)
# worksheet.merge_range('I6:I7', 'PI', blue_header_format)
# worksheet.merge_range('J6:J7', 'CLIENTE', blue_header_format)
# worksheet.merge_range('K6:K7', 'MONEDA', blue_header_format)
# worksheet.merge_range('L6:L7', 'TC', blue_header_format)

# worksheet.merge_range('M6:N6', 'IMPORTE TOTAL I/I', blue_header_format)
# worksheet.write('M7', 'DLLS', blue_header_format)
# worksheet.write('N7', 'MN', blue_header_format)
worksheet.merge_range('G6:G7', 'FACTURA', blue_header_format)
worksheet.merge_range('H6:H7', 'PI', blue_header_format)
worksheet.merge_range('I6:I7', 'CLIENTE', blue_header_format)
worksheet.merge_range('J6:J7', 'MONEDA', blue_header_format)
worksheet.merge_range('K6:K7', 'TC', blue_header_format)

worksheet.merge_range('L6:M6', 'IMPORTE TOTAL I/I', blue_header_format)
worksheet.write('L7', 'MN', blue_header_format)
worksheet.write('M7', 'DLL', blue_header_format)
# worksheet.merge_range('O6:O7', 'CAPTURO ', blue_header_format)
# worksheet.merge_range('P6:P7', 'REVISO ', blue_header_format)
# worksheet.merge_range('Q6:Q7', 'AUTORIZO', blue_header_format)

for i in range(0,len(facturas)):
   row_index=str(8+i)
   worksheet.write('C'+row_index, str(i+1), blue_content)
   worksheet.write('D'+row_index, facturas['date'].values[i], blue_content_date)
   worksheet.write('E'+row_index, str(facturas['payment_conditions'].values[i]), blue_content)
   worksheet.write('F'+row_index, str(facturas['payment_conditions'].values[i]), blue_content)
#    worksheet.write('G'+row_index, ' ', blue_content)
   worksheet.write('G'+row_index, str(facturas['facture'].values[i]), blue_content)
   worksheet.write('H'+row_index, str(facturas['invoice'].values[i]), blue_content)
   worksheet.write('I'+row_index, str(facturas['customer'].values[i]), blue_content)
   worksheet.write('J'+row_index, str(facturas['coin'].values[i]), blue_content)
   worksheet.write('K'+row_index, facturas['exchange_sell'].values[i], blue_content)
   if(facturas['exchange_sell'].values[i]>1):
        worksheet.write('L'+row_index,0, blue_content)
        worksheet.write('M'+row_index, facturas['exchange_sell'].values[i]*facturas['amount'].values[i], blue_content_dll)
   else:
       
        worksheet.write('L'+row_index, facturas['amount'].values[i], blue_content)
        worksheet.write('M'+row_index, 0, blue_content_dll)
#  worksheet.write('N'+row_index, ' ', blue_content)

trow=8+len(facturas)

worksheet.merge_range('J'+str(trow)+':K'+str(trow), 'Total', blue_header_format_bold)
worksheet.write_formula('L'+str(trow),  '{=SUM(L8:L'+str(trow-1)+')}', blue_content_footer)
worksheet.write_formula('M'+str(trow),  '{=SUM(M8:M'+str(trow-1)+')}', blue_content_footer_dll)

worksheet.set_column('L:N',19)
worksheet.set_column('I:I',20)
worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
workbook.close()