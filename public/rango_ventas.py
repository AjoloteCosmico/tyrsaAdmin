import sys
import mysql.connector
import numpy as np
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
#TODO: inciroirar el año desde el server al variable year
clientes=pd.read_sql("""select  SUM(internal_orders.total) as total,COUNT(internal_orders.id) as pi,customers.customer,customers.clave from customers inner join internal_orders
                     on internal_orders.customer_id = customers.id
                     where internal_orders.date > '2024-01-01' 
                     group by customers.customer,customers.clave order by total """,cnx)

#traer datos de los pedidos
pedidos=pd.read_sql("""Select internal_orders.* ,customers.clave,customers.alias,
coins.exchange_sell, coins.coin, coins.symbol, coins.code
from ((
    internal_orders
    inner join customers on customers.id = internal_orders.customer_id )
    inner join coins on internal_orders.coin_id = coins.id) 
     """,cnx)

objetivo=pd.read_sql("""select * 
                     from settings""",cnx)['objetivo_anual'].values[0]


nordenes=len(pedidos)
df=pedidos[['date']]

tc=pd.read_sql('select * from coins where id=13 ',cnx)['exchange_sell'].values[0]
writer = pd.ExcelWriter('storage/report/rango_ventas1.xlsx', engine='xlsxwriter')
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
    'border': 1,
    'num_format': '[$$-409]#,##0.00'})
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


import datetime

currentDateTime = datetime.datetime.now()
date = currentDateTime.date()
year = date.strftime("%Y")
rangos=[
        [0,50],
        [51,100],
        [101,200],
        [301,400],
        [401,500],
        [500,600],
        [601,700],
        [701,800],
        [801,900],
        [901,1000],
        [1000,2000],
        [2001,3000],
        [3001,99000]
        ]
dias_transcurridos=date-datetime.date(int(year), 1, 1)
#Columna para filtrar por fechas
pedidos['date']=pd.to_datetime(pedidos['date'])
pedidos=pedidos.loc[pedidos['date']>year+'-01-01']
df[0:1].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=6, header=False, index=False)
worksheet = writer.sheets['Sheet1']
#Encabezado del documento--------------
worksheet.merge_range('B2:F2', 'CUENTAS POR COBRAR REPORTE 3/8', negro_b)
worksheet.merge_range('B3:F3', 'RANGO DE VENTAS POR CLIENTE', negro_s)

worksheet.write('H2', 'AÑO', negro_b)
worksheet.write('I2', year, negro_b)
worksheet.merge_range('J2:K3', """FECHA DEL REPORTE
DD/MM/AAAA""", negro_b)
worksheet.merge_range('J4:K4', date, negro_b)
worksheet.insert_image("A1", "img/logo/logo.png",{"x_scale": 0.6, "y_scale": 0.6})
#Cual es el rango con mas filas?
max_rows=0
n=0
for i in rangos:
    li=i[0]*1000
    ls=i[1]*1000
    target_clientes=clientes.loc[(clientes['total']>=li)&(clientes['total']<=ls)]
    if(len(target_clientes)>max_rows):
         max_rows=len(target_clientes)
#Tablas de cada rango en fila
for i in rangos:
    
    print('de',i[0],'a',i[1])
    li=i[0]*1000
    ls=i[1]*1000
    target_clientes=clientes.loc[(clientes['total']>=li)&(clientes['total']<=ls)]
    if(len(target_clientes)>0):
        worksheet.merge_range(6,n*4+1,6,n*4+4,'DE '+str(i[0])+' A '+str(i[1]), blue_header_format)
        worksheet.write(7,n*4+1,'NO.', blue_header_format)
        worksheet.write(7,n*4+2,'CLIENTE', blue_header_format)
        worksheet.write(7,n*4+3,'PI', blue_header_format)
        worksheet.write(7,n*4+4,'TOTAL', blue_header_format)
        for j in range(len(target_clientes)):
            print(target_clientes['total'].values[j],target_clientes['customer'].values[j])
            worksheet.write(8+j,n*4+1,target_clientes['clave'].values[j].replace(' ',''), blue_content)
            worksheet.write(8+j,n*4+2,target_clientes['customer'].values[j], blue_content)
            worksheet.write(8+j,n*4+3,target_clientes['pi'].values[j], blue_content_unit)
            worksheet.write(8+j,n*4+4,target_clientes['total'].values[j], blue_content)
        for j in np.arange(len(target_clientes),max_rows,1):
            worksheet.write(8+j,n*4+1,' ', blue_content)
            worksheet.write(8+j,n*4+2,' ', blue_content)
            worksheet.write(8+j,n*4+3,' ', blue_content)
            worksheet.write(8+j,n*4+4,' ', blue_content)

        worksheet.merge_range(8+max_rows,n*4+1,8+max_rows,n*4+3,'TOTAL', blue_header_format)
        worksheet.write(8+max_rows,n*4+4,target_clientes['total'].sum(), blue_header_format)

        n=n+1

 
# Tablas inferiores
worksheet.write(11+max_rows,1,'CANATIDAD', blue_header_format)
worksheet.write(11+max_rows,2,'RANGO', blue_header_format)
worksheet.write(11+max_rows,3,'$', blue_header_format)
worksheet.write(11+max_rows,4,'% EN PI', blue_header_format)
worksheet.write(11+max_rows,5,'% EN $', blue_header_format)

#Tabla de resumen de rangos
n=0
for i in rangos:
    li=i[0]*1000
    ls=i[1]*1000
    target_clientes=clientes.loc[(clientes['total']>=li)&(clientes['total']<=ls)]
    if(len(target_clientes)>0):
        worksheet.write(12+max_rows+n,1,target_clientes['pi'].sum(),blue_content_unit)
        worksheet.write(12+max_rows+n,2,'DE '+str(i[0])+' A '+str(i[1]),blue_content)
        worksheet.write(12+max_rows+n,3,target_clientes['total'].sum(),blue_content)
        worksheet.write(12+max_rows+n,4,str(round(target_clientes['pi'].sum()*100/clientes['pi'].sum(),2))+'%',blue_content_unit)
        worksheet.write(12+max_rows+n,5,str(round(target_clientes['total'].sum()*100/clientes['total'].sum(),2))+'%',blue_content_unit)
        n=n+1



worksheet.merge_range(11+max_rows,7,11+max_rows,8,'SUMA DE PEDIDOS AL AÑO', blue_header_format)
worksheet.write(11+max_rows,9,str(clientes['pi'].sum()),blue_content_bold)
worksheet.merge_range(12+max_rows,7,12+max_rows,8,'VENTAS EN MONEDA NACIONAL', blue_header_format)
worksheet.write(12+max_rows,9,clientes['total'].sum(),blue_content_bold)
#AGRANDAR CPLUMNAS
worksheet.set_column('A:A',15)
worksheet.set_column('C:C',33)
worksheet.set_column('F:F',20)

worksheet.set_column('G:G',33)

worksheet.set_column('J:J',20)
worksheet.set_column('K:K',33)

worksheet.set_column('N:N',20)
worksheet.set_column('O:O',33)

worksheet.set_column('R:R',20)
worksheet.set_column('S:S',33)

#worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
worksheet.set_landscape() 
#Hoja de graficas

worksheet_charts = workbook.add_worksheet("Gráficas")
worksheet_charts.merge_range('B2:F2', 'CUENTAS POR COBRAR REPORTE 3/8', negro_b)
worksheet_charts.merge_range('B3:F3', 'RANGO DE VENTAS POR CLIENTE', negro_s)

worksheet_charts.write('H2', 'AÑO', negro_b)
worksheet_charts.write('I2', year, negro_b)
worksheet_charts.merge_range('J2:K3', """FECHA DEL REPORTE
DD/MM/AAAA""", negro_b)
worksheet_charts.merge_range('L2:L3', date, negro_b)
worksheet_charts.insert_image("A1", "img/logo/logo.png",{"x_scale": 0.6, "y_scale": 0.6})

# Create a new chart object.
chart = workbook.add_chart({'type': 'pie','subtype': 'Monto por rango'})

# Add a series to the chart.
chart.add_series({'values': '=Sheet1!$D$'+str(12+max_rows)+':$D$'+str(12+max_rows+ len(rangos)),
                  'categories': '=Sheet1!$C$'+str(12+max_rows)+':$C$'+str(12+max_rows+ len(rangos)),
                  'percentage': True,
                    'leader_lines': True,
                    'position': 'best_fit',
                    'data_labels': {
                    'value': True,
                    'font': {'color': 'gray','size': 10}
                }})


# Insert the chart into the worksheet.
worksheet_charts.insert_chart('B5', chart,{'x_scale': 2.15, 'y_scale': 1.35})


# Create a new chart object.
chart = workbook.add_chart({'type': 'pie','subtype': 'No. PI por rango'})
chart.set_title({
    'name': 'Np. PI por rango'})
# Add a series to the chart.
chart.add_series({'values': '=Sheet1!$B$'+str(12+max_rows)+':$B$'+str(12+max_rows+ len(rangos)),
                  'categories': '=Sheet1!$C$'+str(12+max_rows)+':$C$'+str(12+max_rows+ len(rangos)),
                   'categories': '=Sheet1!$C$'+str(12+max_rows)+':$C$'+str(12+max_rows+ len(rangos)),
                  'percentage': True,
                    'leader_lines': True,
                    'position': 'best_fit',
                    'data_labels': {
                    'value': True,
                    'font': {'color': 'gray','size': 10}}
                  })


# Insert the chart into the worksheet.
worksheet_charts.insert_chart('B25', chart,{'x_scale': 2.15, 'y_scale': 1.35})




workbook.close()
                