import pandas as pd
import sys
import mysql.connector
id=str(sys.argv[1])
# initialize list of lists
cnx = mysql.connector.connect(user='tyrsa',
                              password='1234',
                              host='localhost',
                              port='8111',
                              database='u458219132_tyrsawesadmin',
                              use_pure=False)

query = ('SELECT * from payments')
pagos=pd.read_sql(query,cnx)
#order_id=pagos.loc[(pagos["id"]==int(id),"order_id") ].values[0]
order_id=int(id)
thisPays=pagos.loc[(pagos["order_id"]==order_id)&(pagos["status"]=="pagado") ]
print(order_id)
orden = pd.read_sql("select * from internal_orders where id="+str(order_id),cnx)
cliente = pd.read_sql("select * from customers where id = "+str(orden["customer_id"].values[0]),cnx)
moneda = pd.read_sql("select * from coins where id="+str(orden["coin_id"].values[0]),cnx)


query = ('SELECT * from internal_orders')
nordenes=len(pd.read_sql(query,cnx))


pac=0#porcentaje acumulado
mac=0#monto acumulado
thisPays=thisPays.reset_index(drop=True)
df=thisPays[["nfactura","ncomp","moneda","fecha_factura","amount","percentage","tipo_cambio","importe_acumulado","porcentaje_acumulado"]]
df=df.reset_index(drop=True)
cambio_actual=0
for i in df.itertuples():
    pac=pac+i[6]
    df.iloc[i[0],8]=pac
    
    if(i[7]>0):
        cambio_actual=i[7]
        mac=mac+(i[5]*i[7])
    else:
        mac=mac+i[5]
    df.iloc[i[0],7]=mac
    df.iloc[i[0],2]=str(moneda["code"].values[0])



thisAllPays=pagos.loc[(pagos["order_id"]==order_id) ]
writer = pd.ExcelWriter('storage/report/contraportada'+str(order_id)+'.xlsx', engine='xlsxwriter')

import xlsxwriter
workbook = writer.book
##FORMATOS PARA EL TITULO---------------------------------------
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

#FORMATOS PARA CABECERAS DE TABLA --------------------------------
header_format = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'center',
    'fg_color': 'yellow',
    'border': 1})

blue_header_format = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'border_color':'blue',
    'border': 1})

blue_hf = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'border_color':'blue',
    'font_color': 'blue',
    'border': 1})


#FORMATOS PARA TABLAS PER CE------------------------------------
tabla_normal = workbook.add_format({
    'border': 1,
    'align': 'center',
    'valign': 'vcenter',
    'font_color': 'black',
    'font_size':12})
    
tabla_prog = workbook.add_format({
    'bold': True,
    'text_wrap': True,
    'valign': 'top',
    'fg_color':'#F4B084',
    'border': 1,
    'border_color':'blue',})
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

df.to_excel(writer, sheet_name='Sheet1', startrow=9,startcol=6, header=False, index=False)
prog=thisAllPays[["moneda","fecha_factura","amount","percentage"]]
prog.to_excel(writer, sheet_name='Sheet1', startrow=9,startcol=2, header=False, index=False)
worksheet = writer.sheets['Sheet1']
worksheet.set_column(2,19,15)
#celdas del dataframe
worksheet.conditional_format(xlsxwriter.utility.xl_range(9, 6, 9+len(df), 6+len(df.columns)+2), {'type': 'no_errors', 'format': tabla_normal})
worksheet.conditional_format(xlsxwriter.utility.xl_range(9, 1, 9+len(prog), 2+len(prog.columns)), {'type': 'no_errors', 'format': tabla_prog})

# Write the column headers with the defined format.
worksheet.merge_range(7,6,8,6, "FACTURA NUMERO",header_format)
worksheet.merge_range(7,7,8,7, "COMPROBANTE DE INGRESOS NUMERO",header_format)

worksheet.merge_range('I8:L8', 'REAL', header_format)
worksheet.write(8, 8, "MONEDA", header_format)
worksheet.write(8, 9, "FECHA DD-MM-AA", header_format)
worksheet.write(8, 10, "IMPORTE $ IVA INCLUIDO", header_format)
worksheet.write(8, 11, "% DEL COBRO PARCIAL", header_format)

worksheet.merge_range(7,12,8,12, "TIPO DE CAMBIO",header_format)

worksheet.merge_range(7,13,7,14, "EQUIVALENTE EN M.N.",header_format)
worksheet.write(8,13 ,"IMPORTE ACUMULADO",header_format)
worksheet.write(8,14 ,"PORCENTAJE DEL COBRO ACUMULADO",header_format)


for j in range(1,len(prog)+1):
    worksheet.write(8+j, 1, 'Cobro'+str(j), negro_b)

for j in range(1,len(df)+1):
    worksheet.write(8+j, 15, 'Nombre del capturista', negro_s)

for j in range(1,len(df)+1):
    worksheet.write(8+j, 16, 'Nombre del gerente', negro_s)

for j in range(1,len(df)+1):
    worksheet.write(8+j, 17, 'Nombre del administrador', negro_s)

worksheet.merge_range(7,15,7,17, "VERIFICACION DEL COBRO",header_format)
worksheet.write(8, 15, 'captura', header_format)
worksheet.write(8, 16, 'GA', header_format)
worksheet.write(8, 17, 'DA', header_format)

#cabeceras
worksheet.merge_range('B8:B9', 'COBRO', blue_header_format)
worksheet.merge_range('C8:F8', 'Progrmado', blue_hf)
worksheet.write(8, 2, 'Moneda', blue_hf)
worksheet.write(8, 3, 'Fecha', blue_hf)
worksheet.write(8, 4, 'Importe', blue_hf)
worksheet.write(8, 5, "% de Cobro", blue_hf)

worksheet.write(3, 20, orden["invoice"].values[0], rojo_g)
worksheet.write(5, 18,'$'+ str(orden["total"].values[0]), negro_b)
worksheet.write(6, 18, moneda["code"].values[0], negro_b)
worksheet.merge_range('N6:Q6', 'IMPORTE TOTAL DEL PEDIDO IVA INCLUIDO', negro_s)
worksheet.merge_range('N7:Q7', 'TIPO DE MONEDA', negro_s)
# Encabezado.
worksheet.merge_range('G2:N2', 'TYRSA CONSORCIO S.A. DE C.V. ', rojo_g)
worksheet.merge_range('G3:N3', 'Soluciones en logistica interior', negro_s)
worksheet.merge_range('G4:N4', 'Contraportada Pedido interno No.' + str(orden["invoice"].values[0]), negro_b)
worksheet.merge_range('G5:N5', 'Control de Cobros por P.I.', rojo_b)
worksheet.write(4, 20, nordenes, rojo_b)
worksheet.write(4, 18, "NHO-2022", negro_b)
###--------------barras inferiores de totales y sumas
trow=len(prog)+11

worksheet.set_row(trow-1, 5) 
worksheet.write(trow,3,"Totales  ", b1ne)
worksheet.write(trow+1,3,"Validacion ", b1e)
worksheet.write(trow+2,3,"(Debe ser 0)", b1se)
worksheet.conditional_format(xlsxwriter.utility.xl_range(trow,2,trow,2 ), {'type': 'no_errors', 'format': b1n})
worksheet.conditional_format(xlsxwriter.utility.xl_range(trow,1,trow,1 ), {'type': 'no_errors', 'format': b1no})
worksheet.conditional_format(xlsxwriter.utility.xl_range(trow+1,1,trow+1,1 ), {'type': 'no_errors', 'format': b1o})
worksheet.conditional_format(xlsxwriter.utility.xl_range(trow+2,1,trow+2,1 ), {'type': 'no_errors', 'format': b1so})
worksheet.conditional_format(xlsxwriter.utility.xl_range(trow+2,2,trow+2,2 ), {'type': 'no_errors', 'format': b1s})




worksheet.write(trow,4,"$"+str(prog["amount"].sum()), b2n)
worksheet.write(trow+1,4,"$"+str(orden["total"].values[0]-prog["amount"].sum()),  b2c)
worksheet.write(trow+2,4,"okay", b2s)

worksheet.write(trow,5,str(prog["percentage"].sum())+'%',b2n)
worksheet.write(trow+1,5,str(100-prog["percentage"].sum())+'%',  b2c)
worksheet.write(trow+2,5,"okay",  b2s)

worksheet.conditional_format(xlsxwriter.utility.xl_range(trow+1,1,trow+1,1 ), {'type': 'no_errors', 'format': b1o})
worksheet.conditional_format(xlsxwriter.utility.xl_range(trow+2,1,trow+2,1 ), {'type': 'no_errors', 'format': b1so})
worksheet.conditional_format(xlsxwriter.utility.xl_range(trow+2,2,trow+2,2 ), {'type': 'no_errors', 'format': b1s})


worksheet.write(trow,9,"Totales  ", b3n)
worksheet.write(trow+1,9,"Validacion ", b3c)
worksheet.write(trow+2,9,"(Debe ser 0)", b3s)

worksheet.write(trow,10,"$"+str(df["amount"].sum()), b4n)
worksheet.write(trow+1,10,"$"+str(orden["total"].values[0]-df["amount"].sum()),  b4c)
worksheet.write(trow+2,10,"okay",  b4s)

worksheet.write(trow,11,str(df["percentage"].sum())+'%', b4n)
worksheet.write(trow+1,11,str(100-df["percentage"].sum())+'%',  b4c)
worksheet.write(trow+2,11,"okay",  b4s)

#calcular equivalente a moneda nacional



worksheet.merge_range(trow,12,trow,17, 'Equivalente en moneda nacional incluye IVA', header_format)
worksheet.merge_range(trow+1,12,trow+1,13, 'DA',header_format)
worksheet.merge_range(trow+1,14,trow+1,15, 'COBRADO',header_format)
worksheet.merge_range(trow+1,16,trow+1,17, 'POR COBRAR',header_format)
worksheet.merge_range(trow+2,12,trow+2,13,"$"+str(orden["total"].values[0]*cambio_actual) ,total_cereza_format)
worksheet.merge_range(trow+2,14,trow+2,15, "$"+str(df["amount"].sum()*cambio_actual),total_cereza_format)
worksheet.merge_range(trow+2,16,trow+2,17, '$'+str((orden["total"].values[0]-df["amount"].sum())*cambio_actual),total_cereza_format)

worksheet.write(trow+4, 5, 'OBSERVACIONES',negro_b)
worksheet.merge_range(trow+5,1,trow+8,18, str(orden["observations"].values[0]), observaciones_format)

workbook.close()