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
	
	try:
		
		if command == 'info':
			user = token[2]
			id = token[3]
			order = Orders.get(Orders.user_id == user and Orders.id == id)	
			localtime = time.asctime( time.localtime(time.time()) )
			u = order.due
			due = time.strftime('%m/%d/%Y',time.localtime(u))
			rep = "%s \nbalance: %s\ndue: %s" % (localtime,order.balance,due)
			snd.send_sms(sender,rep)
			print rep
			#print out
		elif command == 'stock':
			id = int(token[2])
			stock = Stock.get(Stock.id == id)
			rep = "Stock #%s has only %s item/s left." % (id,stock.quantity)
			snd.send_sms(sender,rep)
			print rep
		else:
			print 'command error'
			snd.send_sms(sender,'command error')
	except SystemExit:
		print "closed"
