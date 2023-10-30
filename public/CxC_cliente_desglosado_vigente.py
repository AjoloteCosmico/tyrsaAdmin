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
id=0
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


#traer datos de los pedidos
pedidos=pd.read_sql("""Select internal_orders.* ,customers.clave,customers.alias,
coins.exchange_sell, coins.coin, coins.symbol,coins.code
from ((
    internal_orders
    inner join customers on customers.id = internal_orders.customer_id )
    inner join coins on internal_orders.coin_id = coins.id)
     """,cnx)
clientes=pd.read_sql("select * from customers",cnx)
cobros=pd.read_sql("""select cobro_orders.*,internal_orders.coin_id as coin_pedido,internal_orders.customer_id
                     from (((
                         cobro_orders 
    inner join cobros on cobros.id=cobro_orders.cobro_id)
    inner join internal_orders on internal_orders.id = cobros.order_id )
    inner join coins on internal_orders.coin_id = coins.id) """,cnx)

facturas=pd.read_sql("""select factures.*,internal_orders.coin_id as coin_pedido,internal_orders.customer_id  
                     from (
                         factures
    inner join internal_orders on internal_orders.id = factures.order_id )""",cnx)
creditos=pd.read_sql("""select credit_notes.*,internal_orders.coin_id as coin_pedido,internal_orders.customer_id as customer_pedido 
                     from (
                         credit_notes
    inner join internal_orders on internal_orders.id = credit_notes.order_id ) """,cnx)
print(creditos)
nordenes=len(pedidos)
df=pedidos[['date']]
print(cobros['order_id'])
tc=pd.read_sql('select * from coins where id=13 ',cnx)['exchange_sell'].values[0]
#Filtrando datos---------------------------------------
#Separar pedidos vigentes
    #Agregar columna con saldo en los cobros
pedidos=pedidos.assign(saldo=0.0)
for i in range(len(pedidos)):
    pedidos['saldo'].values[i]=cobros.loc[cobros['order_id']==pedidos['id'].values[i],'amount'].sum()
pedidos=pedidos.loc[pedidos['total']-pedidos['saldo']>1]
writer = pd.ExcelWriter('storage/report/CxC_cliente_desglosado_vigente'+str(id)+'.xlsx', engine='xlsxwriter')

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
blue_content_dll = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'bg_color': '#b4e3b1',
    'border_color':a_color,
    'font_size':10,
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

import datetime

currentDateTime = datetime.datetime.now()
date = currentDateTime.date()
year = date.strftime("%Y")
df[0:1].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=6, header=False, index=False)
worksheet = writer.sheets['Sheet1']
#Encabezado del documento--------------
worksheet.merge_range('B2:F2', 'CUENTAS POR COBRAR REPORTE 3B ', negro_b)
worksheet.merge_range('B3:F3', 'DERECHOS ADQUIRIDOS POR COBRAR VIGENTES', negro_s)
worksheet.merge_range('B4:F4', 'CLASIFICADAS POR CLIENTE DESGLOSADO', negro_b)

worksheet.write('H2', 'AÑO', negro_b)

worksheet.write('I2', year, negro_b)
worksheet.merge_range('J2:K3', """FECHA DEL REPORTE
DD/MM/AAAA""", negro_b)

worksheet.write('L2', date, negro_b)
worksheet.insert_image("A1", "img/logo/logo.png",{"x_scale": 0.6, "y_scale": 0.6})
#llenando la tabla
row_index=7
for i in range(0,len(clientes)):
   print(str(i)+' esa no')
   if(len(pedidos.loc[pedidos['customer_id']==clientes['id'].values[i]])>0):
        print(str(i)+'esta si')
        print("!!!!!!!!!!!!!!!!!!!!!!!!!!!!")
        worksheet.merge_range('H'+str(4+row_index)+':R'+str(4+row_index), 'CUENTAS POR COBRAR POR CLIENTE DESGLOSADO', negro_b)

        worksheet.merge_range('C'+str(6+row_index)+':C'+str(10+row_index), 'PDA', blue_header_format)
        worksheet.merge_range('D'+str(6+row_index)+':D'+str(10+row_index), 'PI CANTIDAD', blue_header_format)
        worksheet.merge_range('E'+str(6+row_index)+':E'+str(10+row_index), 'FECHA', blue_header_format)

        worksheet.merge_range('F'+str(6+row_index)+':G'+str(9+row_index), 'CLIENTE', blue_header_format)
        worksheet.write('F'+str(10+row_index), 'NUMERO', blue_header_format)
        worksheet.write('G'+str(10+row_index), 'NOMBRE CORTO', blue_header_format)

        worksheet.merge_range('H'+str(6+row_index)+':H'+str(10+row_index), """ 
                                  MONEDA""", blue_header_format)

        worksheet.merge_range('I'+str(6+row_index)+':L'+str(6+row_index), 'DERECHOS ADQUIRIDOS', blue_header_format)
        worksheet.merge_range('I'+str(7+row_index)+':J'+str(9+row_index), """IMPORTE TOTAL 
(DERECHOS ADQUIRIDOS) 
SIN IVA""", blue_header_format)
        worksheet.write('I'+str(10+row_index), 'MN', blue_header_format)
        worksheet.write('J'+str(10+row_index), 'DLLS', blue_header_format)


        worksheet.merge_range('K'+str(7+row_index)+':L'+str(9+row_index), """COBRADO
(IMPORTE POR COBRAR)
SIN IVA""", blue_header_format)
        worksheet.write('K'+str(10+row_index), 'MN', blue_header_format)
        worksheet.write('L'+str(10+row_index), 'DLLS', blue_header_format)


    

        worksheet.merge_range('M'+str(7+row_index)+':M'+str(10+row_index), '% POR COBRAR DEL PEDIDO INTERNO', blue_header_format)

        worksheet.merge_range('N'+str(6+row_index)+':O'+str(6+row_index), 'DERECHOS ADQUIRIDOS POR COBRAR CONTABLES', blue_header_format)


        worksheet.merge_range('N'+str(7+row_index)+':O'+str(9+row_index), """POR FACTURAR
CXC CONTABLES
(SIN IVA)""", blue_header_format)
        worksheet.write('N'+str(10+row_index), 'MN', blue_header_format)
        worksheet.write('O'+str(10+row_index), 'DLLS', blue_header_format)
        
        worksheet.merge_range('P'+str(6+row_index)+':P'+str(10+row_index), 'STATUS', blue_header_format)
        row_index=str(11+row_index)
        
        print(cobros.columns)
        cobros_mn=cobros.loc[(cobros['customer_id']==clientes['id'].values[i])&(cobros['coin_pedido']==1)]
        facturas_mn=facturas.loc[(facturas['customer_id']==clientes['id'].values[i])&(facturas['coin_pedido']==1)]
        notas_mn=creditos.loc[(creditos['customer_pedido']==clientes['id'].values[i])&(creditos['coin_pedido']==1)]
        
        cobros_dlls=cobros.loc[(cobros['customer_id']==clientes['id'].values[i])&(cobros['coin_pedido']!=1)]
        facturas_dlls=facturas.loc[(facturas['customer_id']==clientes['id'].values[i])&(facturas['coin_pedido']!=1)]
        notas_dlls=creditos.loc[(creditos['customer_id']==clientes['id'].values[i])&(creditos['coin_pedido']!=1)]
        
        pedidos_mn=pedidos.loc[(pedidos['customer_id']==clientes['id'].values[i])&(pedidos['coin_id']==1)]
        pedidos_dlls=pedidos.loc[(pedidos['customer_id']==clientes['id'].values[i])&(pedidos['coin_id']!=1)]
        
        this_pedidos=pedidos.loc[(pedidos['customer_id']==clientes['id'].values[i])]
        
        total_mn=  pedidos_mn['total'].sum()/1.16
        total_dlls=pedidos_dlls['total'].sum()/1.16
        #datos generales del pedido
        #worksheet.write('B'+row_index, str(pedidos['noha'].values[i]), blue_content)
        for k in range(len(this_pedidos)):
            
            this_cobros=cobros.loc[(cobros['order_id']==this_pedidos['id'].values[k])]
            this_facturas=facturas.loc[(facturas['order_id']==this_pedidos['id'].values[k])]
            this_notas=creditos.loc[(creditos['order_id']==this_pedidos['id'].values[k])]
        
            worksheet.write('C'+row_index, str(k+1), blue_content)
            worksheet.write('D'+row_index, this_pedidos['invoice'].values[k], blue_content)
            worksheet.write('E'+row_index, this_pedidos['reg_date'].values[k], blue_content)
            worksheet.write('F'+row_index, str(clientes['clave'].values[i]), blue_content)
            worksheet.write('G'+row_index, str(clientes['alias'].values[i]), blue_content)
            worksheet.write('H'+row_index, this_pedidos['code'].values[k], blue_content)
            #subtotal
            #pesos
            if(this_pedidos['coin_id'].values[k]==1):
                worksheet.write('I'+row_index,this_pedidos['total'].values[k]/1.16, blue_content)
                worksheet.write('J'+row_index, 0, blue_content_dll)
                #por cobrar
                worksheet.write('K'+row_index,this_pedidos['total'].values[k]/1.16- this_cobros['amount'].sum()/1.16 , blue_content)
                worksheet.write('L'+row_index, 0 , blue_content_dll)
                #facturado
                xc=this_pedidos['total'].values[k]/1.16- this_cobros['amount'].sum()/1.16
                if(xc>1):
                    #por facturar
                    worksheet.write('N'+row_index,xc-this_facturas['amount'].sum()/1.16-this_notas['amount'].sum()/1.16-this_cobros['amount'].sum()/1.16 , blue_content)
                    worksheet.write('O'+row_index, 0 , blue_content_dll)
                else:
                    #por facturar
                    worksheet.write('N'+row_index,0, blue_content)
                    worksheet.write('O'+row_index, 0 , blue_content_dll)
           
            
            else:
                worksheet.write('I'+row_index,0, blue_content)
                worksheet.write('J'+row_index, this_pedidos['total'].values[k]/1.16, blue_content_dll)
               #por cobrar
                worksheet.write('K'+row_index,0 , blue_content)
                worksheet.write('L'+row_index, this_pedidos['total'].values[k]/1.16- this_cobros['amount'].sum()/1.16 , blue_content_dll)
         #facturado
                xc=this_pedidos['total'].values[k]/1.16- this_cobros['amount'].sum()/1.16
                if(xc>1):
                    #por facturar
                    worksheet.write('N'+row_index, 0, blue_content)
                    worksheet.write('O'+row_index, xc-this_facturas['amount'].sum()/1.16-this_notas['amount'].sum()/1.16-this_cobros['amount'].sum()/1.16 , blue_content_dll)
                else:
                    #por facturar
                    worksheet.write('N'+row_index,0, blue_content)
                    worksheet.write('O'+row_index, 0 , blue_content_dll)
           
            
            worksheet.write('M'+row_index, "{:.2f}".format((this_pedidos['total'].values[k]- this_cobros['amount'].sum())*100/this_pedidos['total'].values[k])+"%", blue_content)
            
            
             #status
            if(total_mn+total_dlls-cobros_mn['amount'].sum()/1.16-cobros_dlls['amount'].sum()/1.16>1):
                worksheet.write('P'+row_index,'ACTIVO', blue_content)
            else:
                worksheet.write('P'+row_index,'CERRADO', blue_content)
            row_index=str(int(row_index)+1)
        trow=int(row_index)

        worksheet.write('H'+str(trow), 'Subtotales', blue_header_format_bold)
        #SUBTOTAL PEDIDOS MN
        worksheet.write('I'+str(trow), total_mn, blue_content_bold)
        #SUBTOTAL PEDIDOS DLLS
        worksheet.write('J'+str(trow), total_dlls, blue_content_bold)
        #TOTAL POR COBRAR MN
        worksheet.write_formula('K'+str(trow),  '{=SUM(K'+str(trow-len(this_pedidos))+':K'+str(trow-1)+')}', blue_content_bold)
        #TOTAL POR COBRAR DLLS
        worksheet.write_formula('L'+str(trow),  '{=SUM(L'+str(trow-len(this_pedidos))+':L'+str(trow-1)+')}', blue_content_bold)
       
        worksheet.write('M'+str(trow+1),  "{:.2f}".format((this_pedidos['total'].sum()-cobros_dlls['amount'].sum()-cobros_mn['amount'].sum())*100/this_pedidos['total'].sum())+"%", blue_content_bold)
        #TOTAL POR FACTURAR DLLS
        worksheet.write_formula('N'+str(trow),  '{=SUM(N'+str(trow-len(this_pedidos))+':N'+str(trow-1)+')}',blue_content_bold)
        worksheet.write_formula('O'+str(trow),  '{=SUM(O'+str(trow-len(this_pedidos))+':O'+str(trow-1)+')}',blue_content_bold)


        #TOTALES TOTAL DE ADEBIS
        worksheet.write('H'+str(trow), 'Subtotales', blue_header_format_bold)
        worksheet.merge_range('I'+str(trow+1)+':J'+str(trow+1),' ',blue_content_bold)
        worksheet.write_formula('I'+str(trow+1)+':J'+str(trow+1),  'SUM(I'+str(trow)+'+J'+str(trow)+'*'+str(tc)+')',blue_content_bold)

        worksheet.merge_range('K'+str(trow+1)+':L'+str(trow+1),' ',blue_content_bold)
        worksheet.write_formula('K'+str(trow+1)+':L'+str(trow+1),  'SUM(K'+str(trow)+'+L'+str(trow)+'*'+str(tc)+')',blue_content_bold)

        worksheet.merge_range('N'+str(trow+1)+':O'+str(trow+1),' ',blue_content_bold)
        worksheet.write_formula('N'+str(trow+1)+':O'+str(trow+1),  'SUM(N'+str(trow)+'+O'+str(trow)+'*'+str(tc)+')',blue_content_bold)
        
        
        row_index=trow

# worksheet.write('K'+str(trow), str(cobros['amount'].sum()), blue_content)
# worksheet.write('L'+str(trow), str(cobros['exchange_sell'].values[0]*cobros['amount'].sum()), blue_content_bold)

worksheet.set_column('A:A',15)
worksheet.set_column('E:E',20)
worksheet.set_column('L:L',15)
worksheet.set_column('G:G',15)
worksheet.set_column('H:H',15)
worksheet.set_column('I:N',15)
worksheet.set_column('P:T',15)

#worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
workbook.close()