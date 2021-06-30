#!C:\Users\willi\AppData\Local\Programs\Python\Python38-32\python.exe
#!/usr/bin/python

import numpy as np 
import pandas as pd 
import matplotlib.pyplot as plt 
from statsmodels.tsa.seasonal import seasonal_decompose 
import psycopg2

conn = psycopg2.connect(database = "machine_learning", user = "postgres", password = "postgres", host = "localhost", port = "5432")
cur = conn.cursor()

cur.execute("delete from arima")
cur.execute("delete from hwes")
cur.execute("delete from real")
cur.execute("delete from dummy")
cur.execute("delete from analysis");
cur.execute("delete from accuracy");
conn.commit()
