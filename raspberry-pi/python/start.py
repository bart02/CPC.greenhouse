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

minutes = 5 #Minutes before sending data

import serial                   # For connect to arduino
import time                     # For sleep
from threading import Thread    # For multi-tasking
import requests                 # For data sending

variables = {'data1': [], 'data2': 0}   # Global variables, 'data1' for data from arduino

def send_to_server():
    while True:
        time.sleep(minutes * 60)
        if len(variables['data1']) == 5:
            for i in variables['data1']:
                requests.get('http://greenhouse.cpc.tomsk.ru/api.php?key=30bJpP0R29epB7kofxF5WszPtP1fRJxWbVEf89bDXOFJpEJRMdvTN6ouqXOtg2bb&type=' + str(i) + '&data=' + variables['data1'][i])

def search():   # Function for searching the arduino port
    found = False
    for j in range(3):
        for i in range(64):
            try:
                if j == 0:
                    port = "/dev/ttyACM" + str(i)
                elif j == 1:
                    port = "/dev/ttyUSB" + str(i)
                elif j == 2:
                    port = "COM" + str(i)
                ser = serial.Serial(port)
                ser.close()
                found = True
                break
            except serial.serialutil.SerialException:
                pass
        if found:
            return port
            break
    if not found:
        raise NameError("Ports not found")

def receiving_data():   # Function for receiving data from arduino
    while True:
        data = ser.readline().decode('utf-8')   # Read the data from arduino
        if data[0] == '.':
            if data[1] == ',':
                data = data[2:].split('!')[0].split('@')
                variables['data1'] = list(map(int, data))

def make_global():  # Function for make variables global
    global variables
    global minutes

make_global()   # Make variables global

ser = serial.Serial(search(), 9600)  # Open serial port
time.sleep(1)  # Waiting for port

receiving = Thread(target=receiving_data)   # Create the threading for receive data

time.sleep(5)
receiving.start()   # Start the threading for receive data
print('[INFO] Started')

sending = Thread(target=send_to_server)   # Create the threading for sending data to server
sending.start()   # Start the threading for sending data to server

while True:  # Print variables on display, and switch position to arduino display
    #if len(variables['data1']) == 5:
    #    if variables['data1'][4] == '1':
    #        ser.write("., [ Automatic  ] @[\1] [\2]  [\1] [\2]!".encode('utf-8'));
    #    else:
    #        ser.write("., [   Manual   ] @[\2] [\1]  [\2] [\1]!".encode('utf-8'));
    #time.sleep(0.5)
    print(variables['data1'])
