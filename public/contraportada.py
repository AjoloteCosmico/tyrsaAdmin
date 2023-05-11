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
cliente = pd.read_sql("select * from customers where id = "+str(orden["customer_id"].values[0]),cnx)
moneda = pd.read_sql("select * from coins where id="+str(orden["coin_id"].values[0]),cnx)
query = ('SELECT * from payments where order_id = '+str(order_id))
#pagos historicos, los que fueron programados en un inicio
hpagos=pd.read_sql(query,cnx)
query = ('SELECT * from internal_orders')
cobros=pd.read_sql("""Select cobros.*,capturistas.name as capturista, revisores.name as revisor, autorizadores.name as autorizador
    from (((cobros 
    left join users as capturistas on cobros.capturo=capturistas.id)
    left join users as revisores on cobros.reviso=revisores.id)
    left join users as autorizadores on cobros.autorizo=autorizadores.id)
    inner join factures on factures.id = cobros.facture_id where cobros.order_id = """+str(order_id),cnx)
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
    'num_format': 'dd/mm/yy'})
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
    'num_format':'dd/mm/yy'})
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

df.to_excel(writer, sheet_name='Sheet1', startrow=9,startcol=5, header=False, index=False)
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
worksheet.merge_range('C6:D6', 'CLIENTE', blue_header_format)
worksheet.merge_range('E6:F6', cliente['alias'].values[0], blue_content)
worksheet.merge_range('C7:D7', 'MONEDA', blue_header_format)
worksheet.merge_range('E7:F7', moneda['coin'].values[0], blue_content)
worksheet.merge_range('C8:D8', 'FECHA DD-MM-AAA', blue_header_format)
worksheet.merge_range('E8:F8', str(orden['reg_date'].values[0]), blue_content)

#tabla superior totales
worksheet.write('H6', "SUBTOTAL", red_header_format)
worksheet.merge_range('I6:J6', '$'+str(orden['subtotal'].values[0]), red_content)
worksheet.write('H7', "IVA", red_header_format)
worksheet.merge_range('I7:J7',  '$'+str(orden['total'].values[0]-orden['subtotal'].values[0]), red_content)
worksheet.write('H8', "TOTAL (I/I)", red_header_format_bold)
worksheet.merge_range('I8:J8',  '$'+str(orden['total'].values[0]), red_content_bold)

#tabla superior facturas
worksheet.write('L6', "FACTURADO", blue_header_format)
worksheet.merge_range('M6:N6', '$'+str(facturas['amount'].sum()), blue_content)
worksheet.merge_range('L7:N7', 'IVA INCLUIDO', blue_header_format)
worksheet.write('L8', "POR FACTURAR", blue_header_format)
worksheet.merge_range('M8:N8', '$'+str(hpagos['amount'].sum() -facturas['amount'].sum()), blue_content)

#tabla superior por cobrar ¿?
worksheet.write('P6', "D.A", red_header_format)
worksheet.merge_range('Q6:R6', str(orden['total'].values[0]), red_content)
worksheet.write('S6', "I/I", red_header_format)
worksheet.write('T6', moneda['code'].values[0], red_header_format)
worksheet.write('P7', "COBRADO", red_header_format)
worksheet.merge_range('Q7:R7', '$'+str(cobros['amount'].sum()), red_content)
worksheet.write('S7', "I/I", red_header_format)
worksheet.write('T7', moneda['code'].values[0], red_header_format)
worksheet.write('P8', "POR COBRAR", red_header_format)
worksheet.merge_range('Q8:R8','$'+ str(orden['total'].values[0]-cobros['amount'].sum()), red_content)
worksheet.write('S8', "I/I", red_header_format)
worksheet.write('T8', moneda['code'].values[0], red_header_format)


#tabla programado-----------------------
#     encabezados----------------
worksheet.merge_range('C10:C12', 'Pago \n (Cobro)', blue_header_format)
worksheet.merge_range('D10:G10', 'PI. Programado', blue_header_format)

worksheet.merge_range('D11:D12', 'MONEDA', blue_header_format)
worksheet.merge_range('E11:E12', 'FECHA \n DD-MM-AA', blue_header_format)
worksheet.merge_range('F11:F12', 'IMPORTE $ \n IVA INCLUIDO', blue_header_format)
worksheet.merge_range('G11:G12', '% DEL PAGO PARCIAL', blue_header_format)
#      rellenando la tabla----------------------------------
mac=0
for i in range(0,len(hpagos)):
    worksheet.write('C'+str(13+i), str(i+1), blue_content)
    worksheet.write('D'+str(13+i), moneda['code'].values[0], blue_content)
    worksheet.write('E'+str(13+i), hpagos['date'].values[i], blue_content_date)
    worksheet.write('F'+str(13+i), hpagos['amount'].values[i], blue_content)
    worksheet.write('G'+str(13+i), "{:.2f}".format(hpagos['percentage'].values[i]) + ' %', blue_content)
    mac=mac+hpagos['amount'].values[i]
#tabla facturas-------------------------------
worksheet.merge_range('H10:J10', 'FACTURA', red_header_format)
worksheet.merge_range('H11:H12', 'NUMERO',red_header_format)
worksheet.merge_range('I11:I12', 'FECHA \n DD-MM-AAA',red_header_format)
worksheet.merge_range('J11:J12', 'IMPORTE \n IVA INCLUIDO',red_header_format)
#rellenando la tabla
for i in range(0,len(facturas)):
    worksheet.write('H'+str(13+i), str(facturas['facture'].values[i]), red_content)
    worksheet.write('I'+str(13+i), facturas['date'].values[i], red_content_date)
    worksheet.write('J'+str(13+i), facturas['amount'].values[i], red_content)
for i in range(0,len(notas)):
    worksheet.write('H'+str(13+len(facturas)+i), str(notas['credit_note'].values[i])+' (credito)', red_content)
    worksheet.write('I'+str(13+len(facturas)+i), notas['date'].values[i], red_content_date)
    worksheet.write('J'+str(13+len(facturas)+i), '-$'+ "{:,.2f}".format(notas['amount'].values[i]), red_content)

#tabla  comprobantes de ingreso------------------
worksheet.merge_range('K10:O10', 'COMPROBANTE DE INGRESO (COBRADO REALMENTE)', blue_header_format)
worksheet.merge_range('K11:K12', 'NUMERO', blue_header_format)
worksheet.merge_range('L11:L12', 'FECHA \n DD-MM-AAA', blue_header_format)
worksheet.merge_range('M11:M12', 'MONEDA', blue_header_format)
worksheet.merge_range('N11:N12', 'IMPORTE \n IVA INCLUIDO', blue_header_format)
worksheet.merge_range('O11:O12', '% DEL PAGO PARCIAL', blue_header_format)
#Tabla equivalente- pero sigue siendo la de comprobante eh
worksheet.merge_range('P10:P12', 'TIPO DE \n CAMBIO', red_header_format)
worksheet.merge_range('Q10:R10', 'EQUIVALENTE EN M.N.', red_header_format)
worksheet.merge_range('Q11:Q12', 'IMPORTE $  ACUMULADO', red_header_format)
worksheet.merge_range('R11:R12', '% DE PAGO ACUMULADO', red_header_format)
worksheet.merge_range('S10:U10', 'VALIDACION DEL COBRO', red_header_format)
worksheet.merge_range('S11:U11', 'Vo. Bo.', red_header_format)
worksheet.write('S12', 'CAPTURA', red_header_format)
worksheet.write('T12', 'G.A.', red_header_format)
worksheet.write('U12', 'D.A.', red_header_format)
#rellenando la tabla
importe_acumulado=0
porcentaje_acumulado=0
for i in range(0,len(cobros)):
    porcentaje_acumulado=porcentaje_acumulado+cobros['amount'].values[i]*100/orden['total'].values[0]
    importe_acumulado=importe_acumulado+cobros['amount'].values[i]*cobros['tc'].values[i]
    worksheet.write('K'+str(13+i), str(cobros['comp'].values[i]), blue_content)
    worksheet.write('L'+str(13+i), cobros['date'].values[i], blue_content_date)
    worksheet.write('M'+str(13+i), moneda['code'].values[0], blue_content)
    worksheet.write('N'+str(13+i), cobros['amount'].values[i], blue_content)
    worksheet.write('O'+str(13+i), "{:.2f}".format(cobros['amount'].values[i]*100/orden['total'].values[0])+'%', blue_content)
    worksheet.write('P'+str(13+i), cobros['tc'].values[i], red_content)
    worksheet.write('Q'+str(13+i), importe_acumulado, red_content)
    worksheet.write('R'+str(13+i), "{:.2f}".format(porcentaje_acumulado)+'%', red_content)
    worksheet.write('S'+str(13+i), str(cobros['capturo'].values[i]), red_content)
    worksheet.write('T'+str(13+i), str(cobros['reviso'].values[i]), red_content)
    worksheet.write('U'+str(13+i), str(cobros['autorizo'].values[i]), red_content)


table_len=max(len(hpagos),len(facturas)+len(notas))
table_len=max(table_len,len(cobros))
trow=14+table_len

#validaciones ordenes_internas pagos historicos
worksheet.merge_range('C'+str(trow)+':E'+str(trow), 'Totales', blue_header_format_bold)
worksheet.merge_range('C'+str(trow+1)+':E'+str(trow+1), '(Debe ser 0)', blue_header_format)
worksheet.merge_range('C'+str(trow+2)+':E'+str(trow+2), 'validacion', blue_header_format)

worksheet.write('F'+str(trow),hpagos["amount"].sum() , blue_content_bold)
worksheet.write('F'+str(trow+1),hpagos["amount"].sum() - orden["total"].values[0], blue_content)
if(hpagos["amount"].sum()==orden["total"].values[0] ):
   worksheet.write('F'+str(trow+2),'Okay' , blue_content)
else:
    
   worksheet.write('F'+str(trow+2),'No Okay' , blue_content)
worksheet.write('G'+str(trow),"{:.2f}".format(hpagos["percentage"].sum()) , blue_content_bold)
worksheet.write('G'+str(trow+1),"{:.2f}".format(hpagos["percentage"].sum() -100), blue_content)
if(hpagos["percentage"].sum()==100 ):
   worksheet.write('G'+str(trow+2),'Okay' , blue_content)
else:
   worksheet.write('G'+str(trow+2),'NO Okay' , blue_content)


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
   worksheet.write('O'+str(trow+2),'Okay' , blue_content_bold)
else:
   worksheet.write('O'+str(trow+2),'NO Okay' , blue_content_bold)


worksheet.merge_range('P'+str(trow)+':U'+str(trow),'Equivalente en moneda nacional (Iva incluido)', red_header_format_bold)
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
   worksheet.merge_range(trow+5,1,trow+8,18,'Sin observaciones', observaciones_format)



worksheet.set_column('F:F',15)
worksheet.set_column('L:L',15)
worksheet.set_column('H:H',15)
worksheet.set_column('P:P',15)
worksheet.set_column('N:N',15)
worksheet.set_column('J:J',15)
worksheet.set_landscape()
worksheet.set_paper(9)
worksheet.fit_to_pages(1, 1)  
workbook.close()