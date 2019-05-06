<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Ajax Modal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Important to work AJAX CSRF -->
    <meta name="_token" content="{!! csrf_token() !!}" />

    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">

    </head>

    <body>
        <nav class="navbar navbar-default">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="javascript:void(0);">Ajax Modal Demo</a>
            </div>
          </div>
        </nav>
        <div class="container">
                   <div class="alert alert-success" style="display:none"></div>

            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-right">
                      <button type="btn_add" id="btn_add" class="btn btn-default pull-right" >add customer</button>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <table class="table table-striped table-hover ">
                        <thead>
                            <tr class="info">
                              <th>ID </th>
                              <th> Name</th>
                              <th>email</th>
                               <th>gender</th>

                              <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="customers-list" name="customers-list">
                            @foreach($customers as$customer)
                              <tr id="$customer{{$customer->id}}" class="active">
                                  <td>{{$customer->id}}</td>
                                  <td>{{$customer->name}}</td>
                                  <td>{{$customer->email}}</td>
                                  <td> {{$customer->gender}}</td>
                                  <td width="35%">
                                      <button class="btn btn-warning btn-detail open_modal" value="{{$customer->id}}" id ="edit">Edit</button>
                                      <button class="btn btn-danger btn-deletes delet" 
                                        data-id="{{ $customer->id }}" >Delete</button>
                                  </td>
                              </tr>
                            @endforeach
                        </tbody>
                    </table> 
                </div>
            </div>s
        </div>

        <!-- Passing BASE URL to AJAX -->
      <input id="url" type="hidden" value="{{ \Request::url() }}">

        <!-- MODAL SECTION -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4 class="modal-title" id="myModalLabel">customer Form</h4>
              </div>
              <div class="modal-body">
                <form id="frmcustomer" name="frmcustomer" class="form-horizontal" novalidate="">
                  <div class="form-group error">
                    <label for="inputName" class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control has-error" id="name" name="name" placeholder="Customer Name" value="">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-3 control-label">email</label>
                    <div class="col-sm-9">
                      <input type="email" class="form-control" id="mail" name="mail" placeholder="email" value="">
                    </div>
                  </div>
                  <div class="form-group">
                      <label for="inputName" class="col-sm-3 control-label">gender</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="gender" name="gender" placeholder="gender" value="">
                      </div>
                    </div>
                </form>
              </div>
              
              <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save"  value="add">Save Changes</button>
                                <button type="button" class="btn btn-success" id="update"  value="update">update</button>

                <input type="hidden" id="customer_id" name="customer_id" value="0">
              </div>
            </div>
          </div>
        </div>

          



       </body>

    <!-- Scripts -->  
   <script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous">
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script type="text/javascript">
  
  
 jQuery(document).ready(function(){

    /**
     * ADD Button
     */
    jQuery('#btn_add').click(function(e){
      e.preventDefault();
      $('#update').hide();
      $('#myModal').modal();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });

    });
});

  

   
    /**
     * Save Button
     */
    jQuery('#btn-save').click(function(){
      var id =$(this).data("id");
      var name= jQuery('#name').val();
      var email=jQuery('#mail').val();
      var  gender=jQuery('#gender').val();
      var state = $('#btn-save').val();
      var method = "POST"; //for creating new resource
console.log(id);
         jQuery.ajax({
        url:"{{url('/Customers')}}",
        method:method,
        data:{
          name:name,
          email:email,
          gender:gender

        },

        success:function(result){


          console.log(result);
        
          //var customer=console.log(data);
          var customer = '<tr id="customer' + result.id + '"><td>' + result.id + '</td><td>' + result.name + '</td> <td>' +result.email +'</td><td>' + result.gender + '</td>';
          customer += '<td><button class="btn btn-warning btn-detail open_modal" value="' + result.id + '">Edit</button>';
          customer += ' <button class="btn btn-danger btn-delete delete-product" value="' + result.id+ '">Delete</button></td></tr>';
             $('#customers-list').append(customer);
                           // $('#frmProducts').trigger("reset");
              }
        
});                $('#myModal').modal('hide');

    });

    /**
      *EditButton**/
          $('.open_modal').click(function(){

      var customer_id =$(this).val();
     // $('#myModal').modal(); 
        console.log("work");

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });


      $.ajax({
            type: "GET",
            url:"{{url('/Customers')}}/"+customer_id+'/edit' ,

            success: function (data) {
                console.log(data);
                $('#customer_id').val(data.id);
                $('#name').val(data.name);
                $('#mail').val(data.email);
                $('#gender').val(data.gender);
                $('#btn-save').hide();
               $('update').show();
                $('#myModal').modal('show');
           // error: function (data) {
//console.log('Error:', data);
            }
        });
    });  

    /**
     * Delete Button

     */
    $('.delet').click(function(){

      var id = $(this).data("id");
      // var token = $("meta[name='csrf-token']").attr("content");
      console.log("{{url('/Customers')}}/" + id);
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      jQuery.ajax({
        url:"{{url('/Customers')}}/" + id,
        type: 'DELETE',
        dataType: "JSON",
        data: {
          "id": id,
        },
        success: function (){
          location.reload();

          console.log("it Works");

        }
      });

      
      //jQuery('#modal').modal('hide');
    });

/////////////////







</script>

<script type="text/javascript">
  


 /**
     * Update Button
     */
    jQuery('#update').click(function(){

      var id =$(this).data("id");
      var customer_id = $('#customer_id').val();;

      var name= jQuery('#name').val();
      var email=jQuery('#mail').val();
      var  gender=jQuery('#gender').val();
         $.ajaxSetup({
             headers: {
                   'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        
                    }
                        });


         jQuery.ajax({
        url:"{{url('/Customers')}}"+ '/'+customer_id,
        method:'PUT',
        data:{
          id:customer_id,
          name:name,
          email:email,
          gender:gender

        },

        success:function(result){

          console.log(result);
          //var customer=console.log(data);
          var customer = '<tr id="customer' + result.id + '"><td>' + result.id + '</td><td>' + result.name + '</td> <td>' +result.email +'</td><td>' + result.gender + '</td>';
          customer += '<td><button class="btn btn-warning btn-detail open_modal" value="' + result.id + '">Edit</button>';
          customer += ' <button class="btn btn-danger btn-delete delete" value="' + result.id+ '">Delete</button></td></tr>';
             $('#customer'+ customer_id).replaceWith(customer);


              }
        
});               $('#myModal').modal('hide')
                  $('#frmcustomer').trigger("reset");
                  $('#btn-save').show();





    });


</script>


 
</html>