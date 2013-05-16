import wx
import datetime

from DBManager              import DBManager
from wx.lib.pubsub          import Publisher
from CanchasCuentaSinCancha import SeleccionarProducto
from Reporter               import Reporter


class Gasto(wx.Dialog):

    def __init__(self, parent, id, title):
        wx.Dialog.__init__(self, parent, id, title, size=(180, 130))

        self.DBM = DBManager()
        vbox     = wx.BoxSizer(wx.VERTICAL)

        hbox  = wx.BoxSizer(wx.HORIZONTAL)
        label = wx.StaticText( self, label="Egreso de Caja")
        font  = wx.Font(14, wx.NORMAL, wx.NORMAL, wx.BOLD)
        label.SetFont( font )
        hbox.Add(label, 0, wx.EXPAND, 20)
        line  = wx.StaticLine(self, -1, wx.Point(10, 30), wx.Size(380, -1))
        vbox.Add(hbox)
        vbox.Add(line)

        hbox2      = wx.BoxSizer(wx.HORIZONTAL)
        label2     = wx.StaticText(self, label="Monto")
        self.monto = wx.TextCtrl( self, -1, "")
        hbox2.Add(label2)
        label2.SetFont(font)
        hbox2.Add(self.monto)
        vbox.Add(hbox2)

        hbox3      = wx.BoxSizer(wx.HORIZONTAL)
        label3     = wx.StaticText(self, label="Concepto")
        self.descr = wx.TextCtrl( self, -1, "")
        hbox3.Add(label3)
        hbox3.Add(self.descr)
        label3.SetFont(font)
        vbox.Add(hbox3)
        
        egresar = wx.Button(self, label="Descontar")
        vbox.Add(egresar)
        egresar.Bind(wx.EVT_BUTTON, self.generarEgreso)

        self.SetSizer(vbox)
        self.Show()

    def generarEgreso(self, evt):
        self.DBM.generateEgreso( self.descr.GetValue(), self.monto.GetValue() )

        self.Close()
        self.Destroy()


class MyCalendar(wx.Dialog):
    def __init__(self, parent, id, title):
        wx.Dialog.__init__(self, parent, id, title)

        vbox = wx.BoxSizer(wx.VERTICAL)

        txt_cal_desde = wx.StaticText(self, -1, "Fecha Desde:")
        self.calend   = wx.calendar.CalendarCtrl(self, -1, wx.DateTime_Now(),
        style         = wx.calendar.CAL_SHOW_HOLIDAYS|wx.calendar.CAL_SEQUENTIAL_MONTH_SELECTION)
        vbox.Add(txt_cal_desde, flag=wx.CENTER)
        vbox.Add(self.calend, 0, wx.EXPAND | wx.ALL, 20)

        vbox.Add((-1, 20))

        hbox2 = wx.BoxSizer(wx.HORIZONTAL)
        vbox.Add(hbox2, 0, wx.ALIGN_CENTER | wx.TOP | wx.BOTTOM, 20)

        txt_cal_hasta = wx.StaticText(self, -1, "Fecha Hasta:")
        self.calend2  = wx.calendar.CalendarCtrl(self, -1, wx.DateTime_Now(),
        style = wx.calendar.CAL_SHOW_HOLIDAYS|wx.calendar.CAL_SEQUENTIAL_MONTH_SELECTION)
        vbox.Add(txt_cal_hasta, flag=wx.CENTER)
        vbox.Add(self.calend2, 0, wx.EXPAND | wx.ALL, 20)

        vbox.Add((-1, 20))

        hbox2 = wx.BoxSizer(wx.HORIZONTAL)
        btn = wx.Button(self, -1, 'Ok')
        cancelBtn = wx.Button(self, -1, 'Cancel')
        hbox2.Add(btn, 1)
        hbox2.Add(cancelBtn, 1)
        vbox.Add(hbox2, 0, wx.ALIGN_CENTER | wx.TOP | wx.BOTTOM, 20)

        btn.Bind(wx.EVT_BUTTON, self.okClicked)
        cancelBtn.Bind(wx.EVT_BUTTON, self.cnlClicked)

        self.SetSizerAndFit(vbox)

        self.Show(True)
        self.Centre()

    def okClicked(self, event):
        date_desde = self.calend.GetDate()
        date_hasta = self.calend2.GetDate()
        Publisher().sendMessage(("dates"), (date_desde, date_hasta))

    def cnlClicked(self, event):
        self.Destroy()


class IniciarCaja(wx.Dialog):
    def __init__(self, parent, id, title):
        wx.Dialog.__init__(self, parent, id, title, size=(180,90))
        self.DBM = DBManager()

        vbox  = wx.BoxSizer(wx.VERTICAL)

        hbox1 = wx.BoxSizer(wx.HORIZONTAL)
        font  = wx.Font(16, wx.NORMAL, wx.NORMAL, wx.BOLD)
        title = wx.StaticText(self, -1, "Inicio de caja")
        title.SetFont( font )

        hbox2      = wx.BoxSizer(wx.HORIZONTAL)
        self.money = wx.TextCtrl(self, -1, "")
        image      = wx.Image('green-ok.gif', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
        btn_ini    = wx.BitmapButton(self, id=-1, bitmap=image, size=(30,30))

        vbox.Add( hbox1 )
        vbox.Add( hbox2 )
        hbox1.Add( title )
        hbox2.Add( self.money )
        hbox2.Add( btn_ini )

        self.Bind(wx.EVT_BUTTON, self.OnInit, btn_ini)

        #self.SetSizerAndFit(vbox)
        self.SetSizer(vbox)
        self.Show(True)

    def OnInit( self, evt ):
        dinero    = self.money.GetValue()
        this_time = datetime.datetime.now().strftime("%m/%d/%y")
        self.DBM.addProductTrans( this_time, dinero, 1, 1, 19, 1, 1, 0, 0)
        self.Close()


class CanchasTabFinanzas(wx.Panel):

   def __init__(self, parent):

       wx.Panel.__init__(self, parent=parent, id=wx.ID_ANY)

       self.DBM   = DBManager()
       self.vbox  = wx.BoxSizer( wx.VERTICAL )
       hbox1      = wx.BoxSizer( wx.HORIZONTAL )
       image1     = wx.Image('calendar.png', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
       btn_cal    = wx.BitmapButton(self, id=-1, bitmap=image1, size=(40,30))
       image2     = wx.Image('print.png', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
       btn_prt    = wx.BitmapButton(self, id=-1, bitmap=image2, size=(40,30))
       image3     = wx.Image('money.png', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
       btn_inicio = wx.BitmapButton(self, id=-1, bitmap=image3, size=(40,30))
       image4     = wx.Image('cashRegister.png', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
       btn_gasto  = wx.BitmapButton(self, id=-1, bitmap=image4, size=(40,30))
       #image3       = wx.Image('venta.png', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
       #btn_vta      = wx.BitmapButton(self, id=-1, bitmap=image3, size=(40,30))
       self.desde   = None
       self.hasta   = None

       self.Bind(wx.EVT_BUTTON, self.OnCalendar, btn_cal)
       #self.Bind(wx.EVT_BUTTON, self.OnVenta, btn_vta)
       self.Bind(wx.EVT_BUTTON, self.OnPrint, btn_prt)
       self.Bind(wx.EVT_BUTTON, self.OnInicio, btn_inicio)
       self.Bind(wx.EVT_BUTTON, self.OnGasto, btn_gasto)

       hbox1.Add(btn_cal)
       hbox1.Add(btn_prt)
       hbox1.Add(btn_inicio)
       hbox1.Add(btn_gasto)
       #hbox1.Add(btn_vta)
       self.vbox.Add(hbox1)

       self.hbox2 = wx.BoxSizer( wx.HORIZONTAL )

       self.list_ctrl = wx.ListCtrl(self, style=wx.LC_REPORT)

       self.hbox2.Add(self.list_ctrl, 2, flag=wx.EXPAND)
       self.vbox.Add(self.hbox2, 2, wx.EXPAND)

       self.TOTAL     = 0

       self.SetSizer(self.vbox)
       self.__generateContent()
       Publisher().subscribe(self.OnExternalCalSelected, ("dates"))
       Publisher().subscribe(self.OnTabSelected , ("tab_cuentas_update"))

   def __generateContent( self, desde=None, hasta=None): 
       cuentas = self.DBM.getCuentas(desde, hasta)
       egresos = self.DBM.getEgresos(desde, hasta)

       index = 0

       self.list_ctrl.InsertColumn(0, "Hora")
       self.list_ctrl.InsertColumn(1, "Producto")
       self.list_ctrl.InsertColumn(2, "Cantidad")
       self.list_ctrl.InsertColumn(3, "Precio")
       self.list_ctrl.InsertColumn(4, "Total")

       for cuenta in cuentas+egresos:
          self.list_ctrl.InsertStringItem(index, cuenta[0])
          self.list_ctrl.SetStringItem(index, 1, cuenta[1])
          if cuenta[1] == "Inicio de caja":
              self.list_ctrl.SetStringItem(index, 2, '-')
              self.list_ctrl.SetStringItem(index, 3, '-')
          else:
              self.list_ctrl.SetStringItem(index, 3, "$ %s" % str(cuenta[3]))
              self.list_ctrl.SetStringItem(index, 2, str(cuenta[2]))

          self.list_ctrl.SetStringItem(index, 4, "$ %s" % str(cuenta[4]))

          self.TOTAL += cuenta[4]

          if index % 2:
             self.list_ctrl.SetItemBackgroundColour(index, "white")
          else:
             self.list_ctrl.SetItemBackgroundColour(index, "gray")
          index += 1

       self.list_ctrl.InsertStringItem(index, 'TOTAL')
       self.list_ctrl.SetStringItem(index, 1, '')
       self.list_ctrl.SetStringItem(index, 2, '')
       self.list_ctrl.SetStringItem(index, 3, '')
       self.list_ctrl.SetStringItem(index, 4, '$ %s' % str(self.TOTAL))
       self.list_ctrl.SetItemBackgroundColour(index, "red")
       self.list_ctrl.SetItemTextColour(index, "yellow")

   def OnExternalCalSelected( self, evt ):
       desde      = evt.data[0].__str__().split(' ')[0]
       hasta      = evt.data[1].__str__().split(' ')[0]
       self.desde = desde
       self.hasta = hasta
       self.TOTAL = 0
       self.list_ctrl.ClearAll()
       self.__generateContent( desde, hasta )

   def OnGasto( self, evt ):
       Gasto(self, -1, "Egreso de caja")
       self.list_ctrl.ClearAll()
       self.__generateContent()

   def OnCalendar( self, evt ):
       MyCalendar(self, -1, "Seleccion rango de fecha")

   def OnVenta( self, evt ):
       SeleccionarProducto(self, -1, "Seleccionar producto")

   def OnInicio( self, evt ):
       IniciarCaja(self, -1, "Inicio de caja")

   def OnPrint( self, evt ):
      
      this_time = datetime.datetime.now().strftime("%d/%m/%y")
      nombre	 = "ventas"+this_time+".pdf "
      #import pdb;pdb.set_trace()
      if self.desde == None or self.hasta == None:
           wx.MessageBox('Primero debe seleccionar un rango para el reporte', 'Error al generar el reporte',
                          wx.OK | wx.ICON_ERROR)
      else:
           dlg = wx.FileDialog(
                                self, message="Choose a file",
                                defaultFile=nombre,
                                wildcard="*.pdf",
                                style=wx.OPEN | wx.MULTIPLE | wx.CHANGE_DIR
           )
           if dlg.ShowModal() == wx.ID_OK:
               paths = dlg.GetPaths()
               path = None
               for path in paths:
                   path = path
           dlg.Destroy()


           RPTR = Reporter( path, (self.desde, self.hasta), "ganancia" )
           RPTR.doReport()


   def OnTabSelected( self, evt):
       self.list_ctrl.ClearAll()
       self.__generateContent()
