#!C:\Users\willi\AppData\Local\Programs\Python\Python38-32\python.exe
#!/usr/bin/python

import numpy as np 
import pandas as pd 
import matplotlib.pyplot as plt
import psycopg2
import time
from statsmodels.tsa.seasonal import seasonal_decompose
from statsmodels.tsa.holtwinters import ExponentialSmoothing as HWES
import statsmodels.api as sm


conn = psycopg2.connect(database = "machine_learning", user = "postgres", password = "postgres", host = "localhost", port = "5432")
cur = conn.cursor()

cur.execute("SELECT * from arima")

rowsArima = cur.fetchall()

dataArima = pd.DataFrame(rowsArima,columns = ['Month','Value'])
dataArima.set_index('Month',inplace = True)
dataArima.index = pd.to_datetime(dataArima.index)

cur.execute("SELECT * from hwes")

rowsHwes = cur.fetchall()

dataHwes = pd.DataFrame(rowsHwes,columns = ['Month','Value'])
dataHwes.set_index('Month',inplace = True)
dataHwes.index = pd.to_datetime(dataHwes.index)

cur.execute("SELECT * from real")

rowsReal = cur.fetchall()
dataReal = pd.DataFrame(rowsReal,columns = ['Month','Value'])
dataReal.set_index('Month',inplace = True)
dataReal.index = pd.to_datetime(dataReal.index)


dataReal_date = []
dataReal_value = []
for i in dataReal.values:
    dataReal_value.append(int(i))
for i in dataReal.index:
    dataReal_date.append(str(i)[:10])

dataArima_value = []
for i in dataArima.values:
    dataArima_value.append(int(i))
for i in dataArima.index:
    dataArima_value.append(str(i)[:10])

dataHwes_value = []
for i in dataHwes.values:
    dataHwes_value.append(int(i))
for i in dataReal.index:
    dataHwes_value.append(str(i)[:10])
    
cur.execute("delete from analysis where analysis = 'error';");

print(dataArima)
arimaErrors = [abs(dataReal_value[i]-dataArima_value[i])/dataReal_value[i] for i in range(len(dataReal_value))]
arimaErrorsBias = sum(arimaErrors) * 1.0/len(dataReal_value) * 100

cur.execute("insert into analysis (algo,analysis,value) values (\'SARIMAX\', \'error\',"+str(arimaErrorsBias)+");");

hwesErrors = [abs(dataReal_value[i]-dataHwes_value[i])/dataReal_value[i] for i in range(len(dataReal_value))]
hwesErrorsBias = sum(hwesErrors) * 1.0/len(dataReal_value) * 100
cur.execute("insert into analysis (algo,analysis,value) values (\'HWES\', \'error\',"+str(hwesErrorsBias)+");");

conn.commit()
