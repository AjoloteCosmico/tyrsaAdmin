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
# id=str(sys.argv[1])
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
query = ('SELECT i.reg_date,i.invoice, i.noha,i.status,i.total, i.subtotal,i.date, i.description, i.category, c.clave, c.alias, c.customer_suburb, c.customer, coins.code, coins.coin, coins.exchange_sell from internal_orders as i INNER JOIN customers as c on c.id = i.customer_id INNER JOIN coins on coins.id = i.coin_id  ORDER BY i.invoice;')
orders=pd.read_sql(query,cnx)
writer = pd.ExcelWriter('storage/report/consecutivo_pedido1.xlsx', engine='xlsxwriter')
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
    'border': 1})
blue_header_format_bold = workbook.add_format({
    'bold': True,
    'bg_color': a_color,
    'text_wrap': True,
    'valign': 'vcenter',
    'align': 'center',
    'border_color':'white',
    'font_color': 'white',
    'border': 1,
    'num_format': '[$$-409]#,##0.00',
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
#FORMATOS PARA TABLAS PER CE------------------------------------

blue_content = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    
    'border_color':a_color,
    'font_size':10,
    'num_format': '[$$-409]#,##0.00'})
blue_content_unit = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    
    'border_color':a_color,
    'font_size':10,
    })


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
    'num_format': '[$$-409]#,##0.00'
    })

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

total_cereza_format = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#F4B084',
    'border': 1})
#dataframes

orders['reg_date'][0:4].to_excel(writer, sheet_name='Sheet1', startrow=14,startcol=3, header=False, index=False)
orders['clave'] = orders['clave'].replace({' ':''}, regex=True)
orders['code']=orders['code'].str.replace('MN','MXN')

worksheet = writer.sheets['Sheet1']
#worksheet.set_column(2,19,15)
# Encabezado.
worksheet.merge_range('G2:N2', 'TYRSA CONSORCIO S.A. DE C.V. ', rojo_l)
worksheet.merge_range('G3:N3', 'Soluciones en logistica interior', negro_s)
worksheet.merge_range('G4:N4', 'CONSECUTIVO DE PEDIDOS INTERNOS' ,negro_b)
worksheet.merge_range('G5:N5', 'Control de Cobros por P.I.', rojo_b)
worksheet.write('O4', "AÑO", negro_b)
import datetime

currentDateTime = datetime.datetime.now()
date = currentDateTime.date()
worksheet.write('P4', date.strftime("%Y"), negro_b)
worksheet.write('O6', "ACUMULADO", blue_header_format)
# worksheet.write('O7', orders.loc[orders['date'].astype(str)>date.strftime("%Y")+'-01-01',"total"].sum()/1.16, blue_content)
worksheet.write('O7','=SUM(O15:O'+str(len(orders)+13)+')', blue_content_bold)
worksheet.write('O8', "HASTA EL ULTIMO PEDIDO", blue_content)

worksheet.set_column(14, 14, 20)
# worksheet.write('L10', "$0.0", blue_header_format)
# worksheet.write('M10', "$0.0", blue_header_format)
# worksheet.write('N10', "NA", blue_header_format)

#Headers del dataframe
worksheet.set_column(3, 3, 20)

worksheet.insert_image("A1", "img/logo/logo.png",{"x_scale": 1, "y_scale": 1})
worksheet.merge_range('C12:C14', 'PDA \n NOHA \n '+str(date.strftime("%Y")), blue_header_format)
worksheet.merge_range('D12:D14', 'FECHA DE EMISION  \n DD-MM-AAAA', blue_header_format)
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
worksheet.merge_range('O13:O14', 'MXN (EQUIVALENTE)', blue_header_format)

worksheet.merge_range('P12:P14', 'ACUMULADO EN MONEDA NACIONAL (EQUIVALENTE) I/I', blue_header_format)
worksheet.merge_range('Q12:Q14', 'STATUS', blue_header_format)
acumulado=0
for col in ["category","description","customer_suburb","status"]:
     orders[col]=orders[col].str.upper()
orders["category"]=orders["category"].fillna('PRODUCTOS')
#Llenar la tabla
orders['reg_date']=pd.to_datetime(orders['reg_date'], format='%Y-%m-%d')
orders['reg_date']=orders['reg_date'].dt.strftime('%d-%m-%Y')
orders.loc[orders['status'] == 'CANCELADO','total']= 0
orders=orders.sort_values(by=['invoice'], ascending=True)
for i in range(0,len(orders)):
     acumulado=acumulado+((orders["total"].values[i])/1.16*orders["exchange_sell"].values[i])
     worksheet.write(14+i, 2, str(int(orders["noha"].values[i])),blue_content_unit)
     worksheet.write(14+i, 3, str(orders["reg_date"].values[i]),blue_content)
     worksheet.write(14+i, 4, str(int(orders["invoice"].values[i])),blue_content_unit)
     worksheet.write(14+i, 5, str(orders["clave"].values[i]),blue_content)
     worksheet.write(14+i, 6, str(orders["alias"].values[i])[:15],blue_content)
     worksheet.write(14+i, 7, str(orders["category"].values[i]),blue_content)
     worksheet.write(14+i, 8, str(orders["description"].values[i]),blue_content)
     worksheet.write(14+i, 9, str(orders["customer_suburb"].values[i])[:15],blue_content)
     worksheet.write(14+i, 10, str(orders["code"].values[i]),blue_content)
     if(orders["coin"].values[i]=='NACIONAL'):
        
        worksheet.write(14+i, 11, ' ',blue_content)
        worksheet.write(14+i, 12, '0',blue_content_dll)
     else:
        worksheet.write(14+i, 11, 'EXTRANJERA',blue_content)
        worksheet.write(14+i, 12, orders["total"].values[i]/1.16,blue_content_dll)
     worksheet.write(14+i, 13, "{:.4f}".format(orders["exchange_sell"].values[i]),blue_content)
     worksheet.write(14+i, 14, (orders["total"].values[i]*orders["exchange_sell"].values[i])/1.16,blue_content)
    
     worksheet.write(14+i, 15, acumulado,blue_content)
     worksheet.write(14+i, 16, orders["status"].values[i],blue_content_bold)

worksheet.merge_range('K'+str(len(orders)+15)+':L'+str(len(orders)+15), 'TOTALES', blue_header_format)
worksheet.write_formula('M'+str(len(orders)+15), '=SUM(M15:M'+str(len(orders)+13)+')', blue_content_bold_dll)
worksheet.write_formula('O'+str(len(orders)+15), '=SUM(O15:O'+str(len(orders)+13)+')', blue_content_bold)

worksheet.set_column('H:J',23)

worksheet.set_column('L:L',15)
worksheet.set_column('M:M',20)
worksheet.set_column('I:I',24)
worksheet.set_column('P:P',20)
worksheet.set_column('G:G',15)
worksheet.set_column('Q:Q',15) 

worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
workbook.close()