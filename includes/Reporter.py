# -*- coding: utf-8 -*-
from reportlab.lib.enums     import TA_JUSTIFY
from reportlab.lib           import colors
from reportlab.lib.pagesizes import A4
from reportlab.platypus      import SimpleDocTemplate, Table, TableStyle, Image, Paragraph, Spacer
from reportlab.lib.styles    import getSampleStyleSheet, ParagraphStyle
from reportlab.lib.units     import inch
from DBManager               import DBManager

class Reporter( object ):

   def __init__( self, reportname, data, tipo ):
      self.doc      = SimpleDocTemplate(reportname, pagesize=A4)
      self.data     = data
      self.elements = list()
      self.logo     = 'logo.png'
      self.DBM      = DBManager()
      self.tipo     = tipo

   def __addHead( self ):

      if  self.tipo == "stock":
         styles = getSampleStyleSheet()
         ptext  = '<font size=14>Reporte estado de Stock</font>'
         styles.add(ParagraphStyle(name='Justify', alignment=TA_JUSTIFY))
         self.elements.append( Paragraph(ptext, styles["Normal"]) )
         self.elements.append(Spacer(1, 12))
      elif self.tipo == "ganancia":
         styles = getSampleStyleSheet()
         ptext  = '<font size=14>Reporte de ganancias de Tifosi (%s, %s)</font>' % ( self.data[0], self.data[1] )
         styles.add(ParagraphStyle(name='Justify', alignment=TA_JUSTIFY))
         self.elements.append( Paragraph(ptext, styles["Normal"]) )
         self.elements.append(Spacer(1, 12))
  
   def __addTable( self ):
      tt    = list()

      if self.tipo == "ganancia":
         data  = self.DBM.getCuentas(self.data[0], self.data[1])
         total = 0
         tt.append( ['Fecha', 'Descripción', 'Cantidad', 'Precio'] )

         for producto in data:
            tt.append( [producto[0], producto[1], producto[2], "$ %.2f" % float( producto[4] ) ] )
            total += float( producto[4] )

         tt.append( ["TOTAL" , "", "", "$ %.2f" % total] )
      elif self.tipo == "stock":
         total = 0
         tt.append( ['Código', 'Descripción', 'Marca', 'Precio', 'Punto Pedido', 'Stock'] )

         for producto in self.data:
            if producto[1] != '1000':
               tt.append( [ producto[1], producto[2], producto[3], "$ %.2f" % float( producto[4] ), producto[5], producto[6] ] )
               total += float( producto[4] * producto[6] )

      tabla = Table(tt)

      if self.tipo == "ganancia":
          tabla.setStyle( TableStyle([
                                     ('ALIGN', (1,1), (-2, -2), 'RIGHT'),
                                     ('INNERGRID', (0,0), (-1,-1), 0.25, colors.black),
                                     ('BOX', (0,0), (-1,-1), 0.55, colors.black),
                                     ('TEXTCOLOR',(0,-1),(-1,-1),colors.yellow),
                                     ('BACKGROUND',(0,-1),(-1,-1),colors.red),
                                     ('BACKGROUND',(0,0),(-1,0),colors.gray)
                                    ]))
      elif self.tipo == "stock":
          tabla.setStyle( TableStyle([
                                     ('ALIGN', (1,1), (-1, -1), 'RIGHT'),
                                     ('INNERGRID', (0,0), (-1,-1), 0.25, colors.black),
                                     ('BOX', (0,0), (-1,-1), 0.55, colors.black),
                                     ('BACKGROUND',(0,0),(-1,0),colors.gray)
                                    ]))

      self.elements.append( tabla )

      if self.tipo == "ganancia":
         styles = getSampleStyleSheet()
         ptext  = '<font size=10>Total de ventas: %s </font>' % len( data )
         self.elements.append(Spacer(1, 12))
         styles.add(ParagraphStyle(name='Justify', alignment=TA_JUSTIFY))
         self.elements.append( Paragraph(ptext, styles["Normal"]) )
      elif self.tipo == "stock":
         styles = getSampleStyleSheet()
         ptext  = '<font size=10>Productos en Stock: %s </font>' % len( self.data )
         self.elements.append(Spacer(1, 12))
         styles.add(ParagraphStyle(name='Justify', alignment=TA_JUSTIFY))
         self.elements.append( Paragraph(ptext, styles["Normal"]) )
      
         styles = getSampleStyleSheet()
         ptext  = '<font size=10>Dinero en Stock: $ %.2f </font>' % total
         styles.add(ParagraphStyle(name='Justify', alignment=TA_JUSTIFY))
         self.elements.append( Paragraph(ptext, styles["Normal"]) )

   def doReport( self ):
      self.__addHead()
      self.__addTable()
      self.doc.build( self.elements )
      
