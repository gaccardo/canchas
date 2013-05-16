import wx

from DBManager     import DBManager
from wx.lib.pubsub import Publisher

class SeleccionarProducto( wx.Dialog ):

   def __init__( self, parent, id, title ):
       wx.Dialog.__init__( self, parent, id, title )
       self.DBM = DBManager()
       self.producto_comprado = None

       self.SetSize( ( 320, 260 ) )

       vbox   = wx.BoxSizer( wx.VERTICAL )
       font   = wx.Font(16, wx.NORMAL, wx.NORMAL, wx.BOLD)
       hbox0  = wx.BoxSizer( wx.HORIZONTAL )
       b_text = wx.StaticText( self, -1, "BUSCAR" )
       b_text.SetFont( font )
       hbox0.Add( b_text,  flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP )
       vbox.Add( hbox0, flag=wx.CENTER | wx.EXPAND )

       hbox1        = wx.BoxSizer( wx.HORIZONTAL )
       self.b_field = wx.TextCtrl( self, -1, "" )
       b_button     = wx.Button( self, -1, "Buscar" )
       hbox1.Add( self.b_field, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP,
                  border=10 )
       hbox1.Add( b_button, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, border=10 )
       vbox.Add(  hbox1 )

       hbox3       = wx.BoxSizer( wx.HORIZONTAL )
       cantidad    = wx.StaticText( self, -1, "Cantidad" )
       self.b_cant = wx.TextCtrl( self, -1, "", size=(40,20) )
       comprar     = wx.Button( self, -1, "Agregar" )
       hbox3.Add( cantidad, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, border=10 )
       hbox3.Add( self.b_cant, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP,
                  border=10 )
       hbox3.Add( comprar, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, border=10 )
       vbox.Add(  hbox3 )

       hbox2       = wx.BoxSizer( wx.HORIZONTAL )
       self.b_decr = wx.TextCtrl( self, -1, "", size=(40,20) )
       hbox2.Add( self.b_decr, proportion=3, 
                  flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, border=10 )
       vbox.Add(  hbox2, proportion=3, flag=wx.CENTER | wx.EXPAND, border=3 )

       self.Bind(wx.EVT_BUTTON, self.__OnSearch, b_button)
       self.Bind(wx.EVT_BUTTON, self.__OnBuy, comprar)

       self.SetSizer( vbox )
       self.Show(     True )

   def __OnSearch( self, evt ):
       try:
          producto = self.DBM.getProductoByCode( self.b_field.GetValue() )[0]
          if producto[6] == 0:
             self.b_decr.SetValue( "Stock Agotado" )
          else:
             self.b_decr.SetValue( "%s %s $%.2f" % ( producto[2],
                                                     producto[3],
                                                     producto[4] ) )
             self.producto_comprado = producto
       except:
          self.b_decr.SetValue( "Producto Inexistente" )

   def __OnBuy( self, evt ):
      cantidad = self.b_cant.GetValue()
      if self.producto_comprado[6] < int( cantidad ):
         wx.MessageBox("No tiene suficiente stock para realizar la venta", 
                       "Stock Insuficiente",
                       wx.OK | wx.ICON_INFORMATION)
      else:
         Publisher().sendMessage(("producto_seleccionado"), 
                                 {'producto':self.producto_comprado, 
                                  'cantidad':cantidad} )
         self.Destroy()


class CuentaCancha( wx.Dialog ):

   def __init__( self, parent, id, title, data ):
       wx.Dialog.__init__( self, parent, id, title )
       self.data = data

       self.SetSize(    ( 800, 600 ) )
       self.SetMinSize( ( 800, 600 ) )

       self.list_ctrl = wx.ListCtrl(self, style=wx.LC_REPORT)
       image2         = wx.Image('images/add.png',
                                 wx.BITMAP_TYPE_ANY).ConvertToBitmap()
       self.btn_add   = wx.BitmapButton(self, id=-1, bitmap=image2, 
                                        size=(24,24))
       image5         = wx.Image('images/delete.png',
                                  wx.BITMAP_TYPE_ANY).ConvertToBitmap()
       self.btn_del   = wx.BitmapButton(self, id=-1, bitmap=image5, 
                                        size=(24,24))

       self.__generateContent( )
       self.Bind(wx.EVT_CLOSE, self.__OnClose)
       Publisher().subscribe(self.__redefine, ("producto_seleccionado"))

   def __OnClose( self, evt ):
       Publisher().sendMessage(("cuentacancha_cerrada"), True)
       self.Destroy() 

   def __generateContent( self ):
       self.DBM          = DBManager()
       id_reserva        = self.DBM.getIDReservado( self.data['fecha'],
                                                    self.data['id_cancha'],
                                                    self.data['horario'] )
       id_cuenta_horario = self.DBM.getCuentaHorarioID( id_reserva )[0]
       productos         = self.DBM.getProductosByCuenta( id_cuenta_horario )
       rows              = list()

       try:
          for row in productos:
             rows.append( (row[3], row[4], row[5], row[1], row[2]) )
       except:
          rows.append( ('Vacio', '', '', '', '') )

       self.list_ctrl.InsertColumn(0, "Codigo")
       self.list_ctrl.InsertColumn(1, "Marca")
       self.list_ctrl.InsertColumn(2, "Descripcion")
       self.list_ctrl.InsertColumn(3, "Precio")
       self.list_ctrl.InsertColumn(4, "Cantidad")

       index = 0
       total = 0
       for row in rows:
          self.list_ctrl.InsertStringItem(index, row[0])
          self.list_ctrl.SetStringItem(index, 1, row[1])
          self.list_ctrl.SetStringItem(index, 2, row[2])
          self.list_ctrl.SetStringItem(index, 3, "$ %s" % str( row[3] ))
          self.list_ctrl.SetStringItem(index, 4, str( row[4] ))

          total +=  row[3] * row[4]

          if index % 2:
             self.list_ctrl.SetItemBackgroundColour(index, "white")
          else:
             self.list_ctrl.SetItemBackgroundColour(index, "gray")

          index += 1

       self.list_ctrl.InsertStringItem(index, "TOTAL")
       self.list_ctrl.SetStringItem(index, 1, "")
       self.list_ctrl.SetStringItem(index, 2, "")
       self.list_ctrl.SetStringItem(index, 3, "")
       self.list_ctrl.SetStringItem(index, 4, "$ %s" % total)
       self.list_ctrl.SetItemBackgroundColour(index, "red")

       self.Bind(wx.EVT_BUTTON, self.onAdd, self.btn_add)
       self.Bind(wx.EVT_BUTTON, self.onDel, self.btn_del)

       sizer  = wx.BoxSizer(wx.VERTICAL)
       sizer2 = wx.BoxSizer(wx.HORIZONTAL)

       sizer2.Add(self.btn_add, 0, wx.ALL, 1)
       sizer2.Add(self.btn_del, 0, wx.ALL, 1)
       sizer.Add(sizer2, 0, wx.ALL, 1)
       sizer.Add(self.list_ctrl, 1, wx.EXPAND)
       self.SetSizer(sizer)
       self.Show(True)

   def __redefine( self, evt ):
      self.list_ctrl.ClearAll()
      id_reserva        = self.DBM.getIDReservado( self.data['fecha'], 
                                                   self.data['id_cancha'], 
                                                   self.data['horario'] )
      id_cuenta_horario = self.DBM.getCuentaHorarioID( id_reserva )[0]

      self.DBM.addProductToCuentaCancha( id_cuenta_horario, 
                                         evt.data['producto'][0],
                                         evt.data['producto'][4],
                                         evt.data['cantidad'] )
      nueva_cantidad = evt.data['producto'][6] - int( evt.data['cantidad'] )
      self.DBM.reduceStockById( evt.data['producto'][0], nueva_cantidad ) 
      self.DBM.addProductTrans( self.data["fecha"],
                                evt.data['cantidad'], 
                                1, 
                                evt.data['producto'][4],
                                evt.data['producto'][0],
                                1,
                                1,
                                self.data['id_cancha'], 
                                id_cuenta_horario)

      self.__generateContent()

   def onAdd( self, evt ):
      sp = SeleccionarProducto( self, id=wx.ID_ANY, 
                                title="Agregar Producto a la Compra")

   def onDel( self, evt ):
      item              = self.list_ctrl.GetItem( self.list_ctrl.GetFirstSelected() )
      product           = self.DBM.getProductoByCode( item.GetText() )
      id_reserva        = self.DBM.getIDReservado( self.data['fecha'], 
                                                   self.data['id_cancha'],
                                                   self.data['horario'] )
      id_cuenta_horario = self.DBM.getCuentaHorarioID( id_reserva )[0]
      productos         = self.DBM.getProductosByCuenta( id_cuenta_horario )
      cantidad          = 0

      for prod in productos:
         if prod[0] == product[0][0]:
            cantidad = prod[2]

      n_cantidad = cantidad + product[0][6]

      self.DBM.reduceStockById(               product[0][0], n_cantidad        )
      self.DBM.deleteProductFromCuenta(       product[0][0], id_cuenta_horario )
      self.DBM.deleteProductFromProductTrans( product[0][0], id_cuenta_horario )

      self.list_ctrl.ClearAll()
      self.__generateContent()
