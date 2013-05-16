import wx

from CanchasTabs import CanchasTabs

class CanchasMainPanel(wx.Panel):

    def __init__(self, parent):
        wx.Panel.__init__(self, parent)

        mainSizer = wx.BoxSizer(wx.VERTICAL)
        notebook  = CanchasTabs( self )
        mainSizer.Add(notebook, 1, wx.ALL|wx.EXPAND, 5)
        self.SetSizer( mainSizer )
        self.Layout()
        self.Show()
