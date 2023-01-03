import pandas as pd
import sys
import mysql.connector
import xlsxwriter
import pandas as pd
import sys
import mysql.connector
ncomp=str(sys.argv[1])
# initialize list of lists
cnx = mysql.connector.connect(user='tyrsa',
                              password='1234',
                              host='localhost',
                              port='3306',
                              database='u458219132_tyrsawesadmin',
                              use_pure=False)

query = ('SELECT p.date, p.banco, p.nfactura, i.invoice, c.customer, coins.code, p.tipo_cambio, p.amount, p.ncomp, p.capturista FROM customers as c inner join internal_orders as i on i.customer_id = c.id inner join payments as p on p.order_id=i.id inner join coins on coins.id = i.coin_id WHERE p.ncomp = '+str(ncomp)+" and p.status= 'pagado';")
pagos=pd.read_sql(query,cnx)

writer = pd.ExcelWriter("storage/report/comprobante_ingresos"+str(ncomp)+".xlsx", engine='xlsxwriter')
pagos[["date","banco"]].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=2, header=False, index=False)
pagos[["nfactura","invoice","customer"]].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=4, header=False, index=False)
pagos[["code","tipo_cambio","amount"]].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=8, header=False, index=False)
pagos["capturista"].to_excel(writer, sheet_name='Sheet1', startrow=7,startcol=12, header=False, index=False)

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
tabla_celeste = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'fg_color': '#8CC5FF',
    'font_size':12})
        
worksheet = writer.sheets['Sheet1']
worksheet.write(3, 20, pagos["ncomp"].values[0], azul_g)

# Encabezado.
worksheet.merge_range('G2:N2', 'COMPROBANTE DE INGRESOS NO. '+str(pagos["ncomp"].values[0]), azul_g)
worksheet.merge_range('G3:N3', 'CUENTAS COBRADAS DE PEDIDOS INTERNOS', azul_g)


worksheet.set_column(2, 2, 20)
worksheet.set_column(11, 11, 20)

#Dataframe yellow headers bitch xd
worksheet.merge_range('B6:B7', 'PDA', header_format)
worksheet.merge_range('C6:C7', 'FECHA D-M-A', header_format)
worksheet.merge_range('D6:D7', 'BANCO', header_format)
worksheet.merge_range('E6:E7', 'FACTURA NO.', header_format)
worksheet.merge_range('F6:F7', 'PI No.', header_format)
worksheet.merge_range('G6:H7', 'CLIENTE', header_format)
worksheet.merge_range('I6:I7', 'MONEDA', header_format)
worksheet.merge_range('J6:J7', 'TC', header_format)

worksheet.merge_range('K6:L6', 'IMPORTE TOTAL ', header_format)
worksheet.write('K7', 'DLLS', header_format)
worksheet.write('L7', 'M.N.', header_format)

worksheet.merge_range('M6:M7', 'CAPTURO', header_format)
worksheet.merge_range('N6:N7', 'REVISO', header_format)
worksheet.merge_range('O6:O7', 'AUTORIZO', header_format)
#CELDAS
total_mn=0
for i in range(0,len(pagos)):
         equivalente= pagos["amount"].values[i]*float(pagos["tipo_cambio"].values[i])
         total_mn=total_mn+equivalente
         worksheet.write(7+i, 11,equivalente,tabla_normal)
         worksheet.write(7+i, 1, i+1,tabla_celeste)

trow=7+len(pagos)
worksheet.merge_range(trow,8,trow,9 ,'Total sin iva', header_format)
worksheet.write(trow, 10, pagos["amount"].sum(),header_format_green)
worksheet.write(trow, 11, total_mn,header_format)
     
worksheet.conditional_format(xlsxwriter.utility.xl_range(7, 2, 6+len(pagos), 14), {'type': 'no_errors', 'format': tabla_normal})

workbook.close()

import excel2img

excel2img.export_img('storage/report/comprobante_ingresos'+str(ncomp)+'.xlsx','storage/report/comprobante_ingresos'+str(ncomp)+'.png')
from PIL import Image
image_1 = Image.open('storage/report/comprobante_ingresos'+str(ncomp)+'.png',)
im_1 = image_1.convert('RGB')
im_1.save('storage/report/comprobante_ingresos'+str(ncomp)+'.pdf')



