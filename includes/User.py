#!/usr/bin/env python

class User( object ):

   def __init__( self, id, nombre, usuario, passwd, id_sucursal, status, telefono, tipo ):
      self.id          = id
      self.nombre      = nombre
      self.usuario     = usuario
      self.passwd      = passwd
      self.id_sucursal = id_sucursal
      self.status      = status
      self.telefono    = telefono
      self.tipo        = tipo

   def getId ( self ):
      return self.id

   def getNombre ( self ):
      return self.nombre

   def getUsuario ( self ):
      return self.usuario

   def getPasswd ( self ):
      return self.passwd

   def getIdSucursal ( self ):
      return self.id_sucursal

   def getStatus ( self ):
      return self.status

   def getTelefono ( self ):
      return self.telefono

   def getTipo ( self ):
      return self.tipo

