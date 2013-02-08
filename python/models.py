import peewee

database = peewee.SqliteDatabase('../db/ads.sqlite')

class BaseModel(peewee.Model):
	class Meta:
		database = database
		
class Orders(BaseModel):
	balance = peewee.FloatField()
	due = peewee.FloatField()
	id = peewee.PrimaryKeyField()
	user_id = peewee.IntegerField()
	downpayment = peewee.FloatField()
	
	def total(self):
		items = Items.select().where(Items.order_id == self.id)
		total = 0
		for i in items:
			total += i.subtotal()
		return total
	
class Items(BaseModel):
	id = peewee.PrimaryKeyField()
	order_id = peewee.IntegerField()
	quantity = peewee.IntegerField()
	price = peewee.FloatField()
	class Meta:
		db_table = 'order_items'

	def subtotal(self):
		return self.quantity * self.price

class Stock(BaseModel):
	id = peewee.PrimaryKeyField()
	product_id = peewee.IntegerField()
	quantity = peewee.IntegerField()