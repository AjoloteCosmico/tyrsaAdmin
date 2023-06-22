import pandas as pd
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
tipo=str(sys.argv[2])
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


pagos=pd.read_sql(query,cnx)
#order_id=pagos.loc[(pagos["id"]==int(id),"order_id") ].values[0]
order_id=int(id)
thisAllPays=pagos.loc[(pagos["order_id"]==order_id) ]
print(order_id)
orden = pd.read_sql("select * from internal_orders where id="+str(order_id),cnx)
cliente = pd.read_sql("select * from customers where id = "+str(orden["customer_id"].values[0]),cnx)
moneda = pd.read_sql("select * from coins where id="+str(orden["coin_id"].values[0]),cnx)

items = pd.read_sql("select * from items where internal_order_id="+str(order_id),cnx)
writer = pd.ExcelWriter("storage/report/factura_resumida"+str(id)+".xlsx", engine='xlsxwriter')

df=thisAllPays[["date","order_id","created_at","updated_at","nfactura",
"ncomp","date","date","date","moneda","moneda","tipo_cambio","amount","moneda","capturista","moneda","moneda","status"]]
df.to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=2, header=False, index=False)
thisAllPays["concept"].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=10, header=False, index=False)
thisAllPays["ncomp"].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=6, header=False, index=False)
#thisAllPays["status"].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=6, header=False, index=False)

workbook = writer.book
##FORMATOS PARA EL TITULO---------------------------------------
azul_g = workbook.add_format({
    'bold': 1,
    'border': 0,
    'align': 'center',
    'valign': 'vcenter',
    #'fg_color': 'yellow',
    'font_color': '#0070C0',
    'font_size':17})
rojo_g = workbook.add_format({
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
 
azulito = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'fg_color': '#B4C6E7',
    'font_size':12})
#FORMATOS PARA CABECERAS DE TABLA --------------------------------
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

blue_content = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12,
    'border_color':a_color})

blue_content_bold = workbook.add_format({
    'bold': True,
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12,
    'border_color':a_color,
    'font_size':13})
yellow_content = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12,
    'border_color':'#e8b321'})
red_content = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12,
    'border_color':b_color})

green_content = workbook.add_format({
    'border': 3,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12,
    'border_color':b_color})
red_content_bold = workbook.add_format({
    'bold':True,
    'border': 3,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':13,
    'border_color':'#80848E'})

header_format = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color': 'yellow',
    'border': 1})

header_format_green = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color': 'yellow',
    'font_color':'green',
    'border': 1})
#FORMATOS PARA TABLAS PER CE------------------------------------
tabla_normal = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12})
    
thisAllPays=pagos.loc[pagos["order_id"]==order_id ]
worksheet = writer.sheets['Sheet1']
worksheet.write(3, 20, orden["invoice"].values[0], azul_g)
# Encabezado.
worksheet.merge_range('G2:N2', 'FACTURA RESUMIDA ', azul_g)
worksheet.merge_range('G3:N3', 'CUENTAS POR COBRAR DE PEDIDOS INTERNOS', azul_g)

worksheet.set_column(2, 2, 20)
worksheet.set_column(10, 10, 20)
worksheet.set_column(15, 15, 20)
#Dataframe yellow headers bitch xd
worksheet.merge_range('B6:B7', 'NOH', header_format)
worksheet.merge_range('C6:C7', 'FECHA D-M-A', header_format)
worksheet.merge_range('D6:D7', 'P.I. NO.', header_format)
worksheet.merge_range('E6:E7', 'NUMERO DE COBRO', header_format)
worksheet.merge_range('F6:F7', 'NUMERO TOTAL DE COBROS', header_format)
worksheet.merge_range('G6:G7', 'FACTURA FOLIO NO.', header_format)
worksheet.merge_range('H6:H7', 'CLIENTE NO', header_format)
worksheet.merge_range('I6:I7', 'NOMBRE CORTO CLIENTE', header_format)
worksheet.merge_range('J6:J7', 'CATEGORIA EQUIPO', header_format)
worksheet.merge_range('K6:K7', 'DESCRIPCION BREVE', header_format)
worksheet.merge_range('L6:L7', 'UBI / SUC / TIENDA PROYECTO', header_format)
worksheet.merge_range('M6:M7', 'TIPO DE MONEDA', header_format)
worksheet.merge_range('N6:N7', 'TIPO DE CAMBIO', header_format)


worksheet.merge_range('O6:P6', 'IMPORTE TOTAL SIN IVA', header_format)
worksheet.write(6, 14, "DLLS", header_format_green)
worksheet.write(6, 15, "M.N.(Equivalente)", header_format)

worksheet.merge_range('Q6:Q7', 'CAPTURO', header_format)
worksheet.merge_range('R6:R7', 'REVISO', header_format)
worksheet.merge_range('S6:S7', 'AUTORIZO', header_format)
worksheet.merge_range('T6:T7', 'STATUS', header_format)

##columnas y tablas como tal pues
for i in range(0,len(df)):
     worksheet.write(7+i, 1, i+1,azulito)

for i in range(0,len(df)):
     worksheet.write(7+i, 3, orden["invoice"].values[0],tabla_normal)

for i in range(0,len(df)):
     worksheet.write(7+i, 4, i+1,tabla_normal)
     worksheet.write(7+i, 12, moneda["code"].values[0],tabla_normal)
     worksheet.write(7+i, 11, cliente["customer_suburb"].values[0],tabla_normal)
     worksheet.write(7+i, 9, items["family"].values[0],tabla_normal)
total_mn=0
pagados=thisAllPays.loc[thisAllPays["status"]=="pagado"]
for i in range(0,len(pagados)):
         equivalente= pagados["amount"].values[i]*float(pagados["tipo_cambio"].values[i])
         total_mn=total_mn+equivalente
         worksheet.write(7+i, 15,equivalente,tabla_normal)


for i in range(0,len(df)):
     worksheet.write(7+i, 5, len(df),tabla_normal)
     worksheet.write(7+i, 7, cliente["id"].values[0],tabla_normal)
     worksheet.write(7+i, 8, cliente["alias"].values[0],tabla_normal)

#barra inferior de totales
trow=8+len(df)
worksheet.write(20, 20, len(df),header_format)
worksheet.merge_range(trow,12,trow,13 ,'Total sin iva', header_format)
worksheet.write(trow, 14, df["amount"].sum(),header_format_green)
worksheet.write(trow, 15, total_mn,header_format)
     
workbook.close()

