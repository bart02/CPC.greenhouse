# ### Quick send reference
# # ///
#
# |||||||||||||||||||||||||||
#
# ### Quick recieve reference
# # Symbol "." - string starting
# # Symbol "," - data from buttons
# # Symbol "@" - separator

import serial
import time
from threading import Thread


variables = {'data1': [], 'data2': 0}


def search():
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

ser = serial.Serial(search(), 9600)
time.sleep(0.3)

recieving = Thread(target=recieving_data)
recieving.start()

while True:
    print(variables['data1'])
    time.sleep(2)
