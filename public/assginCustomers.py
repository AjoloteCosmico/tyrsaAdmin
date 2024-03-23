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

DB_USERNAME = os.getenv('DB_USERNAME')
DB_DATABASE = os.getenv('DB_DATABASE')
DB_PASSWORD = os.getenv('DB_PASSWORD')
DB_PORT = os.getenv('DB_PORT')
cnx = mysql.connector.connect(user=DB_USERNAME,
                              password=DB_PASSWORD,
                              host='localhost',
                              port=DB_PORT,
                              database=DB_DATABASE,
                              use_pure=False)
cursor=cnx.cursor(buffered=True)
pedidos=pd.read_sql('select * from internal_orders',cnx)

# for i in range(0,len(cobros)):
#     if(cobros['facture_id'].values[i]!=0):
#         print(i)
#         cursor.execute('insert into cobro_factures(cobro_id,facture_id) values('+str(cobros['id'].values[i])+','+str(cobros['facture_id'].values[i])+')')

for i in range(0,len(pedidos)):
    cursor.execute('update customers set seller_id='+str(pedidos['seller_id'].values[i])+'where customer.id ='+str(pedidos['customer_id'].values[i]))

cnx.commit()