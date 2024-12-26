<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <title>Demo Task</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .readonly{
            font-size: 20px;
            font-weight: 650;
            color: black;
            border-bottom: 2px solid black;
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">

    <!-- Button trigger modal -->
    {{--  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Launch demo modal
    </button>  --}}

    <!-- Modal -->
    <div class="modal fade bd-example-modal-xl"  id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl"  role="document">
        <div class="modal-content" >
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>

          </div>
          <div class="modal-body">
            <table class="table">
                <tr>

                    <th>Product</th>
                    <th>Rate</th>
                    <th>Unit</th>
                    <th>Qty.</th>
                    <th>Discount (In %)</th>
                    <th>Net Amount</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </tr>

                @if (session()->has('data'))
                    @foreach (session()->get('data') as $value)
                        <tr>

                            <td>
                                <select class="form-select select_product_edit product_data{{$loop->index}}" data-index_id="{{ $loop->index }}"  aria-label="Default select example">

                                    @foreach ($data as $val)
                                    <option value="{{ $val['id'] }}" @if ($val['id'] == $value['product'])
                                        selected
                                    @endif>{{ $val['name'] }}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td >
                                <span class="readonly rate_edit{{ $loop->index }}" data-index_id="{{ $loop->index }}">{{ $value['rate'] }}</span>
                            </td>
                            <td data-index_id="{{ $loop->index }}">
                                <span  class="readonly unit_data{{$loop->index}}">{{ $value['unit'] }}</span>

                            </td>
                            <td >
                                <input type="text" name="qty_edit" data-index_id="{{ $loop->index }}" class="form-control qty_edit qty_data{{$loop->index}}" value="{{ $value['qty'] }}">
                            </td>
                            <td data-index_id="{{ $loop->index }}">
                                <input type="text" name="discount_edit" data-index_id="{{ $loop->index }}" class="form-control discount_edit discount_data{{$loop->index}}" value="{{ $value['discount'] }}">
                            </td>
                            <td data-index_id="{{ $loop->index }}">
                                <span class="readonly net_amount_data{{$loop->index}}" data-index_id="{{ $loop->index }}">{{ $value['net_amount'] }}</span>

                            </td>
                            <td data-index_id="{{ $loop->index }}">
                                <span class="readonly total_amount_data{{$loop->index}}">{{ $value['total_amount'] }}</span>

                            </td>
                            <td><button class="btn btn-danger remove_product" data-index_id="{{ $loop->index }}">Remove</button></td>
                        </tr>
                    @endforeach
                @else

                @endif


            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="close_modal" data-bs-dismiss="modal">Close</button>
            <button type="button" id="submit_form" class="btn btn-primary">Submit</button>
          </div>
        </div>
      </div>
    </div>



        <div class="mt-4 card" style="width: 50rem;">

            <div class="card-body">
                <form id="insert_form">
                    <div class="mb-3 form-group row">
                      <label for="name" class="col-sm-3 col-form-label">Customer Name</label>
                      <div class="col-sm-9">

                        <input type="text" class="form-control" id="name" name="name"  @if(session()->has('data'))
                            @if(session()->get('data')!="")
                                value="{{ session()->get('data')[0]['name'] }}"
                                @readonly(true)
                            @else
                                value=""
                                @readonly(false)
                            @endif
                        @endif>
                      </div>
                    </div>
                    <div class="mb-3 form-group row">
                        <label for="select_product" class="col-sm-3 col-form-label">Select Product</label>

                        <div class="col-sm-9">
                            <select class="form-select select_product" id="select_product" aria-label="Default select example">
                                <option  selected value="not">Select Product</option>
                                @foreach ($data as $val)
                                <option value="{{ $val['id'] }}">{{ $val['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 form-group row">
                        <label for="rate" class="col-sm-3 col-form-label">Rate:</label>

                        <div class="col-sm-9">
                            <span  id="rate"  class="readonly"></span>
                        </div>


                    </div>


                    <div class="mb-3 form-group row">
                        <label for="unit" class="col-sm-3 col-form-label">Unit</label>

                        <div class="col-sm-9">
                            <span   id="unit"  class="readonly"></span>

                        </div>
                    </div>

                    <div class="mb-3 form-group row">
                        <label for="qty" class="col-sm-3 col-form-label">Qty.</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control w-25" id="qty" name="qty" disabled>
                        </div>
                    </div>

                    <div class="mb-3 form-group row">
                        <label for="discount" class="col-sm-3 col-form-label">Discount (In %)</label>

                        <div class="col-sm-9">
                            <input type="text" class="form-control w-50" id="discount" name="discount" disabled>
                        </div>
                    </div>

                    <div class="mb-3 form-group row">
                        <label for="net_amount" class="col-sm-3 col-form-label">Net Amount:</label>

                        <div class="col-sm-9">
                            <span  id="net_amount"  class="readonly"></span>
                        </div>
                    </div>

                    <div class="mb-3 form-group row">
                        <label for="total_amount" class="col-sm-3 col-form-label">Total Amount:</label>

                        <div class="col-sm-9">
                            <span  id="total_amount"  class="readonly"></span>
                        </div>
                    </div>

                    <button type="button" id="add_product" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add</button>
                    <button type="button"  class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">Show Added Products</button>

                </form>
            </div>
        </div>




    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('change','#select_product',function(){

                var id = $(this).val();
                if(id != "not")
                {
                    $.ajax({
                        url:"{{ route('select_product') }}",
                        type:"POST",
                        data:{id:id},
                        success:function(data){

                            $('#qty').attr('disabled',false);
                            $('#discount').attr('disabled',false);
                            $('#select_product').val(data.id);
                            $('#rate').text(data.rate);
                            $('#qty').val(1);
                            $('#unit').text(data.unit);
                            $('#discount').val(0);
                            $('#net_amount').text(data.rate);
                            $('#total_amount').text(data.rate);


                        }
                    });
                }
                else
                {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Please Select A Product And Enter The Name First",

                    });
                    $('#qty').attr('disabled',true);
                    $('#discount').attr('disabled',true);
                    $('#rate').text("");
                    $('#qty').val("");
                    $('#discount').val("");
                    $('#unit').text("");
                    $('#net_amount').text("");
                    $('#total_amount').text("");


                }


            });

            $(document).on('keyup','#discount',function(){

                var rate = parseFloat($('#rate').text());
                var qty = $('#qty').val();

                var net_amount= applyDiscount(rate,$(this).val());
                var total_amount = totalAmount(parseFloat(net_amount),parseFloat(qty));

                $('#net_amount').text(net_amount.toFixed(2));
                $('#total_amount').text(total_amount.toFixed(2));
            });

            $(document).on('keyup','#qty',function(){
                var qty  = $(this).val();
                if(qty == "")
                {
                    qty =0;
                }
                var net_amount = $('#net_amount').text();
                var product = $('#select_product').val();
                var unit = $('#unit').text();

                var result = unit - qty;


                if(result < 0)
                {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Sorry Only "+unit+" Units Available You Can Buy Only "+unit+" Units",
                    });
                    $('#qty').val(1);

                }
                else
                {
                    $('#total_amount').text(totalAmount(net_amount,qty).toFixed(2));
                }





            });

            $(document).on('click','#add_product',function(){
                var name = $('#name').val();
                var product = $('#select_product').val();
                var rate = $('#rate').text();
                var unit  = $('#unit').text();
                var qty = $('#qty').val();
                var discount = $('#discount').val();
                var net_amount = $('#net_amount').text();
                var total_amount = $('#total_amount').text();



                    $('#name').attr('readonly',true);
                    $('select').prop('selectedIndex', 0);
                    $('#qty').attr('disabled',true);
                    $('#discount').attr('disabled',true);
                    $('#rate').text("");
                    $('#qty').val("");
                    $('#discount').val("");
                    $('#unit').text("");
                    $('#net_amount').text("");
                    $('#total_amount').text("");

                if(name != "" && product !="not" && qty!="" &&discount!= "" )
                {
                    $.ajax({
                        url:"{{ route('add.product') }}",
                        type:"POST",
                        data:{name,product,rate,unit,qty,discount,net_amount,total_amount},
                        success:function(data){
                            $(".table").load(location.href + " .table");
                        }
                    });
                }
                else
                {

                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Please Select A Product And Enter The Name First",

                      });


                }
            });



            $(document).on('click','.remove_product',function(){
                var index = $(this).data('index_id');

                $.ajax({
                    url:"{{ route('remove.product') }}",
                    type:"POST",
                    data:{index},
                    success:function(data){
                        if(data ==1)
                        {
                            $(".table").load(location.href + " .table");
                            Swal.fire({
                                icon: "success",
                                title: "Removed",
                                text: "You Have Successfully Removed Product",

                              });
                        }
                        else
                        {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Record Not Removed Something Was Wrong",

                              });
                        }

                    }
                });
            })

            $(document).on('change','.select_product_edit',function(){

                var id = $(this).val();

                var data_id = $(this).data('index_id');

                    $.ajax({
                        url:"{{ route('select_product') }}",
                        type:"POST",
                        data:{id:id},
                        success:function(data){
                            $('.product_data'+data_id).val(data.id);
                            $('.rate_edit'+data_id).text(data.rate);
                            $('.qty_data'+data_id).val(1);
                            $('.unit_data'+data_id).text(data.unit);
                            $('.discount_data'+data_id).val(0);
                            $('.net_amount_data'+data_id).text(data.rate);
                            $('.total_amount_data'+data_id).text(data.rate);


                            $.ajax({
                                url:"{{route('edit.product')}}",
                                type:"POST",
                                data:{
                                    index_id:data_id,
                                    product:data.id,
                                    rate:data.rate,
                                    qty:1,
                                    unit:data.unit,
                                    discount:0,
                                    net_amount:data.rate,
                                    total_amount:data.rate
                                },
                                success:function(data){
                                    if(data == 1)
                                    {
                                        console.log("Selectedd");
                                    }
                                    else
                                    {
                                        console.log("Error In Select Product");
                                    }
                                }
                            });

                        }
                    });

            });

            $(document).on('keyup','.qty_edit',function(){
                var qty  = $(this).val();
                var index_id = $(this).data('index_id');

                var net_amount = $('.net_amount_data'+index_id).text();

                $('.total_amount_data'+index_id).text(totalAmount(net_amount,qty).toFixed(2));

                            $.ajax({
                                url:"{{route('edit.product')}}",
                                type:"POST",
                                data:{
                                    index_id:index_id,
                                    product:$('.product_data'+index_id).val(),
                                    rate:$('.rate_edit'+index_id).text(),
                                    qty:$('.qty_data'+index_id).val(),
                                    unit:$('.unit_data'+index_id).text(),
                                    discount:$('.discount_data'+index_id).val(),
                                    net_amount:$('.net_amount_data'+index_id).text(),
                                    total_amount:$('.total_amount_data'+index_id).text()
                                },
                                success:function(data){
                                    if(data == 1)
                                    {
                                        console.log("Edited");
                                    }
                                    else
                                    {
                                        console.log("Error In Qty Edit");
                                    }

                                }
                            });
            });

            $(document).on('keyup','.discount_edit',function(){
                var index_id = $(this).data('index_id');

                var rate = parseFloat($('.rate_edit'+index_id).text());
                var qty = $('.qty_data'+index_id).val();



                var net_amount= applyDiscount(rate,$(this).val());
                var total_amount = totalAmount(parseFloat(net_amount),parseFloat(qty));

                $('.net_amount_data'+index_id).text(net_amount.toFixed(2));
                $('.total_amount_data'+index_id).text(total_amount.toFixed(2));

                            $.ajax({
                                url:"{{route('edit.product')}}",
                                type:"POST",
                                data:{
                                    index_id:index_id,
                                    product:$('.product_data'+index_id).val(),
                                    rate:$('.rate_edit'+index_id).text(),
                                    qty:$('.qty_data'+index_id).val(),
                                    unit:$('.unit_data'+index_id).text(),
                                    discount:$('.discount_data'+index_id).val(),
                                    net_amount:$('.net_amount_data'+index_id).text(),
                                    total_amount:$('.total_amount_data'+index_id).text()
                                },
                                success:function(data){
                                    if(data == 1)
                                    {
                                        console.log("Edited");
                                    }
                                    else
                                    {
                                        console.log("Error In Discount Edit");
                                    }

                                }
                            });

            });


            $(document).on('click','#submit_form',function(){
                $('#close_modal').trigger('click');
                $(".table").load(location.href + " .table");
                $.ajax({
                    url:"{{ route('store.invoice') }}",
                    type:"POST",
                    success:function(data){
                        if(data ==1)
                        {
                            $("#insert_form").load(location.href + " #insert_form");
                            Swal.fire({
                                icon: "success",
                                title: "Done..",
                                text: "Your Invoice Is Generated.",

                              });
                        }
                        else
                        {

                        }
                        console.log(data);

                    }
                });
            });



            function totalAmount(net_amount,qty){
                return (net_amount * qty);
            }

            function applyDiscount(price, disc) {
                return price - (price * disc /100);
            }
        });
    </script>
</body>
</html>
