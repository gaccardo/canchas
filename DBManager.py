import sys
import sqlite3
import hashlib
import datetime
import getpass

class DBManager( object ):

   def __init__( self ):
      self.db_file = 'maradona.sqlite'

   def __executeQuery( self, sql, debug=None ):
      if debug is True:
         import pdb;pdb.set_trace()

      self.link = sqlite3.connect( self.db_file )
      cursor    = self.link.cursor()
      result    = cursor.execute( sql )

      return result

   """ MANEJO DE USUARIOS """
   def __userExists( self, user ):
      sql    = """SELECT id FROM empleado WHERE usuario = '%s'""" % user
      result = self.__executeQuery( sql )

      try:
         if result.fetchone()[0] == '':
            return False
         else:
            return True
      except:
         return False

   def __checkCredentials( self, user, password ):
      if self.__userExists( user ):
         sql             = """SELECT pass FROM empleado WHERE usuario = '%s'""" % user
         result          = self.__executeQuery( sql )
         password_stored = result.fetchone()[0]

         if password  == password_stored and \
            self.__getUserStatus( user ) == 1:
            return True
         else:
            return False

      return False

   def userLogin( self, user, password ):
      return self.__checkCredentials( user, password )

   def getUserData( self, user ):
      if self.__userExists( user ):
         sql    = """SELECT * FROM empleado WHERE usuario = '%s'""" % user
         result = self.__executeQuery( sql )
         ss = result.fetchone()

         user = { 'id':          ss[0],
                  'nombre':      ss[1],
                  'usuario':     ss[2],
                  'passwd':      ss[3],
                  'id_sucursal': ss[4],
                  'status':      ss[5],
                  'telefono':    ss[6],
                  'type':        ss[7],
                 }     

         return user

      return None

   def __getUserStatus( self, user ):
      if self.__userExists( user ):
         sql    = """SELECT status FROM empleado WHERE usuario = '%s'""" % user
         result = self.__executeQuery( sql )
         result = result.fetchone()
         return int( result[0] )

      return False

   def changeUserStatus( self, user, status ):
      """
      Estados:
       1 - Activo
       2 - Inactivo
      """
      if self.__userExists( user ):
         cur_status = self.__getUserStatus( user )

         if status == cur_status:
            return (False, "El estado ya estaba en %s" % status)
         else:
            sql = """UPDATE empleado SET status = %s WHERE usuario = '%s'""" % ( status, user )
            self.__executeQuery( sql )
            self.link.commit()
            return (True, "Estado modificado")
      else:
         return (False, "El usuario no existe")

   def createUser( self ):
      print "User Creation"
      nombre   = str( raw_input('fullname:'))
      username = str( raw_input('Username: '))
      if self.__userExists( username ):
         print "Usuario existente - No se creara el nuevo usuario"
         return False
      else:
         password = getpass.getpass("Password: ")

         print "User type"
         print " 1 - Admin"
         print " 2 - Common"
         kind     = str( raw_input('::> ') )  
         telefono = str( raw_input('telefono: '))

         sql = """INSERT INTO empleado ('nombre', 'usuario', 'pass', 'id_sucursal', \
                                        'status', 'telefono', 'type') \
                                       VALUES  \
                                       ('%s', '%', '%s', 1, 1, '%s', %s)""" % (nombre,
                                                                                username,
                                                                                password,
                                                                                telefono,
                                                                                kind)

      result = self.__executeQuery( sql, debug=True )
      result.commit()
      result.close()

   def listUsers( self ):
      sql    = """SELECT nombre, usuario, status FROM empleado"""
      result = self.__executeQuery( sql )
      result = result.fetchall()

      print "-----------------------------------------------------------------"
      print "| Empleado\t\t| Usuario\t\t| Estado\t|"
      print "-----------------------------------------------------------------"

      for user in result:
         estado = None

         if user[2] == 1:
            estado = "ACTIVO"
         else:
            estado = 'INACTIVO'

         print "| %s\t\t| %s\t\t| %s\t|" % (user[0], user[1], estado)

      print "-----------------------------------------------------------------"

   """ FIN MANEJO DE USUARIOS """

   def countCanchas( self ):
      sql    = """SELECT COUNT(id) FROM cancha"""
      result = self.__executeQuery( sql )
      return int(result.fetchone()[0])

   def getCanchasNames( self ):
      sql    = """SELECT id, nombre FROM cancha """
      result = self.__executeQuery( sql )
      return result.fetchall()

   def getCanchaPrecio( self, id_cancha ):
      sql    = """SELECT precio FROM cancha WHERE id = '%s'""" % id_cancha
      result = self.__executeQuery( sql )
      return float( result.fetchall()[0][0] )

   def getCanchaStatus( self, fecha, id_cancha, horario ):
      try:
         fecha = fecha.split(' ')[0]
      except:
         fecha = fecha.__str__().split(' ')[0]

      sql    = """SELECT estado FROM horario_cancha WHERE fecha like '%s%%' AND id_cancha = '%s' and nombre = '%s' ORDER BY rowid desc limit 1""" % (fecha, id_cancha, horario)
      result = self.__executeQuery( sql )

      return result.fetchone()

   def getClienteReservado( self, fecha, id_cancha, horario ):
      try:
         fecha = fecha.split(' ')[0]
      except:
         fecha = fecha.__str__().split(' ')[0]

      sql    = """SELECT obs FROM horario_cancha WHERE fecha like '%s%%' AND id_cancha = '%s' and nombre = '%s' ORDER BY rowid desc limit 1""" % (fecha, id_cancha, horario)
      result = self.__executeQuery( sql )

      return result.fetchone()

   def getMinutosActivacion( self, fecha, id_cancha, horario ):
      try:
         fecha = fecha.split(' ')[0]
      except:
         fecha = fecha.__str__().split(' ')[0]

      sql = """SELECT min_activacion FROM horario_cancha WHERE fecha like '%s%%' AND id_cancha = '%s' and nombre = '%s' ORDER BY rowid desc limit 1""" % (fecha, id_cancha    , horario)
      result = self.__executeQuery( sql )

      return result.fetchone()

   def getPrecioReservado( self, fecha, id_cancha, horario ):
      try:
         fecha = fecha.split(' ')[0]
      except:
         fecha = fecha.__str__().split(' ')[0]

      sql    = """SELECT precio FROM horario_cancha WHERE fecha like '%s%%' AND id_cancha = '%s' and nombre = '%s' ORDER BY rowid desc limit 1""" % (fecha, id_cancha, horario)
      result = self.__executeQuery( sql )

      return result.fetchone()

   def getIDReservado( self, fecha, id_cancha, horario ):
      try:
         fecha = fecha.split(' ')[0]
      except:
         fecha = fecha.__str__().split(' ')[0]

      horario = horario.split(':')[0]

      sql    = """SELECT id FROM horario_cancha WHERE fecha like '%s%%' AND id_cancha = %s and nombre = '%s' and estado = 2 ORDER BY rowid desc limit 1""" % (fecha, int(id_cancha), horario)
      result = self.__executeQuery( sql )

      return result.fetchone()

   def getCuentaHorarioID( self, id_reserva ):
      sql    = """SELECT id FROM cuenta_horario WHERE id_horario_cancha = %s ORDER BY rowid desc limit 1""" % id_reserva
      result = self.__executeQuery( sql )

      return result.fetchone()

   def getProductosByCuenta( self, id_cuenta_horario ):
      sql    = """SELECT pc.id_producto, pc.precio, pc.cantidad, p.codigo, p.marca, p.descripcion FROM producto_cuenta as pc, producto as p WHERE pc.id_producto = p.id AND pc.id_cuenta_horario = %s""" % id_cuenta_horario
      result = self.__executeQuery( sql )
      #print "SQL: %s" % sql

      return result.fetchall()

   def doReserva( self, fecha, id_cancha, horario, precio, cliente ):
      if not self.getCanchaStatus( fecha.__str__(), id_cancha, horario ):
         sql    = """INSERT INTO horario_cancha (estado, id_cancha, fecha, nombre, precio, obs) VALUES (1, %s, '%s', '%s', %s, '%s')""" % (id_cancha, fecha, horario, precio, cliente)
         result = self.__executeQuery( sql )
         self.link.commit()
         return True

      elif self.getCanchaStatus( fecha.__str__(), id_cancha, horario )[0] == '0':
         sql    = """INSERT INTO horario_cancha (estado, id_cancha, fecha, nombre, precio, obs) VALUES (1, %s, '%s', '%s', %s, '%s')""" % (id_cancha, fecha, horario, precio, cliente)
         result = self.__executeQuery( sql )
         self.link.commit()
         return True
      else:
         return False

   def activateCancha( self, fecha, id_cancha, horario, cliente, precio, stamp ):
      if self.getCanchaStatus( fecha.__str__(), id_cancha, horario )[0] == '1':
         sql    = """INSERT INTO horario_cancha (estado, id_cancha, fecha, nombre, precio, obs, min_activacion) VALUES ('2', %s, '%s', '%s', %s, '%s', '%s')""" % ( id_cancha, fecha, horario, precio[0], cliente[0], stamp )
         result = self.__executeQuery( sql )
         self.link.commit()

         id_reserva = self.getIDReservado( fecha, id_cancha, horario )
         sql = """INSERT INTO cuenta_horario (nombre, hs_apertura, hs_cierre, id_horario_cancha) VALUES ('%s', '%s', '%s', %s)"""% ( str( cliente[0] ), fecha, '0', int(id_reserva[0]) )
         result = self.__executeQuery( sql )
         self.link.commit()

         return True

      return False

   def closeCancha( self, fecha, id_cancha, horario, cliente, precio ):
      if self.getCanchaStatus( fecha.__str__(), id_cancha, horario )[0] == '2':
         sql    = """INSERT INTO horario_cancha (estado, id_cancha, fecha, nombre, precio, obs) VALUES ('3', %s, '%s', '%s', %s, '%s')""" % ( id_cancha, fecha, horario, precio[0], cliente[0] )
         result = self.__executeQuery( sql )
         self.link.commit()

         sql = """INSERT INTO product_trans (fecha, cantidad, tipo, precio, id_producto, id_empleado, id_sucursal) VALUES ('%s', 1, 2, %s, 0, 1, 1)""" % ( fecha, precio[0] )
         result = self.__executeQuery( sql )
         self.link.commit()

         return True

      return False

   def cancelReserva( self, fecha, id_cancha, horario ):
      if self.getCanchaStatus( fecha, id_cancha, horario )[0] == '1':
         sql    = """INSERT INTO horario_cancha (estado, id_cancha, fecha, nombre) VALUES (0, %s, '%s', '%s')""" % ( id_cancha, fecha, horario )
         result = self.__executeQuery( sql )
         self.link.commit()
         return True

      return False

   def addProductToCuentaCancha( self, id_cuenta_horario, id_producto, precio_producto, cantidad ):
      sql    = """INSERT INTO producto_cuenta (id_cuenta_horario, id_producto, precio, cantidad) VALUES (%s, %s, %s, %s)""" % (id_cuenta_horario, id_producto, precio_producto, cantidad)
      result = self.__executeQuery( sql )
      self.link.commit()

   def deleteProductFromCuenta( self, producto_id, cancha_id ):
      sql    = "DELETE FROM producto_cuenta WHERE id_producto=%s AND id_cuenta_horario=%s""" % ( producto_id, cancha_id )
      result = self.__executeQuery( sql )
      self.link.commit()

   def deleteProductFromProductTrans( self, producto_id, id_cuenta_horario ):
      sql    = """DELETE FROM product_trans WHERE id_producto=%s AND horario=%s""" % ( producto_id, id_cuenta_horario )
      result = self.__executeQuery( sql )
      self.link.commit()

   def addProductTrans( self, fecha, cantidad, tipo, precio, id_producto, id_empleado, id_sucursal, id_cancha, horario ):
      sql    = """INSERT INTO product_trans (fecha, cantidad, tipo, precio, id_producto, id_empleado, id_sucursal, id_cancha, horario) VALUES ('%s', %s, %s, %s, %s, %s, %s, %s, '%s')""" % (fecha, cantidad, tipo, precio, id_producto, id_empleado, id_sucursal, id_cancha, horario)
      result = self.__executeQuery( sql )
      self.link.commit()

   def reduceStockById( self, id_producto, cantidad ):
      sql    = """UPDATE producto SET stock=%s WHERE id=%s""" % ( cantidad, id_producto )
      result = self.__executeQuery( sql )
      self.link.commit()

   def getProductoByCodigo( self, cod ):
      sql    = """SELECT id FROM producto where codigo = '%s'""" % cod
      result = self.__executeQuery( sql )
      return result.fetchone()

   def getCantidadByCodigo( self, cod ):
      sql    = """SELECT stock FROM producto WHERE codigo = '%s'""" % cod
      result = self.__executeQuery( sql )
      return result.fetchone()

   def getProductoByCode( self, code ):
      sql    = """SELECT * FROM producto where codigo = '%s'""" % code
      result = self.__executeQuery( sql )
      return result.fetchall()

   def deleteProductByCode( self, code ):
      sql    = """DELETE FROM producto WHERE codigo='%s'""" % code
      result = self.__executeQuery( sql )
      self.link.commit()
      return result

   def getProductos( self, description=None ):
      if description is None:
          sql    = """SELECT * FROM producto"""
          result = self.__executeQuery( sql )
          return result.fetchall()
      else:
          sql    = """SELECT * FROM producto where descripcion like '%%%s%%'""" % description
          result = self.__executeQuery( sql )
          result = result.fetchall()

          if result == []:
             return None
          else:
             return result

   def productosPedido( self ):
      sql    = """SELECT COUNT(id) FROM producto WHERE stock < p_pedido"""
      result = self.__executeQuery( sql )
      return result.fetchone()

   def getCuentas( self, desde=None, hasta=None ):
      this_time = datetime.datetime.now().strftime("%m/%d/%y")

      if desde is None and hasta is None:
         sql = """SELECT t.fecha, p.descripcion AS producto, t.cantidad, t.precio, (t.cantidad*t.precio) AS total from producto as p INNER JOIN product_trans AS t ON p.id = t.id_producto WHERE t.fecha BETWEEN '%s 00:00:00' AND '%s 23:59:59' ORDER BY t.fecha""" % (this_time, this_time)
      else:
         sql = """SELECT t.fecha, p.descripcion AS producto, t.cantidad, t.precio, (t.cantidad*t.precio) AS total from producto as p INNER JOIN product_trans AS t ON p.id = t.id_producto WHERE t.fecha BETWEEN '%s 00:00:00' AND '%s 23:59:59' ORDER BY t.fecha""" % (desde, hasta)

      result = self.__executeQuery( sql )
      return result.fetchall()

   def getEgresos( self, desde=None, hasta=None ):
      this_time = datetime.datetime.now().strftime("%m/%d/%y")

      if desde is None and hasta is None:
         sql = """SELECT fecha, descripcion, egreso, '', '' FROM movimiento_sucursal WHERE fecha BETWEEN '%s 00:00:00' AND '%s 23:59:59'""" % (this_time, this_time)
      else:
         sql = """SELECT fecha, descripcion, '', '', egreso*(-1) FROM movimiento_sucursal WHERE fecha BETWEEN '%s 00:00:00' AND '%s 23:59:59'""" % (desde, hasta)

      result = self.__executeQuery( sql )
      return result.fetchall()

   def generateEgreso( self, descript, monto ):
      this_time = datetime.datetime.now().strftime("%m/%d/%y")
      sql       = """INSERT INTO movimiento_sucursal (descripcion, ingreso, egreso, fecha, id_empleado, id_sucursal) VALUES ('%s', 0, %s, '%s', 1, 1)""" % (descript, float(monto), this_time)
      result    = self.__executeQuery( sql )
      self.link.commit()

   def __productCodeExists( self, code ):
      sql    = """SELECT COUNT(id) FROM producto WHERE codigo = '%s'""" % code
      result = self.__executeQuery( sql )
      result = result.fetchone()

      if result[0] > 0:
         return True
      else:
         return False

   def addProduct( self, codigo, descripcion, marca, precio, ppedido, cantidad ):
      if int(cantidad) < 1:
         return (False, 'La cantidad debe ser mayor que 0')

      if not self.__productCodeExists( codigo ):
         sql    = """INSERT INTO producto (codigo, descripcion, marca, precio, p_pedido, stock, id_sucursal) VALUES ('%s', '%s', '%s', %s, %s, %s, '1')""" % ( codigo, descripcion, marca, precio, ppedido, cantidad )
         result = self.__executeQuery( sql )
         self.link.commit()
         return (True, 'Producto Agregado')
      else:
         return (False, 'Codigo Existente')

if __name__ == '__main__':
   DBM = DBManager()

   def help():
      print "Administracion de la base de datos:"
      print "DBManager [OPTIONS] <args>"
      print "  --list, -l		Lista Usuarios"
      print "  --create, -c		Crear usuario"
      print "  --help, -h		Muestra esta ayuda"

   try:
      if sys.argv[1] == "--list" or sys.argv[1] == "-l":
         DBM.listUsers()
      if sys.argv[1] == "--help" or sys.argv[1] == "-h":
         help()
      if sys.argv[1] == "--create" or sys.argv[1] == "-c":
         DBM.createUser()
   except:
      help()
