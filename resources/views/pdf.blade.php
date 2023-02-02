<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>#{{$receipt_id}} Receipt</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        table{
            font-size: x-small;
        }
        tfoot tr td{
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }

        h3{
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
            <pre>
                {{$user_details->firstname. ' '.$user_details->lastname}}
                {{$user_details->userdepartment}}
                {{$user_details->usertype}}
                <b>#{{$receipt_id}}</b>
            </pre>
        </td>
    </tr>

  </table>



  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th>#</th>
        <th>Item</th>
        <th>Quantity</th>
        <th>Type</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($requests as $item)
        <tr>
            <th scope="row">{{ $item->supply_id }}</th>
            <td>{{ $item['supply_name'] }}</td>
            <td align="right">{{ $item->quantity }}</td>
            <td align="right">{{ $item['supply_type'] }}</td>
        </tr>
        @endforeach
    </tbody>
  </table>
  
  <table width="100%" style="margin-top: 100px;">
    
      <tr>
        <th style="background-color: lightgray;">This Request was Approved by Campus Executive Director</th>
      </tr>
      
      <tr>
        <th style="font-size: 9px; font-weight: normal;" >Unauthorized replication of a receipt regarding the list of ordered supplies and equipment is strictly prohibited. Violators may face legal consequences and disciplinary action. Please handle all university property and information with the utmost care and respect.</th>
      </tr>
      
  </table>

</body>
</html>




