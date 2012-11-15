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

		while True:
			msg = recv.recv_json()
			sender = msg['sender']
			message = msg['message']
			token = message.split()
			command = token[1]
			id = token[2]
			
			try:
				order = Orders.get(Orders.id == id)
				if command == 'order':
					
					localtime = time.asctime( time.localtime(time.time()) )
					u = order.due
					due = time.strftime('%m/%d/%Y',time.localtime(u))
					rep = "%s \nOrder#: %s\nbalance: Php %s\ndue: %s" % (localtime,id,order.balance,due)
					snd.send_sms(sender,rep)
					print rep
					#print out
				else:
					print 'command error'
					snd.send_sms(sender,'command error')
			except DoesNotExist:
				snd.send_sms(sender,'No order with id of %s' % id)


if __name__ == "__main__":
	proxd = ReplyDaemon(pidfile)
	proxd.start()
