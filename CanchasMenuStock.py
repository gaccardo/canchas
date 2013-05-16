import wx

from DBManager     import DBManager
from wx.lib.pubsub import Publisher
from Reporter      import Reporter

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


class AddStock( wx.Dialog ):
    def __init__(self, parent, id, title):
        wx.Dialog.__init__(self, parent, id, title)

        self.DBM = DBManager()
 
        self.SetSize((210,375))
        self.SetMinSize((210,375))

        vbox = wx.BoxSizer( wx.VERTICAL )

        hbox1           = wx.BoxSizer( wx.HORIZONTAL )
        txt_codigo      = wx.StaticText(self, -1, "Codigo")
        self.ctr_codigo = wx.TextCtrl(self, -1, "")
        hbox1.Add(txt_codigo, wx.EXPAND, 1)
        hbox1.Add(self.ctr_codigo, wx.EXPAND, 1)
        vbox.Add(hbox1, wx.EXPAND) 
        
        hbox2          = wx.BoxSizer( wx.HORIZONTAL )
        txt_descr      = wx.StaticText(self, -1, "Descripcion")
        self.ctr_descr = wx.TextCtrl(self, -1, "")
        hbox2.Add(txt_descr, wx.EXPAND, 1)
        hbox2.Add(self.ctr_descr, wx.EXPAND, 1)
        vbox.Add(hbox2, wx.EXPAND) 

        hbox3          = wx.BoxSizer( wx.HORIZONTAL )
        txt_marca      = wx.StaticText(self, -1, "Marca")
        self.ctr_marca = wx.TextCtrl(self, -1, "")
        hbox3.Add(txt_marca, wx.EXPAND, 1)
        hbox3.Add(self.ctr_marca, wx.EXPAND, 1)
        vbox.Add(hbox3, wx.EXPAND) 

        hbox4      = wx.BoxSizer( wx.HORIZONTAL )
        txt_precio = wx.StaticText(self, -1, "Precio")
        self.ctr_precio = wx.TextCtrl(self, -1, "")
        hbox4.Add(txt_precio, wx.EXPAND, 1)
        hbox4.Add(self.ctr_precio, wx.EXPAND, 1)
        vbox.Add(hbox4, wx.EXPAND) 

        hbox5            = wx.BoxSizer( wx.HORIZONTAL )
        txt_ppedido      = wx.StaticText(self, -1, "Punto Pedido")
        self.ctr_ppedido = wx.TextCtrl(self, -1, "")
        hbox5.Add(txt_ppedido, wx.EXPAND, 1)
        hbox5.Add(self.ctr_ppedido, wx.EXPAND, 1)
        vbox.Add(hbox5, wx.EXPAND) 

        hbox6             = wx.BoxSizer( wx.HORIZONTAL )
        txt_cantidad      = wx.StaticText(self, -1, "Cantidad")
        self.ctr_cantidad = wx.TextCtrl(self, -1, "")
        hbox6.Add(txt_cantidad, wx.EXPAND, 1)
        hbox6.Add(self.ctr_cantidad, wx.EXPAND, 1)
        vbox.Add(hbox6, wx.EXPAND) 

        hbox7       = wx.BoxSizer( wx.HORIZONTAL )
        btn_agregar = wx.Button(self, -1, "AGREGAR")
        hbox7.Add(btn_agregar, flag=wx.CENTER)
        vbox.Add(hbox7, flag=wx.CENTER)

        self.Bind(wx.EVT_BUTTON, self.OnAdd, btn_agregar)

        self.SetSizer( vbox )
        self.Show(True)

    def OnAdd( self, evt ):
        codigo   = self.ctr_codigo.GetValue() 
        descr    = self.ctr_descr.GetValue()
        marca    = self.ctr_marca.GetValue()
        precio   = self.ctr_precio.GetValue()
        ppedido  = self.ctr_ppedido.GetValue()
        cantidad = self.ctr_cantidad.GetValue()

        try:
           tmp = float(precio)
        except:
           wx.MessageBox('El formato de precio debe ser: 0.00', 'No es un precio valido',
                          wx.OK | wx.ICON_ERROR)
           return

        try:
           tmp = int(ppedido)
        except:
           wx.MessageBox('Punto de pedido debe ser un numero', 'No es un numero',
                          wx.OK | wx.ICON_ERROR)
           return

        try:
           tmp = int(cantidad)
        except:
           wx.MessageBox('Cantidad debe ser un numero', 'No es un numero',
                          wx.OK | wx.ICON_ERROR)
           return

        if codigo   == '' or \
           descr    == '' or \
           marca    == '' or \
           precio   == '' or \
           cantidad == '' or \
           ppedido  == '':
           wx.MessageBox('Hay campos en blanco', 'Error en la carga de datos',
                          wx.OK | wx.ICON_ERROR)

           return
        else:
           cod, msg = self.DBM.addProduct(codigo, descr, marca, precio, ppedido, cantidad)

           if not cod:
              wx.MessageBox(msg, 'Error en la carga de datos',
                             wx.OK | wx.ICON_ERROR)

        self.Destroy()
        Publisher().sendMessage(("producto_agregado"), "refresh")


class StockAdmin( wx.Dialog ):
    def __init__(self, parent, id, title):
        wx.Dialog.__init__(self, parent, id, title)

        self.SetSize((800,600))
        self.SetMinSize((800,600))

        self.list_ctrl = wx.ListCtrl(self, style=wx.LC_REPORT)
        image1         = wx.Image('search10.png', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
        self.btn_cal   = wx.BitmapButton(self, id=-1, bitmap=image1, size=(24,24))
        image2         = wx.Image('add.png', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
        self.btn_add   = wx.BitmapButton(self, id=-1, bitmap=image2, size=(24,24))
        image3         = wx.Image('print.png', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
        self.btn_prt   = wx.BitmapButton(self, id=-1, bitmap=image3, size=(24,24))
        image4         = wx.Image('edit.png', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
        self.btn_mod   = wx.BitmapButton(self, id=-1, bitmap=image4, size=(24,24))
        image5         = wx.Image('delete.png', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
        self.btn_del   = wx.BitmapButton(self, id=-1, bitmap=image5, size=(24,24))
        self.DBM       = DBManager()

        self.__generateContent()

    def __generateContent( self, myfilter=None ):
        rows = list()

        try:
           for row in self.DBM.getProductos(myfilter):
              rows.append( (row[1], row[3], row[2], str(row[4]), str(row[6]), str(row[5])) )
        except TypeError:
              rows.append( ('Vacio', '', '', '', '', '') )

        self.list_ctrl.InsertColumn(0, "Codigo")
        self.list_ctrl.InsertColumn(1, "Marca")
        self.list_ctrl.InsertColumn(2, "Descripcion")
        self.list_ctrl.InsertColumn(3, "Precio")
        self.list_ctrl.InsertColumn(4, "Stock")
        self.list_ctrl.InsertColumn(5, "P-Pedido")

        index = 0
        for row in rows:
            if row[0] != '1000':
               self.list_ctrl.InsertStringItem(index, row[0])
               self.list_ctrl.SetStringItem(index, 1, row[1])
               self.list_ctrl.SetStringItem(index, 2, row[2])
               self.list_ctrl.SetStringItem(index, 3, row[3])
               self.list_ctrl.SetStringItem(index, 4, row[4])
               self.list_ctrl.SetStringItem(index, 5, row[5])
             
               if int( row[4] ) <= int( row[5] ):
                   self.list_ctrl.SetItemBackgroundColour(index, "red")
               else:
                   if index % 2:
                       self.list_ctrl.SetItemBackgroundColour(index, "white")
                   else:
                       self.list_ctrl.SetItemBackgroundColour(index, "gray")

               index += 1

        self.Bind(wx.EVT_BUTTON, self.onSearch, self.btn_cal)
        self.Bind(wx.EVT_BUTTON, self.onAdd, self.btn_add)
        self.Bind(wx.EVT_BUTTON, self.onPrint, self.btn_prt)
        self.Bind(wx.EVT_BUTTON, self.onDel, self.btn_del)

        sizer  = wx.BoxSizer(wx.VERTICAL)
        sizer2 = wx.BoxSizer(wx.HORIZONTAL)

        sizer2.Add(self.btn_cal, 0, wx.ALL, 1)
        sizer2.Add(self.btn_add, 0, wx.ALL, 1)
        sizer2.Add(self.btn_del, 0, wx.ALL, 1)
        sizer2.Add(self.btn_mod, 0, wx.ALL, 1)
        sizer2.Add(self.btn_prt, 0, wx.ALL, 1)
        sizer.Add(sizer2, 0, wx.ALL, 1)
        sizer.Add(self.list_ctrl, 1, wx.EXPAND)
        self.SetSizer(sizer)
        self.Show(True)

        Publisher().subscribe(self.onSearch, ("producto_buscado"))
        Publisher().subscribe(self.refreshAfterAdd, ("producto_agregado"))

    def onSearch( self, evt ):
        self.list_ctrl.ClearAll()
        search_stock = SearchStock(self, -1, "Buscar")
        self.__generateContent(evt.data)

    def onAdd( self, evt ):
        add_stock = AddStock(self, -1, "Agregar producto")

    def onDel( self, evt ):
        item = self.list_ctrl.GetItem( self.list_ctrl.GetFirstSelected() )
        product = item.GetText()
        result = self.DBM.deleteProductByCode( product )        
        self.Destroy()

    def onPrint( self, evt ):
        dlg = wx.FileDialog(
                            self, message="Choose a file",
                            defaultFile="reporte-tifosi.pdf",
                            wildcard="*.pdf",
                            style=wx.OPEN | wx.MULTIPLE | wx.CHANGE_DIR
        )
        if dlg.ShowModal() == wx.ID_OK:
           paths = dlg.GetPaths()
           path = None
           for path in paths:
              path = path
        dlg.Destroy()

        RPTR = Reporter( path, self.DBM.getProductos(), "stock" )
        RPTR.doReport()


    def refreshAfterAdd( self, evt ):
        self.list_ctrl.ClearAll()
        self.__generateContent()
