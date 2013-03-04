#!/usr/bin/python
from geventdaemon import GeventDaemon
import os
import logging

logfile = 'logreply.log'
pidfile = 'reply.pid'

logging.basicConfig(filename=logfile,level=logging.INFO)

class ReplyDaemon(GeventDaemon):
	def run(self):
		import sys
		from reply import Reply
		try:
			logging.info("%s: Starting reply" % (time.strftime("%d%b%Y,%H:%M")) )
			rep = Reply()
			rep.run()
		except SystemExit:
			logging.error("%s: Gateway SIGTERM, exiting" % time.strftime("%d%b%Y,%H:%M"))
			sys.exit(0)

if __name__ == "__main__":
	import time
	proxd = ReplyDaemon(pidfile)
	logging.info("%s: Starting daemon" % (time.strftime("%d%b%Y,%H:%M")) )
	proxd.start()
