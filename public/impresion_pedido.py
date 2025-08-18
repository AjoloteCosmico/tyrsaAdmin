from xltpl.writerx import BookWriter  # writerx = para .xlsx (openpyxl)
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

# join para cobros
# cobros=pd.read_sql('Select cobros.* ,customers.customer,internal_orders.invoice, users.name from ((cobros inner join internal_orders on internal_orders.id = cobros.order_id) inner join customers on customers.id = internal_orders.customer_id )inner join users on cobros.capturo=users.id',cnx)

# Carga la plantilla

# id=808

id=str(sys.argv[1])

#traer datos de los pedidos
order=pd.read_sql(f"""Select internal_orders.* ,customers.clave,customers.alias,
coins.exchange_sell, coins.coin, coins.symbol,coins.code
from ((
    internal_orders
    inner join customers on customers.id = internal_orders.customer_id )
    inner join coins on internal_orders.coin_id = coins.id)
                    where internal_orders.id  = {id}
     """,cnx)
customer=pd.read_sql(f"select * from customers where id ={order['customer_id'].values[0]}",cnx)
seller=pd.read_sql(f"select * from sellers where id ={order['seller_id'].values[0]}",cnx)
customer_adress=pd.read_sql(f"select * from 	customer_shipping_addresses	 where customer_id ={order['customer_id'].values[0]}",cnx)
contacts=pd.read_sql(f"select customer_contacts.* from order_contacts  inner join customer_contacts on customer_contacts.id=order_contacts.contact_id where order_contacts.order_id ={order['id'].values[0]}",cnx)
coin=pd.read_sql(f"select * from coins where id ={order['coin_id'].values[0]}",cnx)
items=pd.read_sql(f"select * from items where internal_order_id ={order['id'].values[0]}",cnx)
required_signatures=pd.read_sql(f"""select signatures.*,authorizations.titulo 
                                from authorizations  inner join signatures 
                                on authorizations.id=signatures.auth_id
                                 where signatures.order_id ={order['id'].values[0]}""",cnx)
order['status']=order['status'].str.upper()
print(len(contacts))
# # Datos a renderizar (puedes anidar dicts/listas sin problema)
payload = {
    
    "fecha": "2025-08-16",
}

for df,name in zip([order,customer,seller,customer_adress,coin],["order","customer","seller","customer_adress","coin"]):
    aux_dict={}
    print(name)
    for col in df.columns:
        aux_dict.update({col : df[col].values[0]})
    payload.update({name:aux_dict})
#Colecciones de datos con mas de una fila en el dataframe
for df,name in zip([items,required_signatures,contacts],["items","signatures","contacts"]):
    objects=[]
    print(name,len(df))
    aux_dict={}
    for i in range(len(df)):
        item={}
        for col in df.columns:
            item.update({col : df[col].values[i]})
        objects.append(item)
    if(name=='signatures'):
        for i in range(5-len(required_signatures)):
            objects.append({'firma':'FIRMA','titulo':'Autorizacion'})
            

    payload.update({name:objects})
# #Renderizar excel
writer = BookWriter('plantilla_pedido.xlsx')
# # Renderiza (se pasa una lista de payloads si quieres varias “páginas/hojas”)
writer.render_book([payload])

# # Guarda el resultado
writer.save(f'storage/report/impresion_pedido{id}.xlsx')
# from openpyxl import load_workbook

# # Abre el archivo generado por xltpl
# wb = load_workbook(f'storage/report/temp.xlsx')
# ws = wb.active  # o wb["NombreDeHoja"]

# # Configurar impresión
# ws.page_setup.orientation = ws.ORIENTATION_PORTRAIT   # Vertical
# ws.page_setup.fitToWidth = 1  # Ajustar a 1 página de ancho
# ws.page_setup.fitToHeight = 3  # Ajustar a 3 páginas de alto

# # Guardar cambios
# wb.save(f'storage/report/impresion_pedido{id}.xlsx')