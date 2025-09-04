<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:output method="html" indent="yes"/>

    <xsl:template match="/">
        <html>
            <head>
                <title>Book Information</title>
                <style>
                    body {
                        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                        background: linear-gradient(135deg, #f9f9f9, #e6f7ff);
                        margin: 0;
                        padding: 20px;
                    }
                    table {
                        width: 90%;
                        margin: 20px auto;
                        border-collapse: collapse;
                        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
                        border-radius: 12px;
                        overflow: hidden;
                        animation: fadeIn 1.2s ease;
                    }
                    th {
                        background-color: #444;
                        color: #fff;
                        padding: 12px;
                        text-transform: uppercase;
                        letter-spacing: 1px;
                    }
                    td {
                        padding: 12px;
                        text-align: center;
                        transition: background 0.3s ease, transform 0.2s ease;
                    }
                    tr:nth-child(even) {
                        background: #f9f9f9;
                    }
                    tr:hover {
                        background: #e6f7ff;
                        transform: scale(1.01);
                    }
                    .author {
                        color: #1a237e;
                        font-weight: bold;
                        text-transform: uppercase;
                    }
                    .title {
                        color: #2e7d32;
                        font-weight: 500;
                    }
                    .isbn {
                        color: #6d4c41;
                        font-style: italic;
                    }
                    .publisher {
                        color: #6a1b9a;
                    }
                    .edition {
                        color: #00897b;
                        font-weight: bold;
                    }
                    .price {
                        color: #b71c1c;
                        font-weight: bold;
                        background: #ffebee;
                        border-radius: 8px;
                        padding: 6px 10px;
                        display: inline-block;
                    }
                    @keyframes fadeIn {
                        from {opacity: 0; transform: translateY(20px);}
                        to {opacity: 1; transform: translateY(0);}
                    }
                </style>
            </head>
            <body>
                <h2 style="text-align:center; color:#333;">Book List</h2>
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>ISBN</th>
                        <th>Publisher</th>
                        <th>Edition</th>
                        <th>Price</th>
                    </tr>
                    <xsl:for-each select="bookstore/book">
                        <tr>
                            <td class="title"><xsl:value-of select="title"/></td>
                            <td class="author"><xsl:value-of select="author"/></td>
                            <td class="isbn"><xsl:value-of select="isbn"/></td>
                            <td class="publisher"><xsl:value-of select="publisher"/></td>
                            <td class="edition"><xsl:value-of select="edition"/></td>
                            <td><span class="price">$<xsl:value-of select="price"/></span></td>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>
