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
yellow_header_format = workbook.add_format({
    'bold': True,
    'bg_color': '#e8b321',
    'text_wrap': True,
    'valign': 'top',
    'align': 'center',
    'border_color':'white',
    'font_color': 'white',
    'border': 1})
green_header_format = workbook.add_format({
    'bold': True,
    'bg_color': '#2D936C',
    'text_wrap': True,
    'valign': 'top',
    'align': 'center',
    'border_color':'white',
    'font_color': 'white',
    'border': 1})

#FORMATOS PARA TABLAS PER CE------------------------------------

blue_content = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12,
    'border_color':a_color})

blue_content_bold = workbook.add_format({
    'bold': True,
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12,
    'border_color':a_color,
    'font_size':13})
yellow_content = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12,
    'border_color':'#e8b321'})
red_content = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12,
    'border_color':b_color})

green_content = workbook.add_format({
    'border': 3,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12,
    'border_color':b_color})
red_content_bold = workbook.add_format({
    'bold':True,
    'border': 3,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':13,
    'border_color':'#80848E'})
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


df.to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=6, header=False, index=False)
worksheet = writer.sheets['Sheet1']



#Encabezado del documento--------------

worksheet.merge_range('B2:G2', 'TYRSA CONSORCIO S.A. DE C.V. ', rojo_l)
worksheet.merge_range('B3:G3', 'RESUMEN DE COMPROBANTE DE INGRESOS', negro_s)
worksheet.merge_range('B4:G4', 'Cuentas Cobradas Pedidos Internos', rojo_b)
import datetime

currentDateTime = datetime.datetime.now()
date = currentDateTime.date()
year = date.strftime("%Y")
worksheet.write('H2', 'AÑO', negro_b)
worksheet.write('I2', year, negro_b)
worksheet.merge_range('J2:K3', """FECHA DEL REPORTE
DD/MM/AAAA""", negro_b)
worksheet.merge_range('J4:K4', date, negro_b)
worksheet.insert_image("A1", "img/logo/logo.png",{"x_scale": 0.6, "y_scale": 0.6})

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
   worksheet.write('D'+row_index, str(cobros['date'].values[i]), blue_content)
   worksheet.write('E'+row_index, str(cobros['comp'].values[i]), blue_content)
   worksheet.write('F'+row_index, str(cobros['bank_description'].values[i]), blue_content)
   worksheet.write('G'+row_index, str(cobros['facture'].values[i]), blue_content)
   worksheet.write('H'+row_index, str(cobros['invoice'].values[i]), blue_content)
   worksheet.write('I'+row_index, str(cobros['customer'].values[i]), blue_content)
   worksheet.write('J'+row_index, str(cobros['coin'].values[i]), blue_content)
   worksheet.write('K'+row_index, str(cobros['exchange_sell'].values[i]), blue_content)
   worksheet.write('L'+row_index, str(cobros['amount'].values[i]), blue_content)
   worksheet.write('M'+row_index, str(cobros['exchange_sell'].values[i]*cobros['amount'].values[i]), blue_content)
   
   worksheet.write('N'+row_index, str(cobros['capturista'].values[i]), blue_content)
   worksheet.write('O'+row_index, str(cobros['revisor'].values[i]), blue_content)
   worksheet.write('P'+row_index, str(cobros['autorizador'].values[i]), blue_content)
   
 
trow=8+len(cobros)

worksheet.merge_range('I'+str(trow)+':J'+str(trow), 'Total', blue_header_format_bold)
worksheet.write('K'+str(trow), str(cobros['amount'].sum()), blue_content)
worksheet.write('L'+str(trow), str(cobros['exchange_sell'].values[0]*cobros['amount'].sum()), blue_content_bold)
   


worksheet.set_column('A:A',16)

worksheet.set_column('I:J',17)
worksheet.set_column('L:L',15)
worksheet.set_column('H:H',15)

worksheet.set_column('N:P',16)
worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
workbook.close()