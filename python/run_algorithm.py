#!C:\Users\willi\AppData\Local\Programs\Python\Python38-32\python.exe
#!/usr/bin/python

import numpy as np                  # Unused
import pandas as pd                 # For dataframe
import matplotlib.pyplot as plt     # For ploting graph (unused)
import psycopg2                     # For database control
import time                         # For time record
from statsmodels.tsa.statespace.sarimax import SARIMAX               # SARIMAX
from statsmodels.tsa.holtwinters import ExponentialSmoothing as HWES # HWES
import psutil                       # To monitor CPU usage
import threading                    # To monitor CPU usage
import warnings

warnings.filterwarnings("ignore") 
initialRam = float(psutil.virtual_memory().percent)
initialCpu = float(psutil.Process().cpu_percent(interval=1))
SarimaxCpuUsage = []
SarimaxRamUsage = []
HwesCpuUsage = []
HwesRamUsage = []


#=============================================#
#               Function Def                  #
#=============================================#
def display_cpu(lst,lst2):
    global running

    running = True

    currentProcess = psutil.Process()

    # start loop
    while running:
        lst.append(float(currentProcess.cpu_percent(interval=1)))
        lst2.append(float(psutil.virtual_memory().percent))

def start(lst,lst2):
    global t

    # create thread and start it
    t = threading.Thread(target=display_cpu, args=(lst,lst2,))
    t.start()

def stop():
    global running
    global t

    # use `running` to stop loop in thread so thread will end
    running = False

    # wait for thread's end
    t.join()

def Average(lst):
    if len(lst) == 0:
        return 0
    else:
        return round(sum(lst) / len(lst),2)
#=============================================#
#               Database Conn                 #
#=============================================#
conn = psycopg2.connect(database = "machine_learning", user = "postgres", password = "postgres", host = "localhost", port = "5432")
cur = conn.cursor()


cur.execute("delete from arima")
cur.execute("delete from hwes")
cur.execute("delete from analysis where analysis = 'time';");
cur.execute("delete from analysis where analysis = 'cpuUsage';");
cur.execute("delete from analysis where analysis = 'cpuMax';");
cur.execute("delete from analysis where analysis = 'ram';");
cur.execute("delete from analysis where analysis = 'error';");
cur.execute("SELECT * from dummy")

rows = cur.fetchall()

dataToPredict = pd.DataFrame(rows,columns = ['Month','Passengers'])
dataToPredict.set_index('Month',inplace = True)
dataToPredict.index = pd.to_datetime(dataToPredict.index)


cur.execute("SELECT * from datarange")
dataRange = int(cur.fetchall()[0][0])
years = 2 #in years
period = years * 12
#cur.execute("update flag set progress = 'Arima Done', id = 2 where id = 1;")
#conn.commit()

#=============================================#
#               Arima Algorithm               #
#=============================================#

# Split data into train sets
if (dataRange == 100):
    train = dataToPredict.iloc[:len(dataToPredict)]
else:
    print(len(dataToPredict))
    trainLength = int(len(dataToPredict)*dataRange/100)
    print(trainLength)
    train = dataToPredict.iloc[:trainLength]
    period = int(len(dataToPredict)*(100-dataRange)/100)
    print(period)
    
#=======#
# Arima #
#=======#
start(SarimaxCpuUsage,SarimaxRamUsage)
startTime = time.time()
modelSarimax = SARIMAX(train['Passengers'],  
                order = (0, 1, 1),  
                seasonal_order =(2, 1, 1, 12)) 
  
resultSarimax = modelSarimax.fit() 

forecastSarimax = resultSarimax.predict(start = len(train),  
                          end = (len(train)-1) + period + 2,  
                         typ = 'levels').rename('Forecast')
endTime = time.time()
arimaTime = endTime - startTime
stop()
#=======#
# HWES  #
#=======#
start(HwesCpuUsage,HwesRamUsage)
startTime = time.time()
modelHwes = HWES(train, seasonal_periods=(period + 2), trend='add', seasonal='mul')
fittedHwes = modelHwes.fit(optimized=True, use_brute=True)
forecastHwes = fittedHwes.forecast(period + 2)
endTime = time.time()
hwesTime = endTime - startTime
stop()

#=============================================#
#               Data Pushing                  #
#=============================================#
ArimaDate = []
ArimaValue = []
for i in forecastSarimax.values:
    ArimaValue.append(i)
for i in forecastSarimax.index:
    ArimaDate.append(str(i)[:10])
for i in range(0,len(ArimaDate)-1):
    cur.execute("insert into arima (month,value) values (\'"+str(ArimaDate[i])+"\',"+str(round(ArimaValue[i]))+");");


HwesDate = []
HwesValue = []
for i in forecastHwes.values:
    HwesValue.append(i)
for i in forecastHwes.index:
    HwesDate.append(str(i)[:10])
for i in range(0,len(HwesDate)-1):
    cur.execute("insert into hwes (month,value) values (\'"+str(HwesDate[i])+"\',"+str(round(HwesValue[i]))+");");

# Case if user choose to not input real data. (Accuracy based on training
if (dataRange != 100):
    cur.execute("delete from accuracy;");
    dataReal = dataToPredict.iloc[trainLength:]
    dataReal_date = []
    dataReal_value = []
    for i in dataReal.values:
        dataReal_value.append(int(i))
    for i in dataReal.index:
        dataReal_date.append(str(i)[:10])
    arimaErrors = [abs(dataReal_value[i]-ArimaValue[i])/dataReal_value[i] for i in range(len(dataReal_value))]
    arimaErrorsBias = sum(arimaErrors) * 1.0/len(dataReal_value) * 100

    cur.execute("insert into analysis (algo,analysis,value) values (\'SARIMAX\', \'error\',"+str(arimaErrorsBias)+");");

    hwesErrors = [abs(dataReal_value[i]-HwesValue[i])/dataReal_value[i] for i in range(len(dataReal_value))]
    hwesErrorsBias = sum(hwesErrors) * 1.0/len(dataReal_value) * 100
    cur.execute("insert into analysis (algo,analysis,value) values (\'HWES\', \'error\',"+str(hwesErrorsBias)+");");

    for i in range(0,len(dataReal_date)-1):
        accuracySarimax = (dataReal_value[i]-abs(ArimaValue[i]-dataReal_value[i]))/dataReal_value[i]*100
        accuracyHwes = (dataReal_value[i]-abs(HwesValue[i]-dataReal_value[i]))/dataReal_value[i]*100
        cur.execute("insert into accuracy (month,value,algo) values (\'"+str(dataReal_date[i])+"\',"+str(round(accuracySarimax,2))+","+"\'Sarimax\'"+");");
        cur.execute("insert into accuracy (month,value,algo) values (\'"+str(dataReal_date[i])+"\',"+str(round(accuracyHwes,2))+","+"\'Hwes\'"+");");
        
cur.execute("insert into analysis (algo,analysis,value) values (\'SARIMAX\', \'time\',"+str(arimaTime)+");");
cur.execute("insert into analysis (algo,analysis,value) values (\'HWES\', \'time\',"+str(hwesTime)+");");
cur.execute("insert into analysis (algo,analysis,value) values (\'SARIMAX\', \'cpuUsage\',"+str(Average(SarimaxCpuUsage))+");");
cur.execute("insert into analysis (algo,analysis,value) values (\'HWES\', \'cpuUsage\',"+str(Average(HwesCpuUsage))+");");
cur.execute("insert into analysis (algo,analysis,value) values (\'SARIMAX\', \'cpuMax\',"+ str(max(SarimaxCpuUsage))+");");
cur.execute("insert into analysis (algo,analysis,value) values (\'HWES\', \'cpuMax\',"+ str(max(HwesCpuUsage))+");");
cur.execute("insert into analysis (algo,analysis,value) values (\'SARIMAX\', \'ram\',"+str(Average(SarimaxRamUsage))+");");
cur.execute("insert into analysis (algo,analysis,value) values (\'HWES\', \'ram\',"+str(Average(HwesRamUsage))+");");

conn.commit()
