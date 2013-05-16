import wx
import datetime

from DBManager     import DBManager
from wx.lib.pubsub import Publisher

class SeleccionarProducto( wx.Dialog ):

   def __init__( self, parent, id, title ):
       wx.Dialog.__init__( self, parent, id, title )
       self.DBM               = DBManager()
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
       b_button     = wx.Button( self, -1, "Buscar" )
       hbox1.Add( self.b_field, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, 
                  border=10 )
       hbox1.Add( b_button, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, border=10 )
       vbox.Add( hbox1 )

       hbox3       = wx.BoxSizer( wx.HORIZONTAL )
       cantidad    = wx.StaticText( self, -1, "Cantidad" )
       self.b_cant = wx.TextCtrl( self, -1, "", size=(40,20) )
       comprar     = wx.Button( self, -1, "Agregar" )
       hbox3.Add( cantidad, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, border=10 )
       hbox3.Add( self.b_cant, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP,
                  border=10 )
       hbox3.Add( comprar, flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, border=10 )
       vbox.Add( hbox3 )

       hbox2       = wx.BoxSizer( wx.HORIZONTAL )
       self.b_decr = wx.TextCtrl( self, -1, "", size=(40,20) )
       hbox2.Add( self.b_decr, proportion=3, 
                  flag=wx.EXPAND|wx.LEFT|wx.RIGHT|wx.TOP, border=10 )
       vbox.Add( hbox2, proportion=3, flag=wx.CENTER | wx.EXPAND, border=3 )

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
         Publisher().sendMessage(("producto_seleccionado_sin_cancha"), 
                                 {'producto':self.producto_comprado, 
                                  'cantidad':cantidad} )
         self.Destroy()



class SearchStock( wx.Dialog ):
    def __init__(self, parent, id, title):
        wx.Dialog.__init__(self, parent, id, title)
        self.SetSize((180,75))
        self.SetMinSize((180,75))

        global_sizer    = wx.BoxSizer(wx.VERTICAL)
        sizer           = wx.BoxSizer(wx.HORIZONTAL)
        txt_buscar      = wx.StaticText(self, -1, "Buscar")
        self.ctr_buscar = wx.TextCtrl(self, -1, "")

        sizer.Add(txt_buscar, wx.CENTER|wx.EXPAND)
        sizer.Add(self.ctr_buscar, 0, wx.ALL, 1)

        sizer2     = wx.BoxSizer(wx.HORIZONTAL)
        btn_buscar = wx.Button(self, -1, "BUSCAR")

        self.Bind(wx.EVT_BUTTON, self.__OnSearch, btn_buscar) 
        sizer2.Add(btn_buscar, wx.EXPAND)

        global_sizer.Add(sizer, 0, wx.EXPAND, 1)
        global_sizer.Add(sizer2, 0, wx.EXPAND, 1)

        self.SetSizer(global_sizer)
        self.Show(True)

    def __OnSearch( self, evt ):
        Publisher().sendMessage(("producto_buscado"), self.ctr_buscar.GetValue())
        self.Hide()
        self.Destroy()


class VentaAdmin( wx.Dialog ):
    def __init__(self, parent, id, title):
        wx.Dialog.__init__(self, parent, id, title)

        self.SetSize((800,600))
        self.SetMinSize((800,600))

        self.rows      = list()
        self.list_ctrl = wx.ListCtrl(self, style=wx.LC_REPORT)
        image2         = wx.Image('images/add.png', 
                                  wx.BITMAP_TYPE_ANY).ConvertToBitmap()
        self.btn_add   = wx.BitmapButton(self,
                                         id     = -1,
                                         bitmap = image2,
                                         size   = (24,24))
        image3         = wx.Image('images/red.gif',
                                  wx.BITMAP_TYPE_ANY).ConvertToBitmap()
        self.btn_prt   = wx.BitmapButton(self,
                                         id     = -1,
                                         bitmap = image3, 
                                         size   = (24,24))
        image5         = wx.Image('images/delete.png',
                                  wx.BITMAP_TYPE_ANY).ConvertToBitmap()
        self.btn_del   = wx.BitmapButton(self, 
                                         id     = -1,
                                         bitmap = image5,
                                         size   = (24,24))
        self.DBM       = DBManager()
        self.__generateContent()
        Publisher().subscribe(self.__redefine,
                             ("producto_seleccionado_sin_cancha"))

    def __generateContent( self, myfilter=None ):
        rows = self.rows

        self.list_ctrl.InsertColumn(0, "Codigo")
        self.list_ctrl.InsertColumn(1, "Marca")
        self.list_ctrl.InsertColumn(2, "Descripcion")
        self.list_ctrl.InsertColumn(3, "Cantidad")
        self.list_ctrl.InsertColumn(4, "Precio")

        total = 0
        index = 0
        for row in rows:
            if row[0] != '1000':
               self.list_ctrl.InsertStringItem(index, row[0])
               self.list_ctrl.SetStringItem(index, 1, row[1])
               self.list_ctrl.SetStringItem(index, 2, row[2])
               self.list_ctrl.SetStringItem(index, 3, row[4])
               self.list_ctrl.SetStringItem(index, 4, "$ %.2f" % float(row[3]))

               total += float( row[3] )
             
               if index % 2:
                   self.list_ctrl.SetItemBackgroundColour(index, "white")
               else:
                   self.list_ctrl.SetItemBackgroundColour(index, "gray")

               index += 1

        self.list_ctrl.InsertStringItem(index, 'TOTAL')
        self.list_ctrl.SetStringItem(index, 1, '')
        self.list_ctrl.SetStringItem(index, 2, '')
        self.list_ctrl.SetStringItem(index, 3, '')
        self.list_ctrl.SetStringItem(index, 4, '$ %.2f' % float(total))
        self.list_ctrl.SetItemBackgroundColour(index, "red")
        self.list_ctrl.SetItemTextColour(index, "yellow")

        self.Bind(wx.EVT_BUTTON, self.onAdd, self.btn_add)
        self.Bind(wx.EVT_BUTTON, self.onClose, self.btn_prt)

        sizer  = wx.BoxSizer(wx.VERTICAL)
        sizer2 = wx.BoxSizer(wx.HORIZONTAL)

        sizer2.Add(self.btn_add, 0, wx.ALL, 1)
        sizer2.Add(self.btn_del, 0, wx.ALL, 1)
        sizer2.Add(self.btn_prt, 0, wx.ALL, 1)
        sizer.Add(sizer2, 0, wx.ALL, 1)
        sizer.Add(self.list_ctrl, 1, wx.EXPAND)
        self.SetSizer(sizer)
        self.Show(True)

        Publisher().subscribe(self.onSearch, ("producto_buscado"))
        Publisher().subscribe(self.refreshAfterAdd, ("producto_agregado"))

    def __redefine( self, evt ):
        self.list_ctrl.ClearAll()
        producto = evt.data['producto']
        cantidad = evt.data['cantidad']

        self.rows.append( (producto[1],
                           producto[3],
                           producto[2], 
                           str(producto[4]),
                           cantidad, 
                           producto[0] ) )

        self.__generateContent()

    def onSearch( self, evt ):
        self.list_ctrl.ClearAll()
        search_stock = SearchStock(self, -1, "Buscar")
        self.__generateContent(evt.data)

    def onAdd( self, evt ):
        seleccionar = SeleccionarProducto(self,
                                          -1,
                                          "Agregar un producto a la compra")

    def onClose( self, evt ):
        dlg = wx.MessageDialog(self, 
                               'Seguro que desea cerrar la venta?', 
                               'Cerrar Venta?', wx.YES_NO | wx.ICON_QUESTION)
        result = dlg.ShowModal() == wx.ID_YES

        if result:
           dlg.Destroy()
           self.Destroy()

        for producto in self.rows:
           stock          = int( self.DBM.getCantidadByCodigo( str( producto[0] ) )[0] )
           nueva_cantidad = stock - int(producto[4])

           self.DBM.reduceStockById( producto[5], nueva_cantidad )
           self.DBM.addProductTrans( datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), 
                                     producto[4],
                                     1,
                                     producto[3], 
                                     producto[5], 
                                     1,
                                     1,
                                     0,
                                     0 )

    def refreshAfterAdd( self, evt ):
        self.list_ctrl.ClearAll()
        self.__generateContent()
