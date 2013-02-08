#!/usr/bin/python
from models import *
import client
import time
snd = client.Sender()
recv = client.Receiver()
from peewee import *
from types import *
import locale

while True:
	msg = recv.recv_json()
	sender = msg['sender']
	message = msg['message']
	token = message.split()
	command = token[1]
	
	try:
		
		if command == 'info':
			
			id = int(token[2])
			order = Orders.get(Orders.id == id)	
			localtime = time.asctime( time.localtime(time.time()) )
			u = order.due
			if type(u) is NoneType:
				due = 'Not yet'
			else:
				due = time.strftime('%m/%d/%Y',time.localtime(u))

			locale.setlocale(locale.LC_ALL,"")
			balance = locale.currency(order.balance,grouping=True)

			rep = "%s \nOrder#: %s\nbalance: %s\ndue date: %s" % (localtime,order.id,balance,due)
			snd.send_sms(sender,rep)
			print rep
			#print out
		elif command == 'stock':
			id = int(token[2])
			try:
				stock = Stock.get(Stock.product_id == id)
				rep = "Stock #%s has only %s item/s left." % (id,stock.quantity)
			except peewee.DoesNotExist:
				rep = "Stock is not available."
			
			snd.send_sms(sender,rep)
			print rep
		else:
			print 'command error'
			snd.send_sms(sender,'command error')
	except SystemExit:
		print "closed"
