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

import serial                   # For connect to arduino
import time                     # For sleep
from threading import Thread    # For multi-tasking

variables = {'data1': [], 'data2': 0}   # Global variables, 'data1' for data from arduino


def search():   # Function for searching the arduino port
    found = False
    for j in range(2):
        for i in range(64):
            try:
                if j == 0:
                    port = "/dev/ttyUSB" + str(i)
                if j == 1:
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


make_global()   # Make variables global

ser = serial.Serial(search(), 9600)  # Open serial port
time.sleep(1)  # Waiting for port

receiving = Thread(target=receiving_data)   # Create the threading for receive data

time.sleep(5)
receiving.start()   # Start the threading for receive data
print('[INFO] Started')

while True:  # Print variables on display, and switch position to arduino display
    #if len(variables['data1']) == 5:
    #    if variables['data1'][4] == '1':
    #        ser.write("., [ Automatic  ] @[\1] [\2]  [\1] [\2]!".encode('utf-8'));
    #    else:
    #        ser.write("., [   Manual   ] @[\2] [\1]  [\2] [\1]!".encode('utf-8'));
    #time.sleep(0.5)
    print(variables['data1'])
