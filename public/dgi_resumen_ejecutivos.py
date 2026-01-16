import sys
import mysql.connector
import xlsxwriter
from xlsxwriter.utility import xl_rowcol_to_cell
import pandas as pd
import sys
import mysql.connector
import os
import datetime
from dateutil.relativedelta import relativedelta
import numpy as np

year = datetime.date.today().year

quincena=int(sys.argv[1])+1
# quincena=1
month = np.ceil(quincena/ 2)
isFirstHalf = quincena % 2 != 0
startDate =  str(year)+"-"+str(int(month)).zfill(2)+"-01" if isFirstHalf else  str(year)+"-"+str(int(month)).zfill(2)+"-16"
endDate =  str(year)+"-"+str(int(month)).zfill(2)+"-15" if isFirstHalf else  str((datetime.datetime(year,int(month),1 )+relativedelta(months=1))-datetime.timedelta(days=1))[:10];

from dotenv import load_dotenv
load_dotenv()
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
#Calcular el intervalo segun num de quincena


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
                    where internal_orders.status  != 'CANCELADO'
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
cobros=cobros.sort_values('invoice')

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
                     from sellers where status='ACTIVO'""",cnx)

socios=pd.read_sql("select * from sellers where  dgi > 0",cnx)

no_socios=pd.read_sql("select * from sellers where status='ACTIVO' and dgi <= 0",cnx)
comisiones=pd.read_sql("""select * 
                     from comissions""",cnx)

nordenes=len(pedidos)
df=pedidos[['date']]

tc=pd.read_sql('select * from coins where id=13 ',cnx)['exchange_sell'].values[0]
writer = pd.ExcelWriter('storage/report/dgi_resumen_ejecutivos'+str(quincena-1)+'.xlsx', engine='xlsxwriter')
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
    'font_size':13})
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
    'font_size':14,
    
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
#para transformar coordenadas de columnas al nombre en letra A,B---
start = ord('A') 
currentDateTime = datetime.datetime.now()
date = currentDateTime.date()
year = date.strftime("%Y")
#Columna para filtrar por fechas
pedidos['date']=pd.to_datetime(pedidos['date'])

# -------------HOJA DE RESUMEN
worksheet= workbook.add_worksheet("Resumen")
#Encabezado del documento--------------
worksheet.write('E2', 'AÑO', negro_b)
worksheet.write('F2', year, negro_b)
worksheet.merge_range('E2:F3', """FECHA DEL REPORTE
DD/MM/AAAA""", negro_b)
worksheet.merge_range('G2:G3', date, negro_b)
worksheet.insert_image("A1", "img/logo/logo.png",{"x_scale": 0.6, "y_scale": 0.6})
worksheet.merge_range('B2:D3', """TABLA PARA PAGO DE DGI""", negro_b)
worksheet.merge_range('B4:D4', "Se reporta del "+str(startDate) +" al "+ str(endDate), negro_s)

##SEGUNDA TABLA DE RESUMEN VENTAS DIRECTAS
#Cabeceras
worksheet.merge_range(5,3+len(socios),8,3+len(socios),"""SIN IVA
COMISION GENERADA""",blue_header_format)
worksheet.merge_range(5,1,8,1,"""
PEDIDO INTERNO""",blue_header_format)
worksheet.write(5,2,'NO. VENDEDOR',blue_header_format)
worksheet.write(6,2,'INICIALES',blue_header_format)
worksheet.write(7,2,'NOMBRE CORTO',blue_header_format)
worksheet.write(8,2,'COMP. INGRESOS',blue_header_format)
#antes de iterar inicializo este array para guardar comisiones
totales = {row.iniciales: 0 for _, row in socios.iterrows()}
#total de cada xobro columna
for i in range(len(cobros)):
    this_comisions=comisiones.loc[comisiones['order_id']==cobros['order_id'].values[i]]
    
    worksheet.write(9+i,1,cobros['invoice'].values[i],blue_content)
    worksheet.write(9+i,2,cobros['comp'].values[i],blue_content)
    # worksheet.write(9+i,3+len(socios),(cobros['amount'].values[i]/1.16)*this_comisions['percentage'].sum(),blue_content)
    #formula
for i in range(len(socios)):
    this_comisions=comisiones.loc[(comisiones['seller_id']==socios['id'].values[i])]
    worksheet.write(5,3+i,str(i+1),blue_header_format)
    worksheet.write(6,3+i,socios['iniciales'].values[i],blue_header_format)
    #CONDICIONAL ESPECIFICO PARA NELSON PORQUE NO LE GUSTA ERNESTO
    if(str(socios['seller_name'].values[i]).split()[-1]=='ERNESTO'):
        worksheet.write(7,3+i,'NELSON',blue_header_format)
        worksheet.write(len(cobros)+10, 3+i,'NELSON',blue_content_footer)
    else:
        worksheet.write(7,3+i,str(socios['seller_name'].values[i]).split()[-1],blue_header_format)
        worksheet.write(len(cobros)+10, 3+i,str(socios['seller_name'].values[i]).split()[-1],blue_content_footer)
    worksheet.write(8,3+i,'COMISIÓN $',blue_header_format)
    #LLEANR LAS COLUMNAS DE CADA SOCIO
    for j in range(len(cobros)):
        comision_secundaria=this_comisions.loc[(this_comisions['order_id']==cobros['order_id'].values[j])&(this_comisions['description']!='DGI')]
        
        amount=(cobros['amount'].values[j]/1.16)*this_comisions.loc[(this_comisions['order_id']==cobros['order_id'].values[j])&(this_comisions['description']!='compartida')]['percentage'].sum()
        if(cobros['seller_id'].values[j]==socios['id'].values[i]):
           #CASO EN EL QUE EL SOCIO ES EL VENDEDOR PRINCIPAL
           amount=0  
           totales[socios['iniciales'].values[i]] += (cobros['amount'].values[j]/ 1.16) * cobros['comision'].values[j]
        else:
            totales[socios['iniciales'].values[i]] += comision_secundaria.loc[comision_secundaria['description']=='compartida']['percentage'].sum()*(cobros['amount'].values[j]/1.16)
          
        
        # if(len(comision_secundaria)>0):
        #    amount=(cobros['amount'].values[j]/1.16)*comision_secundaria['percentage'].values[0]
        #    totales[socios['iniciales'].values[i]] += (cobros['amount'].values[j]/1.16)*comision_secundaria['percentage'].sum()
        worksheet.write(9+j,3+i,amount,blue_content)
           
       

for i in range(len(socios)):
        # Definir el rango para la fórmula
    start_cell = xl_rowcol_to_cell(9, 3+i)  # Primera celda (0, 0 -> A1)
    end_cell = xl_rowcol_to_cell(len(cobros) +8, 3+i) 
    # Crear la fórmula SUM para sumar la columna
    formula = '{'+f"=SUM({start_cell}:{end_cell})"+'}'

    # Escribir la fórmula en una celda (por ejemplo, en la fila 6, columna 1 -> A6)
    worksheet.write_formula(len(cobros)+9, 3+i, formula,blue_footer_format_bold)
    worksheet.write_formula(len(cobros)+11, 3+i, formula,blue_footer_format_bold)
    #Formulas para totales de la tabla inferior
    start_cell = xl_rowcol_to_cell(len(cobros)+11, 3+i)  # Primera celda (0, 0 -> A1)
    end_cell = xl_rowcol_to_cell(len(cobros)+12, 3+i) 
    # Crear la fórmula SUM para sumar la columna
    formula = '{'+f"=SUM({start_cell}:{end_cell})"+'}'
    worksheet.write_formula(len(cobros)+13, 3+i, formula,blue_footer_format_bold)
    worksheet.write(len(cobros)+12, 3+i, totales[socios['iniciales'].values[i]],blue_content)
for i in range(len(cobros)):
    worksheet.write_formula(9+i,3+len(socios), '{'+f"=SUM({chr(start+2)}{10+i}:{chr(start+2+len(socios))}{10+i})" +'}',blue_content)
    #formula


worksheet.write_formula(len(cobros)+9, 3+len(socios), '{'+f"=SUM({chr(start+3+len(socios))}10:{chr(start+3+len(socios))}"+str(len(cobros)+9)+")"+'}',blue_footer_format_bold)
worksheet.write(len(cobros)+10, 3+len(socios), 'TOTALES',blue_footer_format_bold)
worksheet.write_formula(len(cobros)+11, 3+len(socios), '{'+f"=SUM({chr(start+3+len(socios))}10:{chr(start+3+len(socios))}"+str(len(cobros)+9)+")"+'}',blue_footer_format_bold)


##Tabla inferior de TOTALES
worksheet.merge_range(9+len(cobros),1,10+len(cobros),2,"",blue_header_format)
worksheet.merge_range(11+len(cobros),1,11+len(cobros),2,"""DGI""",blue_header_format)
worksheet.merge_range(12+len(cobros),1,12+len(cobros),2,"""COMISIONES""",blue_header_format)
#suma de total comisiones no dgi
worksheet.write_formula(len(cobros)+12, 3+len(socios), '{'+f"=SUM(D{str(len(cobros)+13)}:{chr(start+2+len(socios))}{str(len(cobros)+13)})"+'}',blue_footer_format_bold)

worksheet.merge_range(13+len(cobros),1,13+len(cobros),2,"""TOTALES""",blue_header_format)
worksheet.write_formula(len(cobros)+13, 3+len(socios), '{'+f"=SUM({chr(start+3+len(socios))}{str(len(cobros)+12)}:{chr(start+3+len(socios))}{str(len(cobros)+13)})"+'}',blue_footer_format_bold)

worksheet.set_row(5,27)

#AGRANDAR CPLUMNAS
worksheet.set_column('A:A',15)
worksheet.set_column('B:B',20)
worksheet.set_column('C:C',18)
worksheet.set_column('D:D',20)
worksheet.set_column('F:F',25)
worksheet.set_column('G:G',35)
worksheet.set_column('E:O',18)
worksheet.set_column('P:T',15)
worksheet.set_column('U:AX',19)
worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
workbook.close()
