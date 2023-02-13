<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>#{{$receipt->id}} Receipt</title>

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table{
            font-size: x-small;
        }

        .tablemain {
          border: 1px solid black;
          border-collapse: collapse;
        }

        .gray {
            background-color: lightgray
        }

        h3{
            padding: 0px;
        }
    </style>
    
</head>
<body>


  <table width="100%">
    <tr>
        <td valign="top"></td>
        <td align="center">
            <div style="margin-bottom: 50px;">
                <h3>PROPERTY ACKNOWLEDGMENT RECEIPT</h3>
            </div>
        </td>
    </tr>
  </table>
  
  
<table width="100%" style="margin-bottom: 20px;">
    <tr>
        <td>Entity Name: <b>{{strtoupper($user_details->firstname. ' '.$user_details->lastname)}}</b></td>
    </tr>
    
    <tr>
        <td>Fund Cluster: ________________</td>
        <td align="right">PAR No.: <u>{{ date_format(Carbon\Carbon::parse($receipt->done_at), 'm-Y') }}-{{$receipt->id}}</u> </td>
    </tr>
</table>

  <table class="tablemain" width="100%">
    <thead>

      <tr class="tablemain">
        <th class="tablemain" style="width: 10%">Quantity</th>
        <th class="tablemain" style="width: 15%">Unit</th>
        <th class="tablemain" style="width: 25%">Description</th>
        <th class="tablemain" style="width: 20%">Property Number</th>
        <th class="tablemain" style="width: 15%">Date Acquired</th>
        <th class="tablemain" style="width: 15%">Amount</th>
      </tr>
    </thead>
    <tbody>

   
      @foreach ($requests as $item)
      <tr class="tablemain">
          <th class="tablemain" scope="row">{{ $item->quantity }}</th>
          <th class="tablemain" scope="row">UNIT</th>
          <td class="tablemain" align="center">{{ $item['supply_name'] }}</td>
          <td class="tablemain" align="center">{{ date_format(Carbon\Carbon::parse($item->created_at), 'm-Y') }}-{{ $item->supply_id }}</td>
          <td class="tablemain" align="center">{{ date_format(Carbon\Carbon::parse($item->created_at), 'm-Y') }}</td>
          <td class="tablemain" align="center">{{ $item->quantity * $item['supply_price'] }}</td>
      </tr>
      @endforeach

      <tr class="tablemain">
        <th class="tablemain" scope="row" colspan="3" style="width: 100%;">
         <div style="text-align: left; margin: 10px;">Received By:</div>
        
         <div style="margin-bottom: 10px;">
          <div><u>{{strtoupper($user_details->firstname. ' '.$user_details->lastname)}}</u></div>
          <div style="font-weight: 400; font-size: 9px;">Signature over printer name of End User</div>
          <div><u>{{$user_details->usertype}}, {{$user_details->userdepartment}}</u></div>
          <div style="font-weight: 400; font-size: 9px;">Position / Office</div>
          <div style="font-weight: 400;"><u>{{ date_format(Carbon\Carbon::parse($receipt->done_at), 'm/Y/d') }}</u></div>
          <div style="font-weight: 400; font-size: 9px;">Date</div>
        </div>
    
        </th>
        <th class="tablemain" scope="row" colspan="3">
          <div style="text-align: left; margin: 10px;">Issued By:</div>
          <div style="margin-bottom: 10px;">
            <div><u>{{strtoupper(App\Models\User::where('user_type', 1)->first()->firstname." ".App\Models\User::where('user_type', 1)->first()->lastname)}}</u></div>
            <div style="font-weight: 400; font-size: 9px;">Signature over printer name of Supply and/or Property</div>
            <div><u>Supply Office</u></div>
            <div style="font-weight: 400; font-size: 9px;">Position / Office</div>
            <div style="font-weight: 400;"><u>{{ date_format(Carbon\Carbon::parse($receipt->done_at), 'm/Y/d') }}</u></div>
            <div style="font-weight: 400; font-size: 9px;">Date</div>
          </div>
        </th>
    </tr>
 
  </tbody>


  </table>



</body>
</html>




