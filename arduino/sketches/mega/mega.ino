#include <Wire.h>
#include <LiquidCrystal_I2C.h>

LiquidCrystal_I2C lcd(0x27, 16, 2);

boolean autoo = 1;
void setup() {
  lcd.begin();
  lcd.backlight();
  uint8_t tick[8] =
  {
    B00001,
    B00001,
    B00001,
    B00001,
    B10010,
    B01010,
    B01010,
    B00100,
  };
  lcd.createChar(1, tick);
  uint8_t cross[8] =
  {
    B10001,
    B01010,
    B01010,
    B00100,
    B00100,
    B01010,
    B01010,
    B10001,
  };
  lcd.createChar(2, cross);
  Serial.begin(9600);
  pinMode(2, INPUT_PULLUP);
  pinMode(3, INPUT_PULLUP);
  pinMode(4, INPUT_PULLUP);
  pinMode(5, INPUT_PULLUP);
  pinMode(37, INPUT_PULLUP);
  pinMode(13, OUTPUT);
}

void loop() {
  int sensorVal1 = digitalRead(2);
  int sensorVal2 = digitalRead(3);
  int sensorVal3 = digitalRead(4);
  int sensorVal4 = digitalRead(5);
  int autoo = digitalRead(37);
  if (sensorVal1 == sensorVal2) {
    digitalWrite(13, LOW);
  }
  else {
    digitalWrite(13, HIGH);
  }
  Serial.print(".,");
  Serial.print(sensorVal1);
  Serial.print("@");
  Serial.print(sensorVal2);
  Serial.print("@");
  Serial.print(sensorVal3);
  Serial.print("@");
  Serial.print(sensorVal4);
  Serial.print("@");
  Serial.print(autoo);
  Serial.println("!");
  lcd.setCursor(0, 0);
  if (autoo == 0)lcd.print(" [   Manual   ] ");
  else lcd.print(" [ Automatic  ] ");
  lcd.setCursor(0, 1);
  if (autoo == 0) lcd.print("[\2] [\1]  [\2] [\1] ");
  else lcd.print("[\1] [\2]  [\1] [\2] ");
}
