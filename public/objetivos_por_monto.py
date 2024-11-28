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
coins.exchange_sell, coins.coin, coins.symbol, coins.code
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
vendedores=pd.read_sql("""select * 
                     from sellers""",cnx)
objetivo=pd.read_sql("""select * 
                     from settings""",cnx)['objetivo_monto'].values[0]

print(cobros)
nordenes=len(pedidos)
df=pedidos[['date']]

tc=pd.read_sql('select * from coins where id=13 ',cnx)['exchange_sell'].values[0]
writer = pd.ExcelWriter('storage/report/objetivos_por_monto1.xlsx', engine='xlsxwriter')
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


import datetime

currentDateTime = datetime.datetime.now()
date = currentDateTime.date()
year = date.strftime("%Y")
dias_transcurridos=date-datetime.date(int(year), 1, 1)
#Columna para filtrar por fechas
pedidos['date']=pd.to_datetime(pedidos['date'])
pedidos=pedidos.loc[pedidos['date']>year+'-01-01']
df[0:1].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=6, header=False, index=False)
worksheet = writer.sheets['Sheet1']
#Encabezado del documento--------------
worksheet.merge_range('B2:F2', 'CUENTAS POR COBRAR REPORTE 1/8', negro_b)
worksheet.merge_range('B3:F3', 'OBJETIVOS Y RESULTADOS POR MONTO', negro_s)

worksheet.write('H2', 'AÑO', negro_b)
worksheet.write('I2', year, negro_b)
worksheet.merge_range('J2:K3', """FECHA DEL REPORTE
DD/MM/AAAA""", negro_b)
worksheet.merge_range('L2:L3', date, negro_b)
worksheet.insert_image("A1", "img/logo/logo.png",{"x_scale": 0.6, "y_scale": 0.6})

worksheet.write('B6', 'VENDEDOR', blue_header_format)
worksheet.write('C6', 'ENERO', blue_header_format)
worksheet.write('D6', 'FEBRERO', blue_header_format)
worksheet.write('E6', 'MARZO', blue_header_format)
worksheet.write('F6', 'ABRIL', blue_header_format)
worksheet.write('G6', 'MAYO', blue_header_format)
worksheet.write('H6', 'JUNIO', blue_header_format)
worksheet.write('I6', 'JULIO', blue_header_format)
worksheet.write('J6', 'AGOSTO', blue_header_format)
worksheet.write('K6', 'SEPTIEMBRE', blue_header_format)
worksheet.write('L6', 'OCTUBRE', blue_header_format)
worksheet.write('M6', 'NOVIEMBRE', blue_header_format)
worksheet.write('N6', 'DICIEMBRE', blue_header_format)

worksheet.write('O6', 'TOTAL', blue_header_format)
worksheet.write('P6', 'PORCENTAJE', blue_header_format)

for i in range(len(vendedores)):
    seller_id=vendedores['id'].values[i]
    pxv=pedidos.loc[pedidos['seller_id']==seller_id] 
    worksheet.write('B'+str(7+i), vendedores['seller_name'].values[i], blue_content)
    for mes in range(12):
        li=year+'-'+str(mes+1)+'-01'
        ls=year+'-'+str(mes+2)+'-01'
        if(mes+1==12):
            ls=str(int(year)+1)+'-01-01'
        worksheet.write(6+i,mes+2, pxv.loc[(pxv['date']<ls)&(pxv['date']>=li),'total'].sum(), blue_content)
    worksheet.write('O'+str(7+i), pxv['total'].sum(), blue_content)
    worksheet.write('P'+str(7+i), str(round((pxv['total'].sum()*100)/pedidos['total'].sum(),2))+'%', blue_content)
     
worksheet.write('B'+str(len(vendedores)+8), 'Total Mensual', blue_header_format)
for i in ['C','D','E','F','G','H','I','J','K','L','M','N','O']:

    worksheet.write_formula(i+str(len(vendedores)+8),  '{=SUM('+i+'7:'+i+str(len(vendedores)+6)+')}',blue_content_bold)
worksheet.write('P'+str(len(vendedores)+8),  '100%',blue_content_bold)




worksheet.write('B'+str(len(vendedores)+10), 'Objetivo Anual (MONTO)', blue_header_format)
worksheet.merge_range('C'+str(len(vendedores)+10)+':D'+str(len(vendedores)+10), objetivo, blue_content_bold)

worksheet.write('B'+str(len(vendedores)+11), 'Dias transcurridos', blue_header_format)
worksheet.merge_range('C'+str(len(vendedores)+11)+':D'+str(len(vendedores)+11), str(dias_transcurridos.days), blue_content_bold)

worksheet.write('B'+str(len(vendedores)+12), 'Objetivo a la fecha', blue_header_format)
worksheet.merge_range('C'+str(len(vendedores)+12)+':D'+str(len(vendedores)+12), pedidos['total'].sum(), blue_content_bold)

worksheet.write('B'+str(len(vendedores)+13), 'Porcentaje completado', blue_header_format)
worksheet.merge_range('C'+str(len(vendedores)+13)+':D'+str(len(vendedores)+13), str(round(pedidos['total'].sum()*100/objetivo,2))+'%', blue_content_bold)
#Grafica
# chart = workbook.add_chart({'type': 'column'})

# # Configure the chart. In simplest case we add one or more data series.
# chart.add_series({ 'name':'Enero','categories': '=Sheet1!$B$7:$B$'+str(6+len(vendedores)),'values': '=Sheet1!$C$7:$C$'+str(6+len(vendedores))})
# chart.add_series({'name':'Febrero', 'categories': '=Sheet1!$B$7:$B$'+str(6+len(vendedores)),'values': '=Sheet1!$D$7:$D$'+str(6+len(vendedores))})
# chart.add_series({ 'name':'Marzo','categories': '=Sheet1!$B$7:$B$'+str(6+len(vendedores)),'values': '=Sheet1!$E$7:$E$'+str(6+len(vendedores))})
# #insertar grafica
# worksheet.insert_chart('P7', chart,{'x_scale': 2, 'y_scale': 0.75})
#AGRANDAR CPLUMNAS
worksheet.set_column('A:A',15)
worksheet.set_column('B:B',35)
worksheet.set_column('C:O',18)

#worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
worksheet.set_landscape() 

worksheet_charts = workbook.add_worksheet("Gráficas")
worksheet_charts.merge_range('B2:F2', 'CUENTAS POR COBRAR REPORTE 1/8', negro_b)
worksheet_charts.merge_range('B3:F3', 'OBJETIVOS Y RESULTADOS POR MONTO', negro_s)

worksheet_charts.write('H2', 'AÑO', negro_b)
worksheet_charts.write('I2', year, negro_b)
worksheet_charts.merge_range('J2:K3', """FECHA DEL REPORTE
DD/MM/AAAA""", negro_b)
worksheet_charts.merge_range('L2:L3', date, negro_b)
worksheet_charts.insert_image("A1", "img/logo/logo.png",{"x_scale": 0.6, "y_scale": 0.6})

# Create a new chart object.
chart = workbook.add_chart({'type': 'pie'})

# Add a series to the chart.
chart.add_series({'values': '=Sheet1!$O$7:$O$'+str(7+ len(vendedores)),
                  'categories': '=Sheet1!$B$7:$B$'+str(7+ len(vendedores)),
                  'percentage': True,
                    'leader_lines': True,
                    'position': 'best_fit',
                    'data_labels': {
                    'value': True,
                    'font': {'color': 'gray','size': 10}
                }
                  })

# Insert the chart into the worksheet.
worksheet_charts.insert_chart('B5', chart,{'x_scale': 2.15, 'y_scale': 1.35})


# Create a new chart object.
chart = workbook.add_chart({'type': 'line'})

for i in range(len(vendedores)):
    seller_id=vendedores['id'].values[i]
    pxv=pedidos.loc[pedidos['seller_id']==seller_id] 
# Add a series to the chart.
    if(len(pxv)>len(pedidos)*0.05):
        
        chart.add_series({'values': '=Sheet1!$C$'+str(7+i)+':$N$'+str(7+i),
                  'categories': '=Sheet1!$C$6:$N$6',
                  'name':'=Sheet1!$B'+str(7+i)})


chart.add_series({'values': '=Sheet1!$C$'+str(8+len(vendedores))+':$N$'+str(8+len(vendedores)),
                  'categories': '=Sheet1!$C$6:$N$6',
                  'name':'TOTAL',
                  })

# Insert the chart into the worksheet.
worksheet_charts.insert_chart('B25', chart,{'x_scale': 2.15, 'y_scale': 1.35})

worksheet_charts.set_column('B:C',20)
worksheet_charts.set_column('L:L',20)

#worksheet.set_landscape()
worksheet_charts.set_paper(9)
worksheet_charts.fit_to_pages(1, 1)  

workbook.close()