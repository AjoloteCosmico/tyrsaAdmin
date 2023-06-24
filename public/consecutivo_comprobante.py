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
writer = pd.ExcelWriter("storage/report/consecutivo_comprobante"+str(id)+".xlsx", engine='xlsxwriter')
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


cobros['date'].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=2, header=False, index=False)

workbook = writer.book
##FORMATOS PARA EL TITULO---------------------------------------
azul_g = workbook.add_format({
    'bold': 1,
    'border': 0,
    'align': 'center',
    'valign': 'vcenter',
    #'fg_color': 'yellow',
    'font_color': '#0070C0',
    'font_size':17})
rojo_g = workbook.add_format({
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
 
azulito = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'fg_color': '#B4C6E7',
    'font_size':12})
#FORMATOS PARA CABECERAS DE TABLA --------------------------------
header_format = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color': 'yellow',
    'border': 1})

header_format_green = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color': 'yellow',
    'font_color':'green',
    'border': 1})
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
    'border_color':a_color,
    'num_format': '#,###'})

blue_content_bold = workbook.add_format({
    'bold': True,
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12,
    'border_color':a_color,
    'font_size':13,
    'num_format': '#,###'})
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
    'border_color':b_color,
    'num_format': '#,###'})

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
    'border_color':'#80848E',
    'num_format': '#,###'})

#FORMATOS PARA TABLAS PER CE------------------------------------
tabla_normal = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12})
    
worksheet = writer.sheets['Sheet1']
# Encabezado.
worksheet.merge_range('G2:N2', 'CONSECUTIVO DE COMPROBANTE DE INGRESOS ', azul_g)
worksheet.merge_range('G3:N3', 'CUENTAS COBRADAS DE PEDIDOS INTERNOS', azul_g)



#Dataframe yellow headers bitch xd
worksheet.merge_range('B6:B7', 'NOH', blue_header_format)
worksheet.merge_range('C6:C7', 'FECHA D-M-A', blue_header_format)
worksheet.merge_range('D6:D7', 'P.I. NO.', blue_header_format)
worksheet.merge_range('E6:E7', 'NUMERO DE COBROS', blue_header_format)
worksheet.merge_range('F6:F7', 'NUMERO TOTAL DE COBROS', blue_header_format)
worksheet.merge_range('G6:G7', 'FACTURA FOLIO NO.', blue_header_format)
worksheet.merge_range('H6:H7', 'CLIENTE NO', blue_header_format)
worksheet.merge_range('I6:I7', 'NOMBRE CORTO CLIENTE', blue_header_format)
worksheet.merge_range('J6:J7', 'CATEGORIA EQUIPO', blue_header_format)
worksheet.merge_range('K6:K7', 'DESCRIPCION BREVE', blue_header_format)
worksheet.merge_range('L6:L7', 'UBI / SUC / TIENDA PROYECTO', blue_header_format)
worksheet.merge_range('M6:M7', 'TIPO DE MONEDA', blue_header_format)
worksheet.merge_range('N6:N7', 'TIPO DE CAMBIO', blue_header_format)


worksheet.merge_range('O6:P6', 'IMPORTE TOTAL SIN IVA', blue_header_format)
worksheet.write(6, 14, "DLLS", blue_header_format_bold)
worksheet.write(6, 15, "M.N.(Equivalente)", blue_header_format)

worksheet.merge_range('Q6:Q7', 'CAPTURO', blue_header_format)
worksheet.merge_range('R6:R7', 'REVISO', blue_header_format)
worksheet.merge_range('S6:S7', 'AUTORIZO', blue_header_format)
worksheet.merge_range('T6:T7', 'STATUS', blue_header_format)

##columnas y tablas como tal pues
acum=0
for i in range(0,len(cobros)):
     acum=acum+cobros['amount'].values[i]*cobros['tc'].values[i]
     worksheet.write(7+i, 1, i+1,blue_content)
     worksheet.write(7+i, 2, str(cobros['date'].values[i]),blue_content)
     worksheet.write(7+i, 3, str(cobros['invoice'].values[i]),blue_content)
     worksheet.write(7+i, 4, str(cobros['ordinal'].values[i]),blue_content)
     worksheet.write(7+i, 5, str(cobros['payment_conditions'].values[i]),blue_content)
     worksheet.write(7+i, 6, str(cobros['facture'].values[i]),blue_content)
     worksheet.write(7+i, 7, str(cobros['clave'].values[i]),blue_content)
     worksheet.write(7+i, 8, str(cobros['customer'].values[i]),blue_content)
     worksheet.write(7+i, 9, str(cobros['category'].values[i]),blue_content)
     worksheet.write(7+i, 10, str(cobros['description'].values[i]),blue_content)
     worksheet.write(7+i, 11, str(cobros['customer_suburb'].values[i]),blue_content)
     worksheet.write(7+i, 12, str(cobros['coin'].values[i]),blue_content)
     worksheet.write(7+i, 13, str(cobros['tc'].values[i]),blue_content)
     worksheet.write(7+i, 14, str(cobros['amount'].values[i]),blue_content)
     worksheet.write(7+i, 15, str(cobros['amount'].values[i]*cobros['tc'].values[i]),blue_content)
     worksheet.write(7+i, 16, str(cobros['capturista'].values[i]),blue_content)
     worksheet.write(7+i, 17, str(cobros['revisor'].values[i]),blue_content)
     worksheet.write(7+i, 18, str(cobros['autorizador'].values[i]),blue_content)
     worksheet.write(7+i, 19, str(cobros['status'].values[i]),blue_content)

#barra inferior de totales
trow=8+len(cobros)
worksheet.merge_range(trow,12,trow,13 ,'Total sin iva', blue_header_format)
worksheet.write(trow, 14, cobros["amount"].sum(),blue_header_format_bold)
worksheet.write(trow, 15, acum,blue_header_format)
worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)       
workbook.close()



