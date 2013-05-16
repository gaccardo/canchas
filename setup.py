from cx_Freeze import setup, Executable
import py_compile

opts = {'packages' : ['wx.lib.pubsub.core.kwargs', 'wx.lib.pubsub.core.arg1', 'wx.lib.pubsub.*','pubsub.core.kwargs', 'pubsub.core.arg1'],
        }

setup(
    name = "Canchas",
    version = "0.2",
    description = "Canchas management",
    executables = [Executable("Canchas.py")],
    icon = "icon.ico",
    packages = ['wx.lib.pubsub.*'],
    )

