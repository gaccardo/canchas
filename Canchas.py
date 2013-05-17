#-*- encoding: utf-8 -*-

import sys
sys.path.append('includes/')

import wx
import time

#from wx.lib.pubsub    import setuparg1  
from wx.lib.pubsub    import setupv1  
from wx.lib.pubsub    import Publisher

from CanchasMainPanel import CanchasMainPanel
from CanchasLogin     import CanchasLogin
from CanchasMenuStock import StockAdmin
from CanchasEntrada   import CanchasEntrada
from DBManager        import DBManager
from User             import User
from Licencer         import LicenseChecker

FRAME_LOGIN = None
FRAME       = None

class TabSelected( object ):

   def __init__( self ):
      self.cur_tab = None

   def setTab( self, tab ):
      self.cur_tab = tab

   def getTab( self ):
      return self.cur_tab


class CustomTaskBarIcon( wx.TaskBarIcon ):

   def __init__(self): 
        super( CustomTaskBarIcon, self).__init__()
        icon   = wx.Icon("images/favicon.ico", wx.BITMAP_TYPE_ICO)
        tbicon = wx.TaskBarIcon()
        tbicon.SetIcon(icon, "Canchas - Tifosi")

        self.Bind(wx.EVT_MENU, self.OnMenu)
        self.Bind(wx.EVT_MENU, self.OnAbout, id=wx.ID_ABOUT)
        self.Bind(wx.EVT_MENU, self.OnClose, id=wx.ID_CLOSE)
        self.Bind(wx.EVT_TASKBAR_LEFT_DOWN,  self.OnClick)


class CanchasFrame( wx.Frame ):

    def update(self, event):
       now = int(time.time())
       mod = now % 2
       if mod:
           self.StatusText.SetStatusText('Hay %s producto/s debajo del punto de pedido' % self.DBM.productosPedido(), 2)
       else:
           self.StatusText.SetStatusText('Mensaje de sistema', 2)
 
    def __init__(self, user_data):
        wx.Frame.__init__(self, None, wx.ID_ANY, 
                          "Canchas",
                          size=(800,600),
                          #style=wx.SYSTEM_MENU|wx.CAPTION|wx.CLOSE_BOX|wx.MINIMIZE_BOX|wx.SYSTEM_MENU
                          )

        self.config     = wx.Config('canchas-config')
        self.config.Write('sucursal', '1')
        panel           = CanchasMainPanel(self)
        self.StatusText = self.CreateStatusBar(3)
        username        = self.config.Read('logged_user')
        self.DBM        = DBManager()
        self.StatusText.SetStatusText('Tifosi - Gestion de Canchas')
        self.StatusText.SetStatusText('Usuario: %s' % username, 1)

        self.StatusText.SetBackgroundColour("red")

        if self.DBM.productosPedido() > 0:
           self.StatusText.SetStatusText('Hay %s producto/s debajo del punto de pedido' % self.DBM.productosPedido(), 2)
           self.timer = wx.Timer(self)
           self.Bind(wx.EVT_TIMER, self.update, self.timer)
           self.timer.Start(1000)
        else: 
           self.StatusText.SetStatusText('Sin Novedad', 2)

        menubar       = wx.MenuBar()
        archivo       = wx.Menu()
        stock         = wx.Menu()
        #configuracion = wx.Menu()
        ayuda         = wx.Menu()

        entrada = archivo.Append(101, '&Entrada...', 'Registrar horario de entrada')
        sync    = archivo.Append(102, '&Sincronizar...', 'Sincronizar datos con el servidor')
        #venta   = archivo.Append(103, '&Venta...', 'Venta en el kiosco')
        archivo.AppendSeparator()
        salir = archivo.Append(502, 'Sa&lir', 'Salir')
        self.Bind(wx.EVT_MENU, self.OnClose, salir)
        self.Bind(wx.EVT_MENU, self.OnEntrada, entrada)
        #self.Bind(wx.EVT_MENU, self.OnVenta, venta)
        self.Bind(wx.EVT_MENU, self.OnSync, sync)

        if user_data.getTipo() == 1:
           stock_admin = stock.Append(301, '&Stock...', 'Administrar el stock')
           self.Bind(wx.EVT_MENU, self.HereStockAdmin, stock_admin)
           precios_canchas = stock.Append(302, '&Canchas...', 'Precio por cancha')

        menubar.Append(archivo, "&Archivo")

        if user_data.getTipo() == 1:
           menubar.Append(stock, '&Administrar')

        self.SetMenuBar(menubar)

        """
        icon   = wx.Icon("favicon.ico", wx.BITMAP_TYPE_ICO)
        tbicon = wx.TaskBarIcon()
        tbicon.SetIcon(icon, "Canchas - Tifosi")
        """
        self.tabselected = TabSelected()
        Publisher().subscribe(self.SelTab, ("tab_selected"))

        self.Show()

    def HereStockAdmin( self, evt ):
        HereStockAdmin = StockAdmin(self, -1, 'Administrar Stock')

    def SelTab( self , evt ):
        self.tabselected.setTab(evt.data)

    def OnClose(self, evt):
        self.Destroy()

    def OnEntrada(self, evt):
        entrada = CanchasEntrada(self, -1, "Registro de Ingreso")        

    def OnSync(self, evt):
        print "Sync"


class CanchasLoginFrame( wx.Frame ):

    def __init__(self):
        wx.Frame.__init__(self, None, wx.ID_ANY,
                          "Canchas Login",
                          size=(240,160),
                          style=wx.SYSTEM_MENU|wx.CAPTION|wx.CLOSE_BOX|wx.MINIMIZE_BOX|wx.SYSTEM_MENU
                          )

        panel = CanchasLogin( self )
        self.Show()

    def offLogin(self):
        self.Destroy()


def LaunchApp( evt ):
    if evt.data != "denied":
        user      = evt.data
        user_data = User( user['id'], 
                          user['nombre'],
                          user['usuario'],
                          user['passwd'],
                          user['id_sucursal'],
                          user['status'],
                          user['telefono'], 
                          user['type'] )

        FRAME = CanchasFrame( user_data )
        FRAME_LOGIN.Destroy()
    else:
        wx.MessageBox('Usuario o Password incorrecto', 'Acceso Denegado', 
        wx.OK | wx.ICON_ERROR)


if __name__ == "__main__":
    #app = wx.App(redirect=True,filename="error.log")
    app = wx.App(redirect=False)
    #lc  = LicenseChecker()
    #act = lc.isActive()

    """
    if act['active']:
       FRAME_LOGIN = CanchasLoginFrame()
       Publisher().subscribe(LaunchApp, ("login"))
    else:
       wx.MessageBox("Mensaje remoto: %s" % act['msg'], 'eHead Systems - Acceso denegado',
       wx.OK | wx.ICON_ERROR)
    """

    FRAME_LOGIN = CanchasLoginFrame()
    Publisher().subscribe(LaunchApp, ("login"))
 
    app.MainLoop()

