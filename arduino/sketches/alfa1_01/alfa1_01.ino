// celsius - температура (1 градусник) а надо температуру почвы и внутри теплицы, снаружи+ влажность воздуха и почвы внутри,
#include "DHT.h"
#define DHTPIN 8
#define DHTTYPE DHT11   // DHT 11

#include "U8glib.h"
#include <OneWire.h>
DHT dht(DHTPIN, DHTTYPE);
int h;
int t;
OneWire ds(2); // на пине 10 (нужен резистор 4.7 КОм)
unsigned long time1;
unsigned long time2;
unsigned long time3;
unsigned long time4;
static unsigned char u8g_logo_bits[] U8G_PROGMEM  = {0x10,
                                                     0x10,
                                                     0x38,
                                                     0x7C,
                                                     0x7C,
                                                     0x7C,
                                                     0x7C,
                                                     0x38,
                                                    };
static unsigned char u8g_logo_bits1[] U8G_PROGMEM  = {0x00,
                                                      0x18,
                                                      0x18,
                                                      0x00,
                                                      0x1C,
                                                      0x18,
                                                      0x18,
                                                      0x18,
                                                      0x3C,
                                                     };
static unsigned char u8g_logo_bits4[] U8G_PROGMEM  = {
  0xF0, 0xFF, 0x1F, 0x00,
  0x08, 0x00, 0x20, 0x00,
  0x04, 0x00, 0x40, 0x00,
  0x02, 0x00, 0x80, 0x00,
  0x01, 0x00, 0x00, 0x01,
  0x01, 0x00, 0x00, 0x01,
  0xDD, 0x6D, 0x2B, 0x01,
  0x49, 0x55, 0x19, 0x01,
  0xC9, 0x45, 0x2B, 0x01,
  0x01, 0x00, 0x00, 0x01,
  0xFD, 0xFF, 0x3F, 0x01,
  0x01, 0x00, 0x00, 0x01,
  0x49, 0x3C, 0x09, 0x01,
  0x49, 0x24, 0x0D, 0x01,
  0x49, 0x24, 0x03, 0x01,
  0x49, 0x24, 0x0D, 0x01,
  0xF9, 0x25, 0x09, 0x01,
  0x81, 0x01, 0x00, 0x01,
  0x82, 0x01, 0x80, 0x00,
  0x04, 0x00, 0x40, 0x00,
  0x08, 0x00, 0x20, 0x00,
  0xF0, 0xFF, 0x1F, 0x00,
};
static unsigned char u8g_logo_bits2[] U8G_PROGMEM  = {0xFF,
                                                      0x91,
                                                      0x91,
                                                      0x91,
                                                      0xF1,
                                                      0x91,
                                                      0x91,
                                                      0x91,
                                                      0xFF,
                                                     };
static unsigned char u8g_logo_bits3[] U8G_PROGMEM  = {0x1C,
                                                      0x22,
                                                      0x41,
                                                      0x5D,
                                                      0x49,
                                                      0x41,
                                                      0x22,
                                                      0x1C,
                                                      0x1C,

                                                     };
int celsius, fahrenheit;
int okno = 1;
int menu = 1;
int statys = 0;
int statys1 = 0;
int statys2 = 0;
int statys3 = 0;
int statys4 = 0;
int statys5 = 1;
int statys6 = 0;
int statys7 = 0;
int statys8 = 1;
int statys9 = 0;
int statys10 = 0;
int statys11 = 0;
int statys12 = 0;
int key = 0;
int Relay = 5;
int Relay2 = 6;
int Relay3 = 7;
U8GLIB_ST7920_128X64 u8g(13, 11, 12, U8G_PIN_NONE);


void temp(void) {
  time1 = millis();
  byte i;
  byte present = 0;
  byte type_s;
  byte data[12];
  byte addr[8];
  if ( !ds.search(addr)) {
    ds.reset_search();
    return;
  }
  if (OneWire::crc8(addr, 7) != addr[7]) {
    return;
  }
  switch (addr[0]) {
    case 0x10:
      type_s = 1;
      break;
    case 0x28:
      type_s = 0;
      break;
    case 0x22:
      type_s = 0;
      break;
    default:
      Serial.println("Device is not a DS18x20 family device.");
      return;
  }
  ds.reset();
  ds.select(addr);
  ds.write(0x44);
  if ((time1 - time2) > 2000)
  {
    present = ds.reset();
    ds.select(addr);
    ds.write(0xBE);
    for ( i = 0; i < 9; i++) { // нам необходимо 9 байт
      data[i] = ds.read();
    }
    int16_t raw = (data[1] << 8) | data[0];
    if (type_s) {
      raw = raw << 3; // разрешение 9 бит по умолчанию
      if (data[7] == 0x10) {
        raw = (raw & 0xFFF0) + 12 - data[6];
      }
    } else {
      byte cfg = (data[4] & 0x60);
      if (cfg == 0x00) raw = raw & ~7; // разрешение 9 бит, 93.75 мс
      else if (cfg == 0x20) raw = raw & ~3; // разрешение 10 бит, 187.5 мс
      else if (cfg == 0x40) raw = raw & ~1; // разрешение 11 бит, 375 мс
    }
    celsius = (float)raw / 16.0;
    time2 = time1;
  }

}

void draw(void) {
  temp();
  int sensorValue = analogRead(A0);
  if (sensorValue > 0 && sensorValue < 100) {
    key = 0;
  }
  u8g.setFont(u8g_font_6x10);//Установка шрифта
  u8g.drawXBMP(2, 2, 8, 9, u8g_logo_bits1);
  u8g.drawXBMP(2, 15, 8, 9, u8g_logo_bits2);
  u8g.drawStr( 4, 37, "3");
  u8g.drawXBMP(3, 42, 8, 9, u8g_logo_bits3);
  u8g.drawXBMP(2, 54, 7, 8, u8g_logo_bits);
  //u8g.drawFrame(0,47,50,13);
  u8g.drawHLine(0, 0, 128);
  u8g.drawHLine(0, 63, 128);
  u8g.drawVLine(0, 0, 128);
  u8g.drawVLine(127, 0, 64);
  if (menu == 1) {
    u8g.drawVLine(12, 13, 64); u8g.drawXBMP(100, 40, 25, 22, u8g_logo_bits4);
    u8g.drawHLine(0, 13, 12); u8g.drawStr( 25, 10, "Information"); u8g.drawStr( 16, 31, "t,C ="); u8g.drawStr( 16, 48, "humidity ="); u8g.setPrintPos( 48, 31); u8g.print(celsius);
  }

  if (menu == 2) {
    if (okno == 4) {
      okno = 1;
    }
    if (statys > 1) {
      statys = 0;
    }
    if (statys == 0) {
      u8g.drawStr( 88, 15, "on");
    }
    if (statys == 1) {
      u8g.drawStr( 88, 15, "off");
      if (okno == 2) {
        u8g.drawFrame(15, 23, 52, 14);
        if (sensorValue > 900 && key == 0) {
          statys1++;
          key = 1;
        }
      }
      if (okno == 3) {
        u8g.drawFrame(15, 37, 52, 14);
        if (sensorValue > 900 && key == 0) {
          statys2++;
          key = 1;
        }
      }
    }
    if (statys1 > 1) {
      statys1 = 0;
    }
    if (statys2 > 1) {
      statys2 = 0;
    }
    if (statys1 == 0) {
      u8g.drawStr( 76, 34, "close");
    }
    if (statys1 == 1) {
      u8g.drawStr( 76, 34, "open");
    }
    if (statys2 == 0) {
      u8g.drawStr( 76, 48, "close");
    }
    if (statys2 == 1) {
      u8g.drawStr( 76, 48, "open");
    }
    u8g.drawVLine(12, 25, 64); u8g.drawVLine(12, 0, 14); u8g.drawStr( 19, 15, "Mode auto:"); u8g.drawStr( 16, 34, "Window1:"); u8g.drawStr( 16, 48, "Window2:");
    u8g.drawHLine(0, 13, 12); u8g.drawHLine(0, 25, 12);
    if ((okno == 1) || (statys == 0)) {
      u8g.drawFrame(18, 4, 61, 14);
      if (sensorValue > 900 && key == 0) {
        statys++;
        key = 1;
      }
    }
  }


  if (menu == 3) {
    if (okno == 4) {
      okno = 1;
    } u8g.drawVLine(12, 39, 64); u8g.drawVLine(12, 0, 28); u8g.drawHLine(0, 27, 12); u8g.setPrintPos( 70, 52);
    u8g.print(statys5 * 10);
    u8g.drawHLine(0, 39, 12); u8g.drawStr( 29, 10, "Soil heating"); u8g.drawStr( 19, 22, "Mode auto:"); u8g.drawStr( 16, 38, "Heating:"); u8g.drawStr( 16, 52, "Power:");
    if (statys3 == 0) {
      u8g.drawStr( 85, 22, "on");
    }
    if (statys3 == 1) {
      u8g.drawStr( 80, 22, "off");
      if (okno == 2) {
        u8g.drawFrame(14, 28, 54, 14);
        if (sensorValue > 900 && key == 0) {
          statys4++;
          key = 1;
        }
        if (statys4 > 1) {
          statys4 = 0;
        }
      }
      if (okno == 3) {
        u8g.drawFrame(14, 42, 42, 14); u8g.drawStr( 90, 52, "%"); if (sensorValue > 900 && key == 0) {
          statys5++;
          key = 1;
        }
        if (statys5 > 10) {
          statys5 = 1;
        }       ;
      }
    }
    if (statys4 == 0) {
      u8g.drawStr( 72, 38, "close");
    }
    if (statys4 == 1) {
      u8g.drawStr( 72, 38, "open");
    }
    if ((okno == 1) || (statys3 == 0)) {
      u8g.drawFrame(18, 11, 61, 14);
      if (sensorValue > 900 && key == 0) {
        statys3++;
        key = 1;
      }
      if (statys3 > 1) {
        statys3 = 0;
      }
    }

  }






  if (menu == 4) {
    u8g.drawVLine(12, 52, 64); u8g.drawVLine(12, 0, 41); u8g.drawHLine(0, 52, 12);
    u8g.drawHLine(0, 40, 12);
    if (okno == 4) {
      okno = 1;
    } u8g.setPrintPos( 70, 52);

    u8g.drawStr( 29, 10, "Lamps"); u8g.drawStr( 19, 22, "Mode auto:"); u8g.drawStr( 16, 38, "Heating:"); u8g.drawStr( 16, 52, "Power:"); u8g.print(statys8 * 10);
    if (statys6 == 0) {
      u8g.drawStr( 85, 22, "on");
    }
    if (statys6 == 1) {
      u8g.drawStr( 80, 22, "off");
      if (okno == 2) {
        u8g.drawFrame(14, 28, 54, 14);
        if (sensorValue > 900 && key == 0) {
          statys7++;
          key = 1;
        }
        if (statys7 > 1) {
          statys7 = 0;
        }
      }
      if (okno == 3) {
        u8g.drawFrame(14, 42, 42, 14); u8g.drawStr( 90, 52, "%"); if (sensorValue > 900 && key == 0) {
          statys8++;
          key = 1;
        }
        if (statys8 > 10) {
          statys8 = 1;
        }       ;
      }
    }
    if (statys7 == 0) {
      u8g.drawStr( 72, 38, "close");
    }
    if (statys7 == 1) {
      u8g.drawStr( 72, 38, "open");
    }
    if ((okno == 1) || (statys6 == 0)) {
      u8g.drawFrame(18, 11, 61, 14);
      if (sensorValue > 900 && key == 0) {
        statys6++;
        key = 1;
      }
      if (statys6 > 1) {
        statys6 = 0;
      }
    }

  }
  if (menu == 5) {
    u8g.drawVLine(12, 0, 53); if (okno > 4) {
      okno = 1;
    }
    u8g.drawHLine(0, 52, 12); u8g.drawStr( 40, 10, "Water"); u8g.drawStr( 16, 28, "auto:");  u8g.drawStr( 73, 28, "rele2:"); u8g.drawStr( 16, 50, "rele1:"); u8g.drawStr( 73, 50, "rele3:"); if (okno == 1 || statys9 == 0) {
      u8g.drawFrame(14, 17, 54, 14); if (sensorValue > 900 && key == 0) {
        statys9++;
        key = 1;
      }
      if (statys9 > 1) {
        statys9 = 0;
      }
    }
    if (statys12 == 0) {
      u8g.drawStr( 109, 50, "off");
      digitalWrite(Relay3, LOW);
    }
    if (statys12 == 1) {
      u8g.drawStr( 109, 50, "on");
      digitalWrite(Relay3, HIGH);
    }

    if (statys10 == 0) {
      u8g.drawStr( 53, 50, "off");
      digitalWrite(Relay, LOW);
    }
    if (statys10 == 1) {
      u8g.drawStr( 53, 50, "on");
      digitalWrite(Relay, HIGH);
    }
    if (statys11 == 0) {
      u8g.drawStr( 109, 28, "off");
      digitalWrite(Relay2, LOW);
    }
    if (statys11 == 1) {
      u8g.drawStr( 109, 28, "on");
      digitalWrite(Relay2, HIGH);
    }

    if (statys9 == 0) {
      u8g.drawStr( 49, 28, "on");
    }
    if (statys9 == 1) {
      u8g.drawStr( 49, 28, "off"); if (okno == 2) {
        u8g.drawFrame(14, 39, 57, 14);
        if (sensorValue > 900 && key == 0) {
          statys10++;
          key = 1;
        } if (statys10 > 1) {
          statys10 = 0;
        }
      }
      if (okno == 3) {
        u8g.drawFrame(71, 17, 36, 14);
        if (sensorValue > 900 && key == 0) {
          statys11++;
          key = 1;
        } if (statys11 > 1) {
          statys11 = 0;
        }
      }
      if (okno == 4) {
        u8g.drawFrame(71, 39, 36, 14);
        if (sensorValue > 900 && key == 0) {
          statys12++;
          key = 1;
        } if (statys12 > 1) {
          statys12 = 0;
        }
      }
    }
  }
}

void setup(void) {
  Serial.begin(9600);
  pinMode(Relay, OUTPUT);
  pinMode(Relay2, OUTPUT);
  pinMode(Relay3, OUTPUT);
  pinMode(3, OUTPUT);
  pinMode(4, OUTPUT);
  pinMode(13, OUTPUT);
  // assign default color value
  if ( u8g.getMode() == U8G_MODE_R3G3B2 )
    u8g.setColorIndex(255); // white
  else if ( u8g.getMode() == U8G_MODE_GRAY2BIT )
    u8g.setColorIndex(3); // max intensity
  else if ( u8g.getMode() == U8G_MODE_BW )
    u8g.setColorIndex(1); // pixel on
  dht.begin();
}

void loop(void) {
  time1 = millis();
  if (statys9 == 0) {
    if ((time1 - time3) < 30000)
    {
      digitalWrite(Relay, HIGH);
      digitalWrite(Relay2, LOW);
      digitalWrite(Relay3, LOW);
      statys10 = 1;
      statys11 = 0;
      statys12 = 0;
    }
    if ((60000 > (time1 - time3)) && ((time1 - time3) > 30000))
    {
      digitalWrite(Relay, LOW);
      digitalWrite(Relay2, HIGH);
      digitalWrite(Relay3, LOW);
      statys10 = 0;
      statys11 = 1;
      statys12 = 0;
    }
    if ((120000 > (time1 - time3)) && ((time1 - time3) > 60000))
    {
      digitalWrite(Relay, LOW);
      digitalWrite(Relay2, LOW);
      digitalWrite(Relay3, HIGH);
      statys10 = 0;
      statys11 = 0;
      statys12 = 1;
    }
    if ((time1 - time3) > 120000) {
      time3 = time1;
    }
  }
  int sensorValue = analogRead(A0);
  if (sensorValue > 300 && sensorValue < 400 && key == 0)
  {

    menu++;
    okno = 1;
    key = 1;
  }
  if (sensorValue > 500 && sensorValue < 700 && key == 0)
  {
    okno++;
    key = 1;
  }
  if (sensorValue > 0 && sensorValue < 100)
  {
    key = 0;
  }
  if (menu > 5)
  {
    menu = 1;
  }
  if ((time1 - time4) > 2000) {
    h = dht.readHumidity();
    t = dht.readTemperature();  //частота обновления 2000 сек
    time4 = time1;
  }
  if ((h != 0) && (t != 0))
  {
    Serial.print(".,");
    Serial.print(h);
    Serial.print("@");
    Serial.print(t);
    Serial.println("!");
  }
  u8g.firstPage();


  do {
    draw();
  } while ( u8g.nextPage() );

}
