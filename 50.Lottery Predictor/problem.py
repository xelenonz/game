from Crypto.Util.number import *
from Crypto.PublicKey import RSA
import random

flag = "______________________________________________"
m = bytes_to_long(flag)

key = RSA.generate(1024)
c = pow(m, key.e, key.n)
print("Welcome to Lattery Predictor from Certificate\n")
print("PublicKey:\n")
print("N = " + str(key.n) + "\n")
print("e = " + str(key.e) + "\n\n")
print("Example input my certificate " + str(c) + "\n\n")

while True:
    try:
        tc = int(raw_input("certificate: "))
        tm = pow(tc, key.d, key.n)
    except:
        break

    l2 = random.randint(1,99)
    l3 = (tm%8) * l2

    print("Last 3 number: %03d\n\n"%(l3))
