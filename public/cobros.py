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
cobros=pd.read_sql('select * from cobros',cnx)
cobros=cobros.fillna(0)
# for i in range(0,len(cobros)):
#     if(cobros['facture_id'].values[i]!=0):
#         print(i)
#         cursor.execute('insert into cobro_factures(cobro_id,facture_id) values('+str(cobros['id'].values[i])+','+str(cobros['facture_id'].values[i])+')')

for i in range(0,len(cobros)):
    if(cobros['order_id'].values[i]!=0):
        print(i)
        cursor.execute('insert into cobro_orders(cobro_id,order_id,amount) values('+str(cobros['id'].values[i])+','+str(cobros['order_id'].values[i])+','+str(cobros['amount'].values[i])+')')


cnx.commit()