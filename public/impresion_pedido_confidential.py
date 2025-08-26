from xltpl.writerx import BookWriter  # writerx = para .xlsx (openpyxl)
import sys
import mysql.connector
import xlsxwriter
import pandas as pd
import sys
import mysql.connector
import os
from dotenv import load_dotenv
import num2words
import numpy as np
load_dotenv()
#ESTE ARGUMENTO NO SE USA EN ESTE REPORTE, SERÁ 0 SIEMPRE UWU
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

id=str(sys.argv[1])
#traer datos de los pedidos
order=pd.read_sql(f"""select internal_orders.* ,customers.clave,customers.alias,
coins.exchange_sell, coins.coin, coins.symbol,coins.code
from ((
    internal_orders
    inner join customers on customers.id = internal_orders.customer_id )
    inner join coins on internal_orders.coin_id = coins.id)
                    where internal_orders.id  = {id}
     """,cnx)
order['status']=order['status'].str.upper()
for col in ["reg_date","date_delivery","instalation_date"]:
    order[col] = pd.to_datetime(order[col], format="%Y-%m-%d").dt.strftime("%d-%m-%Y")
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
pagos=pd.read_sql(f"select * from payments where order_id ={order['id'].values[0]}",cnx)

pagos['dia_anio']=pd.to_datetime(pagos["date"], format="%Y-%m-%d").dt.dayofyear
pagos['semana']=pd.to_datetime(pagos["date"], format="%Y-%m-%d").dt.isocalendar().week
pagos['date'] = pd.to_datetime(pagos['date'], format="%Y-%m-%d").dt.strftime("%d-%m-%Y")
comisiones=pd.read_sql(f"""select comissions.*,sellers.iniciales,sellers.seller_name from comissions
                       inner join sellers on sellers.id=comissions.seller_id
                        where order_id ={order['id'].values[0]}""",cnx)
letter_total=num2words.num2words(order['total'].values[0], lang='es')
# # Datos a renderizar (puedes anidar dicts/listas sin problema)
payload = {
    "fecha": "2025-08-16",
    'letter_total':letter_total,
    'completer':np.arange(0,13-len(pagos))
}

for df,name in zip([order,customer,seller,customer_adress,coin],["order","customer","seller","customer_adress","coin"]):
    aux_dict={}
    print(name)
    for col in df.columns:
        aux_dict.update({col : df[col].values[0]})
    payload.update({name:aux_dict})
#Colecciones de datos con mas de una fila en el dataframe
for df,name in zip([items,required_signatures,contacts,pagos,comisiones],["items","signatures","contacts","pagos","comisiones"]):
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
    if((name=='contacts')&(len(df)<3)):
        for i in range(3-len(df)):
            objects.append({'customer_contact_name':'NA','customer_contact_office_phone':'-','customer_contact_office_phone_ext':'-',
                            'customer_contact_mobile':'-','customer_contact_email':'-'}) 
    if((name=='items')&(len(df)<3)):
        for i in range(3-len(items)):
            objects.append({'amount':'0',})         
    payload.update({name:objects})
# #Renderizar excel
writer = BookWriter('plantilla_pedido_confidential.xlsx')
# Renderiza (se pasa una lista de payloads si quieres varias “páginas/hojas”)
writer.render_book([payload])

# Guarda el resultado
writer.save(f'storage/report/impresion_pedido_confidential{id}.xlsx')