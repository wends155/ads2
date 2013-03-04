#!/usr/bin/python
from models import *
import client
import time
snd = client.Sender()
recv = client.Receiver()
from peewee import *
from types import *
import locale
import sys
import logging

class Reply():

	def run(self):
		while True:
			msg = recv.recv_json()
			sender = msg['sender']
			message = msg['message']
			token = message.split()
			if len(token) > 2:
				command = token[1]
			else: 
				command = 'error'
			
			try:
				
				if command == 'info':
					
					id = int(token[2])
					try:
						order = Orders.get(Orders.id == id)	
						localtime = time.asctime( time.localtime(time.time()) )
						u = order.due
						if type(u) is NoneType:
							due = 'Unclaimed'
						else:
							due = time.strftime('%m/%d/%Y',time.localtime(u))
						if type(order.balance) is not NoneType:
							locale.setlocale(locale.LC_ALL,"")
							balance = locale.currency(order.balance,grouping=True)
						else:
							balance = order.total()

						rep = "%s \nOrder#: %s\nbalance: %s\ndue date: %s" % (localtime,order.id,balance,due)
					except peewee.DoesNotExist:
						rep = "Order does not exist"
					
					snd.send_sms(sender,rep)
					#print rep
					logging.info(rep)
					#print out
				elif command == 'stock':
					id = int(token[2])
					try:
						stock = Stock.get(Stock.product_id == id)
						rep = "Stock #%s has only %s item/s left." % (id,stock.quantity)
					except peewee.DoesNotExist:
						rep = "Stock is not available."
					
					snd.send_sms(sender,rep)
					#print rep
					logging.info(rep)
				else:
					rep = 'command error'
					#print rep
					logging.info(rep)
					snd.send_sms(sender,rep)
			except SystemExit:
				print "closed"
				sys.exit(0)

if __name__ == "__main__":
	rep = Reply()
	rep.run()