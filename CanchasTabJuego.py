import wx
import wx.calendar
import sqlite3
#import time
import datetime

from DBManager           import DBManager
from CanchasCuentaCancha import CuentaCancha
from wx.lib.pubsub       import Publisher
from CanchasMenuVenta import VentaAdmin


class DateSelected( object ):

   def __init__(self):
      self.date_selected = None

   def SetDate( self, date ):
      self.date_selected = date

   def GetDate( self ):
      return self.date_selected

date_selected = DateSelected()

class ReservaForm( wx.Dialog ):
	
    def __init__( self, parent, id, title, data ):
        wx.Dialog.__init__( self, parent, id, title )
        self.SetSize( wx.Size(200,200) )

        self.DBM    = DBManager()
        self.data   = data
        font_labels = wx.Font(13, wx.NORMAL, wx.NORMAL, wx.BOLD)

        vbox  = wx.BoxSizer( wx.VERTICAL )
        label = wx.StaticText( self, label="Reserva")
        font  = wx.Font(16, wx.NORMAL, wx.NORMAL, wx.BOLD)
        label.SetFont( font )
        vbox.Add(label, 0, wx.EXPAND, 20)

        line = wx.StaticLine(self, -1, wx.Point(10, 30), wx.Size(380, -1))
        vbox.Add(line)

        hbox1  = wx.BoxSizer( wx.HORIZONTAL )
        label1 = wx.StaticText( self, label="Cancha:")
        label2 = wx.StaticText( self, label= str( data[0] ) )
        hbox1.Add(label1)
        hbox1.Add(label2)
        vbox.Add(hbox1, flag=wx.EXPAND)

        hbox2  = wx.BoxSizer( wx.HORIZONTAL )
        label3 = wx.StaticText( self, label="Horario:")
        label4 = wx.StaticText( self, label="%s:00 hs" % str( data[1] ) )
        hbox2.Add(label3)
        hbox2.Add(label4)
        vbox.Add(hbox2, flag=wx.EXPAND)

        self.precio = self.DBM.getCanchaPrecio( data[0] )
        hbox3       = wx.BoxSizer( wx.HORIZONTAL )
        label5      = wx.StaticText( self, label="Precio:")
        self.preci  = wx.TextCtrl( self, -1, "$%.2f" % self.precio)
        hbox3.Add(label5)
        hbox3.Add(self.preci)
        vbox.Add(hbox3, flag=wx.EXPAND)

        hbox4      = wx.BoxSizer( wx.HORIZONTAL )
        label6     = wx.StaticText( self, label="Cliente:")
        self.text2 = wx.TextCtrl(self, -1, "")
        hbox4.Add(label6)
        hbox4.Add(self.text2)
        vbox.Add(hbox4, flag=wx.EXPAND)

        hbox5   = wx.BoxSizer( wx.HORIZONTAL )
        button1 = wx.Button( self, label="Reservar")
        button2 = wx.Button( self, label="Cancelar")
        hbox5.Add(button1)
        hbox5.Add(button2)
        vbox.Add(hbox5, flag=wx.CENTER)

        label1.SetFont( font_labels )
        label2.SetFont( font_labels )
        label3.SetFont( font_labels )
        label4.SetFont( font_labels )
        label5.SetFont( font_labels )
        label6.SetFont( font_labels )
        self.preci.SetFont( font_labels )

        button1.Bind(wx.EVT_BUTTON, self.processReserva)
        button2.Bind(wx.EVT_BUTTON, self.__destroy)

        self.SetSizer( vbox )
        self.Show( True )
        self.Centre()

    def processReserva( self, evt ):
        error  = (False, '')
        precio = 0

        if self.text2.GetValue() == "":
           error = (True, 'El cliente no puede ser vacio')
        
        self.precio = self.preci.GetValue()
        self.precio = float(self.precio.split('$')[1])
        result = {'old_data' : self.data, 
                  'precio'   : self.precio, 
                  'cliente'  : self.text2.GetValue(), 
                  'msg'      : error}
        self.Destroy()
        Publisher().sendMessage(("reserva_form"), result)

    def __destroy( self, evt ):
        self.Destroy()

class InfoDialog( wx.Dialog ):

    def __init__( self, parent, id, title, data ):
        wx.Dialog.__init__( self, parent, id, title )
        self.SetSize( wx.Size(640,480) )
        font_general = wx.Font(13, wx.NORMAL, wx.NORMAL, wx.NORMAL)

        vbox = wx.BoxSizer(wx.VERTICAL)

        Info_Cancha = wx.StaticText(self, label="Info Cancha")
        font        = wx.Font(16, wx.NORMAL, wx.NORMAL, wx.BOLD)
        Info_Cancha.SetFont(font)
        vbox.Add(Info_Cancha)

        hbox1    = wx.BoxSizer(wx.HORIZONTAL)
        t_status = wx.StaticText(self, label="Estado:")
        c_status = wx.StaticText(self, label=data['status'])
        t_status.SetFont(font_general)
        c_status.SetFont(font_general)
        hbox1.Add(t_status, wx.EXPAND)
        hbox1.Add(c_status, wx.EXPAND)
        vbox.Add(hbox1)

        hbox2  = wx.BoxSizer(wx.HORIZONTAL)
        t_name = wx.StaticText(self, label="Cancha:")
        c_name = wx.StaticText(self, label=data['cancha'])
        t_name.SetFont(font_general)
        c_name.SetFont(font_general)
        hbox2.Add(t_name, wx.EXPAND)
        hbox2.Add(c_name, flag=wx.ALL | wx.RIGHT | wx.EXPAND)
        vbox.Add(hbox2)

        hbox3  = wx.BoxSizer(wx.HORIZONTAL)
        t_hora = wx.StaticText(self, label="Horario:")
        c_hora = wx.StaticText(self, label=data['horario'])
        t_hora.SetFont(font_general)
        c_hora.SetFont(font_general)
        hbox3.Add(t_hora, wx.EXPAND)
        hbox3.Add(c_hora, wx.EXPAND)
        vbox.Add(hbox3)

        hbox4     = wx.BoxSizer(wx.HORIZONTAL)
        t_cliente = wx.StaticText(self, label="Cliente:")
        c_cliente = wx.StaticText(self, label=data['cliente'])
        t_cliente.SetFont(font_general)
        c_cliente.SetFont(font_general)
        hbox4.Add(t_cliente, wx.EXPAND)
        hbox4.Add(c_cliente, wx.EXPAND)
        vbox.Add(hbox4)

        hbox5    = wx.BoxSizer(wx.HORIZONTAL)
        t_precio = wx.StaticText(self, label="Precio:")
        c_precio = wx.StaticText(self, label="$%.2f" % data['precio'])
        #c_precio = wx.TextCtrl(self, -1, "$%.2d" % data['precio'])
        t_precio.SetFont(font_general)
        c_precio.SetFont(font_general)
        hbox5.Add(t_precio, flag=wx.EXPAND)
        hbox5.Add(c_precio, wx.EXPAND)
        vbox.Add(hbox5)

        hbox6 = wx.BoxSizer(wx.HORIZONTAL)
        t_gasto = wx.StaticText(self, label="Gastos Realizados:")
        c_gasto = wx.StaticText(self, label="$%.2f" % data['gastos'])
        t_gasto.SetFont(font_general)
        c_gasto.SetFont(font_general)
        hbox6.Add(t_gasto, flag=wx.EXPAND)
        hbox6.Add(c_gasto, wx.EXPAND)
        vbox.Add(hbox6)

        self.list_ctrl = wx.ListCtrl(self, style=wx.LC_REPORT, size=((630,300)))
        index = 0

        self.list_ctrl.InsertColumn(0, "Codigo")
        self.list_ctrl.InsertColumn(1, "Producto")
        self.list_ctrl.InsertColumn(2, "Marca")
        self.list_ctrl.InsertColumn(3, "Cantidad")
        self.list_ctrl.InsertColumn(4, "Precio")
        self.list_ctrl.InsertColumn(5, "Total")

        try:
            for producto in data['productos']:
                self.list_ctrl.InsertStringItem(index, producto[3])
                self.list_ctrl.SetStringItem(index, 1, producto[5])
                self.list_ctrl.SetStringItem(index, 2, producto[4])
                self.list_ctrl.SetStringItem(index, 3, str(producto[2]))
                self.list_ctrl.SetStringItem(index, 4, "$%.2f" % producto[1])
                self.list_ctrl.SetStringItem(index, 5, "$%.2f" % producto[1]*producto[2])
        except KeyError:
            pass

        vbox.Add(self.list_ctrl)

        self.SetSizer(vbox)
        self.Layout()
        self.Show(True)
    
class MyCalendar(wx.Dialog):
	
    def __init__(self, parent, id, title):
        wx.Dialog.__init__(self, parent, id, title)

        vbox = wx.BoxSizer(wx.VERTICAL)

        self.calend = wx.calendar.CalendarCtrl(self, -1, wx.DateTime_Now(),
        style = wx.calendar.CAL_SHOW_HOLIDAYS|wx.calendar.CAL_SEQUENTIAL_MONTH_SELECTION)
        self.calend.SetLowerDateLimit( wx.DateTime_Now())
        vbox.Add(self.calend, 0, wx.EXPAND | wx.ALL, 20)

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
        date = self.calend.GetDate()
        Publisher().sendMessage(("date_selected"), date)
        return date

    def cnlClicked(self, event):
        self.Destroy()

class MinutosDespues(wx.Dialog):
    def __init__(self, parent, id, title, data):
        wx.Dialog.__init__(self, parent, id, title, size=(200,90))
        self.DBM = DBManager()
        self.data = data

        vbox  = wx.BoxSizer(wx.VERTICAL)

        hbox1 = wx.BoxSizer(wx.HORIZONTAL)
        font  = wx.Font(16, wx.NORMAL, wx.NORMAL, wx.BOLD)
        title = wx.StaticText(self, -1, "Minutos al Activar")
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

        self.Bind(wx.EVT_BUTTON, self.__ProccedActivate, btn_ini)

        #self.SetSizerAndFit(vbox)
        self.SetSizer(vbox)
        self.Show(True)

    def __ProccedActivate(self, evt):
        self.Close()
        self.Destroy()

        data = {'data':self.data, 'value':self.money.GetValue()}

        Publisher().sendMessage(("procced"), data)


class CanchasTabJuego(wx.Panel):

   def addPanel(self, label, panel, header=False, data=None,
                cliente=None, precio=None, disabled=None):
     
      panel_tmp = wx.Panel(parent = self, 
		           id     = wx.ID_ANY, 
			   style  = wx.SIMPLE_BORDER)

      if label != "RESERVADA" and label != 'LIBRE' and label != 'CERRADA':
          text = wx.StaticText(panel_tmp, label=label)
      else:
          text = wx.StaticText(panel_tmp, label="")

      tmp_vbox         = wx.BoxSizer(wx.HORIZONTAL)
      tmp_global_sizer = wx.GridSizer(0, 3, 0, 0)
      font             = wx.Font(16, wx.NORMAL, wx.NORMAL, wx.BOLD)

      if header:
          text.SetForegroundColour((255,255,255))
	  panel_tmp.SetBackgroundColour("Black")
          text.SetFont(font)
      else:
          if label != "RESERVADA" and label != "ACTIVA" and label != 'CERRADA':
              image2       = wx.Image('images/favicon.ico', 
                                     wx.BITMAP_TYPE_ANY).ConvertToBitmap()
              self.btn_res = wx.BitmapButton(panel_tmp, 
                                            id=-1, 
                                            bitmap=image2, 
                                            size=(24,24))
          else:
              if label != 'CERRADA' and label != "ACTIVA":
                  image5       = wx.Image('images/delete.png', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
                  self.btn_del = wx.BitmapButton(panel_tmp, id=-1, bitmap=image5, size=(24,24))

          if label == "RESERVADA" or label == 'CERRADA' or label == 'ACTIVA':
              image_info   = wx.Image('images/info.png', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
              self.btn_inf = wx.BitmapButton(panel_tmp, id=-1, bitmap=image_info, size=(24,24))

          if label != 'ACTIVA' and label == 'RESERVADA':
              image6       = wx.Image('images/green-ok.gif', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
              self.btn_act = wx.BitmapButton(panel_tmp, id=-1, bitmap=image6, size=(24,24))
          elif label == 'ACTIVA':
              image9       = wx.Image('images/red.gif', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
              self.btn_dct = wx.BitmapButton(panel_tmp, id=-1, bitmap=image9, size=(24,24))
              image3       = wx.Image('images/venta.png', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
              self.btn_vnt = wx.BitmapButton(panel_tmp, id=-1, bitmap=image3, size=(24,24))
          
          panel_tmp.SetBackgroundColour("White")

          if label != "RESERVADA" and label != 'ACTIVA' and label != 'CERRADA':
              tmp_vbox.Add(self.btn_res)

          if label == 'RESERVADA':
              tmp_vbox.Add(self.btn_del)

          if label == 'CERRADA' or label == "RESERVADA" or label == "ACTIVA":
              tmp_vbox.Add(self.btn_inf)

          if label != 'ACTIVA' and label == 'RESERVADA':
              tmp_vbox.Add(self.btn_act)
          elif label == 'ACTIVA':
              tmp_vbox.Add(self.btn_dct)
              tmp_vbox.Add(self.btn_vnt)

              m_total      = self.__MontoTotal( data )
              monto_total  = wx.StaticText(panel_tmp, id=-1, label="$%s" % m_total)
              monto_font   = wx.Font(14, wx.NORMAL, wx.NORMAL, wx.BOLD)
              monto_total.SetFont( monto_font )

              desfa        = wx.StaticText(panel_tmp, id=-1, label=" | %s min" % data[2])
              desfa.SetFont( monto_font )
              tmp_vbox.Add(monto_total, flag=wx.RIGHT)
              tmp_vbox.Add(desfa, flag=wx.RIGHT)

              self.Bind(wx.EVT_BUTTON, lambda evt, data=data: self.__OnAddVenta(evt, data), self.btn_vnt)
              self.Bind(wx.EVT_BUTTON, lambda evt, data=data: self.__OnCloseCancha(evt, data), self.btn_dct)

          elif label == 'CERRADA':
              m_total      = self.__MontoTotal( data )
              monto_total  = wx.StaticText(panel_tmp, id=-1, label="$%s" % m_total)
              monto_font   = wx.Font(14, wx.NORMAL, wx.NORMAL, wx.BOLD)
              monto_total.SetFont( monto_font )
              monto_total.SetForegroundColour((255,255,0))
              tmp_vbox.Add(monto_total, flag=wx.RIGHT)

          if label != "RESERVADA":
              text = wx.StaticText(panel_tmp, label="")

          tmp_vbox.Add(text)

          if label != "ACTIVA" and label == 'RESERVADA':
            if data is not None:
                  self.Bind(wx.EVT_BUTTON, lambda evt, data=data: self.__OnActivate(evt, data), self.btn_act)

          if label != "RESERVADA" and label != "ACTIVA" and label != "CERRADA":
              if data is not None:
                  self.Bind(wx.EVT_BUTTON, lambda evt, data=data: self.__OnBallClick(evt, data), self.btn_res)

          if label == "RESERVADA":
              if date_selected.GetDate() is not None:
                 cliente = self.DBM.getClienteReservado(date_selected.GetDate(), data[0], data[1])[0]
              else:
                 cliente = self.DBM.getClienteReservado(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1])[0]

              cliente_label = wx.StaticText(panel_tmp, id=-1, label="%s" % cliente)
              monto_font    = wx.Font(14, wx.NORMAL, wx.NORMAL, wx.BOLD)
              cliente_label.SetFont(monto_font)
              tmp_vbox.Add(cliente_label)

              if data is not None:
                  self.Bind(wx.EVT_BUTTON, lambda evt, data=data: self.__OnCancelClick(evt, data), self.btn_del)

          if label == "RESERVADA" or label == 'CERRADA' or label == "ACTIVA":
              if data is not None:
                  self.Bind(wx.EVT_BUTTON, lambda evt, data=data: self.__OnInfoClick(evt, data), self.btn_inf)

              
      if label == "RESERVADA":
          panel_tmp.SetBackgroundColour("Yellow")
      elif label == "ACTIVA":
          panel_tmp.SetBackgroundColour("Green")

      if label == "CERRADA":
          panel_tmp.SetBackgroundColour("Red")

      tmp_vbox.Add(tmp_global_sizer, flag=wx.EXPAND)
      panel_tmp.SetSizer(tmp_vbox)
      panel.Add(panel_tmp, flag=wx.EXPAND, proportion=1)

   def __MontoTotal(self, data):
      id_reserva = None

      if date_selected.GetDate() is not None:
         id_reserva = self.DBM.getIDReservado( data_selected.GetDate(), data[0], data[1] )
      else:
         id_reserva = self.DBM.getIDReservado( datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1] )

      id_cuenta = self.DBM.getCuentaHorarioID( id_reserva )
      productos = self.DBM.getProductosByCuenta( id_cuenta )

      total = 0
      for prod in productos:
         total += prod[1] * prod[2]

      return total

   def __OnActivate(self, evt, data):
      minutos = MinutosDespues(self, -1, "Minutos", data)

   def __PostOnActivate(self, evt):
      data = evt.data['data']
      stamp = evt.data['value']

      if date_selected.GetDate() is not None:
         cliente = self.DBM.getClienteReservado(date_selected.GetDate(), data[0], data[1])
         precio  = self.DBM.getPrecioReservado(date_selected.GetDate(), data[0], data[1])
         result  = self.DBM.activateCancha(date_selected.GetDate(), data[0], data[1], cliente, precio, stamp)
      else:
         cliente = self.DBM.getClienteReservado(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1])
         precio  = self.DBM.getPrecioReservado(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1])
         result  = self.DBM.activateCancha(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1], cliente, precio, stamp)

      self.OnCalSelected( date_selected )

   def __OnCloseCancha( self, evt, data ):
      if date_selected.GetDate() is not None:
         cliente = self.DBM.getClienteReservado(data_selected.GetDate(), data[0], data[1])
         precio  = self.DBM.getPrecioReservado(data_selected.GetDate(), data[0], data[1])
         result  = self.DBM.closeCancha(date_selected.GetDate(), data[0], data[1], cliente, precio)
      else:
         cliente = self.DBM.getClienteReservado(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1])
         precio  = self.DBM.getPrecioReservado(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1])
         result  = self.DBM.closeCancha(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1], cliente, precio)

      self.OnCalSelected( date_selected )

   def __OnAddVenta(self, evt, data):
      status = None

      if date_selected.GetDate() is not None:
         status = self.DBM.getCanchaStatus(date_selected.GetDate(), data[0], data[1])
      else:
         status = self.DBM.getCanchaStatus(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1])

      if status is not None:
         if status[0] != "2":
            wx.MessageBox("La cancha debe estar activa para poder asignarle una compra", "Activar Primero",
                          wx.OK | wx.ICON_INFORMATION)
         else:
            result = dict()
            if date_selected.GetDate() is not None:
               result['cliente'] = self.DBM.getClienteReservado(date_selected.GetDate(), data[0], data[1])[0]
               result['precio']  = self.DBM.getPrecioReservado(date_selected.GetDate(), data[0], data[1])[0]
               result['cancha']  = [name for name in self.DBM.getCanchasNames() if name[0] == data[0]][0][1]
               result['horario'] = "%s:00 hs" % data[1]
               result['status']  = self.DBM.getCanchaStatus(date_selected.GetDate(), data[0], data[1])[0]
               result['fecha']   = date_selected.GetDate()
               result['id_cancha'] = data[0]
            else:
               result['cliente'] = self.DBM.getClienteReservado(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1])[0]
               result['precio']  = self.DBM.getPrecioReservado(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1])[0]
               result['cancha']  = [name for name in self.DBM.getCanchasNames() if name[0] == data[0]][0][1]
               result['horario'] = "%s:00 hs" % data[1]
               result['status']  = self.DBM.getCanchaStatus(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1])[0]
               result['fecha']   = datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__()
               result['id_cancha'] = data[0]

            CuentaCancha(self, id=wx.ID_ANY, title="Cuenta de cancha", data=result)
      else:
         wx.MessageBox("La cancha debe estar activa para poder asignarle una compra", "Activar Primero",
                       wx.OK | wx.ICON_INFORMATION)

   def __OnCancelClick( self, evt, data ):
      if date_selected.GetDate() is not None:
          result = self.DBM.cancelReserva(date_selected.GetDate(),data[0], data[1]) 
      else:
          result = self.DBM.cancelReserva(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(),data[0], data[1]) 

      if result:
         wx.MessageBox('Cancelacion exitosa', 'Cancelacion Exitosa',
                       wx.OK | wx.ICON_INFORMATION)

      self.OnCalSelected( date_selected )

   def __OnBallClick( self, evt, data ):
      result = None
      ReservaForm( self, id=wx.ID_ANY, title="Formulario de Reserva", data=data )

   def __OnInfoClick( self, evt, data ):
      result = dict()
      if date_selected.GetDate() is not None:
         result['cliente'] = self.DBM.getClienteReservado(date_selected.GetDate(), data[0], data[1])[0]
         result['precio']  = self.DBM.getPrecioReservado(date_selected.GetDate(), data[0], data[1])[0]
         result['cancha']  = [name for name in self.DBM.getCanchasNames() if name[0] == data[0]][0][1]
         result['horario'] = "%s:00 hs" % data[1]
         result['status']  = self.DBM.getCanchaStatus(date_selected.GetDate(), data[0], data[1])[0]
         id_reserva        = self.DBM.getIDReservado( date_selected.GetDate(), data[0], data[1] )
         id_cuenta_horario = self.DBM.getCuentaHorarioID( id_reserva )
      else:
         result['cliente'] = self.DBM.getClienteReservado(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1])[0]
         result['precio']  = self.DBM.getPrecioReservado(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1])[0]
         result['cancha']  = [name for name in self.DBM.getCanchasNames() if name[0] == data[0]][0][1]
         result['horario'] = "%s:00 hs" % data[1]
         status            = self.DBM.getCanchaStatus(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1])[0]

         try:
            id_reserva        = self.DBM.getIDReservado(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1])[0]
            id_cuenta_horario = self.DBM.getCuentaHorarioID( id_reserva )
            productos         = self.DBM.getProductosByCuenta( id_cuenta_horario )
            total             = 0

            result['productos'] = productos

            for y in [i[1] * i[2] for i in productos]:
               total += y

            result['gastos']  = total
         except:
            result['gastos']  = 0

         if status == '1':
            result['status'] = 'Reservada'
         elif status == '2':
            result['status']  = 'Activa'
            id_reserva        = self.DBM.getIDReservado(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(), data[0], data[1])[0]
            id_cuenta_horario = self.DBM.getCuentaHorarioID( id_reserva )
            productos         = self.DBM.getProductosByCuenta( id_cuenta_horario )

            result['productos'] = productos
            
         elif status == '3':
            result['status'] = 'Cerrada'

      InfoDialog( self, id=wx.ID_ANY, title="Informacion de Horario", data=result )

   def __postReserva( self, evt ):
      data    = evt.data['old_data']
      precio  = evt.data['precio']
      cliente = evt.data['cliente']
      msg     = evt.data['msg']
      result  = None

      if not msg[0]:

          if date_selected.GetDate() is not None:
              result = self.DBM.doReserva(date_selected.GetDate(),data[0], data[1], precio, cliente)
          else: 
              result = self.DBM.doReserva(datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S").__str__(),data[0], data[1], precio, cliente)

          if result:
             wx.MessageBox('La reserva fue exitosa', 'Reversa Exitosa',
                           wx.OK | wx.ICON_INFORMATION)
          else:
             wx.MessageBox('Este horario estaba reservado', 'Reseva Cancelada',
                           wx.OK | wx.ICON_HAND)
      else:
         wx.MessageBox(msg[1], 'Error',
                       wx.OK | wx.ICON_ERROR)

      self.OnCalSelected( date_selected )

   def buildCells(self, this_time=None):
      cells     = list()
      c_canchas = self.DBM.countCanchas()
      n_canchas = self.DBM.getCanchasNames()
      horarios  = ['14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24']

      if this_time == 'None':
         this_time = datetime.datetime.now().strftime("%m/%d/%y %H:%M:%S")

      cells.append({'label'   : 'HORARIOS', 
                    'header'  : True, 
                    'data'    : None, 
                    'cliente' : '', 
                    'precio'  : ''})

      for nombre in n_canchas:
         cells.append( {'label'   : nombre[1], 
                        'header'  : True,
                        'data'    : None, 
                        'cliente' : '',
                        'precio'  : ''} )

      for hora in horarios:
         cells.append( {'label'   : "%s:00 hs" % hora, 
                        'header'  : True, 
                        'data'    : None,
                        'cliente' : '',
                        'precio'  : ''} )

         for cancha in n_canchas:
            status  = self.DBM.getCanchaStatus(this_time, cancha[0], hora)
            paso    = True
            cliente = ''
            precio  = ''

            if status is not None and status[0] == '1':
               cliente = self.DBM.getClienteReservado(this_time, cancha[0], hora)
               precio  = self.DBM.getPrecioReservado(this_time, cancha[0], hora)

            if status is not None and status[0] == '0':
               paso = False

            if status is not None and paso :
               status = str( status[0] )

               if status == '0':
                  cells.append( {'label'   : 'LIBRE', 
                                 'header'  : False,
                                 'data'    : ( cancha[0],
                                               hora),
                                 'cliente' : cliente,
                                 'precio'  : precio } )
               if status == '1':
                  cells.append( {'label'   : 'RESERVADA', 
                                 'header'  : False,
                                 'data'    : ( cancha[0],
                                               hora),
                                 'cliente' : cliente, 
                                 'precio'  : precio } )
               if status == '2':
                  desfasa = self.DBM.getMinutosActivacion(this_time, 
                                                          cancha[0],
                                                          hora)
                  cells.append( {'label'   : 'ACTIVA', 
                                 'header'  : False,
                                 'data'    : ( cancha[0],
                                               hora,
                                               desfasa[0] ), 
                                 'cliente' : cliente, 
                                 'precio'  : precio } )
               if status == '3':
                  cells.append( {'label'   : 'CERRADA',
                                 'header'  : False, 
                                 'data'    : ( cancha[0],
                                               hora ),
                                 'cliente' : cliente, 
                                 'precio'  : precio } )
            else:
               cells.append( {'label':'LIBRE', 'header': False, 'data': (cancha[0], hora), 'cliente':'', 'precio':'' } )
               
      return cells

   def constructCells(self, global_sizer, this_time=None):
      this_time = this_time.__str__()
      #print "This_time: %s" % type( this_time )

      for cell in self.buildCells(this_time):
         self.addPanel(label=cell['label'], header=cell['header'], panel=global_sizer, data=cell['data'], cliente=cell['cliente'], precio=cell['precio'], disabled=False)

   def __refresh( self, evt ):
      self.global_sizer.Clear(deleteWindows=True)
      self.global_sizer.Layout()
      self.constructCells( self.global_sizer )
      self.global_sizer.Layout()

   def OnCalSelected( self, evt ):
      self.global_sizer.Clear(deleteWindows=True)
      self.global_sizer.Layout()
      self.constructCells(self.global_sizer, evt.GetDate())
      self.global_sizer.Layout()

   def OnExternalCalSelected( self, evt ):
      self.global_sizer.Clear(deleteWindows=True)
      self.global_sizer.Layout()
      self.constructCells(self.global_sizer, evt.data)
      self.global_sizer.Layout()
      #self.fecha_banner.SetLabel( evt.data.__str__() )

      date_selected.SetDate( evt.data )

   def ShowCalendar( self, evt ):
      MyCalendar(self, id=wx.ID_ANY, title="Calendar")

   def OnVenta( self, evt ):
      venta = VentaAdmin(self, -1, 'Realizar una venta')

   def __init__(self, parent):

      wx.Panel.__init__(self, parent=parent, id=wx.ID_ANY)

      self.DBM          = DBManager()
      canchas           = self.DBM.countCanchas() + 1
      self.vbox         = wx.BoxSizer(wx.VERTICAL)
      self.global_sizer = wx.GridSizer(canchas, canchas, 0, 0)
      image1            = wx.Image('calendar.png', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
      self.btn_cal      = wx.BitmapButton(self, id=-1, bitmap=image1, size=(30,30))
      image2            = wx.Image('venta.png', wx.BITMAP_TYPE_ANY).ConvertToBitmap()
      self.btn_vnt      = wx.BitmapButton(self, id=-1, bitmap=image2, size=(30,30))
      cur_date          = None

      if date_selected.GetDate() is not None:
         cur_date = date_selected.GetDate()
      else:
         cur_date = datetime.datetime.now().strftime("%m/%d/%y").__str__()

      titulo = wx.StaticText(self, -1, "Fecha: %s" % cur_date)
      line   = wx.StaticText(self, -1, "")
      font   = wx.Font(16, wx.MODERN, wx.NORMAL, wx.BOLD)

      titulo.SetFont(font)
      self.Bind(wx.EVT_BUTTON, self.ShowCalendar, self.btn_cal)
      self.Bind(wx.EVT_BUTTON, self.OnVenta, self.btn_vnt)
      self.constructCells(self.global_sizer)
      self.tool_bar = wx.BoxSizer(wx.HORIZONTAL)
      self.tool_bar.Add(self.btn_cal)
      self.tool_bar.Add(self.btn_vnt)
      self.tool_bar.Add(titulo)
      self.vbox.Add(self.tool_bar, proportion=1)
      self.vbox.Add(line, proportion=1)
      self.vbox.Add(self.global_sizer, proportion=27, flag=wx.EXPAND)
      self.SetSizer(self.vbox)

      Publisher().subscribe(self.OnExternalCalSelected, ("date_selected"))
      Publisher().subscribe(self.__postReserva, ("reserva_form"))
      Publisher().subscribe(self.__refresh, ("cuentacancha_cerrada"))
      Publisher().subscribe(self.__PostOnActivate, ("procced"))
