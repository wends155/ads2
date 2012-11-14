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
		#from peewee import *

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
			except SystemExit:
				print "closed"


if __name__ == "__main__":
	proxd = ReplyDaemon(pidfile)
	proxd.start()
