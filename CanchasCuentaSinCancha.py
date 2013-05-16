import wx

from DBManager     import DBManager
from wx.lib.pubsub import Publisher

class SeleccionarProducto( wx.Dialog ):

   def __init__( self, parent, id, title ):
       wx.Dialog.__init__( self, parent, id, title )
       self.DBM = DBManager()
       self.producto_comprado = None

       self.SetSize( ( 320, 260 ) )

       vbox = wx.BoxSizer( wx.VERTICAL )
       font = wx.Font(16, wx.NORMAL, wx.NORMAL, wx.BOLD)

       hbox0  = wx.BoxSizer( wx.HORIZONTAL )
       b_text = wx.StaticText( self, -1, "BUSCAR" )
       b_text.SetFont( font )
       hbox0.Add( b_text,  flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP )
       vbox.Add( hbox0, flag=wx.CENTER | wx.EXPAND )

       hbox1        = wx.BoxSizer( wx.HORIZONTAL )
       self.b_field = wx.TextCtrl( self, -1, "" )
       #self.b_cant  = wx.TextCtrl( self, -1, "", size=(40,10) )
       b_button     = wx.Button( self, -1, "Buscar" )
       hbox1.Add( self.b_field, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, border=10 )
       #hbox1.Add( self.b_cant, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, border=10 )
       hbox1.Add( b_button, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, border=10 )
       vbox.Add( hbox1 )
       #vbox.Add( (-1, 25) )

       hbox3       = wx.BoxSizer( wx.HORIZONTAL )
       cantidad    = wx.StaticText( self, -1, "Cantidad" )
       self.b_cant = wx.TextCtrl( self, -1, "", size=(40,20) )
       comprar     = wx.Button( self, -1, "Agregar" )
       hbox3.Add( cantidad, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, border=10 )
       hbox3.Add( self.b_cant, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, border=10 )
       hbox3.Add( comprar, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, border=10 )
       vbox.Add( hbox3 )

       hbox2       = wx.BoxSizer( wx.HORIZONTAL )
       self.b_decr = wx.TextCtrl( self, -1, "", size=(40,20) )
       #self.list_ctrl = wx.ListCtrl(self, style=wx.LC_REPORT)
       hbox2.Add( self.b_decr, proportion=3, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, border=10 )
       vbox.Add( hbox2, proportion=3, flag=wx.CENTER | wx.EXPAND, border=3 )

       self.Bind(wx.EVT_BUTTON, self.__OnSearch, b_button)
       self.Bind(wx.EVT_BUTTON, self.__OnBuy, comprar)

       self.SetSizer( vbox )
       self.Show( True )

       #self.__generateContent()

   def __OnSearch( self, evt ):
       try:
          producto = self.DBM.getProductoByCode( self.b_field.GetValue() )[0]
          if producto[6] == 0:
             self.b_decr.SetValue( "Stock Agotado" )
          else:
             self.b_decr.SetValue( "%s %s $%.2f" % ( producto[2], producto[3], producto[4] ) )
             self.producto_comprado = producto
       except:
          self.b_decr.SetValue( "Producto Inexistente" )

   def __OnBuy( self, evt ):
      cantidad = self.b_cant.GetValue()
      if self.producto_comprado[6] < int( cantidad ):
         wx.MessageBox("No tiene suficiente stock para realizar la venta", "Stock Insuficiente",
                        wx.OK | wx.ICON_INFORMATION)
      else:
         Publisher().sendMessage(("producto_seleccionado_sin_cancha"), {'producto':self.producto_comprado, 'cantidad':cantidad} )
         self.Destroy()
