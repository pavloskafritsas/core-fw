<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0"
    xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="/list">
        <html>
            <body>
                <table style="border-spacing: 0; width: 100%; border: 1px solid #ccc; margin: 20px 0; padding: 10px">
                    <thead>
                        <tr>
                            <td>
                                <b>Ημ/νια</b>
                            </td>
                            <td>
                                <b>Ώρα</b>
                            </td>
                            <td>
                                <b>Όνομα πολίτη</b>
                            </td>
                            <td>
                                <b>ΑΜΚΑ</b>
                            </td>
                            <td>
                                <b>Ηλικία</b>
                            </td>
                            <td>
                                <b>Κατάσταση</b>
                            </td>
                        </tr>
                    </thead>

                    <tbody>
                        <xsl:for-each select="Appointments/Appointment">
                            <tr>
                                <td>
                                    <xsl:value-of select="@date"/>
                                </td>
                                <td>
                                    <xsl:value-of select="@time"/>
                                </td>
                                <td>
                                    <xsl:value-of select="Citizen/@first_name"/>
                                 
                                    &#160;
                                
                                    <xsl:value-of select="Citizen/@last_name"/>
                                </td>
                                <td>
                                    <xsl:value-of select="Citizen/@amka"/>
                                </td>
                                <td>
                                    <xsl:value-of select="Citizen/@age"/>
                                </td>
                                <td>
                                    <xsl:choose>
                                        <xsl:when test="@status[@Appointment='Ολοκληρωμένο']">
                                            <span style="color: green">Ολοκληρωμένο</span>
                                        </xsl:when>
                                        <xsl:otherwise>
                                            <span>Μη ολοκληρωμένο</span>
                                        </xsl:otherwise>
                                    </xsl:choose>
                                </td>
                            </tr>
                        </xsl:for-each>
                    </tbody>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>