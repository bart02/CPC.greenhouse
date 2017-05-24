# ### Quick send reference
# # Symbol "." - string starting
# # Symbol "," - data for LCD
# # Symbol "@" - separator
# # Symbol "!" - string end
#
# |||||||||||||||||||||||||||
#
# ### Quick recieve reference
# # Symbol "." - string starting
# # Symbol "," - data from buttons
# # Symbol "@" - separator
# # Symbol "!" - string end

import serial
import time
from threading import Thread

variables = {'data1': [], 'data2': 0}

def recieving_data():
	while True:
		data = ser.readline().decode('utf-8')
		if data[0] == '.':
			if data[1] == ',':
				data = data[2:].split('!')[0].split('@')
				variables['data1'] = data

def make_global():
	global variables
	
make_global()

ser = serial.Serial('COM6', 9600)
time.sleep(0.3)

recieving = Thread(target=recieving_data)

time.sleep(2)
recieving.start()
print('[INFO] Started')

while True:
	if len(variables['data1']) == 5:
		if variables['data1'][4] == '1':
			ser.write("., [ Automatic  ] @[\1] [\2]  [\1] [\2]!".encode('utf-8'));
		else:
			ser.write("., [   Manual   ] @[\2] [\1]  [\2] [\1]!".encode('utf-8'));
	time.sleep(0.5)
	print(variables['data1'])