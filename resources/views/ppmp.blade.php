<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{$receipt}}</title>

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
                <h3>PROJECT PROCUREMENT MANAGEMENT PLAN (PPMP)</h3>
            </div>
        </td>
    </tr>
  </table>
  
  
<table width="100%" style="margin-bottom: 20px;">
    <tr>
        <td>END-USER/UNIT: <b></b></td>
    </tr>
</table>

  <table class="tablemain" width="100%">
    <thead>

      <tr class="tablemain">
        <th class="tablemain" style="width: 3%">No.</th>
        <th class="tablemain" style="width: 10%">Item Code</th>
        <th class="tablemain" style="width: 30%">General Description</th>
        <th class="tablemain" style="width: 7%">Unit of Measure</th>
 
        <th class="tablemain" style="width: 13%">Quantity</th>
        <th class="tablemain" style="width: 13%">Estimated Budget</th>
        
        <th class="tablemain" style="width: 2%">Jan</th>
        <th class="tablemain" style="width: 2%">Feb</th>
        <th class="tablemain" style="width: 2%">Mar</th>
        <th class="tablemain" style="width: 2%">Apr</th>
        <th class="tablemain" style="width: 2%">May</th>
        <th class="tablemain" style="width: 2%">Jun</th>
        <th class="tablemain" style="width: 2%">Jul</th>
        <th class="tablemain" style="width: 2%">Aug</th>
        <th class="tablemain" style="width: 2%">Sep</th>
        <th class="tablemain" style="width: 2%">Oct</th>
        <th class="tablemain" style="width: 2%">Nov</th>
        <th class="tablemain" style="width: 2%">Dec</th>
      </tr>
    </thead>

    <tbody>

      @if(!is_null($supplies))
        <tr class="tablemain">
          <td colspan="18" class="tablemain" style="background-color: DarkTurquoise">Supplies</td>
        </tr>
        @foreach ($supplies as $supply)
          <tr class="tablemain">
            <td class="tablemain" align="center"></td>
            <td class="tablemain" align="center">{{$supply['supply']->id}}</td>
            <td class="tablemain" align="center">{{$supply['supply']->supply_name}}</td>
            <td class="tablemain" align="center"></td>
            <td class="tablemain" align="center">{{$supply['qty']}}</td>
            <td class="tablemain" align="center">{{$supply['qty']*$supply['supply']->supply_price}}</td>
            <td class="tablemain" align="center"></td>
            <td class="tablemain" align="center"></td>
            <td class="tablemain" align="center"></td>
            <td class="tablemain" align="center"></td>
            <td class="tablemain" align="center"></td>
            <td class="tablemain" align="center"></td>
            <td class="tablemain" align="center"></td>
            <td class="tablemain" align="center"></td>
            <td class="tablemain" align="center"></td>
            <td class="tablemain" align="center"></td>
            <td class="tablemain" align="center"></td>
            <td class="tablemain" align="center"></td>
          </tr>
        @endforeach
      @endif

      @if(!is_null($equipments))
      <tr class="tablemain">
        <td colspan="18" class="tablemain" style="background-color: DarkTurquoise">Equipments</td>
      </tr>
      @foreach ($equipments as $equipment)
        <tr class="tablemain">
          <td class="tablemain" align="center"></td>
          <td class="tablemain" align="center">{{$equipment['supply']->id}}</td>
          <td class="tablemain" align="center">{{$equipment['supply']->supply_name}}</td>
          <td class="tablemain" align="center"></td>
          <td class="tablemain" align="center">{{$equipment['qty']}}</td>
          <td class="tablemain" align="center">{{$equipment['qty']*$equipment['supply']->supply_price}}</td>
          <td class="tablemain" align="center"></td>
          <td class="tablemain" align="center"></td>
          <td class="tablemain" align="center"></td>
          <td class="tablemain" align="center"></td>
          <td class="tablemain" align="center"></td>
          <td class="tablemain" align="center"></td>
          <td class="tablemain" align="center"></td>
          <td class="tablemain" align="center"></td>
          <td class="tablemain" align="center"></td>
          <td class="tablemain" align="center"></td>
          <td class="tablemain" align="center"></td>
          <td class="tablemain" align="center"></td>
        </tr>
      @endforeach
    @endif


    </tbody>


  </table>



</body>
</html>




