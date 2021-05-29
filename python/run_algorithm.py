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

cur.execute("delete from arima")
cur.execute("delete from hwes")
cur.execute("delete from analysis where analysis = 'time';");

cur.execute("SELECT * from dummy")

rows = cur.fetchall()

dataToPredict = pd.DataFrame(rows,columns = ['Month','Passengers'])
dataToPredict.set_index('Month',inplace = True)
dataToPredict.index = pd.to_datetime(dataToPredict.index)


cur.execute("SELECT * from real")

rows2 = cur.fetchall()
dataReal = pd.DataFrame(rows2,columns = ['Month','Value'])
dataReal.set_index('Month',inplace = True)
dataReal.index = pd.to_datetime(dataReal.index)

period = 2 #in years
#cur.execute("update flag set progress = 'Arima Done', id = 2 where id = 1;")
#conn.commit()

#result.plot()
#plt.show()

from pmdarima import auto_arima 
import warnings 
warnings.filterwarnings("ignore") 


# Split data into train sets 
train = dataToPredict.iloc[:len(dataToPredict)] 

'''
ARIMA
'''
# Fit a SARIMAX(0, 1, 1)x(2, 1, 1, 12) on the training set 
from statsmodels.tsa.statespace.sarimax import SARIMAX 
start_time = time.time()
model_sarimax = SARIMAX(train['Passengers'],  
                order = (0, 1, 1),  
                seasonal_order =(2, 1, 1, 12)) 
  
result_sarimax = model_sarimax.fit() 

# Forecast for the next 3 years 
forecast_sarimax = result_sarimax.predict(start = len(train),  
                          end = (len(train)-1) + (period) * 12,  
                         typ = 'levels').rename('Forecast')
end_time = time.time()
arima_time = end_time - start_time
'''
END ARIMA
'''


'''
HWES
'''
#build and train the model on the training data
start_time = time.time()
model_hwes = HWES(train, seasonal_periods=(period) * 12, trend='add', seasonal='mul')
fitted_hwes = model_hwes.fit(optimized=True, use_brute=True)

#create an out of sample forcast for the next 12 steps beyond the final data point in the training data set
forecast_hwes = fitted_hwes.forecast((period)*12)
end_time = time.time()
hwes_time = end_time - start_time
'''
END HWES
'''

'''
SES

from statsmodels.tsa.arima.model import ARIMA
  
model_arima = ARIMA(train['Passengers'],  
                order = (0, 1, 1),  
                seasonal_order =(2, 1, 1, 12)) 
  
model_fit_arima = model_arima.fit()
forecast_arima = model_fit_arima.forecast(steps = 48)

#print(forecast)
#print(forecast_hwes)
#print(forecast_arima)
'''


test = dataToPredict.iloc[len(dataToPredict)-24:] 
pred_date = []
pred_value = []
for i in forecast_sarimax.values:
    pred_value.append(i)
for i in forecast_sarimax.index:
    pred_date.append(str(i)[:10])
for i in range(0,len(pred_date)-1):
    cur.execute("insert into arima (month,value) values (\'"+str(pred_date[i])+"\',"+str(round(pred_value[i]))+");");


pred2_date = []
pred2_value = []
for i in forecast_hwes.values:
    pred2_value.append(i)
for i in forecast_hwes.index:
    pred2_date.append(str(i)[:10])
for i in range(0,len(pred2_date)-1):
    cur.execute("insert into hwes (month,value) values (\'"+str(pred2_date[i])+"\',"+str(round(pred2_value[i]))+");");

dataReal_date = []
dataReal_value = []
for i in dataReal.values:
    dataReal_value.append(int(i))
for i in forecast_hwes.index:
    dataReal_date.append(str(i)[:10])
    
dataTest = []
for i in test.values:
    dataTest.append(i)

cur.execute("insert into analysis (algo,analysis,value) values (\'SARIMAX\', \'time\',"+str(arima_time)+");");
cur.execute("insert into analysis (algo,analysis,value) values (\'HWES\', \'time\',"+str(hwes_time)+");");

'''

pred3_date = []
pred3_value = []
for i in forecast_arima.values[12:]:
    pred3_value.append(i)
for i in forecast_arima.index[12:]:
    pred3_date.append(str(i)[:10])
for i in range(0,len(pred3_date)-1):
    cur.execute("insert into var (month,value) values (\'"+str(pred3_date[i])+"\',"+str(round(pred3_value[i]))+");");
'''
conn.commit()
