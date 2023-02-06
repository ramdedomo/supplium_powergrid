<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $report_details }} Reports</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }

        h3 {
            style="padding: 0px;"
        }
    </style>
</head>

<body>


    <table width="100%">
        <tr>
            <td valign="top"></td>
            <td align="right">
                <div style="border-left-style: solid; border-width: 10px; border-color: gold;">
                    <h3>Pangasinan State University - Urdaneta Campus</h3>
                </div>

                <p>Supplium - Supply Inventory System</p>
                <b>{{ $report_details }} Reports</b>
            </td>
        </tr>
    </table>

    <table width="100%" style="margin-top: 20px;">
        <tr>
            <th style="background-color: lightgray;">Supply & Equipments Report</th>
        </tr>
    </table>

    <table width="100%">
        <thead style="background-color: lightgray;">
            <tr>
                <th>ID</th>
                <th>Item</th>
                <th>Type</th>
                <th>Price</th>
                <th>No. of Request</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($supplies as $supply)
                <tr>
                    <td>{{ $supply->id }}</td>
                    <td>{{ $supply->supply_name }}</td>
                    <td>
                        @if ($supply->supply_type == 0)
                            Supply
                        @else
                            Equipments
                        @endif
                    </td>
                    <td>{{ $supply->supply_price }}.00 PHP</td>
                    <td>{{ $supply->request_count }}</td>
                    <td>{{ $supply->request_total }}.00 PHP</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table width="100%" style="margin-top: 20px;">
        <tr>
            <th style="background-color: lightgray;">Department Report</th>
        </tr>
    </table>


    <table width="100%">
        <thead style="background-color: lightgray;">
            <tr>
                <th>Department</th>
                <th>Department Type</th>
                <th>No. of Request (Equipments)</th>
                <th>No. of Request (Supply)</th>
                <th>Total No. of Request</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
                <tr>
                    <td>{{ $department->department_description }}</td>
                    <td>
                        @if ($department->nonteaching == 1)
                            Non-Teaching
                        @else
                            Teaching
                        @endif
                    </td>
                    <td>
                      {{$department->request_count_equipments}}
                    </td>
                    <td>{{$department->request_count_supply}}</td>
                    <td>{{$department->request_count}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>
