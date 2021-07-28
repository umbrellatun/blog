<!DOCTYPE html>
<html lang="th">
<head>
     <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
     <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
     <title></title>
     <link rel="stylesheet" href="style.css" media="all" />
     <style>
     @font-face {
          font-family: myFirstFont;
         src: url({{ asset('font/SukhumvitSet-Medium.ttf') }});
     }
     .clearfix:after {
          content: "";
          display: table;
          clear: both;
     }

     a {
          color: #5D6975;
          text-decoration: underline;
     }

     body {
          position: relative;
          width: 21cm;
          height: 29.7cm;
          margin: 0 auto;
          color: #001028;
          background: #FFFFFF;
          font-size: 12px;
          font-family: Arial;
          padding: 10px 10px;
          font-family: myFirstFont, sans-serif;
     }

     header {
          padding: 10px 10px;
          margin-bottom: 30px;
     }

     #logo {
          text-align: center;
          margin-bottom: 10px;
     }

     #logo img {
          width: 90px;
     }

     h1 {
          border-top: 1px solid  #5D6975;
          border-bottom: 1px solid  #5D6975;
          color: #5D6975;
          font-size: 2.4em;
          line-height: 1.4em;
          font-weight: normal;
          text-align: center;
          margin: 0 0 20px 0;
          background: url({{asset('assets/images/order/dimension.png')}});
     }

     #project {
          float: left;
     }

     #project span {
          color: #5D6975;
          text-align: right;
          width: 52px;
          margin-right: 10px;
          display: inline-block;
          font-size: 0.8em;
     }

     #company {
          float: right;
          text-align: right;
     }

     #project div,
     #company div {
          white-space: nowrap;
     }

     table {
          width: 100%;
          border-collapse: collapse;
          border-spacing: 0;
          margin-bottom: 20px;
     }

     table tr:nth-child(2n-1) td {
          background: #F5F5F5;
     }

     table th,
     table td {
          /* text-align: center; */
     }

     table th {
          padding: 5px 20px;
          color: #5D6975;
          border-bottom: 1px solid #C1CED9;
          white-space: nowrap;
          font-weight: normal;
     }

     table .service,
     table .desc {
          /* text-align: left; */
     }

     table td {
          padding: 20px;
          /* text-align: left; */
     }

     table td.service,
     table td.desc {
          vertical-align: top;
     }

     table td.unit,
     table td.qty,
     table td.total {
          font-size: 1.2em;
     }

     table td.grand {
          border-top: 1px solid #5D6975;;
     }

     #notices .notice {
          color: #5D6975;
          font-size: 1.2em;
     }

     footer {
          color: #5D6975;
          width: 100%;
          height: 30px;
          position: absolute;
          bottom: 0;
          border-top: 1px solid #C1CED9;
          padding: 10px 10px;
          text-align: center;
     }
     </style>
</head>
<body>
     {{dd($orders)}}

</body>
</html>
