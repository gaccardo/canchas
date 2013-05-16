import wx
import datetime

class CanchasEntrada( wx.Dialog ):

    def __init__(self, parent, id, title):
        wx.Dialog.__init__(self, parent, id, title)

        self.SetSize((280,175))
        self.SetMinSize((280,175))

        vbox  = wx.BoxSizer( wx.VERTICAL )
        hbox1 = wx.BoxSizer( wx.HORIZONTAL )

        self.clock = wx.StaticText(self, -1, datetime.datetime.now().strftime("%d/%m/%Y %H:%M:%S"))
        font       = wx.Font(16, wx.NORMAL, wx.NORMAL, wx.BOLD)
        self.clock.SetFont(font)
        self.timer = wx.Timer(self)
        self.Bind(wx.EVT_TIMER, self.update, self.timer)
        self.timer.Start(1000)

        hbox1.Add(self.clock)
        vbox.Add(hbox1, flag=wx.CENTER)

        hbox2       = wx.BoxSizer( wx.HORIZONTAL )
        codigo      = wx.TextCtrl(self, -1, "")
        btn_entrada = wx.Button(self, -1, "INGRESO")

        hbox2.Add(codigo)
        hbox2.Add(btn_entrada)
        vbox.Add(hbox2, flag=wx.CENTER)

        self.SetSizer(vbox)
        self.Show(True)

    def update(self, evt):
        self.clock.SetLabel(datetime.datetime.now().strftime("%d/%m/%Y %H:%M:%S"))
    
