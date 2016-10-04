from Crypto.Util.number import *
from Crypto.PublicKey import RSA
import random
import socket

sock = socket.socket()
sock.setsockopt(socket.SOL_SOCKET, socket.SO_REUSEADDR, 1)
sock.bind(("0.0.0.0",9001))
sock.listen(5)

flag = "--------------------------------------------------------------------------------"
m = bytes_to_long(flag)

while True:
    try:
        cn, addr = sock.accept()
        cn.settimeout(10)
        key = RSA.generate(2048)
        c = pow(m, key.e, key.n)
        cn.sendall("Welcome to Lottery Predictor from Certificate\n")
        cn.sendall("PublicKey:\n")
        cn.sendall("N = " + str(key.n) + "\n")
        cn.sendall("e = " + str(key.e) + "\n\n")
        cn.sendall("Example input my certificate " + str(c) + "\n\n")

        while True:
            cn.sendall("Certificate: ")
            try:
                tc = int(cn.recv(1024))
                tm = pow(tc, key.d, key.n)
            except:
                break

            l2 = random.randint(1,99)
            l3 = (tm%8) * l2

            cn.sendall("Last 3 number: %03d\n\n"%(l3))
    except:
        pass
