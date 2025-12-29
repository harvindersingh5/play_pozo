<!DOCTYPE html>
<html>

<head>
    <title>Download CSV</title>
    <style>
        body {
            font-family: 'Segoe UI', Roboto, Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f7fa;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            border-bottom: 2px solid #eaeaea;
            padding-bottom: 10px;
        }

        p {
            margin-bottom: 15px;
        }

        a {
            display: inline-block;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }

        a:hover {
            background-color: #2980b9;
        }

        p:nth-of-type(3) {
            margin-top: 30px;
            font-size: 14px;
            color: #7f8c8d;
        }

        p:nth-of-type(4) {
            background-color: #ecf0f1;
            padding: 10px;
            border-radius: 4px;
            border-left: 3px solid #3498db;
            font-family: monospace;
            word-break: break-all;
        }
    </style>
</head>

<body>
    <h1>Download Your CSV File</h1>
    <p>Please click the link below to download your CSV file:</p>
    <a href="{{ $downloadLink }}" download>Download CSV</a>
    <p>If the link doesn't work, copy and paste this URL into your browser:</p>
    <p>{{ $downloadLink }}</p>
</body>

</html>
