import sys
import mysql.connector
import xlsxwriter
from xlsxwriter.utility import xl_rowcol_to_cell
import pandas as pd
import sys
import mysql.connector
import os
from dotenv import load_dotenv
import datetime
from dateutil.relativedelta import relativedelta
import numpy as np

year = datetime.date.today().year
quincena=int(sys.argv[1])+1
# quincena=2
month = np.ceil(quincena/ 2)
isFirstHalf = quincena % 2 != 0
startDate =  str(year)+"-"+str(int(month)).zfill(2)+"-01" if isFirstHalf else  str(year)+"-"+str(int(month)).zfill(2)+"-16"
endDate =  str(year)+"-"+str(int(month)).zfill(2)+"-15" if isFirstHalf else  str((datetime.datetime(year,int(month),1 )+relativedelta(months=1))-datetime.timedelta(days=1))[:10];

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
programados=pd.read_sql('select * from payments',cnx)
clientes=pd.read_sql("""select  * from customers """,cnx)
bancos=pd.read_sql("""select  * from banks """,cnx)

pedidos=pd.read_sql("""Select internal_orders.* ,customers.clave,customers.alias,
coins.exchange_sell, coins.coin, coins.symbol, coins.code,sellers.seller_name
from (((
    internal_orders
    inner join customers on customers.id = internal_orders.customer_id )
    inner join coins on internal_orders.coin_id = coins.id)
    inner join  sellers on sellers.id=internal_orders.seller_id)
                    where status!='CANCELADO'
     """,cnx)

cobros=pd.read_sql("""select cobro_orders.*,cobros.comp,cobros.date,cobros.bank_id,
                   internal_orders.customer_id,internal_orders.invoice,internal_orders.noha,
                   internal_orders.seller_id,internal_orders.comision,internal_orders.total
                     from (((
                         cobro_orders 
    inner join cobros on cobros.id=cobro_orders.cobro_id)
    inner join internal_orders on internal_orders.id = cobros.order_id )
    inner join coins on internal_orders.coin_id = coins.id)
                   where cobros.date >= '"""+startDate+"' and cobros.date <= '"+endDate+"'",cnx)


facturas=pd.read_sql("""select factures.*,cobro_factures.cobro_id
                     from (((
                         factures
    inner join internal_orders on internal_orders.id = factures.order_id )
    inner join cobro_factures on cobro_factures.facture_id=factures.id )
    inner join coins on internal_orders.coin_id = coins.id) """,cnx)

creditos=pd.read_sql("""select * 
                     from ((
                         credit_notes    inner join internal_orders on internal_orders.id = credit_notes.order_id )
    inner join coins on internal_orders.coin_id = coins.id) """,cnx)

vendedores=pd.read_sql("""select * 
                     from sellers where status = 'ACTIVO'""",cnx)
socios=pd.read_sql("select * from sellers where  dgi > 0",cnx)

no_socios=pd.read_sql("select * from sellers where status='ACTIVO' and dgi <= 0",cnx)
comisiones=pd.read_sql("""select * 
                     from comissions""",cnx)

nordenes=len(pedidos)
df=pedidos[['date']]

tc=pd.read_sql('select * from coins where id=13 ',cnx)['exchange_sell'].values[0]
writer = pd.ExcelWriter('storage/report/dgi_resumen_venta'+str(quincena-1)+'.xlsx', engine='xlsxwriter')
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
    'font_size':11})
firmas = workbook.add_format({
    'bold': 0,
    'top': 1,
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
divisor = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'center',
    'bg_color': '#696e78',
    'border': 0,})

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
blue_content_red = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'red',
    
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

total_cereza_format = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#F4B084',
    'border': 1})


import datetime

currentDateTime = datetime.datetime.now()
date = currentDateTime.date()
year = date.strftime("%Y")
#Columna para filtrar por fechas
pedidos['date']=pd.to_datetime(pedidos['date'])

# -------------HOJA DE RESUMEN
worksheet= workbook.add_worksheet("Resumen")
#Encabezado del documento--------------

worksheet.write('G2', 'AÑO', negro_b)

worksheet.write('H2', year, negro_b)
worksheet.merge_range('G2:H3', """FECHA DEL REPORTE
DD/MM/AAAA""", negro_b)
worksheet.merge_range('I2:I3', date, negro_b)
worksheet.insert_image("A1", "img/logo/logo.png",{"x_scale": 0.6, "y_scale": 0.6})

worksheet.merge_range('B3:F4', """TABLA DE VENDEDORES PARA PAGO DE COMISIONES  
                      DGI PARA NIVELES DIRECTIVOS""", negro_s)

worksheet.merge_range('B5:F5', "Se reporta del "+str(startDate) +" al "+ str(endDate), negro_s)
##SEGUNDA TABLA DE RESUMEN VENTAS DIRECTAS
#Cabeceras
worksheet.merge_range(5,3,8,3,"""SIN IVA
comision generada por el monto""",blue_header_format)
worksheet.merge_range(5,4,8,4,"""
PEDIDO INTERNO""",blue_header_format)
worksheet.write(5,5,'No. vendedor',blue_header_format)
worksheet.write(6,5,'Iniciales',blue_header_format)
worksheet.write(7,5,'Nombre corto',blue_header_format)
worksheet.write(8,5,'comp.Ingesos',blue_header_format)
#total de cada xobro columna
for i in range(len(cobros)):
    worksheet.write(9+i,3,cobros['amount'].values[i]/1.16,blue_content)
    worksheet.write(9+i,4,cobros['invoice'].values[i],blue_content)
    worksheet.write(9+i,5,cobros['comp'].values[i],blue_content)
for i in range(len(no_socios)):
    this_comisions=comisiones.loc[comisiones['seller_id']==no_socios['id'].values[i]]
    worksheet.write(5,6+i,str(i+1),blue_header_format)
    worksheet.write(6,6+i,no_socios['iniciales'].values[i],blue_header_format)
    worksheet.write(7,6+i,str(no_socios['seller_name'].values[i]).split()[-1],blue_header_format)
    worksheet.write(8,6+i,'comision $',blue_header_format)
    worksheet.write(len(cobros)+10, 6+i,str(no_socios['seller_name'].values[i]).split()[-1],blue_content_footer)
    for j in range(len(cobros)):
        comision_secundaria=this_comisions.loc[this_comisions['order_id']==cobros['order_id'].values[j]]
        amount=0
        if(cobros['seller_id'].values[j]==no_socios['id'].values[i]):
           amount=(cobros['amount'].values[j])*cobros['comision'].values[j]
        
        if(len(comision_secundaria)>0):
           amount=(cobros['amount'].values[j])*comision_secundaria['percentage'].values[0]
        worksheet.write(9+j,6+i,amount/1.16,blue_content)

for i in range(len(no_socios)):
        # Definir el rango para la fórmula
    start_cell = xl_rowcol_to_cell(9, 6+i)  # Primera celda (0, 0 -> A1)
    end_cell = xl_rowcol_to_cell(len(cobros) - 1, 6+i) 
    # Crear la fórmula SUM para sumar la columna
    formula = f"=SUM({start_cell}:{end_cell})"

    # Escribir la fórmula en una celda (por ejemplo, en la fila 6, columna 1 -> A6)
    worksheet.write_formula(len(cobros)+9, 6+i, formula,blue_footer_format_bold)

worksheet.write_formula(len(cobros)+9, 3, f"=SUM(D10:D"+str(len(cobros)+9)+")",blue_footer_format_bold)

#AGRANDAR CPLUMNAS
worksheet.set_column('A:A',15)

worksheet.set_column('D:D',21)
worksheet.set_column('F:F',25)
worksheet.set_column('G:G',35)
worksheet.set_column('E:O',18)
worksheet.set_column('P:T',15)
worksheet.set_column('U:AX',19)
worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
workbook.close()
