import wx 

# TABS
import CanchasTabReservas, CanchasTabFinanzas, CanchasTabJuego, CanchasTabClientes

from wx.lib.pubsub import Publisher

class CanchasTabs( wx.Notebook ):

   def __init__( self, parent ):
      wx.Notebook.__init__( self, parent, id=wx.ID_ANY, style=wx.BK_TOP)

      tabJuego = CanchasTabJuego.CanchasTabJuego( self )
      self.AddPage(tabJuego, "Reservas")

#      tabReservas = CanchasTabReservas.CanchasTabReservas( self )
#      self.AddPage(tabReservas, "")

      tabFinanzas = CanchasTabFinanzas.CanchasTabFinanzas( self )
      self.AddPage(tabFinanzas, "Cuentas")

#      tabClientes = CanchasTabClientes.CanchasTabClientes( self )
#      self.AddPage(tabClientes, "Estacionamiento")

      self.Bind(wx.EVT_NOTEBOOK_PAGE_CHANGED, self.OnPageChanged)
      self.Bind(wx.EVT_NOTEBOOK_PAGE_CHANGING, self.OnPageChanging)

   def OnPageChanged(self, event):
      old = event.GetOldSelection()
      new = event.GetSelection()
      sel = self.GetSelection()
      #print 'OnPageChanged,  old:%d, new:%d, sel:%d\n' % (old, new, sel)
      Publisher().sendMessage(("tab_selected"), new)

      if new == 1:
         Publisher().sendMessage(("tab_cuentas_update"), new)

      event.Skip()

   def OnPageChanging(self, event):
      old = event.GetOldSelection()
      new = event.GetSelection()
      sel = self.GetSelection()
      #print 'OnPageChanging, old:%d, new:%d, sel:%d\n' % (old, new, sel)
      event.Skip()
