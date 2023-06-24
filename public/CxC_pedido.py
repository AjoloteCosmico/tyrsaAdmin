import sys
import mysql.connector
import xlsxwriter
import pandas as pd
import sys
import mysql.connector
import os
from dotenv import load_dotenv
load_dotenv()
#ESTE ARGUMENTO NO SE USA EN ESTE REPORTE, SERÁ 0 SIEMPRE UWU
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
#Seccion para traer informacion de la base
query = ('SELECT * from customers where id = 1')

# join para cobros
# cobros=pd.read_sql('Select cobros.* ,customers.customer,internal_orders.invoice, users.name from ((cobros inner join internal_orders on internal_orders.id = cobros.order_id) inner join customers on customers.id = internal_orders.customer_id )inner join users on cobros.capturo=users.id',cnx)


#traer datos de los pedidos
pedidos=pd.read_sql("""Select internal_orders.* ,customers.clave,customers.alias,
coins.exchange_sell, coins.coin, coins.symbol
from ((
    internal_orders
    inner join customers on customers.id = internal_orders.customer_id )
    inner join coins on internal_orders.coin_id = coins.id)
     """,cnx)
cobros=pd.read_sql("""select cobro_orders.*
                     from (((
                         cobro_orders 
    inner join cobros on cobros.id=cobro_orders.cobro_id)
    inner join internal_orders on internal_orders.id = cobros.order_id )
    inner join coins on internal_orders.coin_id = coins.id) """,cnx)
facturas=pd.read_sql("""select * 
                     from ((
                         factures
    inner join internal_orders on internal_orders.id = factures.order_id )
    inner join coins on internal_orders.coin_id = coins.id) """,cnx)
creditos=pd.read_sql("""select * 
                     from ((
                         credit_notes    inner join internal_orders on internal_orders.id = credit_notes.order_id )
    inner join coins on internal_orders.coin_id = coins.id) """,cnx)
print(creditos)
nordenes=len(pedidos)
df=pedidos[['date']]
print(cobros['order_id'])
tc=pd.read_sql('select * from coins where id=2 ',cnx)['exchange_sell'].values[0]
writer = pd.ExcelWriter('storage/report/CxC_pedido'+str(id)+'.xlsx', engine='xlsxwriter')
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
    'font_size':13}) 
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
    'border': 1})
blue_header_format_bold = workbook.add_format({
    'bold': True,
    'bg_color': a_color,
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


blue_content_dll = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'bg_color': '#b4e3b1',
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

total_cereza_format = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#F4B084',
    'border': 1})


df[0:1].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=6, header=False, index=False)
worksheet = writer.sheets['Sheet1']
#Encabezado del documento--------------
worksheet.merge_range('B2:G3', 'TYRSA CONSORCIO S.A. DE C.V. ', rojo_l)
worksheet.merge_range('B4:G4', 'Soluciones en logistica interior', negro_s)
worksheet.merge_range('H2:R3', 'CUENTAS POR COBRAR POR P.I.', negro_b)
worksheet.merge_range('H4:R4', 'CUENTAS POR COBRAR', rojo_b)

worksheet.insert_image("A1", "img/logo/logo.png",{"x_scale": 0.5, "y_scale": 0.5})
worksheet.merge_range('B6:B8', 'NOHA', blue_header_format)
worksheet.merge_range('C6:C8', 'PDA', blue_header_format)
worksheet.merge_range('D6:D8', 'PI', blue_header_format)
worksheet.merge_range('E6:E8', 'FECHA', blue_header_format)

worksheet.merge_range('F6:G7', 'CLIENTE', blue_header_format)
worksheet.write('F8', 'NUMERO', blue_header_format)
worksheet.write('G8', 'NOMBRE CORTO', blue_header_format)

worksheet.merge_range('H6:H8', 'MONEDA', blue_header_format)

worksheet.merge_range('I6:O6', 'DERECHOS ADQUIRIDOS', blue_header_format)
worksheet.merge_range('I7:J7', 'IMPORTE TOTAL SIN IVA', blue_header_format)
worksheet.write('I8', 'MN', blue_header_format)
worksheet.write('J8', 'DLLS', blue_header_format)


worksheet.merge_range('K7:L7', 'COBRADO', blue_header_format)
worksheet.write('K8', 'MN', blue_header_format)
worksheet.write('L8', 'DLLS', blue_header_format)


worksheet.merge_range('M7:N7', 'POR COBRAR', blue_header_format)
worksheet.write('M8', 'MN', blue_header_format)
worksheet.write('N8', 'DLLS', blue_header_format)


worksheet.merge_range('O7:O8', '% POR COBRAR DEL PEDIDO INTERNO', blue_header_format)

worksheet.merge_range('P6:S6', 'DERECHOS ADQUIRIDOS POR COBRAR', blue_header_format)
worksheet.merge_range('P7:Q7', 'FACTURADO', blue_header_format)
worksheet.write('P8', 'MN', blue_header_format)
worksheet.write('Q8', 'DLLS', blue_header_format)


worksheet.merge_range('R7:S7', 'POR FACTURAR', blue_header_format)
worksheet.write('R8', 'MN', blue_header_format)
worksheet.write('S8', 'DLLS', blue_header_format)
#llenando la tabla
xcobrar_mn=0
xcobrar_dlls=0
x_mn=0
xcobrar_dlls=0
for i in range(0,len(pedidos)):
   row_index=str(9+i)
   #datos generales del pedido
   worksheet.write('B'+row_index, str(pedidos['noha'].values[i]), blue_content)
   worksheet.write('C'+row_index, str(i+1), blue_content)
   worksheet.write('D'+row_index, str(pedidos['invoice'].values[i]), blue_content)
   worksheet.write('E'+row_index, str(pedidos['reg_date'].values[i]), blue_content)
   worksheet.write('F'+row_index, str(pedidos['clave'].values[i]), blue_content)
   worksheet.write('G'+row_index, str(pedidos['alias'].values[i]), blue_content)
   worksheet.write('H'+row_index, str(pedidos['coin'].values[i]), blue_content)
   #total
   if(pedidos['coin_id'].values[i]==1):
      worksheet.write('I'+row_index, pedidos['total'].values[i], blue_content)
      worksheet.write('J'+row_index, 0, blue_content_dll)
   else:
      worksheet.write('I'+row_index, 0, blue_content)
      worksheet.write('J'+row_index, pedidos['total'].values[i], blue_content_dll)
#cobrado
   if(pedidos['coin_id'].values[i]==1):
      worksheet.write('K'+row_index, cobros.loc[cobros['order_id']==pedidos['id'].values[i],'amount'].sum(), blue_content)
      worksheet.write('L'+row_index, 0, blue_content_dll)
   else:
      worksheet.write('K'+row_index, 0, blue_content)
      worksheet.write('L'+row_index, cobros.loc[cobros['order_id']==pedidos['id'].values[i],'amount'].sum(), blue_content_dll)
   #por cobrar
   if(pedidos['coin_id'].values[i]==1):
      worksheet.write('M'+row_index, pedidos['total'].values[i]-cobros.loc[cobros['order_id']==pedidos['id'].values[i],'amount'].sum(), blue_content)
      worksheet.write('N'+row_index, 0, blue_content_dll)
   else:
      worksheet.write('M'+row_index, 0, blue_content)
      worksheet.write('N'+row_index,pedidos['total'].values[i]- cobros.loc[cobros['order_id']==pedidos['id'].values[i],'amount'].sum(), blue_content_dll)
   
   worksheet.write('O'+row_index, "{:.2f}".format((pedidos['total'].values[i]- cobros.loc[cobros['order_id']==pedidos['id'].values[i],'amount'].sum())*100/pedidos['total'].values[i])+"%", blue_content)
   #facturado
   if(pedidos['coin_id'].values[i]==1):
      worksheet.write('P'+row_index, (facturas.loc[facturas['order_id']==pedidos['id'].values[i],'amount'].sum()-creditos.loc[creditos['order_id']==pedidos['id'].values[i],'amount'].sum()), blue_content)
      worksheet.write('Q'+row_index, 0, blue_content_dll)
   else:
      worksheet.write('P'+row_index, 0, blue_content)
      worksheet.write('Q'+row_index,pedidos['total'].values[i]- (facturas.loc[facturas['order_id']==pedidos['id'].values[i],'amount'].sum()-creditos.loc[creditos['order_id']==pedidos['id'].values[i],'amount'].sum()), blue_content_dll)
  
   #por facturar
   if(pedidos['coin_id'].values[i]==1):
      worksheet.write('R'+row_index, pedidos['total'].values[i]-facturas.loc[facturas['order_id']==pedidos['id'].values[i],'amount'].sum()+creditos.loc[creditos['order_id']==pedidos['id'].values[i]], blue_content)
      worksheet.write('S'+row_index, 0, blue_content_dll)
   else:
      worksheet.write('R'+row_index, 0, blue_content)
      worksheet.write('S'+row_index,pedidos['total'].values[i]- facturas.loc[facturas['order_id']==pedidos['id'].values[i],'amount'].sum()+creditos.loc[creditos['order_id']==pedidos['id'].values[i]], blue_content_dll)
  
trow=9+len(pedidos)

worksheet.write('H'+str(trow), 'Subtotales', blue_header_format_bold)
#SUBTOTAL PEDIDOS MN
worksheet.write('I'+str(trow), pedidos.loc[pedidos['coin_id']==1,'subtotal'].sum(), blue_content_bold)
#SUBTOTAL PEDIDOS DLLS
worksheet.write('J'+str(trow), pedidos.loc[pedidos['coin_id']!=1,'subtotal'].sum(), blue_content_bold)
#TOTAL COBRADO MN
worksheet.write_formula('K'+str(trow),  '{=SUM(K9:K'+str(trow-1)+')}', blue_content_bold)
#TOTAL COBRADO DLLS
worksheet.write_formula('L'+str(trow),  '{=SUM(L9:L'+str(trow-1)+')}', blue_content_bold)
#TOTAL POR COBRAR MN
worksheet.write_formula('M'+str(trow),  '{=SUM(M9:M'+str(trow-1)+')}', blue_content_bold)
#TOTAL POR COBRAR DLLS
worksheet.write_formula('N'+str(trow),  '{=SUM(N9:N'+str(trow-1)+')}',blue_content_bold)
#porcentake
# worksheet.write('O'+str(trow+1), "{:.2f}".format((pedidos['total'].sum()- cobros['amount'].sum())*100/pedidos['subtotal'].sum())+"%", blue_content_bold)
#TOTAL FACTURADOR DLLS
worksheet.write_formula('P'+str(trow),  '{=SUM(P9:P'+str(trow-1)+')}', blue_content_bold)
#TOTAL POR FACTURAR MN
worksheet.write_formula('Q'+str(trow),  '{=SUM(Q9:Q'+str(trow-1)+')}', blue_content_bold)
#TOTAL POR FACTURAR DLLS
worksheet.write_formula('R'+str(trow),  '{=SUM(R9:R'+str(trow-1)+')}',blue_content_bold)
worksheet.write_formula('S'+str(trow),  '{=SUM(S9:S'+str(trow-1)+')}',blue_content_bold)


#TOTALES TOTAL DE ADEBIS
worksheet.write('H'+str(trow), 'Subtotales', blue_header_format_bold)
worksheet.merge_range('I'+str(trow+1)+':J'+str(trow+1),' ',blue_content_bold)
worksheet.write_formula('I'+str(trow+1)+':J'+str(trow+1),  '{=(I'+str(trow)+'+J'+str(trow)+' * '+str(tc)+')}',blue_content_bold)

worksheet.write('I'+str(trow+2), 'TC', blue_header_format_bold)
worksheet.write('J'+str(trow+2),tc , blue_content_bold)


worksheet.merge_range('K'+str(trow+1)+':L'+str(trow+1),' ',blue_content_bold)
worksheet.write_formula('K'+str(trow+1)+':L'+str(trow+1),  '{=(K'+str(trow)+'+L'+str(trow)+' * '+str(tc)+')}',blue_content_bold)
worksheet.write('K'+str(trow+2), 'TC', blue_header_format_bold)
worksheet.write('L'+str(trow+2),tc , blue_content_bold)


worksheet.merge_range('M'+str(trow+1)+':N'+str(trow+1),' ',blue_content_bold)
worksheet.write_formula('M'+str(trow+1)+':N'+str(trow+1),  '{=(M'+str(trow)+'+N'+str(trow)+' * '+str(tc)+')}',blue_content_bold)
worksheet.write('M'+str(trow+2), 'TC', blue_header_format_bold)
worksheet.write('N'+str(trow+2),tc , blue_content_bold)


worksheet.merge_range('P'+str(trow+1)+':Q'+str(trow+1),' ',blue_content_bold)
worksheet.write_formula('P'+str(trow+1)+':Q'+str(trow+1),  '{=(P'+str(trow)+'+Q'+str(trow)+' * '+str(tc)+')}',blue_content_bold)
worksheet.write('P'+str(trow+2), 'TC', blue_header_format_bold)
worksheet.write('Q'+str(trow+2),tc , blue_content_bold)


worksheet.merge_range('R'+str(trow+1)+':S'+str(trow+1),' ',blue_content_bold)
worksheet.write_formula('R'+str(trow+1)+':S'+str(trow+1),  '{=(R'+str(trow)+'+S'+str(trow)+' * '+str(tc)+')}',blue_content_bold)
worksheet.write('R'+str(trow+2), 'TC', blue_header_format_bold)
worksheet.write('S'+str(trow+2),tc , blue_content_bold)


# worksheet.write('K'+str(trow), str(cobros['amount'].sum()), blue_content)
# worksheet.write('L'+str(trow), str(cobros['exchange_sell'].values[0]*cobros['amount'].sum()), blue_content_bold)

worksheet.set_column('L:L',15)
worksheet.set_column('G:G',15)
worksheet.set_column('H:H',15)
worksheet.set_column('I:N',15)
worksheet.set_column('P:T',15)

#worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
workbook.close()