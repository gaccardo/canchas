import wx

from wx.lib.pubsub import Publisher
from DBManager import DBManager

class CanchasLogin (wx.Panel ):

   def __init__(self, parent):

       wx.Panel.__init__(self, parent=parent, id=wx.ID_ANY)

       self.DBM    = DBManager() 
       self.config = wx.Config('canchas-config') 

       vbox = wx.BoxSizer(wx.VERTICAL)
       hbox = wx.BoxSizer(wx.HORIZONTAL)

       lbl_title = wx.StaticText(self, -1, "Tifosi - Canchas")
       font      = wx.Font(16, wx.NORMAL, wx.NORMAL, wx.BOLD)
       lbl_title.SetFont(font)
       hbox.Add(lbl_title)
       vbox.Add(hbox, flag=wx.CENTER)

       hbox_line = wx.BoxSizer(wx.HORIZONTAL)
       static_line = wx.StaticLine(self)
       hbox_line.Add(static_line,0,wx.EXPAND,5)
       vbox.Add(hbox_line, wx.EXPAND)

       hbox1 = wx.BoxSizer(wx.HORIZONTAL)

       # Username
       self.txt_Username = wx.TextCtrl(self, -1, size=(150,20))
       lbl_Username      = wx.StaticText(self, -1, "Usuario:   ")

       hbox1.Add(lbl_Username)
       hbox1.Add(self.txt_Username)
       vbox.Add(hbox1, flag=wx.LEFT)

       # Password
       hbox2             = wx.BoxSizer(wx.HORIZONTAL)
       self.txt_Password = wx.TextCtrl(self, -1, size=(150,20), style=wx.TE_PASSWORD)
       lbl_Password      = wx.StaticText(self, -1, "Password:")
       hbox2.Add(lbl_Password)
       hbox2.Add(self.txt_Password)
       vbox.Add(hbox2, flag=wx.LEFT)

       # Submit button
       hbox3 = wx.BoxSizer(wx.HORIZONTAL)
       btn_Process = wx.Button(self, -1, "&Entrar")
       self.Bind(wx.EVT_BUTTON, self.OnSubmit, btn_Process)

       btn_Cancel = wx.Button(self, -1, "&Cancel")

       hbox3.Add(btn_Process, flag=wx.CENTER)
       hbox3.Add(btn_Cancel, flag=wx.CENTER)

       vbox.Add(hbox3, flag=wx.CENTER)

       self.SetSizer(vbox)
       self.Fit()

   def OnSubmit(self, evt):

       #Publisher().sendMessage(("login"), "auth")
       if self.DBM.userLogin( self.txt_Username.GetValue(), self.txt_Password.GetValue() ):
          user_data = self.DBM.getUserData( self.txt_Username.GetValue() )
          Publisher().sendMessage(("login"), user_data)
          Publisher().sendMessage(("user"), self.txt_Username.GetValue())
          self.config.Write( 'logged_user', self.txt_Username.GetValue() )
       else:
          Publisher().sendMessage(("login"), "denied")

       return True
