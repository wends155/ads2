#!/usr/bin/python
from geventdaemon import GeventDaemon
import os

pidfile = 'reply.pid'
class ReplyDaemon(GeventDaemon):
	def run(self):
		from models import Orders
		import client
		import time
		snd = client.Sender()
		recv = client.Receiver()
		from peewee import DoesNotExist
		from types import NoneType

		while True:
			msg = recv.recv_json()
			sender = msg['sender']
			message = msg['message']
			token = message.split()
			command = token[1]
			
			
			try:
				
				if command == 'order':
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
					#print rep
				elif command == 'stock':
					id = int(token[2])
					try:
						stock = Stock.get(Stock.product_id == id)
						rep = "Stock #%s has only %s item/s left." % (id,stock.quantity)
					except peewee.DoesNotExist:
						rep = "Stock is not available."
					
					snd.send_sms(sender,rep)
					#print rep
				else:
					print 'command error'
					snd.send_sms(sender,'command error')
			except DoesNotExist:
				snd.send_sms(sender,'No order with id of %s' % id)


if __name__ == "__main__":
	proxd = ReplyDaemon(pidfile)
	proxd.start()
