<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:template match="/">
    <html>
      <head>
        <title>Employee Information</title>
      </head>
      <body>
        <h1>Employee Information</h1>
        <xsl:apply-templates/>
      </body>
    </html>
  </xsl:template>

  <xsl:template match="employees">
    <xsl:apply-templates/>
  </xsl:template>

  <xsl:template match="employee">
    <div style="border: 1px solid #ccc; margin-bottom: 20px; padding: 10px;">
      <h2><xsl:value-of select="name"/></h2>
      <p>ISBN: <xsl:value-of select="@isbn"/></p>
      <p>Email: <xsl:value-of select="email"/></p>
      <p>Phones:</p>
      <ul>
        <xsl:for-each select="phones/phone">
          <li><xsl:value-of select="."/> - <xsl:value-of select="@type"/></li>
        </xsl:for-each>
      </ul>
      <p>Address:</p>
      <p><xsl:value-of select="addresses/address/Street"/> <xsl:value-of select="addresses/address/BuildingNumber"/></p>
      <p><xsl:value-of select="addresses/address/Region"/>, <xsl:value-of select="addresses/address/City"/></p>
      <p><xsl:value-of select="addresses/address/Country"/></p>
    </div>
  </xsl:template>
</xsl:stylesheet>
