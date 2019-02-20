
function addcustomerinfo()
{
    var firstname  = $('#firstname').val();
    var lastname  = $('#lastname').val();
    var formid = $("#hiddenformid").val();
    if(formid==5){
       formid=2;
    }
    // alert(formid);
    if(firstname === ""){
        $('#firstname').focus();
    }
    else if (lastname === "")
    {
       $('#lastname').focus();

    }
    else{
      $.ajax({
            type: "POST",
            url: "../src/AddNewCustomer.php",
            data:({firstname:firstname
              ,lastname:lastname,
               formid:formid
            }),
            dataType:'json',
            success: function(response) {
              // alert(response['firstname']);
              var param1="Customer "+response.firstname+" added successfully";
              app.toast(param1, {
                actionTitle: 'Success',
                // actionUrl: 'something',
                actionColor: 'success'
              });
              $('#CustomerModal').modal('hide');
              clear_customer();
               getcustomer();

            }
        });
    }
}
function getcustomer()
{
var formid = $("#hiddenformid").val();
// alert(formid);
if(formid==5){
   formid=2;
}
// alert(formid);
var customer='';
    $.ajax({
        type: "POST",
        url: "../src/fetch_customer.php",
        data:
        {
            formid:formid
        },
        success: function(msg) {

          customer+='<select  class="form-control" data-provide="selectpicker" data-live-search="true"  title="Choose a terms" onchange="addcustomer()" id="customername">';
          customer+=msg;
          customer+='<option data-icon="fa fa-edit" style="font-weight: bold;  padding: 5px;color: #797878;border: 2px solid #71bd71;"  value="#ac">Add Customer</option>';
          customer+='<option value=""></option>';
          customer+='</select>';
          $("#setcustomer").html(customer);
        }
    });
}

function clear_customer()
{
$("#firstname").val('');
$("#lastname").val('');
}
