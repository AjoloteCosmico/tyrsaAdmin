import sys
import mysql.connector
import xlsxwriter
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

clientes=pd.read_sql("""select  * from customers """,cnx)
bancos=pd.read_sql("""select  * from banks """,cnx)

pedidos=pd.read_sql("""Select internal_orders.* ,customers.clave,customers.alias,
coins.exchange_sell, coins.coin, coins.symbol, coins.code
from ((
    internal_orders
    inner join customers on customers.id = internal_orders.customer_id )
    inner join coins on internal_orders.coin_id = coins.id)
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
                     from sellers where status='ACTIVO'""",cnx)

socios=pd.read_sql("select * from sellers where  dgi > 0",cnx)

no_socios=pd.read_sql("select * from sellers where status='ACTIVO' and dgi <= 0",cnx)
comisiones=pd.read_sql("""select * 
                     from comissions""",cnx)

nordenes=len(pedidos)
df=pedidos[['date']]

tc=pd.read_sql('select * from coins where id=13 ',cnx)['exchange_sell'].values[0]
writer = pd.ExcelWriter('storage/report/dgi_comp'+str(quincena-1)+'.xlsx', engine='xlsxwriter')
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
  

#------HOJA DE Comprobante
worksheet= workbook.add_worksheet("C.Ingresos")

worksheet.merge_range('B1:F1', "Se reporta del "+str(startDate) +" al "+ str(endDate), negro_s)
#Encabezado del documento--------------

write_row=3
for i in range(len(cobros)):
    print('cobro',i)
    cliente=clientes.loc[clientes['id']==cobros['customer_id'].values[i]]
    banco =bancos.loc[bancos['id']==cobros['bank_id'].values[i]]
    factura=facturas.loc[facturas['cobro_id']==cobros['id'].values[i]]
    vendedor=vendedores.loc[vendedores['id']==cobros['seller_id'].values[i]]
    worksheet.merge_range(write_row,2,write_row,6, 'CUENTAS COBRADAS DE PEDIDOS INTERNOS', negro_b)
    #tABLITA DE DATOS DEL COMPROBANTE
    worksheet.merge_range(write_row+1,2,write_row+1,5, 'COMPROBANTE DE INGRESOS no.', blue_header_format)
    worksheet.merge_range(write_row+2,2,write_row+2,5, 'NOHA C.I.', blue_header_format)
    worksheet.merge_range(write_row+3,2,write_row+3,5, 'FECHA (DMA)', blue_header_format)
    worksheet.write(write_row+1,6,cobros['comp'].values[i],blue_content)
    worksheet.write(write_row+2,6,cobros['noha'].values[i],blue_content)
    worksheet.write(write_row+3,6,cobros['date'].values[i],blue_content_date)
    
    #Tabla de cleinte y banco
    
    worksheet.write(write_row+1,8,'CLIENTE',blue_header_format)
    worksheet.write(write_row+2,8,'BANCO',blue_header_format)
    worksheet.write(write_row+3,8,'MONEDA',blue_header_format)
    worksheet.merge_range(write_row+1,9,write_row+1,10,cliente['customer'].values[0],blue_content)
    worksheet.merge_range(write_row+2,9,write_row+2,10, banco['bank_description'].values[0], blue_content)
    worksheet.merge_range(write_row+3,9,write_row+3,10, banco['coin'].values[0], blue_content)
    
    worksheet.write(write_row+1,11,'TIPO DE CAMBIO',blue_header_format)
    worksheet.write(write_row+2,11,'FACTOR IVA',blue_header_format)
    worksheet.write(write_row+3,11,' ',blue_header_format)
    worksheet.write(write_row+1,12,'',blue_content)
    worksheet.write(write_row+2,12,'1.16',blue_content)
    worksheet.write(write_row+3,12,' ',blue_content)


    #TABLA PRINCIPAL LARGA
    worksheet.merge_range(write_row+5,2,write_row+7,2, 'PDA', blue_header_format)
    worksheet.merge_range(write_row+5,3,write_row+7,3, 'PEDIDO INTERNO No.', blue_header_format)
    worksheet.merge_range(write_row+5,4,write_row+7,4, 'FACTURA No.', blue_header_format)
    worksheet.merge_range(write_row+5,5,write_row+6,6, 'IMPORTE TOTAL DE ESTE COBRO', blue_header_format)
    worksheet.write(write_row+7,5,'DLLS',blue_header_format)
    worksheet.write(write_row+7,6,'M.N.',blue_header_format)
    worksheet.merge_range(write_row+5,7,write_row+7,7, 'VENDEDOR', blue_header_format)
    worksheet.merge_range(write_row+5,8,write_row+6,9, 'COMISION', blue_header_format)
    worksheet.write(write_row+7,8,'% NEGOCIADA',blue_header_format)
    worksheet.write(write_row+7,9,'M.N.',blue_header_format)
    worksheet.merge_range(write_row+5,10,write_row+6,11, 'IMPORTE TOTAL DEL PEDIDO', blue_header_format)
    worksheet.write(write_row+7,10,'DLLS',blue_header_format)
    worksheet.write(write_row+7,11,'M.N.',blue_header_format)
    worksheet.merge_range(write_row+5,12,write_row+6,13, 'IMPORTE PAGADO POR EL CLIENTE', blue_header_format)
    worksheet.write(write_row+7,12,'DLLS',blue_header_format)
    worksheet.write(write_row+7,13,'M.N.',blue_header_format)
    worksheet.merge_range(write_row+5,14,write_row+7,14, '% COMISION QUE SE DEBE SOBRE EL AVANCE', blue_header_format)
    worksheet.merge_range(write_row+5,15,write_row+7,15, 'COMISION A PAGAR M.N I/I', blue_header_format)
    worksheet.merge_range(write_row+5,16,write_row+7,16, 'VALIDAR QUE SE DEBE 0', blue_header_format)
    worksheet.merge_range(write_row+5,17,write_row+7,17, 'ESTATUS', blue_header_format)

    worksheet.write(write_row+8,2,i+1,blue_content_unit)
    worksheet.write(write_row+8,3,cobros['noha'].values[i],blue_content)
    try:
        worksheet.write(write_row+8,4,factura['facture'].values[0],blue_content)
    except:
        print('no hay factura')
        worksheet.write(write_row+8,4,'na',blue_content)
    worksheet.write(write_row+8,5,0,blue_content_dll)
    worksheet.write(write_row+8,6,cobros['amount'].values[i],blue_content)
    if(len(vendedor)>0):
        vendedor_id=vendedor['id'].values[0]
        worksheet.write(write_row+8,7,vendedor['seller_name'].values[0],blue_content)
    else:
        vendedor_id=0
        
        worksheet.write(write_row+8,7,'vendedor eliminado',blue_content)
    worksheet.write(write_row+8,8,str(cobros['comision'].values[i])+'%',blue_content)
    worksheet.write(write_row+8,9,cobros['amount'].values[i]*cobros['comision'].values[i],blue_content)
    worksheet.write(write_row+8,10,0,blue_content_dll)
    worksheet.write(write_row+8,11,cobros['total'].values[i],blue_content)
    
    #FIRMAS
    worksheet.write(write_row+12,3,'CAPTURO',firmas)
    worksheet.write(write_row+12,5,'REVISO',firmas)
    worksheet.write(write_row+12,7,'AUTORIZO',firmas)
    #OBSERVACIONES
    worksheet.merge_range(write_row+10,9,write_row+10,17, 'OBSERVACIONES', blue_header_format)
    worksheet.merge_range(write_row+11,9,write_row+12,17, ' ', blue_content_bold)

    #SIN IVA
    worksheet.merge_range(write_row+14,2,write_row+14,4, 'SIN IVA', blue_header_format_bold)
    worksheet.write(write_row+14,5,0.0,blue_content_footer_dll)
    worksheet.write(write_row+14,6,0.0,blue_content_footer)
    worksheet.merge_range(write_row+14,7,write_row+14,8, '  ', blue_header_format)
    worksheet.write(write_row+14,9,0.0,blue_content_footer)
    worksheet.write(write_row+14,10,0.0,blue_content_footer_dll)
    worksheet.write(write_row+14,11,0.0,blue_content_footer)
    
    worksheet.write(write_row+14,12,0.0,blue_content_footer)
    worksheet.write(write_row+14,13,' ',blue_content_footer)
    worksheet.write(write_row+14,14,0.0,blue_content_footer)
    worksheet.merge_range(write_row+14,15,write_row+14,16, '  ', blue_header_format)

    
    worksheet.merge_range(write_row+16,2,write_row+16,5, 'VENDEDORES ACTIVOS / DISPERSION DE COMISIONES SIN IVA', negro_s)
    worksheet.write(write_row+16,6,0.0,blue_header_format_bold)
    worksheet.merge_range(write_row+16,8,write_row+16,11, 'EJECUTIVOS ACTIVOS / DISPERSION DGI SIN IVA', negro_s)
    worksheet.write(write_row+16,12,0.0,blue_header_format_bold)
    
    worksheet.merge_range(write_row+18,2,write_row+19,2, 'VENDEDOR', blue_header_format)
    worksheet.merge_range(write_row+18,3,write_row+18,4, 'COMISION', blue_header_format)
    worksheet.write(write_row+19,3, '%', blue_header_format)
    worksheet.write(write_row+19,4, 'M.N. sin iva ', blue_header_format)

    worksheet.merge_range(write_row+18,8,write_row+19,8, 'FACTORES DGI', blue_header_format)
    
    worksheet.merge_range(write_row+18,9,write_row+19,9, 'VENDEDOR Y EJECUTIVO SV', blue_header_format)
    
    worksheet.merge_range(write_row+18,10,write_row+18,11, 'DGI', blue_header_format)

    worksheet.write(write_row+19,10, '%', blue_header_format)
    worksheet.write(write_row+19,11, 'M.N. sin iva ', blue_header_format)
   
    worksheet.merge_range(write_row+18,12,write_row+19,12, '¿PROCEDE PAGO?', blue_header_format)

    for j in range(len(no_socios)):
        worksheet.write(write_row+20+j,2,no_socios['seller_name'].values[j],blue_content)
        # if(len(comisiones.loc[(comisiones['order_id']==cobros['order_id'].values[i])&(comisiones['seller_id']==no_socios['id'].values[j])])>0):
        if(vendedor_id==no_socios['id'].values[j]):
            worksheet.write(write_row+20+j,3,'100%',blue_content)
            worksheet.write(write_row+20+j,4,(cobros['amount'].values[i]*cobros['comision'].values[i])/1.16,blue_content)
        else:
            worksheet.write(write_row+20+j,3,'0%',blue_content)
            worksheet.write(write_row+20+j,4,0,blue_content)
        worksheet.write(write_row+20+j,2,no_socios['seller_name'].values[j])
    #ultimo ciclo de vendedores

    worksheet.merge_range(write_row+23+len(no_socios),0,write_row+23+len(no_socios),20, ' ', divisor)
    write_row=write_row+26+len(no_socios)



worksheet.set_column('C:C',24)

worksheet.set_column('E:E',24)

worksheet.set_column('G:O',22)
worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  

workbook.close()
