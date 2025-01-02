import network
import socket
import time
import secrets
import machine
from machine import Pin, SoftI2C
import ssd1306

led = Pin('LED', Pin.OUT)

buzzer_pin = machine.Pin(20, machine.Pin.OUT)
buzzer = machine.PWM(buzzer_pin)

i2c = SoftI2C(scl=Pin(5), sda=Pin(4))

oled_width = 128
oled_height = 64
oled = ssd1306.SSD1306_I2C(oled_width, oled_height, i2c)

ssid = secrets.SSID
password = secrets.PASSWORD

wlan = network.WLAN(network.STA_IF)
wlan.active(True)

wlan.connect(ssid, password)
html = """<!DOCTYPE html>
<html>
    <head> <title>Rambo PI</title> </head>
        <body> <h1>LED Status Indicator</h1>
        <p>%s</p>

        </body>
</html>
"""
# Wait for connect or fail
max_wait = 10
while max_wait > 0:
    if wlan.status() < 0 or wlan.status() >= 3:
        break
    max_wait -= 1
    print('waiting for connection...')
    time.sleep(1)

# Handle connection error
if wlan.status() != 3:
    raise RuntimeError('network connection failed')
else:
    print('connected')
    status = wlan.ifconfig()
    print( 'ip = ' + status[0] )
    oled.text( 'ip = ', 0, 0 )
    oled.text( status[0], 0, 10 )
    oled.show()

# Open socket
addr = socket.getaddrinfo('0.0.0.0', 80)[0][-1]

s = socket.socket()
s.bind(addr)
s.listen(1)

print('listening on', addr)
# Listen for connections
while True:
    try:
        cl, addr = s.accept()
        print('client connected from', addr)
        request = cl.recv(1024)
        print(request)
        request = str(request)
        led_on = request.find('/light/on')
        led_off = request.find('/light/off')
        buzzer_on = request.find('/buzzer/on')
        buzzer_off = request.find('/buzzer/off')
        print( 'led on = ' + str(led_on))
        print( 'led off = ' + str(led_off))
        print( 'buzzer on = ' + str(buzzer_on))
        print( 'buzzer off = ' + str(buzzer_off))

        stateis = "ALL OFF"

        if led_on == 6:
            print("led on")
            led.value(1)
            stateis = "LED is ON"

        if led_off == 6:
            print("led off")
            led.value(0)
            stateis = "LED is OFF"

        if buzzer_on == 6:
            print("buzzer on")
            buzzer.freq(1047)
            buzzer.duty_u16(50)
            stateis = "BUZZER is ON"

        if buzzer_off == 6:
            print("buzzer off")
            buzzer.duty_u16(0)
            buzzer.deinit()
            stateis = "BUZZER is OFF"

        response = html % stateis
        cl.send('HTTP/1.0 200 OK\r\nContent-type: text/html\r\n\r\n')
        cl.send(response)
        cl.close()

    except OSError as e:
        cl.close()
        print('connection closed')