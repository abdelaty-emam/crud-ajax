
$(document).ready(function(){

    //get base URL *********************
    var url = $('#url').val();


    //display modal form for creating new product *********************
    $('#btn_add').click(function(){
        $('#btn-save').val("add");
        $('#frmcustomer').trigger("reset");
        $('#myModal').modal('show');
    });



    //display modal form for product EDIT ***************************
    $(document).on('click','.open_modal',function(){
        var customer_id = $(this).val();
       
        // Populate Data in Edit Modal Form
        $.ajax({
            type: "GET",
            url: url + '/' + customer_id +'/edit',
            success: function (data) {
                console.log(data);
                $('#customer_id').val(data.id);
                $('#name').val(data.name);
                $('#mail').val(data.email);
                $('#gender').val(data.gender);

                $('#btn-save').val("update");
                $('#myModal').modal('show');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });



    //create new product / update existing product ***************************
    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        e.preventDefault(); 
        var formData = {
            name: $('#name').val(),
            email: $('#mail').val(),
            gender: $('#gender').val(),

        }

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();
        var type = "POST"; //for creating new resource
        var customer_id = $('#customer_id').val();;
        var my_url = url;
        if (state == "update"){
            type = "PUT"; //for updating existing resource
            my_url += '/' + customer_id;
        }
        console.log(formData);
        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var customer = '<tr id="customer' + data.id + '"><td>' + data.id + '</td><td>' + data.name + '</td><td>' + data.email + '</td>';
                customer += '<td><button class="btn btn-warning btn-detail open_modal" value="' + data.id + '">Edit</button>';
                customer += ' <button class="btn btn-danger btn-delete delete" value="' + data.id + '">Delete</button></td></tr>';
                if (state == "add"){ //if user added a new record
                    $('#customers-list').append(customer);
                }else{ //if user updated an existing record
                    $("#customer" + customer_id).replaceWith( customer );
                }
                $('#frmcustomer').trigger("reset");
                $('#myModal').modal('hide')
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });


    //delete product and remove it from TABLE list ***************************
    $(document).on('click','.delet',function(){
        var customer_id = $(this).val();
        console.log(customer_id);
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })
        $.ajax({
            type: "DELETE",
            url: url + '/' + customer_id,
            success: function (data) {
                console.log(data);
                $("#customer" + customer_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
    
});