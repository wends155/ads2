from models import *
import client
import time
snd = client.Sender()
recv = client.Receiver()
from peewee import *

while True:
	msg = recv.recv_json()
	sender = msg['sender']
	message = msg['message']
	token = message.split()
	command = token[1]
	user = token[2]
	id = token[3]
	try:
		order = Orders.get(Orders.user_id == user and Orders.id == id)
		if command == 'info':
			
			localtime = time.asctime( time.localtime(time.time()) )
			
			rep = "%s \nbalance: %s\ndue: %s" % (localtime,order.balance,order.due)
			snd.send_sms(sender,rep)
			print rep
			#print out
		else:
			print 'command error'
			snd.send_sms(sender,'command error')
	except:
		print 'order does not exist'
		snd.send_sms(sender,'order does not exist')
