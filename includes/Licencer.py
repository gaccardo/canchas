#!/usr/bin/env python

import urllib

class LicenseChecker( object ):

   def __init__( self ):
      self.url           = 'http://logon.guidoaccardo.com.ar/'
      self.count_offline = 15

   def __countTimes( self ):
      ff = open( 'times.ehead', 'r' )
      bb = ff.read()
      ff.close()

      return int( bb )

   def __updateTimes( self, times ):
      actual = self.__countTimes()
      ff     = open( 'times.ehead', 'w' )
      ff.write( str( actual-times ) )
      ff.close()

   def isActive( self ):
      try:
         site    = urllib.urlopen( self.url )
         content = site.readlines()
         site.close()
      except IOError:
         if not self.__countTimes() == 0:
            self.__updateTimes( 1 )
            return { 'active':True, 'msg':'Ejecutando sin conexion.' }
         else:
            return { 'active':False, 'msg':'Ejecutado demasiadas veces sin conexion.' }

      if content[0].strip() == 'ACTIVE':
         self.__updateTimes( self.count_offline )
         return { 'active':True, 'msg':'Iniciando Sistema' }
      else:
         return { 'active':False, 'msg':content[0].strip() }
