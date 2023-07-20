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
b_color='#3A4363'
# Conectar a DB
cnx = mysql.connector.connect(user=DB_USERNAME,
                              password=DB_PASSWORD,
                              host='localhost',
                              port=DB_PORT,
                              database=DB_DATABASE,
                              use_pure=False)
#Seccion para traer informacion de la base
query = ('SELECT * from customers where id =1')
like_customer=pd.read_sql(query,cnx)


#order_id=pagos.loc[(pagos["id"]==int(id),"order_id") ].values[0]
order_id=int(id)
print(order_id)
orden = pd.read_sql("select * from internal_orders where id="+str(order_id),cnx)
retencion=pd.read_sql("""select * from items where internal_order_id= """+str(order_id)+""" and family='FLETE'""",cnx)['import'].sum()*orden['tasa'].values[0]
print("retencion:  "+str(retencion))
cliente = pd.read_sql("select * from customers where id = "+str(orden["customer_id"].values[0]),cnx)
moneda = pd.read_sql("select * from coins where id="+str(orden["coin_id"].values[0]),cnx)
query = ('SELECT * from payments where order_id = '+str(order_id))
#pagos historicos, los que fueron programados en un inicio
hpagos=pd.read_sql(query,cnx)
query = ('SELECT * from internal_orders')
cobros=pd.read_sql("""Select cobro_orders.*, cobros.tc,cobros.comp,cobros.date,
capturistas.iniciales as capturista, revisores.iniciales as revisor, autorizadores.iniciales as autorizador
    from ((((cobro_orders 
    inner join cobros on cobros.id=cobro_orders.cobro_id)
    left join users as capturistas on cobros.capturo=capturistas.id)
    left join users as revisores on cobros.reviso=revisores.id)
    left join users as autorizadores on cobros.autorizo=autorizadores.id)
      where cobro_orders.order_id = """+str(order_id),cnx)
notas=pd.read_sql('Select* from credit_notes where order_id= '+str(orden['id'].values[0]),cnx)
nordenes=len(pd.read_sql(query,cnx))
df=hpagos[['date','percentage']]
#Traer facturas
query = ('SELECT * from factures where order_id = '+str(order_id))
facturas=pd.read_sql(query,cnx)

pac=0#porcentaje acumulado
mac=0#monto acumulado
writer = pd.ExcelWriter('storage/report/contraportada'+str(order_id)+'.xlsx', engine='xlsxwriter')

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
    'border': 1,
    
    'font_size':10})
blue_header_format_bold = workbook.add_format({
    'bold': True,
    'bg_color': a_color,
    'text_wrap': True,
    'valign': 'top',
    'align': 'center',
    'border_color':'white',
    'font_color': 'white',
    'border': 1,
    'font_size':10})

red_header_format = workbook.add_format({
    'bold': True,
    'bg_color': b_color,
    'text_wrap': True,
    'valign': 'top',
    'align': 'center',
    'border_color':'white',
    'font_color': 'white',
    'border': 1,
    
    'font_size':10})

red_header_format_bold = workbook.add_format({
    'bold': True,
    'bg_color': b_color,
    'text_wrap': True,
    'valign': 'top',
    'align': 'center',
    'border_color':'white',
    'font_color': 'white',
    'border': 1,
    'font_size':10})


#FORMATOS PARA TABLAS PER CE------------------------------------

blue_content = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':9,
    'border_color':a_color,
    'num_format': '[$$-409]#,##0.00'})

blue_content_bold = workbook.add_format({
    'bold': True,
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':10,
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
red_content = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':9,
    'border_color':b_color,
    'num_format': '[$$-409]#,##0.00'})

red_content_bold = workbook.add_format({
    'bold':True,
    'border': 3,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':10,
    'border_color':'#80848E',
    'num_format': '[$$-409]#,##0.00'})

red_content_date = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':9,
    'border_color':b_color,
    'num_format':'dd/mm/yyyy'})
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
b4n= workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#F4B084',
    'font_size':12,
    'top': 1,
    'left': 1,
    'right':1})
    
b4c = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#F4B084',
    'font_size':13,
    'left': 1,
    'right':1})
    
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
    
#dataframes

df.to_excel(writer, sheet_name='Sheet1', startrow=11,startcol=5, header=False, index=False)
worksheet = writer.sheets['Sheet1']
#Encabezado del documento--------------
worksheet.merge_range('B2:G3', 'TYRSA CONSORCIO S.A. DE C.V. ', rojo_l)
worksheet.merge_range('B4:G4', 'Soluciones en logistica interior', negro_s)
worksheet.merge_range('H2:R3', 'Contraportada Pedido interno No.' + str(orden["invoice"].values[0]), negro_b)
worksheet.merge_range('H4:R4', 'Control de Cobros por P.I.', rojo_b)
worksheet.merge_range('S2:S3', 'PI. Numero', blue_header_format)
worksheet.write('S4', "NOHA-2023", blue_header_format)
worksheet.merge_range('T2:T3', orden['invoice'].values[0], blue_content)
worksheet.write('T4', orden['noha'].values[0], blue_content)
worksheet.insert_image("A1", "img/logo/logo.png",{"x_scale": 0.5, "y_scale": 0.5})
#tabla superior de datos cliente--------------------
worksheet.merge_range('C8:D8', 'CLIENTE', blue_header_format)
worksheet.merge_range('E8:F8', cliente['alias'].values[0], blue_content)
worksheet.merge_range('C9:D9', 'MONEDA', blue_header_format)
worksheet.merge_range('E9:F9', moneda['coin'].values[0], blue_content)
worksheet.merge_range('C10:D10', 'FECHA DD-MM-AAA', blue_header_format)
worksheet.merge_range('E10:F10', str(orden['reg_date'].values[0]), blue_content)

#tabla superior totales
worksheet.write('H6', "SUBTOTAL", red_header_format)
worksheet.merge_range('I6:J6', orden['subtotal'].values[0], red_content)
worksheet.write('H7', "IVA", red_header_format)
worksheet.merge_range('I7:J7',  orden['subtotal'].values[0]*(1-orden['descuento'])*0.16, red_content)

worksheet.write('H8', "DESCUENTO", red_header_format)
worksheet.merge_range('I8:J8',  orden['subtotal'].values[0]*(orden['descuento']), red_content)

worksheet.write('H9', "RETENCION", red_header_format)
worksheet.merge_range('I9:J9',  retencion, red_content)
worksheet.write('H10', "TOTAL (I/I)", red_header_format_bold)
worksheet.merge_range('I10:J10',  orden['total'].values[0], red_content_bold)

#tabla superior facturas
worksheet.write('L8', "FACTURADO", blue_header_format)
worksheet.merge_range('M8:N8', facturas['amount'].sum() -notas['amount'].sum(), blue_content)
worksheet.merge_range('L9:N9', 'IVA INCLUIDO', blue_header_format)
worksheet.write('L10', "POR FACTURAR", blue_header_format)
worksheet.merge_range('M10:N10', orden["total"].values[0]-facturas["amount"].sum()+notas['amount'].sum(), blue_content)

#tabla superior por cobrar ¿?
worksheet.write('P8', "D.A", red_header_format)
worksheet.merge_range('Q8:R8', orden['total'].values[0], red_content)
worksheet.write('S8', "I/I", red_header_format)
worksheet.write('T8', moneda['code'].values[0], red_header_format)
worksheet.write('P9', "COBRADO", red_header_format)
worksheet.merge_range('Q9:R9', cobros['amount'].sum(), red_content)
worksheet.write('S9', "I/I", red_header_format)
worksheet.write('T9', moneda['code'].values[0], red_header_format)
worksheet.write('P10', "POR COBRAR", red_header_format)
worksheet.merge_range('Q10:R10', orden['total'].values[0]-cobros['amount'].sum(), red_content)
worksheet.write('S10', "I/I", red_header_format)
worksheet.write('T10', moneda['code'].values[0], red_header_format)


#tabla programado-----------------------
#     encabezados----------------
worksheet.merge_range('C12:C14', 'COBRO ', blue_header_format)
worksheet.merge_range('D12:G12', 'PI. Programado', blue_header_format)

worksheet.merge_range('D13:D14', 'MONEDA', blue_header_format)
worksheet.merge_range('E13:E14', 'FECHA \n DD-MM-AA', blue_header_format)
worksheet.merge_range('F13:F14', 'IMPORTE $ \n IVA INCLUIDO', blue_header_format)
worksheet.merge_range('G13:G14', '% DEL PAGO PARCIAL', blue_header_format)
#      rellenando la tabla----------------------------------
mac=0
for i in range(0,len(hpagos)):
    worksheet.write('C'+str(15+i), str(i+1), blue_content)
    worksheet.write('D'+str(15+i), moneda['code'].values[0], blue_content)
    worksheet.write('E'+str(15+i), hpagos['date'].values[i], blue_content_date)
    worksheet.write('F'+str(15+i), hpagos['amount'].values[i], blue_content)
    worksheet.write('G'+str(15+i), "{:.2f}".format(hpagos['percentage'].values[i]) + ' %', blue_content)
    mac=mac+hpagos['amount'].values[i]
#tabla facturas-------------------------------
worksheet.merge_range('H12:J12', 'FACTURA', red_header_format)
worksheet.merge_range('H13:H14', 'NUMERO',red_header_format)
worksheet.merge_range('I13:I14', 'FECHA \n DD-MM-AAA',red_header_format)
worksheet.merge_range('J13:J14', 'IMPORTE \n IVA INCLUIDO',red_header_format)
#rellenando la tabla
for i in range(0,len(facturas)):
    worksheet.write('H'+str(15+i), str(facturas['facture'].values[i]), red_content)
    worksheet.write('I'+str(15+i), facturas['date'].values[i], red_content_date)
    worksheet.write('J'+str(15+i), facturas['amount'].values[i], red_content)
for i in range(0,len(notas)):
    worksheet.write('H'+str(15+len(facturas)+i), str(notas['credit_note'].values[i])+' (credito)', red_content)
    worksheet.write('I'+str(15+len(facturas)+i), notas['date'].values[i], red_content_date)
    worksheet.write('J'+str(15+len(facturas)+i), '-$'+ "{:,.2f}".format(notas['amount'].values[i]), red_content)

#tabla  comprobantes de ingreso------------------
worksheet.merge_range('K12:O12', 'COMPROBANTE DE INGRESO (COBRADO REALMENTE)', blue_header_format)
worksheet.merge_range('K13:K14', 'NUMERO', blue_header_format)
worksheet.merge_range('L13:L14', 'FECHA \n DD-MM-AAA', blue_header_format)
worksheet.merge_range('M13:M14', 'MONEDA', blue_header_format)
worksheet.merge_range('N13:N14', 'IMPORTE \n IVA INCLUIDO', blue_header_format)
worksheet.merge_range('O13:O14', '% DEL COBRO PARCIAL', blue_header_format)
#Tabla equivalente- pero sigue siendo la de comprobante eh
worksheet.merge_range('P12:P14', 'TIPO DE \n CAMBIO', red_header_format)
worksheet.merge_range('Q12:R12', 'EQUIVALENTE EN M.N.', red_header_format)
worksheet.merge_range('Q13:Q14', 'IMPORTE $  ACUMULADO', red_header_format)
worksheet.merge_range('R13:R14', '% DE COBRO ACUMULADO', red_header_format)
worksheet.merge_range('S12:U12', 'VALIDACION DEL COBRO', red_header_format)
worksheet.merge_range('S13:U13', 'Vo. Bo.', red_header_format)
worksheet.write('S14', 'CAPTURA', red_header_format)
worksheet.write('T14', 'G.A.', red_header_format)
worksheet.write('U14', 'D.A.', red_header_format)
#rellenando la tabla
importe_acumulado=0
porcentaje_acumulado=0
for i in range(0,len(cobros)):
    porcentaje_acumulado=porcentaje_acumulado+cobros['amount'].values[i]*100/orden['total'].values[0]
    importe_acumulado=importe_acumulado+cobros['amount'].values[i]*cobros['tc'].values[i]
    worksheet.write('K'+str(15+i), str(cobros['comp'].values[i]), blue_content)
    worksheet.write('L'+str(15+i), cobros['date'].values[i], blue_content_date)
    worksheet.write('M'+str(15+i), moneda['code'].values[0], blue_content)
    worksheet.write('N'+str(15+i), cobros['amount'].values[i], blue_content)
    worksheet.write('O'+str(15+i), "{:.2f}".format(cobros['amount'].values[i]*100/orden['total'].values[0])+'%', blue_content)
    worksheet.write('P'+str(15+i), cobros['tc'].values[i], red_content)
    worksheet.write('Q'+str(15+i), importe_acumulado, red_content)
    worksheet.write('R'+str(15+i), "{:.2f}".format(porcentaje_acumulado)+'%', red_content)
    worksheet.write('S'+str(15+i), str(cobros['capturista'].values[i]), red_content)
    worksheet.write('T'+str(15+i), str(cobros['revisor'].values[i]), red_content)
    worksheet.write('U'+str(15+i), str(cobros['autorizador'].values[i]), red_content)


table_len=max(len(hpagos),len(facturas)+len(notas))
table_len=max(table_len,len(cobros))
trow=16+table_len

#validaciones ordenes_internas pagos historicos
worksheet.merge_range('C'+str(trow)+':E'+str(trow), 'TOTALES', blue_header_format_bold)
worksheet.merge_range('C'+str(trow+1)+':E'+str(trow+1), '(DEBE SER 0)', blue_header_format)
worksheet.merge_range('C'+str(trow+2)+':E'+str(trow+2), 'VALIDACION', blue_header_format)

worksheet.write('F'+str(trow),hpagos["amount"].sum() , blue_content_bold)
worksheet.write('F'+str(trow+1),hpagos["amount"].sum() - orden["total"].values[0], blue_content)
if(hpagos["amount"].sum()==orden["total"].values[0] ):
   worksheet.write('F'+str(trow+2),'OK' , blue_content)
else:
    
   worksheet.write('F'+str(trow+2),'NO OK' , blue_content)
worksheet.write('G'+str(trow),"{:.2f}".format(hpagos["percentage"].sum())+'%' , blue_content_bold)
worksheet.write('G'+str(trow+1),"{:.2f}".format(hpagos["percentage"].sum() -100)+'%', blue_content)
if(hpagos["percentage"].sum()==100 ):
   worksheet.write('G'+str(trow+2),'OK' , blue_content)
else:
   worksheet.write('G'+str(trow+2),'NO Ok' , blue_content)


#worksheet.merge_range('H'+str(trow)+':H'+str(trow+2), 'NA', blue_header_format_bold)

worksheet.write('I'+str(trow),'FACTURADO' , red_header_format_bold)
worksheet.write('I'+str(trow+2),'POR FACTURAR' , red_header_format)

worksheet.write('J'+str(trow),facturas["amount"].sum() -notas['amount'].sum(), red_content_bold)
worksheet.write('J'+str(trow+2), orden["total"].values[0]-facturas["amount"].sum()+notas['amount'].sum(), red_content)

#valiaciones cobros
worksheet.write('M'+str(trow),'COBRADO' , blue_header_format_bold)
worksheet.write('M'+str(trow+2),'POR COBRAR' , blue_header_format)
worksheet.write('N'+str(trow),cobros["amount"].sum() , blue_content_bold)
worksheet.write('N'+str(trow+2), orden["total"].values[0]-cobros["amount"].sum(), blue_content)

worksheet.write('O'+str(trow), "{:.2f}".format(cobros["amount"].sum()*100/orden["total"].values[0]) + '%', blue_content)
worksheet.write('O'+str(trow+1), "{:.2f}".format(100 - cobros["amount"].sum()*100/orden["total"].values[0]) + '%', blue_content)

if(cobros["amount"].sum()==orden['total'].values[0] ):
   worksheet.write('O'+str(trow+2),'OK' , blue_content_bold)
else:
   worksheet.write('O'+str(trow+2),'NO OK' , blue_content_bold)


worksheet.merge_range('P'+str(trow)+':U'+str(trow),'EQUIVALENTE EN MONEDA NACIONAL (IVA INCLUIDO))', red_header_format_bold)
worksheet.merge_range('P'+str(trow+1)+':Q'+str(trow+1),'D.A.', red_header_format)
worksheet.merge_range('R'+str(trow+1)+':S'+str(trow+1),'Cobrado', red_header_format)
worksheet.merge_range('T'+str(trow+1)+':U'+str(trow+1),'Por cobrar', red_header_format)
worksheet.merge_range('P'+str(trow+2)+':Q'+str(trow+2),orden['total'].values[0], red_content)
worksheet.merge_range('R'+str(trow+2)+':S'+str(trow+2),cobros["amount"].sum(), red_content)
worksheet.merge_range('T'+str(trow+2)+':U'+str(trow+2),orden["total"].values[0]-cobros["amount"].sum(),red_content)


worksheet.write(trow+4, 5, 'OBSERVACIONES',negro_b)    
if(orden["observations"].values[0]!=None):
   worksheet.merge_range(trow+5,1,trow+8,18, str(orden["observations"].values[0]), observaciones_format)
else:    
   worksheet.merge_range(trow+5,1,trow+8,18,'SIN OBSERVACIONES', observaciones_format)



worksheet.set_column('F:F',15)
worksheet.set_column('L:L',15)
worksheet.set_column('H:H',15)
worksheet.set_column('P:Q',15)
worksheet.set_column('N:N',15)
worksheet.set_column('J:J',15)

worksheet.set_column('O:O',14)
worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
workbook.close()