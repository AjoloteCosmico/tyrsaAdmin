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
query = ('SELECT * from customers where id =1')

# join para cobros
# cobros=pd.read_sql('Select cobros.* ,customers.customer,internal_orders.invoice, users.name from ((cobros inner join internal_orders on internal_orders.id = cobros.order_id) inner join customers on customers.id = internal_orders.customer_id )inner join users on cobros.capturo=users.id',cnx)


#traer datos de los pedidos
pedidos=pd.read_sql("""Select internal_orders.* ,customers.clave,customers.alias,
coins.exchange_sell, coins.coin, coins.symbol
from ((
    internal_orders
    inner join customers on customers.id = internal_orders.customer_id )
    inner join coins on internal_orders.coin_id = coins.id)
     """,cnx)
clientes=pd.read_sql("select * from customers",cnx)
cobros=pd.read_sql("""select cobros.*,internal_orders.coin_id as coin_pedido,internal_orders.customer_id  
                     from (
                         cobros
    inner join internal_orders on internal_orders.id = cobros.order_id )""",cnx)
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
writer = pd.ExcelWriter('storage/report/CxC_cliente_desglosado'+str(id)+'.xlsx', engine='xlsxwriter')

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


blue_content_dll = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'bg_color': '#b4e3b1',
    'border_color':a_color,
    'font_size':10,
    'num_format': '[$$-409]#,##0.00'})
total_cereza_format = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#F4B084',
    'border': 1})


df[0:1].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=6, header=False, index=False)
worksheet = writer.sheets['Sheet1']
#Encabezado del documento--------------
worksheet.merge_range('B2:G3', 'TYRSA CONSORCIO S.A. DE C.V. ', rojo_l)
worksheet.merge_range('B4:G4', 'Soluciones en logistica interior', negro_s)

#llenando la tabla
counter=0
for i in range(0,len(clientes)):
   print(str(i)+' esa no')
   if(len(pedidos.loc[pedidos['customer_id']==clientes['id'].values[i]])>0):
        print(str(i)+'esta si')
        print("!!!!!!!!!!!!!!!!!!!!!!!!!!!!")
        worksheet.merge_range('H'+str(2+counter)+':R'+str(3+counter), 'CUENTAS POR COBRAR POR CLIENTE CONSOLIDADO', negro_b)
        worksheet.merge_range('H'+str(4+counter)+':R'+str(4+counter), 'CUENTAS POR COBRAR', rojo_b)

        worksheet.merge_range('C'+str(6+counter)+':C'+str(8+counter), 'PDA', blue_header_format)
        worksheet.merge_range('D'+str(6+counter)+':D'+str(8+counter), 'PI CANTIDAD', blue_header_format)
        worksheet.merge_range('E'+str(6+counter)+':E'+str(8+counter), 'FECHA', blue_header_format)

        worksheet.merge_range('F'+str(6+counter)+':G'+str(7+counter), 'CLIENTE', blue_header_format)
        worksheet.write('F'+str(8+counter), 'NUMERO', blue_header_format)
        worksheet.write('G'+str(8+counter), 'NOMBRE CORTO', blue_header_format)

        worksheet.merge_range('H'+str(6+counter)+':H'+str(8+counter), 'MONEDA', blue_header_format)

        worksheet.merge_range('I'+str(6+counter)+':O'+str(6+counter), 'DERECHOS ADQUIRIDOS', blue_header_format)
        worksheet.merge_range('I'+str(7+counter)+':J'+str(7+counter), 'IMPORTE TOTAL SIN IVA', blue_header_format)
        worksheet.write('I'+str(8+counter), 'MN', blue_header_format)
        worksheet.write('J'+str(8+counter), 'DLLS', blue_header_format)


        worksheet.merge_range('K'+str(7+counter)+':L'+str(7+counter), 'COBRADO', blue_header_format)
        worksheet.write('K'+str(8+counter), 'MN', blue_header_format)
        worksheet.write('L'+str(8+counter), 'DLLS', blue_header_format)


        worksheet.merge_range('M'+str(7+counter)+':N'+str(7+counter), 'POR COBRAR', blue_header_format)
        worksheet.write('M'+str(8+counter), 'MN', blue_header_format)
        worksheet.write('N'+str(8+counter), 'DLLS', blue_header_format)


        worksheet.merge_range('O'+str(7+counter)+':O'+str(8+counter), '% POR COBRAR DEL PEDIDO INTERNO', blue_header_format)

        worksheet.merge_range('P'+str(6+counter)+':S'+str(6+counter), 'DERECHOS ADQUIRIDOS POR COBRAR', blue_header_format)
        worksheet.merge_range('P'+str(7+counter)+':Q'+str(7+counter), 'FACTURADO', blue_header_format)
        worksheet.write('P'+str(8+counter), 'MN', blue_header_format)
        worksheet.write('Q'+str(8+counter), 'DLLS', blue_header_format)


        worksheet.merge_range('R'+str(7+counter)+':S'+str(7+counter), 'POR FACTURAR', blue_header_format)
        worksheet.write('R'+str(8+counter), 'MN', blue_header_format)
        worksheet.write('S'+str(8+counter), 'DLLS', blue_header_format)
        row_index=str(9+counter)
        
        print(cobros.columns)
        cobros_mn=cobros.loc[(cobros['customer_id']==clientes['id'].values[i])&(cobros['coin_pedido']==1)]
        facturas_mn=facturas.loc[(facturas['customer_id']==clientes['id'].values[i])&(facturas['coin_pedido']==1)]
        notas_mn=creditos.loc[(creditos['customer_pedido']==clientes['id'].values[i])&(creditos['coin_pedido']==1)]
        
        cobros_dlls=cobros.loc[(cobros['customer_id']==clientes['id'].values[i])&(cobros['coin_pedido']!=1)]
        facturas_dlls=facturas.loc[(facturas['customer_id']==clientes['id'].values[i])&(facturas['coin_pedido']!=1)]
        notas_dlls=creditos.loc[(creditos['customer_id']==clientes['id'].values[i])&(creditos['coin_pedido']!=1)]
        
        total_mn=  pedidos.loc[(pedidos['customer_id']==clientes['id'].values[i])&(pedidos['coin_id']==1),'total'].sum()
        total_dlls=pedidos.loc[(pedidos['customer_id']==clientes['id'].values[i])&(pedidos['coin_id']!=1),'total'].sum()

        #datos generales del pedido
        #worksheet.write('B'+row_index, str(pedidos['noha'].values[i]), blue_content)
        worksheet.write('C'+row_index, str(i+1), blue_content)
        worksheet.write('D'+row_index, str(len(pedidos.loc[pedidos['customer_id']==clientes['id'].values[i]])), blue_content)
        worksheet.write('E'+row_index, str(pedidos.loc[pedidos['customer_id']==clientes['id'].values[i],'reg_date'].values[0]), blue_content)
        worksheet.write('F'+row_index, str(clientes['clave'].values[i]), blue_content)
        worksheet.write('G'+row_index, str(clientes['alias'].values[i]), blue_content)
        worksheet.write('H'+row_index, str(pedidos.loc[pedidos['customer_id']==clientes['id'].values[i],'coin'].unique()), blue_content)
        #subtotal
    
        worksheet.write('I'+row_index,total_mn, blue_content)
        worksheet.write('J'+row_index, total_dlls, blue_content_dll)
    
        #cobrado
        worksheet.write('K'+row_index, cobros_mn['amount'].sum()  , blue_content)
        worksheet.write('L'+row_index,cobros_dlls['amount'].sum()  , blue_content_dll)
        #por cobrar
        worksheet.write('M'+row_index, total_mn-cobros_mn['amount'].sum() -notas_mn['amount'].sum() , blue_content)
        worksheet.write('N'+row_index, total_dlls-cobros_dlls['amount'].sum()-notas_dlls['amount'].sum()  , blue_content_dll)
    
        worksheet.write('O'+row_index, "{:.2f}".format((total_mn+total_dlls-(cobros_dlls['amount'].sum()+cobros_mn['amount'].sum()) )*100/pedidos.loc[pedidos['customer_id']==clientes['id'].values[i],'total'].sum())+"%", blue_content)
        #facturado
        worksheet.write('P'+row_index,( facturas_mn['amount'].sum()-notas_mn['amount'].sum())  , blue_content)
        worksheet.write('Q'+row_index, ( facturas_dlls['amount'].sum()-notas_dlls['amount'].sum())  , blue_content)
    
        #por facturar
        worksheet.write('R'+row_index,total_mn-( facturas_mn['amount'].sum())  , blue_content)
        worksheet.write('S'+row_index, total_dlls-( facturas_dlls['amount'].sum())  , blue_content_dll)
    
        trow=10+counter

        worksheet.write('H'+str(trow), 'Subtotales', blue_header_format_bold)
        #SUBTOTAL PEDIDOS MN
        worksheet.write('I'+str(trow), pedidos.loc[pedidos['coin_id']==1,'subtotal'].sum(), blue_content_bold)
        #SUBTOTAL PEDIDOS DLLS
        worksheet.write('J'+str(trow), pedidos.loc[pedidos['coin_id']!=1,'subtotal'].sum(), blue_content_bold)
        #TOTAL COBRADO MN
        worksheet.write_formula('K'+str(trow),  '{=SUM(K'+str(9+counter)+':K'+str(trow-1)+')}', blue_content_bold)
        #TOTAL COBRADO DLLS
        worksheet.write_formula('L'+str(trow),  '{=SUM(L'+str(9+counter)+':L'+str(trow-1)+')}', blue_content_bold)
        #TOTAL POR COBRAR MN
        worksheet.write_formula('M'+str(trow),  '{=SUM(M'+str(9+counter)+':M'+str(trow-1)+')}', blue_content_bold)
        #TOTAL POR COBRAR DLLS
        worksheet.write_formula('N'+str(trow),  '{=SUM(N'+str(9+counter)+':N'+str(trow-1)+')}',blue_content_bold)
        #TOTAL FACTURADO MN
        worksheet.write('O'+str(trow+1), "{:.2f}".format((pedidos['total'].sum()- cobros['amount'].sum() )*100/pedidos['total'].sum())+"%", blue_content_bold)
        #TOTAL FACTURADOR DLLS
        worksheet.write_formula('P'+str(trow),  '{=SUM(P'+str(9+counter)+':P'+str(trow-1)+')}', blue_content_bold)
        #TOTAL POR FACTURAR MN
        worksheet.write_formula('Q'+str(trow),  '{=SUM(Q'+str(9+counter)+':Q'+str(trow-1)+')}', blue_content_bold)
        #TOTAL POR FACTURAR DLLS
        worksheet.write_formula('R'+str(trow),  '{=SUM(R'+str(9+counter)+':R'+str(trow-1)+')}',blue_content_bold)
        worksheet.write_formula('S'+str(trow),  '{=SUM(S'+str(9+counter)+':S'+str(trow-1)+')}',blue_content_bold)


        #TOTALES TOTAL DE ADEBIS
        worksheet.write('H'+str(trow), 'Subtotales', blue_header_format_bold)
        worksheet.merge_range('I'+str(trow+1)+':J'+str(trow+1),' ',blue_content_bold)
        worksheet.write_formula('I'+str(trow+1)+':J'+str(trow+1),  'SUM(I'+str(trow)+'+J'+str(trow)+')',blue_content_bold)

        worksheet.merge_range('K'+str(trow+1)+':L'+str(trow+1),' ',blue_content_bold)
        worksheet.write_formula('K'+str(trow+1)+':L'+str(trow+1),  'SUM(K'+str(trow)+'+L'+str(trow)+')',blue_content_bold)

        worksheet.merge_range('M'+str(trow+1)+':N'+str(trow+1),' ',blue_content_bold)
        worksheet.write_formula('M'+str(trow+1)+':N'+str(trow+1),  'SUM(M'+str(trow)+'+N'+str(trow)+')',blue_content_bold)

        worksheet.merge_range('P'+str(trow+1)+':Q'+str(trow+1),' ',blue_content_bold)
        worksheet.write_formula('P'+str(trow+1)+':Q'+str(trow+1),  'SUM(P'+str(trow)+'+Q'+str(trow)+')',blue_content_bold)

        worksheet.merge_range('R'+str(trow+1)+':S'+str(trow+1),' ',blue_content_bold)
        worksheet.write_formula('R'+str(trow+1)+':S'+str(trow+1),  'SUM(R'+str(trow)+'+S'+str(trow)+')',blue_content_bold)
        counter=counter+10

# worksheet.write('K'+str(trow), str(cobros['amount'].sum()), blue_content)
# worksheet.write('L'+str(trow), str(cobros['exchange_sell'].values[0]*cobros['amount'].sum()), blue_content_bold)

worksheet.set_column('L:L',15)
worksheet.set_column('G:G',15)
worksheet.set_column('H:H',15)
worksheet.set_column('I:N',15)
worksheet.set_column('P:T',15)

#worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
workbook.close()