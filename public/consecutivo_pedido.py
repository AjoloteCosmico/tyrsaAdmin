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
query = ('SELECT i.reg_date,i.invoice, i.status,i.total, i.subtotal, i.description, i.category, c.clave, c.alias, c.customer_suburb, c.customer, coins.code, coins.coin, coins.exchange_sell from internal_orders as i INNER JOIN customers as c on c.id = i.customer_id INNER JOIN coins on coins.id = i.coin_id;')
orders=pd.read_sql(query,cnx)
writer = pd.ExcelWriter('storage/report/consecutivo_pedido'+str(id)+'.xlsx', engine='xlsxwriter')
workbook = writer.book
##FORMATOS PARA EL TITULO---------------------------------------
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

#FORMATOS PARA CABECERAS DE TABLA --------------------------------
header_format = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'center',
    'fg_color': 'yellow',
    'border': 1})

blue_header_format = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'border_color':'blue',
    'border': 1})

blue_hf = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'border_color':'blue',
    'font_color': 'blue',
    'border': 1})


#FORMATOS PARA TABLAS PER CE------------------------------------
tabla_normal = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12})
    
tabla_prog = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#F4B084',
    'border': 1,
    'border_color':'blue',})
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

#azul blanco------------------------------------------
b1no = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'font_size':12,
    'top': 1,
    'left': 1,
    'border_color': '#0094FF'})
    
b1n = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'font_size':13,
    'top': 1,
    'border_color': '#0094FF'})
    
b1ne = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'font_size':13,
     'top': 1,
    'right': 1,
    'border_color': '#0094FF'})
    
b1e = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'font_size':13,
    'right': 1,
    'border_color': '#0094FF'})
    
b1se = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'font_color':'#00D91A',
    'right': 1,
    'bottom': 1,
    'border_color': '#0094FF'})
    
b1s = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'bottom': 1,
    'border_color': '#0094FF'})
    
b1so = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'bottom': 1,
    'left': 1,
    'border_color': '#0094FF'})

b1o = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'left': 1,
    'border_color': '#0094FF'})

 #-------------------------------------------------
 # AZUL ROJO
 
b2n = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#F4B084',
    'font_size':13,
    'top': 1,
    'left': 1,
    'right': 1,
    'border_color': '#0094FF'})
    
b2c = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#F4B084',
    'font_size':12,
    'left': 1,
    'right': 1,
    'border_color': '#0094FF'})
    
b2s = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#F4B084',
    'font_size':13,
    'font_color':'#00D91A',
    'left': 1,
    'right': 1,
    'bottom':1,
    'border_color': '#0094FF'})
    
#---------------negro AMARILLO
b3n = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color': 'yellow',
    'font_size':13,
    'top': 1,
    'left': 1,
    'right': 1,})
    
b3c = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color': 'yellow',
    'font_size':12,
    'left': 1,
    'right': 1,})
    
b3s = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color': 'yellow',
    'font_size':13,
    'font_color':'#00D91A',
    'left': 1,
    'right': 1,
    'bottom':1,})
    
    #---------------NEGRO ROJO
totales_rojo= workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#F4B084',
    'font_size':13,
    })
    
totales_verde = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#F4B084',
    'font_size':13,
    'font_color':'green',
    })
    
b4s = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#F4B084',
    'font_size':12,
    'font_color':'#00D91A',
    'left': 1,
    'right':1,
    'bottom':1})

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
    'num_format': '"R" #,##0.00'})

blue_content_bold = workbook.add_format({
    'bold': True,
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12,
    'border_color':a_color,
    'font_size':13,
    'num_format': '"R" #,###'})
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
    
#dataframes

orders['reg_date'].to_excel(writer, sheet_name='Sheet1', startrow=14,startcol=3, header=False, index=False)
worksheet = writer.sheets['Sheet1']
#worksheet.set_column(2,19,15)
# Encabezado.
worksheet.merge_range('G2:N2', 'TYRSA CONSORCIO S.A. DE C.V. ', rojo_g)
worksheet.merge_range('G3:N3', 'Soluciones en logistica interior', negro_s)
worksheet.merge_range('G4:N4', 'CONSECUTIVO DE PEDIDOS INTERNOS' ,negro_b)
worksheet.merge_range('G5:N5', 'Control de Cobros por P.I.', rojo_b)
worksheet.write('O4', "AÑO", negro_b)
worksheet.write('P4', "2022", negro_b)
worksheet.write('O6', "ACUMULADO", blue_header_format)
worksheet.write('O7', "$"+str(orders["total"].sum()), blue_content)
worksheet.write('O8', "HASTA EL ULTIMO PEDIDO", blue_content)

worksheet.set_column(14, 14, 20)
worksheet.write('L10', "$0.0", blue_header_format)
worksheet.write('M10', "$0.0", blue_header_format)
worksheet.write('N10', "NA", blue_header_format)
worksheet.write('O10', "$"+str(orders["total"].sum()), blue_content_bold)

#Headers del dataframe
worksheet.set_column(3, 3, 20)
worksheet.merge_range('C12:C14', 'PDA \n NHO \n 2022', blue_header_format)
worksheet.merge_range('D12:D14', 'FECHA DE EMISION  \n DD-MM-AA', blue_header_format)
worksheet.merge_range('E12:E14', 'PEDIDO INTERNO NO.', blue_header_format)

worksheet.merge_range('F12:G12', 'CLIENTE', blue_header_format)
worksheet.merge_range('F13:F14', 'NUMERO', blue_header_format)
worksheet.merge_range('G13:G14', 'NOMBRE CORTO', blue_header_format)

worksheet.merge_range('H12:H14', 'CATEGORIA DEL EQUIPO', blue_header_format)
worksheet.merge_range('I12:I14', 'DESCRIPCION BREVE', blue_header_format)
worksheet.merge_range('J12:J14', 'UBICACION/SUCURSAL/TIENDA/PROYECTO', blue_header_format)
worksheet.merge_range('K12:K14', 'MONEDA', blue_header_format)

worksheet.merge_range('L12:O12', 'IMPORTE TOTAL SIN IVA', blue_header_format)
worksheet.merge_range('L13:M13', 'MONEDA EXTRANJERA', blue_header_format)
worksheet.write('L14', 'NOMBRE', blue_header_format)
worksheet.write('M14', 'IMPORTE', blue_header_format)
worksheet.merge_range('N13:N14', 'TIPO DE CAMBIO', blue_header_format)
worksheet.merge_range('O13:O14', 'M.N. (EQUIVALENTE)', blue_header_format)

worksheet.merge_range('P12:P14', 'ACUMULADO EN MONEDA NACIONAL (EQUIVALENTE) I/I', blue_header_format)
worksheet.merge_range('Q12:Q14', 'STATUS', blue_header_format)
acumulado=0
#Llenar la tabla
for i in range(0,len(orders)):
     acumulado=acumulado+orders["total"].values[i]*orders["exchange_sell"].values[i]
     worksheet.write(14+i, 2, i+1,blue_content)
     worksheet.write(14+i, 3, str(orders["reg_date"].values[i]),blue_content)
     worksheet.write(14+i, 4, str(orders["invoice"].values[i]),blue_content)
     worksheet.write(14+i, 5, str(orders["clave"].values[i]),blue_content)
     worksheet.write(14+i, 6, str(orders["alias"].values[i]),blue_content)
     worksheet.write(14+i, 7, str(orders["category"].values[i]),blue_content)
     worksheet.write(14+i, 8, str(orders["description"].values[i]),blue_content)
     worksheet.write(14+i, 9, str(orders["customer_suburb"].values[i]),blue_content)
     worksheet.write(14+i, 10, str(orders["coin"].values[i]),blue_content)
     worksheet.write(14+i, 11, str(orders["coin"].values[i]),blue_content)
     worksheet.write(14+i, 12, str(orders["subtotal"].values[i]),blue_content)
     worksheet.write(14+i, 13, str(orders["exchange_sell"].values[i]),blue_content)
     worksheet.write(14+i, 14, str(orders["subtotal"].values[i]*orders["exchange_sell"].values[i]),blue_content)
    
     worksheet.write(14+i, 15, str(orders["total"].values[i]),blue_content)
     worksheet.write(14+i, 16, orders["status"].values[i],tabla_normal)
     

workbook.close()

