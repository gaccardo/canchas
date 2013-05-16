import wx

class CanchasTabClientes(wx.Panel):

   def __init__(self, parent):

       wx.Panel.__init__(self, parent=parent, id=wx.ID_ANY)

       sizer = wx.BoxSizer(wx.VERTICAL)
       self.SetSizer(sizer)
       panel = wx.Panel(self)
       sizer.Add(panel)
